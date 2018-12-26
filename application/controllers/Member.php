<?php 

class Member extends CI_Controller{

	public function index(){

		$this->load->view("register_form");
	}

	public function registration(){

		echo "deneme";
	}

	public function activation(){

		
	}
}

 ?>