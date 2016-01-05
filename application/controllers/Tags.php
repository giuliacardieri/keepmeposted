<?php
class Tags extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index($name)
    {
        $name = urldecode($name);
    	$header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];      
        $data['postcard'] = $this->postcards_model->get_postcards_by_tag($name);
        $data['title'] = $name . ' - Tag';
        $data['tag_name'] = $name;
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
        $data['active'] = '';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('tags', $data);
        $this->load->view('templates/show_postcards', $data);
        $this->load->view('templates/back-btn');
        $this->load->view('templates/footer');
    }

}
?>