<?php
class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
        $this->load->model('recommender_model');
    }

    public function index()
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['title'] = 'Home';
        $data['active'] = 'home';
        $data['recommendations'] = $this->recommender_model->get_personal_recommendations();
        $data['popular_recommendations'] = $this->recommender_model->get_popular_recommendations();

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('home');
        $this->load->view('templates/footer');
    }
}
