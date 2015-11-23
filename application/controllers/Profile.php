<?php
class Profile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

		public function index($username=NULL)
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $username = is_null($username) ? $header['username'] : $username;

        $id = $this->postcards_model->get_element('id', array(
            'username' => $username
        ),'user')['id'];
        $name =  $this->postcards_model->get_element('id, photo, username, fname, lname, join_date, country, email, twitter, facebook, postcrossing, postcrossing_forum', array(
            'id' => $id
        ),'user');
        $name['username'] = $username;

        $data = $name;
        $data['logged_user'] = $header['username'];
        $data['title'] = $username . "'s Profile";
        $data['join_date'] = date_format(date_create($name['join_date']), 'j M Y');
        $data['countries'] = $this->postcards_model->get_countries();
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 0));
        $current_username =  $this->postcards_model->get_element('username', array(
            'id' => $this->session->userdata['user_id']
        ),'user')['username'];
       $data['active'] = ($username == $current_username) ? 'profile' : '';
       $data['filter_postcards'] = $this->postcards_model->get_filter_postcards();
       $data['filters'] = $this->postcards_model->get_filter_types();
       $data['order'] = $this->postcards_model->get_order_types();

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $header);
        $this->load->view('templates/nav');
        $this->load->view('profile', $data);
        $this->load->view('templates/filters_profile', $data);
        $this->load->view('templates/show_postcards_profile', $data);
        $this->load->view('templates/footer');
    }

    public function load_postcards()
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['logged_user'] = $header['username'];

        $id = $this->uri->segment(3);
        $type = $this->uri->segment(4);
        switch ($type) {
            case 1:
                $data['postcard'] = $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 0));
                break;
            case 2:
                $data['postcard'] = $this->postcards_model->get_favorites($id);
                break;
            case 3:
                $data['postcard'] =  $this->postcards_model->get_postcards(array('user_id' => $id, 'is_swap' => 1));
                break;
        }
        return $this->load->view('templates/show_postcards_profile', $data);
    }

    public function update_profile()
    {
          $config =  array(
                  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/assets/users/",
                  'upload_url'      => base_url()."assets/users/",
                  'allowed_types'   => "gif|jpg|png|jpeg",
                  'overwrite'       => TRUE,
                  'max_size'        => "1000KB",
                  'encrypt_name'    => TRUE
            );

          $this->load->library('upload', $config);
          $old_file = $this->postcards_model->get_element('photo', array(
              'id' => $this->session->userdata['user_id']
          ),'user')['photo'];

          if (!$this->upload->do_upload('photo'))
          {
              $file_name = $old_file;
              $upload_data = $this->upload->data();
          } else {
              unlink($config['upload_path'] . $old_file);
              $upload_data = $this->upload->data();
              $file_name = $upload_data['file_name'];
          }
          $profile = array(
              'country' => $this->input->post('country'),
              'fname' => $this->input->post('fname'),
              'lname' => $this->input->post('lname'),
              'photo' => $file_name,
          );
          $this->postcards_model->update_profile($profile);
          redirect('profile');
    }

    public function load_profile()
    {
        $data = $this->postcards_model->get_element('id, username, fname, lname, join_date, country, email, twitter, facebook, postcrossing, postcrossing_forum, photo', array(
            'id' => $this->session->userdata['user_id']
        ),'user');
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['join_date'] = date_format(date_create($data['join_date']), 'j M Y');

        return $this->load->view('templates/profile_info', $data);
    }

    public function reload($type)
    {
      $filter_items = array(
        'query' => NULL,
        'tab' => NULL,
        'type' => $type,
        'filter' => $this->input->post('filter'),
        'filter_type' => $this->input->post('filter-type'),
        'order_by' => $this->input->post('order-by')
      );

      $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
      $data['username'] = $header['username'];
      $data['filter_postcards'] = $this->postcards_model->get_filter_postcards();
      $data['filters'] = $this->postcards_model->get_filter_types();
      $data['order'] = $this->postcards_model->get_order_types();
      $postcards = $this->postcards_model->get_results($filter_items);
      $data['postcard'] = $postcards;
      return $this->load->view('templates/show_postcards', $data);
    }
}
