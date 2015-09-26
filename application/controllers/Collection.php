<?php
class Collection extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }
    
    public function index()
    {
        $data['postcard'] = $this->postcards_model->get_postcards();
        $data['title'] = 'Collection';
        
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('show_collection', $data);
        $this->load->view('templates/footer');
    }

}