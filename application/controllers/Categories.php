<?php
class Categories extends MY_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index($id)
    {
    	$header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];      
        $data['postcard'] = $this->postcards_model->get_postcards(array(
            'order_element' => 'date_added',
            'order_by' => 'DESC', 
            'query' => array(
                'category_id' => $id,
            )
        ));
        $data['category_name'] = $this->postcards_model->get_category_name($id);
        $data['title'] = $data['category_name'][0]['name'] . ' - Category';
        $data['active'] = '';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('category', $data);
        $this->load->view('templates/show_postcards', $data);
        $this->load->view('templates/back-btn');
        $this->load->view('templates/footer');
    }

}
?>