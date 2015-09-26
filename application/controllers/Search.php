<?php
class Search extends CI_Controller {
    
    public function index()
    {
        $this->load->view('templates/head');
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('search');
        $this->load->view('templates/footer');
    }
    
    public function results()
    {
        $this->load->view('templates/head');
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('results');
        $this->load->view('templates/footer');
    }

}