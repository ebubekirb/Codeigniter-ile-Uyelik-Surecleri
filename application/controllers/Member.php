<?php 

class Member extends CI_Controller{

	public function __construct(){

		parent::__construct();

		$this->load->library("form_validation");
		$this->load->model("Member_model");
	}

	public function index(){

		$this->load->view("register_form");
	}

	public function registration(){


		$this->form_validation->set_rules("full_name", "Ad Soyad", "trim|required|min_length[3]");
		$this->form_validation->set_rules("email", "E-posta", "trim|required|valid_email|is_unique[member.email]");
		$this->form_validation->set_rules("phone", "Telefon", "trim|required");
		$this->form_validation->set_rules("gender", "Cinsiyet", "trim|required");
		$this->form_validation->set_rules("password", "Şifre", "trim|required|min_length[6]");
		$this->form_validation->set_rules("re_password", "Şifre Doğrulama", "trim|required|min_length[6]|matches[password]");

		$error_messages = array(

			"required"     	=> "<strong>{field}</strong> alanı doldurmak zorundasınız!!",
			"valid_email"  	=> "Lütfen geçerli bir e-posta adresi giriniz!!",
			"is_unique"    	=> "%s alanına ait bir hesap bulunmaktadır!!",
			"matches"	   	=> "Girmiş olduğunuz şifreler aynı değildir!!",
			"min_length"	=> "%s alanı en az 6 karakter olmalıdır!!"	
		);

		$this->form_validation->set_message($error_messages);


		if ($this->form_validation->run() == FALSE) {
			
			$viewData["error"] = validation_errors();
			$this->load->view("register_form" ,$viewData);

		} else{
			
			$this->load->model("Member_model");

			$activation_code = md5(uniqid());

			$data = array(

				"email"				=> $this->input->post("email"),
				"full_name"			=> $this->input->post("full_name"),
				"gender"			=> $this->input->post("gender"),
				"phone"				=> $this->input->post("phone"),
				"password"			=> md5($this->input->post("password")),
				"createdAt"			=> date("Y-m-d H:i:s"),
				"activation_code"	=> $activation_code
			);

			$insert = $this->Member_model->insert($data);

			if ($insert) {
				
				$config = array(

					"protocol" 		=> "smtp",
					"smtp_host" 	=> "ssl://smtp.gmail.com",
					"smtp_port" 	=> "465",
					"smtp_pass" 	=> "549385_:",
					"smtp_user" 	=> "ebubekr385@gmail.com",
					"starttls" 		=> "true",
					"charset" 		=> "utf8",
					"mailtype" 		=> "html",
					"wordwrap" 		=> "true",
					"newline" 		=> "\r\n"
				);

				$link = base_url("member/activation/$activation_code");

				$message = "Merhabalar, {$this->input->post("full_name")}, <br> Üyeliğinizin aktifleşmesi için sadece bir adım kaldı üyeliğinizi aktifleştirmek için lütfen <a href='$link'>tıklayınız...</a>";

				$this->load->library("email", $config);

				$this->email->from("ebubekr385@gmail.com", "Ebubekir Bingöloğlu");
				$this->email->to($this->input->post("email"));
				$this->email->subject("Üyelik Aktivasyonu");
				$this->email->message($message);

				$send = $this->email->send();

				if ($send) {
					
					$this->load->view("thanks");

				} else {
					
					$viewData["error"] = "Üyelik sırasında bir problem oluştu. Lütfen tekrar deneyiniz.";
					$this->load->view("register_form", $viewData);
				}
				


				// Kullanıcıya Aktivasyon işlemi icin email at...
				// email gonderimi..
			} else{

				$viewData["error"] = "Üyelik sırasında bir problem oluştu. Lütfen tekrar deneyiniz.";
				$this->load->view("register_form", $viewData);
			}
		}
	}

	public function activation($id){


		//activation code ile kaydi bul..
		//bu kayda ait isActive => 1
		//activation_code=""
		//başarılı sayfası

		$where = array(

			"activation_code" => $id
		);

		$row = $this->Member_model->get($where);

		if ($row) {
			
			$data = array(

				"isActive" 			=> 1,
				"activation_code" 	=> 0
			);


			$update = $this->Member_model->update($where, $data);

			if ($update) {
				
				$this->load->view("success");

			} else {
				
				$this->load->view("error");
			}
			

		} else {
			
			$this->load->view("error");
		}
		

		//else
		//error page
	}


	/*	Üyelik İşlemleri 2	*/

	public function signin_form(){

		$member = $this->session->userdata("member");

		if ($member) {

			redirect(base_url("homepage"));


		} else {

			$this->load->view("signin");
		}

	}


	public function signin(){

		$member = $this->session->userdata("member");

		if ($member) {

			redirect(base_url("homepage"));


		} else {

			$this->load->view("signin");
		}

		// form validation
			// db kontrolu
				// homepage gonder
			// else
				// hata sayfası
		// else
			// hata mesajlarini gostererek signin sayfasini gostermek...


		$this->form_validation->set_rules("email", "E-posta", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Şifre", "trim|required|min_length[6]");

		$error_messages = array(

			"required"     	=> "<strong>{field}</strong> alanı doldurmak zorundasınız!!",
			"valid_email"  	=> "Lütfen geçerli bir e-posta adresi giriniz!!",
			"min_length"	=> "Lütfen şifrenizi eksiksiz olarak giriniz!!"
		);

		$this->form_validation->set_message($error_messages);	

		if ($this->form_validation->run() == FALSE) {
			
			$viewData["error"] = validation_errors();
			$this->load->view("signin", $viewData);

		} else{


			$where = array(

				"email" 	=> $this->input->post("email"),
				"password" 	=> md5($this->input->post("password"))
			);

			$member = $this->Member_model->get($where);

			if ($member) {

				$this->session->set_userdata("member", $member);

				redirect(base_url("homepage"));

			} else {
				
				$viewData["error"] = "Girmiş olduğunuz bilgilere ait bir kullanıcı bulunamadı!!";
				$this->load->view("signin", $viewData);
			}
			
		}	

	}


	public function logout(){

		$this->session->unset_userdata("member");
		redirect(base_url("member/signin_form"));
	}
}

?>