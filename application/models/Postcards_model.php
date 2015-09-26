<?php
class Postcards_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function get_postcards()
        {
            $query = $this->db->get('postcards');
            return $query->result_array();
        }
    
        public function get_postcard($id)
        {
            $query = $this->db->get_where('postcards', array('id' => $id));
            return $query->row_array();
        }
}
?>