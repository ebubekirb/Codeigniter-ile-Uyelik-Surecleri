<?php 

class Member extends CI_Controller{

	public function __construct(){

		parent::__construct();

		$this->load->library("form_validation");
		$this->load->model("Member_model");
		$this->load->helper("cookie");
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

					$viewData["message"] = "Kayıt İşlemi Başarılıdır. Kaydınızın aktif olabilmesi için size mail gönderdik. Lütfen posta kutunuza gidip. Üyeliğinizi aktifleştiriniz.";
					
					$this->load->view("thanks", $viewData);

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
				"activation_code" 	=> ""
			);


			$update = $this->Member_model->update($where, $data);

			if ($update) {

				$viewData["message"] = "Üyeliğiniz başarılı bir şekilde aktifleştirilmiştir.";
				
				$this->load->view("success", $viewData);

			} else {

				$viewData["error"] ="Bu aktivasyon koduna ait herhangi bir kayıt bulunamadı!";
				
				$this->load->view("error", $viewData);
			}
			

		} else {
			
			$this->load->view("error");
		}
		

		//else
		//error page
	}


	/*	Üyelik İşlemleri 2	*/

	public function signin_form(){

		// form validation
			// db kontrolu
				// homepage gonder
			// else
				// hata sayfası
		// else
			// hata mesajlarini gostererek signin sayfasini gostermek...

		$member = $this->session->userdata("member");

		if ($member) {

			redirect(base_url("homepage"));


		} else {

			$this->load->view("signin");
		}

	}


	public function signin(){


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

				// Beni hatirla...
				if ($this->input->post("remember_me") == "on") {
					
					// cookie deger set et

					$remember_me = array(

						"email" 	=> $this->input->post("email"),
						"password" 	=> $this->input->post("password")
					);

					// set_cookie(key, value, time);

					set_cookie("remember_me", json_encode($remember_me), time() + 60*60*24*30 );

				} else {
					
					// cookie degeri sil...

					delete_cookie("remember_me");
				}
				

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



	public function forgot_password(){

		$this->form_validation->set_rules("email", "E-posta", "trim|required|valid_email");
		$error_messages = array(

			"required"     	=> "<strong>E-posta</strong> alanı doldurmak zorundasınız!!",
			"valid_email"  	=> "Lütfen geçerli bir e-posta adresi giriniz!!"
		);

		$this->form_validation->set_message($error_messages);

		if ($this->form_validation->run() == FALSE) {
			
			$viewData["error"] = validation_errors();
			$this->load->view("signin", $viewData);

		} else{

			$email = $this->input->post("email");

			$where = array(

				"email" 	=> $email,
				"isActive" 	=> 1
			);

			$member = $this->Member_model->get($where);


			if ($member) {

				$change_request_code = md5(uniqid());


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

				$link = base_url("member/forgot_pass_confirm/$change_request_code");

				$message = "Merhabalar, {$member->full_name}, <br> Şifrenizi sıfırlanma talebiniz alındı... Şifrenizi sıfırlamak için lütfen <a href='$link'>tıklayınız...</a>";

				$this->load->library("email", $config);

				$this->email->from("ebubekr385@gmail.com", "Ebubekir Bingöloğlu");
				$this->email->to($this->input->post("email"));
				$this->email->subject("Şifre Sıfırlama");
				$this->email->message($message);

				$send = $this->email->send();

				if ($send) {

					$where = array(

						"id"	=> $member->id
					);

					$data = array(

						"activation_code"	=> $change_request_code
					);


					$update = $this->Member_model->update($where, $data);

					if ($update) {

						$viewData["message"] = "Şifre sıfırlama işlemi başarılıdır. Şifrenizi değiştirebilmeniz için size mail gönderdik. Lütfen posta kutunuza gidip. Şifrenizi sıfırlayınız.";

						$this->load->view("thanks", $viewData);

					} else {

						$viewData["error"] = "Şifre sıfırlama sırasında bir problem oluştu lütfen tekrar deneyiniz!!!";
						$this->load->view("signin", $viewData);
					}


				} else {

					$viewData["error"] = "Şifre sıfırlama sırasında bir problem oluştu lütfen tekrar deneyiniz!!!";
					$this->load->view("signin", $viewData);
				}


				// Kullanıcıya Aktivasyon işlemi icin email at...
				// email gonderimi..
			} else{

				$viewData["error"] = "Girmiş olduğunuz e-posta adresine ait bir kayıt bulunamadı!!!";
				$this->load->view("signin", $viewData);
			}
			
		}
	}


	public function forgot_pass_confirm($code){

		$where = array(

			"activation_code" 	=> $code
		);

		$member = $this->Member_model->get($where);

		$viewData["code"] = $code;

		if ($member) {

		$this->load->view("password_change_form", $viewData);
			
		} else {
			
			$viewData["error"] ="Aradağınız sayfa silinmiş veya yayından kaldırılmış olabilir!";

			$this->load->view("error", $viewData);
		}
	}


	public function password_change($code){

		$this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[6]");
		$this->form_validation->set_rules("re_password", "Şifre Doğrulama", "trim|required|min_length[6]|matches[password]");

		$error_messages = array(

			"required"		=> "%s alanını girmelisiniz!!!",
			"min_length"	=> "Lütfen şifrenizi eksiksiz olarak giriniz!!!"
		);

		$this->form_validation->set_message("error_messages");

		if ($this->form_validation->run() == FALSE) {
			

			redirect(base_url("member/forgot_pass_confirm/$code"));
			

		} else {



			$where = array(
         		
         		"activation_code"	=> $code,
         		"isActive"			=> 1
			);

			$member = $this->Member_model->get($where);

			if ($member) {
				
				// update...

				$where = array(
                	
                	"activation_code"	=> $code
				);

				$data = array(

					"password"			=> md5($this->input->post("password")),
					"activation_code" 	=> ""
				);


				$update = $this->Member_model->update($where, $data);

				if ($update) {
					
					$viewData["message"] = "Şifrenizi başarılı bir şekilde değiştirilmiştir.. Giriş yapmak için <a style ='color:white;' href='".base_url("member/signin_form")."'>tıklayınız</a>";

					$this->load->view("success", $viewData);

				} else {
					
					redirect(base_url("member/forgot_pass_confirm/$code"));
				}
				

			} else {
				
				redirect(base_url("member/forgot_pass_confirm/$code"));
			}
			
		}
		
	}
}

?>