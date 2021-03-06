<?php
class Recommender_model extends CI_Model
{

    // this function gets the popular recommendations - this ones are the same for all users
    // the maximum number of recommendations is 40
    public function get_popular_recommendations()
    {
        if(sizeof($this->get_recommended_postcards(false, 0)) > 40) {
            if(sizeof($this->get_recommended_postcards(false, 1)) > 40) {
                return $this->get_recommended_postcards(false, 2);
            }
        }
        return $this->get_recommended_postcards(false, 1);
    }

    // this function gets the personal recommendations based on each user
    // the maximum number of recommendations is 40
    public function get_personal_recommendations()
    {
        // only show the recommendations for users that have a postcard on their collection/for swap
        $postcards = $this->postcards_model->get_postcards(array('order_element' => 'date_added','order_by' => 'DESC', 'query' => array('user_id' => $this->session->userdata['user_id'])));
        if (!empty($postcards) || !empty($this->get_favorite_categories())) {
          if(sizeof($this->get_recommended_postcards(true, 0)) > 40) {
            if(sizeof($this->get_recommended_postcards(true, 1)) > 40) {
                return $this->get_recommended_postcards(true, 2);
            }
          }
          return $this->get_recommended_postcards(true, 1);
        }
        return NULL;
    }

    // this function adds attributes to the items from the database
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

    // get the username of the postcard owner
    public function get_owner_username($id)
    {
        $this->db->select('username');
        $query = $this->db->get_where('user', array('id' => $id));
        return $query->row_array();
    }

    // defines if a postcard is a favorite of the logged user
    public function is_favorite($data)
    {
        $query = $this->db->get_where('user_favorite_postcard', $data);
        if ($query->row_array()) {
            return true;
        }
        return false;
    }

    // get the popular categories (the most frequent ones) of all users
    public function get_popular_categories()
    {
        $this->db->select('id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get('categories', 5);
        return $query->result_array();
    }

    // get the popular countries (the most frequent ones) from all users
    public function get_popular_countries()
    {
        $this->db->select('id');
        $this->db->order_by('count', 'DESC');
        $query = $this->db->get('countries', 20);
        return $query->result_array();
    }

    // get the recommended postcards
    // $personal : if true it gets the personal recommendations
    // $type : defines the filter that will be applied. It changes if exceeds the allowed maximum number of 40 postcards.
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

        if ($type == 1 || $type == 2 || $type == 3) {
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

        if ($type == 2) {
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
        }

        $this->db->order_by('favorite_count', 'DESC');
        $query = $this->db->get();
        $valid_postcard = array();

        // fix the problem (not solved by the query) when a postcard is a favorite for more than one person
        foreach ($this->add_attr($query->result_array()) as $key => $postcard) {
          if (!$postcard['is_favorite'])
            array_push($valid_postcard, $postcard);
        }
        $valid_postcard = array_values(array_unique($valid_postcard, SORT_REGULAR));
        return array_slice($valid_postcard, 0, 40, true);
    }

    // returns the name of a category
    // $id : the id of the category
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

    // get the explicit and implicit favorite categories of the logged user
    public function get_personal_categories()
    {
        $this->db->select('category_id');
        $query = $this->db->get_where('postcards', array('user_id'=> $this->session->userdata['user_id']));
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

    // get the most popular/favorite countries from the logged user
    public function get_personal_countries()
    {
        $countries = array();

        // get an array of the favorite countries sorted by its frequency on the favorite postcards of the logged user
        $favorites_countries = array_slice($this->sort_personal_countries($this->postcards_model->get_favorites($this->session->userdata['user_id'])), 0, 17, true);

        // get the most popular countries in a user's collection
        $this->db->select('country');
        $query = $this->db->get_where('postcards', array('user_id ='=> $this->session->userdata['user_id']));
        $collection_countries = $this->sort_personal_countries($query->result_array());

        // join both arrays
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

    // sort an array of countries by the number of its occurence.
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
