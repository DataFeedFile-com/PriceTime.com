<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	public function index() {
    $data = array( 'page' => 'home' );

    $this->load->view('header', $data);
		$this->load->view('home', $data);
    $this->load->view('footer', $data);
	}
}