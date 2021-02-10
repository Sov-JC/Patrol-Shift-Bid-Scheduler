<?php

class Home extends CI_Controller {
	function index() {
		// $this->load->view('templates/header');
		// $this->load->view('home');
		// $this->load->view('templates/footer');
		redirect('schedule');
	}
}
