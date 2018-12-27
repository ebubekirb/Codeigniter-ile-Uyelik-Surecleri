<?php 

class Member extends CI_Controller{

	public function index(){

		$this->load->view("register_form");
	}

	public function registration(){

		$this->load->library("form_validation");

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

				$message = "Merhabalar, {$this->input->post("full_name")}, <br> üyeliğinizin aktifleşmesi için sadece bir adım kaldı üyeliğinizi aktifleştirmek için lütfen <a href='$link'>tıklayınız</a>";

				$this->load->library("email", $config);

				$this->email->from("ebubekr385@gmail.com", "Ebubekir Bingöloğlu");
				$this->email->to($this->input->post("email"));
				$this->email->subject("Üyelik Aktivasyonu");
				$this->email->message($message);

				$send = $this->email->send();

				if ($send) {
					
					echo "İşlem başarılıdır";
				} else {
					
					echo "İşlem başarısızdır";
				}
				


				// Kullanıcıya Aktivasyon işlemi icin email at...
				// email gonderimi..
			} else{

				// Error Page
				echo "başarısızdır";
			}
		}
	}

	public function activation(){

		
	}
}

 ?>