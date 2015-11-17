<?php
class Postcards_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        public function get_othertables_results($search, $attr, $table)
        {
          $this->db->select('postcards.id as id, description, favorite_count, postcards.country as country, postcards.photo as photo, user_id, category_id, state, type, postcrossing_id, is_available, date_received, sender, is_swap, date_added', false);
          $this->db->from('postcards');
          if ($table == 'tags') {
            $this->db->join('tags', 'id = postcard_id', 'inner');
            $this->db->like('tagname', $search);
          } else if ($table == 'country') {
            $this->db->join('countries', 'country = countries.id', 'inner');
            $this->db->like('countries.name', $search);
          } else if ($table == 'users'){
            $this->db->join('user', 'user_id = user.id', 'inner');
            $this->db->like('username', $search);
          }
          if ($attr['yours'])
            $this->db->where('postcards.user_id', $this->session->userdata['user_id']);
          if ($attr['type'] == '3')
            $this->db->where('is_swap', 1);
          else if ($attr['type'] == '2')
            $this->db->where('is_swap', 0);
          if ($attr['filter'] != 'a')
            $this->db->where('postcards.'.$attr['filter'], $attr['filter_type']);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function get_postcards_results($search, $attr)
        {
          $like = "(`description` LIKE '%" . $search . "%' ESCAPE '!'";
          $like .= " OR `sender` LIKE '%" . $search . "%' ESCAPE '!'";
          $like .= " OR `postcrossing_id` LIKE '%" . $search . "%' ESCAPE '!')";
          if ($attr['yours'])
            $this->db->where('user_id', $this->session->userdata['user_id']);
          if ($attr['type'] == '3')
            $this->db->where('is_swap', 1);
          else if ($attr['type'] == '2')
            $this->db->where('is_swap', 0);
          if ($attr['filter'] != 'a')
            $this->db->where('postcards.'.$attr['filter'], $attr['filter_type']);
          $this->db->where($like);
          $query = $this->db->get('postcards');
          return $query->result_array();
        }

        public function get_tagnames($search)
        {
          $this->db->select('*');
          $this->db->from('tags');
          $this->db->like('tagname', $search);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function get_tags_results($search, $terms)
        {
          $old = array();
          foreach ($terms as $key => $term) {
              $tag = $this->get_tagnames($term);
              $tags = array_merge($old, $tag);
              $old = $tags;
          }
          $tags = array_values(array_unique($tags, SORT_REGULAR));
          return $tags;
        }

        public function get_users($search)
        {
          $this->db->select('*');
          $this->db->from('user');
          $this->db->or_like('username', $search);
          $this->db->or_like('fname', $search);
          $this->db->or_like('lname', $search);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function get_people_results($search_items, $terms)
        {
          $old = array();
          foreach ($terms as $key => $term) {
              $user = $this->get_users($term);
              $users = array_merge($old, $user);
              $old = $users;
          }
          $users = array_values(array_unique($users, SORT_REGULAR));

          foreach ($users as $key => $user) {
            $users[$key]['country_name'] = $this->get_element('name', array('id' => $users[$key]['country']), 'countries')['name'];
          }
          return $users;
        }

        function order_by_fav($a, $b)
        {
          return strnatcmp($b['favorite_count'], $a['favorite_count']);
        }

        function order_by_date_desc($a, $b)
        {
          return strnatcmp($b['date_received'], $a['date_received']);
        }

        function order_by_date_asc($a, $b)
        {
          return strnatcmp($a['date_received'], $b['date_received']);
        }

        public function get_results($search_items)
        {
          $terms = explode(' ', $search_items['query']);
          $old = array();

          if ($search_items['tab'] == 'people')
            return $this->get_people_results($search_items, $terms);
          if ($search_items['tab'] == 'tags')
            return $this->get_tags_results($search_items, $terms);

          if ($search_items['type'] == 'favorites')
            return $this->get_favorites($this->session->userdata['user_id'], $search_items);

          switch ($search_items['type']) {
            case 'collection': { $search_items['type'] = 2; break; }
            case 'favorites': { $search_items['type'] = 1; break; }
            case 'swap': { $search_items['type'] = 3;  break; }
          }

          $attr = array(
            'yours' => false,
            'type' => $search_items['type'],
            'filter' => $search_items['filter']
          );

          if ($search_items['filter'] != 'a') {
            $attr['filter'] = $search_items['filter'];
            $attr['filter_type'] = $search_items['filter_type'];
          }

          if ($search_items['tab'] == 'yours' || is_null($search_items['tab']))
            $attr['yours'] = true;

          foreach ($terms as $key => $term) {
            $postcard = $this->get_postcards_results($term, $attr);
            $tags = $this->get_othertables_results($term, $attr, 'tags');
            $username = $this->get_othertables_results($term, $attr, 'users');
            $country = $this->get_othertables_results($term, $attr, 'country');
            $postcards = array_merge($old, $tags, $country, $username, $postcard);
            $old = $postcards;
          }
          $postcards = array_values(array_unique($postcards, SORT_REGULAR));

          switch ($search_items['order_by']) {
            case '2': { usort($postcards, array($this, 'order_by_fav')); break; }
            case '3': { usort($postcards, array($this, 'order_by_date_desc')); break; }
            case '4': { usort($postcards, array($this, 'order_by_date_asc')); break; }
          }
          return $this->add_attr($postcards);
        }

        public function add_attr($postcards, $fav=NULL)
        {
          foreach ($postcards as $key => $postcard) {
            $postcards[$key]['owner'] = $this->get_element('username', array('id' => $postcard['user_id']), 'user')['username'];
            $postcards[$key]['owner_id'] = $postcard['user_id'];
            if ($postcard['user_id'] == $this->session->userdata['user_id'])
              $postcards[$key]['url_attr'] = '';
            else
              $postcards[$key]['url_attr'] = $postcards[$key]['owner'];
            $postcards[$key]['category'] = $this->get_element('name', array('id' => $postcard['category_id']), 'categories')['name'];
            $postcards[$key]['country_name'] = $this->get_element('name', array('id' => $postcard['country']), 'countries')['name'];
            $postcards[$key]['date_received'] = date_format(date_create($postcards[$key]['date_received']), ' j M Y');        $postcards[$key]['is_favorite'] = $this->is_favorite(array(
              'postcard_id' => $postcard['id'],
              'user_id' => $postcard['user_id']
            ));
          };
          return $postcards;
        }

        public function get_postcards($array)
        {
            $this->db->order_by('date_added', 'DESC');
            $query = $this->db->get_where('postcards', $array);
            $postcards = $query->result_array();
            return $this->add_attr($postcards);
        }

        public function get_favorites($id, $results=NULL)
        {
            $this->db->select('*, postcards.user_id as owner_id', false);
            $this->db->from('postcards');
            $this->db->join('user_favorite_postcard', 'id = postcard_id','left');
            $this->db->where('user_favorite_postcard.user_id', $id);
            if (!is_null($results)) {
              if ($results['type'] == '3')
                $this->db->where('is_swap', 1);
              else if ($results['type'] == '2')
                $this->db->where('is_swap', 0);
              if ($results['filter'] != 'a')
                $this->db->where('postcards.'.$results['filter'], $results['filter_type']);
            }
            $query = $this->db->get();
            $favorites = $query->result_array();
            foreach ($favorites as $key => $postcard) {
                $favorites[$key]['country-flag'] = $this->get_element('id', array('name' => $postcard['country']), 'countries')['id'];
                $favorites[$key]['owner'] = $this->get_username($postcard['owner_id']);
                $favorites[$key]['is_favorite'] = TRUE;
                if ($postcard['owner_id'] == $this->session->userdata['user_id'])
                    $favorites[$key]['url_attr'] = '';
                else
                    $favorites[$key]['url_attr'] = $favorites[$key]['owner'];
            }

            if (!is_null($results))
              switch ($results['order_by']) {
                case '2': { usort($favorites, array($this, 'order_by_fav')); break; }
                case '3': { usort($favorites, array($this, 'order_by_date_desc')); break; }
                case '4': { usort($favorites, array($this, 'order_by_date_asc')); break; }
              }

            return $favorites;
        }

        public function add_favorite($data)
        {
            $this->db->insert('user_favorite_postcard', $data);
        }

        public function remove_favorite($data)
        {
            $this->db->delete('user_favorite_postcard', $data);
        }

        public function is_favorite($data)
        {
            $query = $this->db->get_where('user_favorite_postcard', $data);
            if ($query->row_array()) {
                return true;
            }
            return false;
        }

        public function get_header_info($id)
        {
            $this->db->select('username, photo');
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->result_array();
        }

        public function get_countries()
        {
            $this->db->order_by('name', 'ASC');
            $query = $this->db->get('countries');
            return $query->result_array();
        }

        public function get_owner($id)
        {
            if ($id == $this->session->userdata['user_id'])
              return NULL;
            $this->db->select('username');
            $this->db->where('id', $id);
            $query = $this->db->get('user');
            return $query->row_array()['username'];
        }

        public function get_postcard($id)
        {
            $query = $this->db->get_where('postcards', array('id' => $id));
            return $query->row_array();
        }

        public function update_postcard($postcard)
        {
            $this->db->where(array('user_id' => $this->session->userdata['user_id'], 'id' => $postcard['id']));
            $this->db->update('postcards', $postcard);
        }

        public function insert_postcard($postcard)
        {
            $this->db->insert('postcards', $postcard);
            return $this->db->insert_id();
        }

        public function edit_postcard($postcard)
        {
            $this->db->where(array('id' => $postcard['id'], 'user_id' => $this->session->userdata['user_id']));
            $this->db->update('postcards', $postcard);
        }

        public function delete_postcard($id)
        {
            $path = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/postcards/";
            $file = $this->get_element('photo', array(
                'id' => $id,
                'user_id' => $this->session->userdata['user_id']
            ),'postcards')['photo'];
            unlink($path . $file);
            $this->db->delete('postcards', array('id' => $id, 'user_id' => $this->session->userdata['user_id']));
        }

        public function insert_tag($tag)
        {
            $this->db->insert('tags', $tag);
        }

        public function get_tags($id)
        {
            $this->db->select('tagname');
            $query = $this->db->get_where('tags', array('postcard_id' => $id));
            return $query->result_array();
        }

        public function delete_tags($id)
        {
            $this->db->delete('tags', array('postcard_id' => $id));
        }

        public function get_username($id) {
            return $this->postcards_model->get_element('username', array('id' => $id), 'user')['username'];
        }

        public function get_element($attr, $array, $table)
        {
            $this->db->select($attr);
            $this->db->where($array);
            $query = $this->db->get($table);
            return $query->row_array();
        }

        public function get_categories()
        {
            $query = $this->db->get('categories');
            return $query->result_array();
        }

        public function get_types()
        {
            $types = array(
                'Forum',
                'Gift',
                'Personal',
                'Postcrossing',
                'Swap',
            );

            return $types;
        }

        public function get_states()
        {
            $states = array(
                'Blank',
                'Damaged',
                'Written',
                'Written and Stamped',
            );

            return $states;
        }

        public function get_filter_types()
        {
            $filters = array(
              'a' => 'All',
              'category_id' => 'Category',
              'country' => 'Country',
              //'state' => 'State',
              //'type' => 'Type'
            );
            return $filters;
        }

        public function get_order_types()
        {
            $filters = array(
              '1' => 'None',
              '2' => 'Popularity',
              '3' => 'Newest',
              '4' => 'Oldest'
            );
            return $filters;
        }

        public function get_filter_postcards()
        {
            $filters = array(
              '1' => 'All',
              '2' => 'Collection',
              '3' => 'Swap',
            );
            return $filters;
        }

        public function update_settings($settings)
        {
            $this->db->where('id', $this->session->userdata['user_id']);
            $this->db->update('user', $settings);
        }

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

        public function get_category_name($id)
        {
            $this->db->select();
            $query = $this->db->get_where('categories', array('id' => $id));
            return $query->result_array();
        }

        public function remove_favorite_categories()
        {
            $this->db->delete('user_favorite_category', array('user_id' => $this->session->userdata['user_id']));
        }

        public function set_favorite_categories($category)
        {
            $this->db->insert('user_favorite_category', $category);
        }

        public function update_profile($profile)
        {
            $this->db->where(array('id' => $this->session->userdata['user_id']));
            $this->db->update('user', $profile);
        }
}
?>
