<?php
class Home extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
        $this->load->model('recommender_model');
        $this->load->model('stats_model');
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
        $data['popular'] = $this->stats_model->get_popular_postcard();
        $data['country_count'] = $this->stats_model->get_country_count($this->session->userdata['user_id']);
        $data['favorites_count'] = $this->stats_model->get_favorites_count($this->session->userdata['user_id']);
        $data['collection_count'] = $this->stats_model->get_postcards_count($this->session->userdata['user_id'], 0);
        $data['category'] = $this->postcards_model->get_favorite_categories();
        $data['popular_category'] = $this->postcards_model->get_category_name($this->stats_model->get_popular_element($this->session->userdata['user_id'], 'category_id'));

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('home');
        $this->load->view('templates/footer');
    }
}
