<?php
class Favorites extends MY_Controller {

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
        $data['postcard'] = $this->postcards_model->get_favorites($this->session->userdata['user_id']);
        $data['title'] = 'Favorites';
        $data['type'] = 'favorites';
        $data['active'] = 'favorites';
        $data['filter_postcards'] = $this->postcards_model->get_filter_postcards();
        $data['filters'] = $this->postcards_model->get_filter_types();
        $data['order'] = $this->postcards_model->get_order_types();

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('favorites');
        $this->load->view('templates/filters', $data);
        $this->load->view('templates/show_postcards', $data);
        $this->load->view('templates/back-btn');
        $this->load->view('templates/footer');
    }

    public function add_favorite($id)
    {
        $data = array (
            'postcard_id' => $id,
            'user_id' =>$this->session->userdata['user_id'],
        );
        $this->postcards_model->add_favorite($data); 

        $data = $this->postcards_model->get_user_info();
        $this->load->library('email');
        $this->email->from('giulia.cardieri@gmail.com', 'Keep Me Posted');
        $this->email->to('giulia.cardieri@gmail.com'); 
        $this->email->subject('Someone favorited your postcard!');
        $this->email->message('Hi ' . $data['fname'] . ', \n Someone favorited your postcard!');  
        $this->email->send();
    }

    public function remove_favorite($id)
    {
        $data = array (
            'postcard_id' => $id,
            'user_id' =>$this->session->userdata['user_id'],
        );
        $this->postcards_model->remove_favorite($data);
    }
}
