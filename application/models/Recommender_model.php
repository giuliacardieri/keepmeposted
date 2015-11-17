<?php
class Recommender_model extends CI_Model
{

    public function get_popular_recommendations()
    {
        if(sizeof($this->get_recommended_postcards(false, 0)) > 40) {
          if(sizeof($this->get_recommended_postcards(false, 1)) > 40) {
              return $this->get_recommended_postcards(false, 2);
          }
          return $this->get_recommended_postcards(false, 1);
        }
        return $this->get_recommended_postcards(false, 1);
    }

    public function get_personal_recommendations()
    {
        if(sizeof($this->get_recommended_postcards(true, 0)) > 40) {
          if(sizeof($this->get_recommended_postcards(true, 1)) > 40) {
              return $this->get_recommended_postcards(true, 2);
          }
          return $this->get_recommended_postcards(true, 1);
        }
        return $this->get_recommended_postcards(true, 1);
    }

    public function add_attr($recommendations)
    {
        foreach ($recommendations as $key => $postcard) {
            $recommendations[$key]['owner'] = $this->get_owner_username($postcard['user_id'])['username'];
            $recommendations[$key]['is_favorite'] = $this->is_favorite(array(
              'postcard_id' => $postcard['id'],
              'user_id' => $this->session->userdata['user_id']
            ));
        }
        return $recommendations;
    }

    public function get_owner_username($id)
    {
        $this->db->select('username');
        $query = $this->db->get_where('user', array('id' => $id));
        return $query->row_array();
    }

    public function is_favorite($data)
    {
        $query = $this->db->get_where('user_favorite_postcard', $data);
        if ($query->row_array()) {
            return true;
        }
        return false;
    }

    public function get_popular_categories()
    {
        $this->db->select('id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get('categories', 4);
        return $query->result_array();
    }

    public function get_popular_countries()
    {
        $this->db->select('id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get('countries', 10);
        return $query->result_array();
    }

    public function get_recommended_postcards($personal, $type)
    {
        if ($personal) {
          $categories = $this->get_personal_categories();
          $countries = $this->get_personal_countries();
        } else {
          $categories = $this->get_popular_categories();
          $countries = $this->get_popular_countries();
        }

        $this->db->select('* , postcards.user_id as user_id', false);
        $this->db->from('postcards');
        $this->db->join('user_favorite_postcard', 'id = postcard_id', 'left');

        // get all postcards that are not favorite from the logged user
        // faz um or dos where com and dentro, o codeigniter confunde ao juntar where com or_where
        $where = '((postcards.user_id !=' .  $this->session->userdata['user_id'] . ' and user_favorite_postcard.user_id !=' . $this->session->userdata['user_id'] . ') or (postcards.user_id !=' . $this->session->userdata['user_id'] . ' and postcard_id is null))';
        $this->db->where($where);

        if ($type == 1) {
          // get postcards from the most popular categories
          foreach ($categories as $key => $category) {
            if (gettype($category) == 'array')
              $category = $category['id'];
            if ($key == 0)
                $where_cat = '(category_id = ' . $category;
            else
                $where_cat  .= ' or category_id = ' .$category;
          }
          $where_cat  .= ')';
          $this->db->where($where_cat);
        }

        if ($type == 2 || $type == 1) {
          // get postcards from the most popular countries
          foreach ($countries as $key => $country) {
            if (gettype($country) == 'array')
              $country = $country['id'];
              if ($key == 0)
                  $where_cou = "(country = '" . $country . "'" ;
              else
                  $where_cou  .= " or country = '" .$country. "'" ;
          }
          $where_cou  .= ')';
          $this->db->where($where_cou);

          $this->db->limit(40);
        }

        $this->db->order_by('favorite_count', 'DESC');
        $query = $this->db->get();
        $valid_postcard = array();

        // fix the problem (not solved by the query) when a postcard is a favorite for more than one person
        foreach ($this->add_attr($query->result_array()) as $key => $postcard) {
          if (!$postcard['is_favorite'])
            array_push($valid_postcard, $postcard);
        }
        return $valid_postcard;
    }

    public function get_category_name($id)
    {
        $this->db->select();
        $query = $this->db->get_where('categories', array('id' => $id));
        return $query->result_array();
    }

    // get the favorite categories chosen by the user
    public function get_favorite_categories()
    {
        $this->db->select('category_id');
        $query = $this->db->get_where('user_favorite_category', array('user_id' => $this->session->userdata['user_id']));
        $categories = $query->result_array();
        if (sizeof($categories) > 0) {
            foreach ($categories as $key => $category) {
                $category = $this->get_category_name($category['category_id']);
                $new_category[$key]['id'] = $category[0]['id'];
                $new_category[$key]['name'] = $category[0]['name'];
            }
            return $new_category;
        } else {
            return '';
        }
    }

    public function get_personal_categories()
    {
        $this->db->select('category_id');
        $query = $this->db->get_where('postcards', array('user_id !='=> $this->session->userdata['user_id']));
        $elements = $query->result_array();
        $category_before = array();
        $categories = array();
        $fav_categories = $this->get_favorite_categories();

        if (!empty($fav_categories))
          // get user favorite categories (if they exist)
          foreach ($fav_categories as $category)
              array_push($categories, $category['id']);

        // sort the categories array for the most popular ones
        foreach ($elements as $key => $element)
            array_push($category_before, $element['category_id']);
        $categories_before = array_count_values($category_before);
        arsort($categories_before);

        // add user popular categories with hers/his favorite categories
        foreach ($categories_before as $category => $value) {
          if (!in_array($category, $categories) && sizeof($categories) < 4)
            array_push($categories, strval($category));
        }
        return $categories;
    }

    public function get_personal_countries()
    {
        $countries = array();

        $favorites_countries = array_slice($this->sort_personal_countries($this->postcards_model->get_favorites($this->session->userdata['user_id'])), 0, 17, true);

        $this->db->select('country');
        $query = $this->db->get_where('postcards', array('user_id !='=> $this->session->userdata['user_id']));
        $collection_countries = $this->sort_personal_countries($query->result_array());

        if (!empty($favorites_countries))
          foreach ($favorites_countries as $key => $element)
              array_push($countries, $key);

        if (!empty($collection_countries))
          foreach ($collection_countries as $key => $element){
            if (!in_array($key, $countries) && sizeof($countries) < 25)
              array_push($countries, $key);
          }

        return $countries;
    }

    public function sort_personal_countries($array)
    {
        $country = array();
        foreach ($array as $key => $element)
            array_push($country, $element['country']);

        // sort the countries array with the most popular ones
        $countries = array_count_values($country);
        arsort($countries);
        return $countries;

    }

}
?>
