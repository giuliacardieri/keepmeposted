<?php
class History extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }
    
    public function index()
    {
        $data['postcard'] = $this->postcards_model->get_postcards();
        $data['title'] = 'History';
        
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('history');
        $this->load->view('templates/show_postcards_table');
        $this->load->view('templates/footer');
    }
}