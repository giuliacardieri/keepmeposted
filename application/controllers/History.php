<?php
class History extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index()
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $this->session->userdata['user_id']));
        $data['title'] = 'History';
        $data['active'] = 'history';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('history');
        $this->load->view('templates/show_postcards_table');
        $this->load->view('templates/footer');
    }
}
