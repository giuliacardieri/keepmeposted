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
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['postcard'] = $this->postcards_model->get_postcards(array(
            'order_element' => 'date_added',
            'order_by' => 'DESC', 
            'query' => array(
                'user_id' => $this->session->userdata['user_id']
            ,)
        ));
        $data['title'] = 'History';
        $data['active'] = 'history';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('history');
        $this->load->view('templates/show_postcards_table', $data);
        $this->load->view('templates/back-btn');
        $this->load->view('templates/footer');
    }

    public function reload_history($order_element, $order_by)
    {
        $data['postcard'] = $this->postcards_model->get_postcards(array(
            'order_element' => $order_element,
            'order_by' => $order_by, 
            'query' => array(
                'user_id' => $this->session->userdata['user_id']
            ,)
        ));

        $this->load->view('templates/show_postcards_table', $data);
    }
}
