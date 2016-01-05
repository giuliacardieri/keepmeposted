<?php
class Login_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        // checks if the user has already signed up
        public function validate_login($data)
        {
            $query = $this->db->where($data);
            $query = $this->db->get('user');
            
            if ($query->num_rows() == 1) { 
                return true;
            }
        }

        // checks if the email typed is already registered
        public function validate_email($data)
        {
            $query = $this->db->where(array('email' => $data['email']));
            $query = $this->db->get('user');
            
            if ($query->num_rows() > 0) { 
                return false;
            }
            return true;
        }

        // checks if the username typed already exists
        public function validate_username($data)
        {
            $query = $this->db->where(array('username' => $data['username']));
            $query = $this->db->get('user');
            
            if ($query->num_rows() > 0) { 
                return false;
            } 
            return true;
        }

        // inserts a new user into the database
        public function new_user($data)
        {
            $query = $this->db->insert('user',$data);
        }
}
