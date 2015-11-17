<?php
class Settings extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('postcards_model');
    }

    public function index()
    {
        $name =  $this->postcards_model->get_element('fname, lname, email, password, username, share_twitter, share_facebook, twitter, facebook, favorite_email, postcrossing, postcrossing_forum', array(
            'id' => $this->session->userdata['user_id']
        ),'user');

        $header =  $this->postcards_model->get_header_info($this->session->userdata['user_id'])[0];
        $data = $name;
        $data['category'] = $this->postcards_model->get_favorite_categories();
        $data['categories'] = $this->postcards_model->get_categories();
        $data['title'] = 'Settings';
        $data['username'] = $header['username'];
        $data['photo'] = $header['photo'];
        $data['forum'] = $name['postcrossing_forum'];
        $data['share_twitter'] =  is_null($name['share_twitter']) ? '0' : $name['share_twitter'];
        $data['share_facebook'] = is_null($name['share_facebook']) ? '0' : $name['share_facebook'];
        $data['favorite_email'] = is_null($name['favorite_email']) ? '0' : $name['favorite_email'];
        $data['active'] = '';

        $this->load->view('templates/head', $data);
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
            'password' => $this->input->post('password'),
            'postcrossing' => $this->input->post('postcrossing'),
            'postcrossing_forum' => $this->input->post('forum'),
            'twitter' => $this->input->post('twitter'),
            'facebook' => $this->input->post('facebook'),
            'share_twitter' => is_null($this->input->post('share_twitter')) ? '0' : '1',
            'share_facebook' => is_null($this->input->post('share_facebook')) ? '0' : '1',
            'favorite_email' => is_null($this->input->post('favorite-email')) ? '0' : '1',
        );
        $this->postcards_model->update_settings($data);
        redirect('settings/index');

    }
}
