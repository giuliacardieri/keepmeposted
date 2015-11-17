<?php
class Search extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function search()
    {
        $query = $this->input->post('search');
        redirect('results/'. $query);
    }

    public function results()
    {
        $search_items = array(
          'query' => $this->input->post('search'),
          'tab' => 'postcards',
          'type' => 'a',
          'filter' => 'a',
          'filter_type' => NULL,
          'order_by' => NULL
        );

        $results = $this->postcards_model->get_results($search_items);
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['title'] = 'Results';
        $data['search_term'] = $search_items['query'];
        $data['postcard'] = $results;
        $data['active'] = '';
        $data['filter_postcards'] = $this->postcards_model->get_filter_postcards();
        $data['filters'] = $this->postcards_model->get_filter_types();
        $data['order'] = $this->postcards_model->get_order_types();

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('results', $data);
        $this->load->view('templates/show_postcards_search', $data);
        $this->load->view('templates/footer');
    }

    public function load_results($tab, $query)
    {
      $search_items = array(
        'query' => $query,
        'tab' => $tab,
        'type' => $this->input->post('type'),
        'filter' => $this->input->post('filter'),
        'filter_type' => $this->input->post('filter-type'),
        'order_by' => $this->input->post('order-by')
      );

      $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
      $data['username'] = $header['username'];
      $data['search_term'] = $search_items['query'];
      $results = $this->postcards_model->get_results($search_items);
      $data['postcard'] = $results;
      if ($tab == 'people')
        return $this->load->view('templates/show_users', $data);
      if ($tab == 'tags')
        return $this->load->view('templates/show_tags', $data);
      return $this->load->view('templates/show_postcards_search', $data);
    }

    public function get_select($filter)
    {
      switch ($filter) {
        case 'category_id': { $data['filter_types'] = $this->postcards_model->get_categories(); break; }
        case 'country': { $data['filter_types'] = $this->postcards_model->get_countries(); break; }
        //case 'state': { $data['filter_types'] = $this->postcards_model->get_states(); break; }
        //case 'type': { $data['filter_types'] = $this->postcards_model->get_types(); break; }
      }
      return $this->load->view('templates/search_select', $data);
    }

}
