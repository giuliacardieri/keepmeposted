<?php
class Settings extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index()
    {
        $name =  $this->postcards_model->get_user_info($this->session->userdata['user_id']);
        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data = $name;
        $data['category'] = $this->postcards_model->get_favorite_categories();
        $data['categories'] = $this->postcards_model->get_categories();
        $data['title'] = 'Settings';
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['forum'] = $name['postcrossing_forum'];
        $data['active'] = '';

        $this->load->view('templates/head', $data);
        $this->load->view('templates/modal_delete_account', $data);
        $this->load->view('templates/modal_unsaved', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/nav');
        $this->load->view('settings', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->postcards_model->remove_favorite_categories();

        $categories = $this->postcards_model->get_categories();
        $categories_data = array();
        for ($i = 1; $i <= sizeof($categories); $i++) {
            if (!is_null($this->input->post('chip-'. $i))) {
                $categories_data =  array(
                    'user_id' => $this->session->userdata['user_id'],
                    'category_id' => $i,
                );
                $this->postcards_model->set_favorite_categories($categories_data);
            }
        }

        $data = array(
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'facebook' => empty($this->input->post('facebook')) ? NULL : $this->input->post('facebook'),
            'twitter' => empty($this->input->post('twitter')) ? NULL : $this->input->post('twitter'),
            'postcrossing' => empty($this->input->post('postcrossing')) ? NULL : $this->input->post('postcrossing'),
            'postcrossing_forum' => empty($this->input->post('postcrossing_forum')) ? NULL : $this->input->post('postcrossing_forum'),
        );

        if (!empty($this->input->post('password')))
            $data['password'] = sha1($this->input->post('password'));

        $this->postcards_model->update_settings($data);
        redirect('settings/index');

    }

    public function delete()
    {
        $this->postcards_model->delete_account();
        $this->session->sess_destroy();
        redirect(base_url());

    }
}
