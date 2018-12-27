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
			
			echo "Deneme - Kayıt başarılı";
		}
	}

	public function activation(){

		
	}
}

 ?>