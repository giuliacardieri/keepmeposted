<?php
class Postcard extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    
    public function view($id=NULL)
    {
        $data['postcard'] = $this->postcards_model->get_postcard($id);
        $data['title'] = $data['postcard']['description'];
        
        if (empty($data['postcard']))
        {
                show_404();
        }
        
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('postcard', $data);
        $this->load->view('templates/footer');
    }
    
    public function add()
    {
        $data['title'] = 'Add Postcard';
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('add');
        $this->load->view('templates/footer');
    }
}