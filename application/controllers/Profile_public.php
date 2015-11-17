<?php
class Profile_public extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index()
    {
        $id = $this->session->userdata['user_id'];
        $name =  $this->postcards_model->get_element('id, photo, username, fname, lname, join_date, country, email, twitter, facebook, postcrossing, postcrossing_forum', array(
            'id' => $id
        ),'user');

        $data = $name;
        $data['title'] = $name['username'] . "'s Profile";
        $data['join_date'] = date_format(date_create($name['join_date']), 'j M Y');
        $data['countries'] = $this->postcards_model->get_countries();
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 0));

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('profile', $data);
        $this->load->view('templates/show_postcards_profile', $data);
        $this->load->view('templates/footer');
    }

		public function view($username=NULL)
    {
        $id = $this->postcards_model->get_element('id', array(
            'username' => $username
        ),'user')['id'];
        $name =  $this->postcards_model->get_element('id, photo, username, fname, lname, join_date, country, email, twitter, facebook, postcrossing, postcrossing_forum', array(
            'id' => $id
        ),'user');

        $data = $name;
        $data['title'] = $username . "'s Profile";
        $data['join_date'] = date_format(date_create($name['join_date']), 'j M Y');
        $data['countries'] = $this->postcards_model->get_countries();
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 0));

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('profile', $data);
        $this->load->view('templates/show_postcards_profile', $data);
        $this->load->view('templates/footer');
    }

    public function load_postcards()
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];

        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        switch ($type) {
            case 1:
                $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 0));
                break;
            case 2:
                $data['postcard'] = $this->postcards_model->get_favorites();
                break;
            case 3:
                $data['postcard'] =  $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 1));
                break;
        }
        return $this->load->view('templates/show_postcards_profile', $data);
    }

    public function update_profile()
    {
          $profile = array(
              'country' => $this->input->post('country'),
              'fname' => $this->input->post('fname'),
              'lname' => $this->input->post('lname'),
          );
          $this->postcards_model->update_profile($profile);
          redirect('profile');
    }

    public function load_profile()
    {
        $data = $this->postcards_model->get_element('id, username, fname, lname, join_date, country, email, twitter, facebook, postcrossing, postcrossing_forum', array(
            'id' => $this->session->userdata['user_id']
        ),'user');
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['join_date'] = date_format(date_create($data['join_date']), 'j M Y');

        return $this->load->view('templates/profile_info', $data);

    }
}
