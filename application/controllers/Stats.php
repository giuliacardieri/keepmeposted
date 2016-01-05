<?php
class Stats extends MY_Controller {    

	public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
        $this->load->model('stats_model');
    }

    public function index()
    {
    	$id = $this->session->userdata['user_id'];
    	$header =  $this->postcards_model->get_header_info($id)[0];

        $data = $header;
        $data['id'] = $id;
        $data['title'] = 'Stats';
       	$data['active'] = 'stats';
        $data['fname'] = $this->postcards_model->get_element('fname', array('id' => $this->session->userdata['user_id']),'user')['fname'];
       	$data['country_count'] = $this->stats_model->get_country_count($id);
        $data['popular_type'] = $this->stats_model->get_popular_element($id, 'type');
        $data['popular_state'] = $this->stats_model->get_popular_element($id, 'state');
        $data['popular_category'] = $this->postcards_model->get_category_name($this->stats_model->get_popular_element($id, 'category_id'));
        $data['popular_country'] = $this->postcards_model->get_element('name', array('id' => $this->stats_model->get_popular_element($id, 'country')), 'countries');
        $data['favorites_count'] = $this->stats_model->get_favorites_count($id);
        $data['collection_count'] = $this->stats_model->get_postcards_count($id, 0);
        $data['swap_count'] = $this->stats_model->get_postcards_count($id, 1);

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $header);
        $this->load->view('templates/nav');
        $this->load->view('stats');
        $this->load->view('templates/show_stats', $data);
        $this->load->view('templates/footer');
    }

	public function get_countries($id)
	{
        return json_encode($this->stats_model->get_countries($id));
	}   

    public function get_categories($id)
    {
        return json_encode($this->stats_model->get_categories($id));
    }
}
?>