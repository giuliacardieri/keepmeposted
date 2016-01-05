<?php
class Swap extends MY_Controller{

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
        $data['postcard'] = $this->postcards_model->get_postcards(array(
            'order_element' => 'date_added',
            'order_by' => 'DESC', 
            'query' => array(
                'user_id' => $this->session->userdata['user_id'],
                'is_swap' => 1
            )
        ));
        $data['title'] = 'Swap';
        $data['type'] = 'swap collection';
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
        $data['active'] = 'swap';
        $data['filter_postcards'] = $this->postcards_model->get_filter_postcards();
        $data['filters'] = $this->postcards_model->get_filter_types();
        $data['order'] = $this->postcards_model->get_order_types();


        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('swap');
        $this->load->view('templates/filters', $data);
        $this->load->view('templates/show_postcards', $data);
        $this->load->view('templates/back-btn');
        $this->load->view('templates/footer');
    }

}
