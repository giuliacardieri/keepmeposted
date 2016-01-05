<?php
class Profile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
        $this->load->model('stats_model');
    }

		public function index($username=NULL)
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $username = is_null($username) ? $header['username'] : $username;

        $id = $this->postcards_model->get_element('id', array(
            'username' => $username
        ),'user')['id'];
        $name =  $this->postcards_model->get_user_info($id);
        $name['username'] = $username;

        $data = $name;
        $data['logged_user'] = $header['username'];
        $data['title'] = $username . "'s Profile";
        $data['join_date'] = date_format(date_create($name['join_date']), 'j M Y');
        $data['countries'] = $this->postcards_model->get_countries();
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['postcard'] = $this->postcards_model->get_postcards(array(
            'order_element' => 'date_added',
            'order_by' => 'DESC', 
            'query' => array(
                'user_id' => $id,
                'is_swap' => 0
            )
        ));
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

    public function load_postcards($id, $type)
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['logged_user'] = $header['username'];

        switch ($type) {
            case 1:
                $data['postcard'] = $this->postcards_model->get_postcards(array(
                    'order_element' => 'date_added',
                    'order_by' => 'DESC', 
                    'query' => array(
                        'user_id' => $id,
                        'is_swap' => 0,
                    )
                ));
                break;
            case 2:
                $data['postcard'] = $this->postcards_model->get_favorites($id);
                break;
            case 3:
                $data['postcard'] = $this->postcards_model->get_postcards(array(
                    'order_element' => 'date_added',
                    'order_by' => 'DESC', 
                    'query' => array(
                        'user_id' => $id,
                        'is_swap' => 1,
                    )
                ));
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
              if ($old_file != 'user.png')
                unlink($config['upload_path'] . $old_file);
              $upload_data = $this->upload->data();
              $file_name = $upload_data['file_name'];
          }

          $profile = array(
              'country' => $this->input->post('country'),
              'fname' => $this->input->post('fname'),
              'lname' => $this->input->post('lname'),
              'photo' => $file_name,
              'facebook' => empty($this->input->post('facebook')) ? NULL : $this->input->post('facebook'),
              'twitter' => empty($this->input->post('twitter')) ? NULL : $this->input->post('twitter'),
              'postcrossing' => empty($this->input->post('postcrossing')) ? NULL : $this->input->post('postcrossing'),
              'postcrossing_forum' => empty($this->input->post('postcrossing_forum')) ? NULL : $this->input->post('postcrossing_forum'),
              'show_facebook' => is_null($this->input->post('show-facebook')) ? '1' : '0',
              'show_twitter' => is_null($this->input->post('show-twitter')) ? '1' : '0',
              'show_postcrossing' => is_null($this->input->post('show-postcrossing')) ? '1' : '0',
              'show_forum' => is_null($this->input->post('show-forum')) ? '1' : '0',
          );
          
          $this->postcards_model->update_profile($profile);
          redirect('profile');
    }

    public function load_profile()
    {
        $data = $this->postcards_model->get_user_info($this->session->userdata['user_id']);
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['country']), 'countries')['name'];
        $data['join_date'] = date_format(date_create($data['join_date']), 'j M Y');

        return $this->load->view('templates/profile_info', $data);
    }

    public function reload($username, $type)
      {
        $filter_items = array(
          'query' => NULL,
          'tab' => 5,
          'type' => $type,
          'filter' => $this->input->post('filter'),
          'filter_type' => $this->input->post('filter-type'),
          'order_by' => $this->input->post('order-by'),
          'user_id' => $this->postcards_model->get_element('id', array('username' => $username), 'user')['id'],
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

    public function load_stats($id)
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['id'] = $id;
        $data['country_count'] = $this->stats_model->get_country_count($id);
        $data['popular_type'] = $this->stats_model->get_popular_element($id, 'type');
        $data['popular_state'] = $this->stats_model->get_popular_element($id, 'state');
        $data['popular_category'] = $this->postcards_model->get_category_name($this->stats_model->get_popular_element($id, 'category_id'));
        $data['popular_country'] = $this->postcards_model->get_element('name', array('id' => $this->stats_model->get_popular_element($id, 'country')), 'countries');
        $data['favorites_count'] = $this->stats_model->get_favorites_count($id);
        $data['collection_count'] = $this->stats_model->get_postcards_count($id, 0);
        $data['swap_count'] = $this->stats_model->get_postcards_count($id, 1);
        return $this->load->view('templates/show_stats', $data);
    }
}
