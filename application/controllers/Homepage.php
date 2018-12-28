<?php 

class Homepage extends CI_Controller{

	public function index(){

		// session icerisinde user var mı? yoksa signin sayfasina yönlendir..

		$member = $this->session->userdata("member");

		if (!$member) {
			
			redirect(base_url("member/signin_form"));


		} else {

			$this->load->view("homepage");
		}
		
	}
}

?>