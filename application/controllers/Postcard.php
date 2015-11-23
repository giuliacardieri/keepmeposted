<?php
class Postcard extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function view($id=NULL)
    {

        if (!is_numeric($id))
          $id = $this->uri->segment(3);
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['postcard'] = $this->postcards_model->get_postcard($id);
        $data['postcard']['owner'] = $this->postcards_model->get_owner($data['postcard']['user_id']);
        $data['postcard']['date_received'] = date_format(date_create($data['postcard']['date_received']), 'j M Y');
        $data['title'] = $data['postcard']['description'];
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['postcard']['country']), 'countries')['name'];
        $data['category'] = $this->postcards_model->get_element('name', array('id' => $data['postcard']['category_id']), 'categories')['name'];
        $data['types'] = $this->postcards_model->get_types();
        $data['states'] = $this->postcards_model->get_states();
        $data['countries'] = $this->postcards_model->get_countries();
        $data['categories'] = $this->postcards_model->get_categories();
        $data['is_favorite'] = $this->postcards_model->is_favorite(array(
            'postcard_id' => $data['postcard']['id'],
            'user_id' => $this->session->userdata['user_id']
        ));
        $data['tags'] = $this->postcards_model->get_tags($data['postcard']['id']);
        $data['active'] = '';

        if (empty($data['postcard'])) {
            show_404();
        }

        $this->load->view('templates/head', $data);
        $this->load->view('templates/modal_delete');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('postcard', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $id = $this->uri->segment(3);
        $this->postcards_model->delete_postcard($id);
        redirect('collection');
    }

    public function add()
    {
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['title'] = 'Add Postcard';
        $data['types'] = $this->postcards_model->get_types();
        $data['states'] = $this->postcards_model->get_states();
        $data['countries'] = $this->postcards_model->get_countries();
        $data['categories'] = $this->postcards_model->get_categories();
        $data['active'] = 'add';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('add');
        $this->load->view('templates/form_postcard', $data);
        $this->load->view('templates/footer');
    }

    public function insert_postcard()
    {
        $config =  array(
                  'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/assets/postcards/",
                  'upload_url'      => base_url()."assets/postcards/",
                  'allowed_types'   => "gif|jpg|png|jpeg",
                  'overwrite'       => TRUE,
                  'max_size'        => "1000KB",
                  'encrypt_name'    => TRUE
            );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo'))
        {
            $file_name = 'postcard.jpg';
            $upload_data = $this->upload->data();
        } else {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }
        $postcard = array(
            'description' => $this->input->post('description'),
            'country' => $this->input->post('country'),
            'photo' => $file_name,
            'user_id' => $this->session->userdata['user_id'],
            'state' => $this->input->post('state'),
            'category_id' => $this->input->post('category'),
            'type' => $this->input->post('type'),
            'postcrossing_id' => $this->input->post('postcrossing-id'),
            'is_available' => $this->input->post('available'),
            'date_received' => date('Y-m-d', strtotime($this->input->post('date'))),
            'sender' => $this->input->post('sender'),
            'is_swap' => $this->input->post('swap'),
        );

        $id = $this->postcards_model->insert_postcard($postcard);

        for ($i=0; $i <= 5; $i++) {
          if ($this->input->post('chip-'.$i)) {
            $tagname = $this->input->post('chip-'.$i);
            $this->postcards_model->insert_tag(array('postcard_id' => $id, 'tagname' => $tagname));
          }
        }

        redirect('postcard/'.$id);
    }

    public function edit_postcard()
        {
          $config =  array(
                'upload_path'     => dirname($_SERVER["SCRIPT_FILENAME"])."/assets/postcards/",
                'upload_url'      => base_url()."assets/users/",
                'allowed_types'   => "gif|jpg|png|jpeg",
                'overwrite'       => TRUE,
                'max_size'        => "1000KB",
                'encrypt_name'    => TRUE
          );

        $this->load->library('upload', $config);
        $old_file = $this->postcards_model->get_element('photo', array(
            'user_id' => $this->session->userdata['user_id'],
            'id' => $this->input->post('id')
        ),'postcards')['photo'];

        if (!$this->upload->do_upload('photo'))
        {
            $file_name = $old_file;
            $upload_data = $this->upload->data();
        } else {
            unlink($config['upload_path'] . $old_file);
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
        }

        $postcard = array(
            'id' => $this->input->post('id'),
            'description' => $this->input->post('description'),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'category_id' => $this->input->post('category'),
            'type' => $this->input->post('type'),
            'postcrossing_id' => $this->input->post('postcrossing-id'),
            'is_available' => $this->input->post('available'),
            'date_received' => date('Y-m-d', strtotime($this->input->post('date'))),
            'sender' => $this->input->post('sender'),
            'is_swap' => $this->input->post('swap'),
            'photo' => $file_name,
        );
        $this->postcards_model->update_postcard($postcard);

        $this->postcards_model->delete_tags($postcard['id']);
        $tagsValue = split(',', $this->input->post('tags-value'));
        foreach ($tagsValue as $key => $tag) {
          if ($this->input->post('chip-'.$tag)) {
            $tagname = $this->input->post('chip-'.$tag);
            $this->postcards_model->insert_tag(array('postcard_id' => $postcard['id'], 'tagname' => $tagname));
          }
        }

        redirect('postcard/'.$postcard['id']);
    }

    public function load_postcard_info($id)
    {
        $data['postcard'] = $this->postcards_model->get_postcard($id);
        $data['postcard']['owner'] = $this->postcards_model->get_owner($data['postcard']['user_id']);
        $data['postcard']['date_received'] = date_format(date_create($data['postcard']['date_received']), 'j M Y');
        $data['title'] = $data['postcard']['description'];
        $data['country_name'] = $this->postcards_model->get_element('name', array('id' => $data['postcard']['country']), 'countries')['name'];
        $data['category'] = $this->postcards_model->get_element('name', array('id' => $data['postcard']['category_id']), 'categories')['name'];
        $data['types'] = $this->postcards_model->get_types();
        $data['states'] = $this->postcards_model->get_states();
        $data['countries'] = $this->postcards_model->get_countries();
        $data['categories'] = $this->postcards_model->get_categories();
        $data['tags'] = $this->postcards_model->get_tags($data['postcard']['id']);
        $data['is_favorite'] = $this->postcards_model->is_favorite(array(
            'postcard_id' => $data['postcard']['id'],
            'user_id' => $this->session->userdata['user_id']
        ));

        return $this->load->view('templates/postcard_info', $data);

    }
}
