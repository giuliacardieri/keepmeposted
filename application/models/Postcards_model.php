<?php
class Postcards_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
        }

        // gets the postcards based on the parameters
        // $search : the search term (if exists)
        // $attr : array of attributes such as the type (swap/collection) or the owner (logged user/other user)
        // $table : the table used on the query
        public function get_othertables_results($search, $attr, $table)
        {
            $this->db->select('postcards.id as id, description, favorite_count, postcards.country as country, postcards.photo as photo, user_id, category_id, state, type, postcrossing_id, is_available, date_received, sender, is_swap, date_added', false);
            $this->db->from('postcards');

            switch ($table) {
            case 'tags': 
                $this->db->join('tags', 'id = postcard_id', 'inner');
                $this->db->like('tagname', $search);
                break;
            case 'country': 
                $this->db->join('countries', 'country = countries.id', 'inner');
                $this->db->like('countries.name', $search);
                break;
            case 'users': 
                $this->db->join('user', 'user_id = user.id', 'inner');
                $this->db->like('username', $search);
                break;
            }

            if (!is_null($attr['user_id']))
                $this->db->where('postcards.user_id', $attr['user_id']);

            if ($attr['type'] == '3')
                $this->db->where('postcards.is_swap', 1);
            else if ($attr['type'] == '2')
                $this->db->where('postcards.is_swap', 0);

            if ($attr['filter'] != 'a')
                $this->db->where('postcards.'.$attr['filter'], $attr['filter_type']);

            $query = $this->db->get();
            return $query->result_array();
        }

        // gets the postcard results of a search
        public function get_postcards_results($search, $attr)
        {
            $like = "(`description` LIKE '%" . $search . "%' ESCAPE '!'";
            $like .= " OR `sender` LIKE '%" . $search . "%' ESCAPE '!'";
            $like .= " OR `postcrossing_id` LIKE '%" . $search . "%' ESCAPE '!')";
            
            if (!is_null($attr['user_id']))
                $this->db->where('user_id', $attr['user_id']);

           if (strtolower($attr['type']) == 'swap' || $attr['type'] == '3')
                $this->db->where('is_swap', 1);
            else if (strtolower($attr['type']) == 'collection' || $attr['type'] == '2')
                $this->db->where('is_swap', 0);

            if ($attr['filter'] != 'a')
                $this->db->where('postcards.'.$attr['filter'], $attr['filter_type']);

            $this->db->where($like);
            $query = $this->db->get('postcards');
            return $query->result_array();
        }

        // gets the tag results for each term of a search
        public function get_tagnames($search)
        {
            $this->db->select('*');
            $this->db->from('tags');
            $this->db->like('tagname', $search);
            $this->db->group_by('tagname');
            $query = $this->db->get();
            return $query->result_array();
        }

        // gets all tag results of a search
        public function get_tags_results($search, $terms)
        {
            $old = array();
            foreach ($terms as $key => $term) {
                $tag = $this->get_tagnames($term);
                $tags = array_merge($old, $tag);
                $old = $tags;
            }
            // makes sure a tag is only returned once
            $tags = array_values(array_unique($tags, SORT_REGULAR));
            usort($tags, array($this, 'order_by_tagname'));
            return $tags;
        }

        // gets the users for one search term
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

        // gets all users from a search
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
            usort($users, array($this, 'order_by_fname'));
            return $users; 
        }

        // order the tags alphabetically by the tagname (a-z)
        function order_by_tagname($a, $b)
        {
            return strnatcmp($a['tagname'], $b['tagname']);
        }

        // order the users alphabetically by the first name (a-z)
        function order_by_fname($a, $b)
        {
            return strnatcmp($a['fname'], $b['fname']);
        }

        // order the postcards by favorite count (desc)
        function order_by_fav($a, $b)
        {
            return strnatcmp($b['favorite_count'], $a['favorite_count']);
        }

        // order the postcards by date added (new-old)
        function order_by_date_added($a, $b)
        {
            return strnatcmp($b['date_added'], $a['date_added']);
        }

        // order the postcards by date received (new-old)
        function order_by_date_desc($a, $b)
        {
            return strnatcmp($b['date_received'], $a['date_received']);
        }

        // order the postcards by date received (old-new)
        function order_by_date_asc($a, $b)
        {
            return strnatcmp($a['date_received'], $b['date_received']);
        }

        // returns the results of a search or the filtered/ordered postcards
        // $search_items
        public function get_results($search_items)
        {
            // divide all terms using an empty space
            $terms = explode(' ', $search_items['query']);
            $old = array();
            $attr = array();

            // defines the type of search based on the tab selected 
            // 5 is when there's no tabs (ex: collection/favorites/swap)
            switch ($search_items['tab']) {
                case 0: return $this->get_people_results($search_items, $terms);
                case 2: return $this->get_tags_results($search_items, $terms);
                case 3: $search_items['user_id'] = $this->session->userdata['user_id']; break;
            }
            
            if (strtolower($search_items['type']) == 'favorites')
                return $this->get_favorites($search_items['user_id'], $search_items);

            $attr['type'] = $search_items['type'];
            $attr['filter'] = $search_items['filter'];
            $attr['user_id'] = $search_items['user_id'];

            if ($search_items['filter'] != 'a') {
                $attr['filter'] = $search_items['filter'];
                $attr['filter_type'] = $search_items['filter_type'];
            }

            if (!is_null($search_items['query'])) {
                // search every way is possible all the search terms
                foreach ($terms as $key => $term) {
                    $postcard = $this->get_postcards_results($term, $attr);
                    $tags = $this->get_othertables_results($term, $attr, 'tags');
                    $username = $this->get_othertables_results($term, $attr, 'users');
                    $country = $this->get_othertables_results($term, $attr, 'country');
                    $postcards = array_merge($old, $tags, $country, $username, $postcard);
                    $old = $postcards;
                }
            } else
                $postcards = $this->get_postcards_results($terms[0], $attr);
            $postcards = array_values(array_unique($postcards, SORT_REGULAR));

            // order by according to user preferences
            switch ($search_items['order_by']) {
                case '1': { usort($postcards, array($this, 'order_by_date_added')); break; }
                case '2': { usort($postcards, array($this, 'order_by_fav')); break; }
                case '3': { usort($postcards, array($this, 'order_by_date_desc')); break; }
                case '4': { usort($postcards, array($this, 'order_by_date_asc')); break; }
                default : { usort($postcards, array($this, 'order_by_date_added')); break; }
            }
            return $this->add_attr($postcards);
        }

        // adds attributes necessary to show postcards
        // $postcards : an array with all postcards
        // $fav : if the array is of favorite postcards
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
                $postcards[$key]['date_received'] = date_format(date_create($postcards[$key]['date_received']), ' j M Y');        
                $postcards[$key]['is_favorite'] = $this->is_favorite(array(
                    'postcard_id' => $postcard['id'],
                    'user_id' => $this->session->userdata['user_id']
                ));
            }
            return $postcards;
        }

        // gets all postcards with an specific tag
        // $tag : the tag that will be used to search postcards
        public function get_postcards_by_tag($tag)
        {
            $this->db->select('postcards.id as id, description, favorite_count, postcards.country as country, postcards.photo as photo, user_id, category_id, state, type, postcrossing_id, is_available, date_received, sender, is_swap, date_added', false);
            $this->db->from('postcards');
            $this->db->join('tags', 'id = postcard_id', 'inner');
            $this->db->group_by('postcards.id');
            $this->db->where('tagname', $tag);
            $query = $this->db->get();
            $postcards = $query->result_array();
            return $this->add_attr($postcards);
        }

        // gets all postcards of the logged user, ordered by date_added (desd)
        public function get_postcards($array)
        {
            $this->db->order_by($array['order_element'], $array['order_by']);
            $query = $this->db->get_where('postcards', $array['query']);
            $postcards = $query->result_array();
            return $this->add_attr($postcards);
        }

        // gets all favorite postcards of the logged user
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
                $favorites[$key]['is_favorite'] = $this->is_favorite(array(
                    'postcard_id' => $postcard['id'],
                    'user_id' => $this->session->userdata['user_id']
                ));
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

        // add a postcards to the favorites table
        public function add_favorite($data)
        {
            if (!$this->is_favorite($data))
                $this->db->insert('user_favorite_postcard', $data);
        }

        // removes a postcards from the favorites table
        public function remove_favorite($data)
        {
            $this->db->delete('user_favorite_postcard', $data);
        }

        // returns true if a postcard is a favorite of the logged user and false if it's not
        public function is_favorite($data)
        {
            $query = $this->db->get_where('user_favorite_postcard', $data);
            if ($query->row_array()) {
                return true;
            }
            return false;
        }

        // gets the necessary information to create the header of each page
        public function get_header_info($id)
        {
            $this->db->select('username, photo');
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->result_array();
        }

        // gets all countries on the table countries
        public function get_countries()
        {
            $this->db->order_by('name', 'ASC');
            $query = $this->db->get('countries');
            return $query->result_array();
        }

        // gets the username of the owner from an specific postcard
        // $id : the id of the postcard
        public function get_owner($id)
        {
            if ($id == $this->session->userdata['user_id'])
                return NULL;
            $this->db->select('username');
            $this->db->where('id', $id);
            $query = $this->db->get('user');
            return $query->row_array()['username'];
        }

        // gets all the information from a postcard
        // $id : the id of postcard
        public function get_postcard($id)
        {
            $query = $this->db->get_where('postcards', array('id' => $id));
            return $query->row_array();
        }

        // updates the information of a postcard
        // $postcard : the information to be updated in the database
        public function update_postcard($postcard)
        {
            $this->db->where(array('user_id' => $this->session->userdata['user_id'], 'id' => $postcard['id']));
            $this->db->update('postcards', $postcard);
        }

        // inserts a new postcard into the database
        // $postcard : the information to be included in the database
        public function insert_postcard($postcard)
        {
            $this->db->insert('postcards', $postcard);
            return $this->db->insert_id();
        }

        // deletes a postcard from the database
        // $id : the id of the postcard that will be deleted
        public function delete_postcard($id)
        {
            $path = dirname($_SERVER["SCRIPT_FILENAME"])."/assets/postcards/";
            $file = $this->get_element('photo', array(
                'id' => $id,
                'user_id' => $this->session->userdata['user_id']
            ),'postcards')['photo'];
            if ($file != 'postcard.png')
                unlink($path . $file);
            $this->db->delete('postcards', array('id' => $id, 'user_id' => $this->session->userdata['user_id']));
        }

        // inserts a tag into the database
        // $tag : the name of the tag to be included
        public function insert_tag($tag)
        {
            $this->db->insert('tags', $tag);
        }

        // gets all tags from an specific postcard
        // $id : the id of the postcard that the tags will be retrieved
        public function get_tags($id)
        {
            $this->db->select('tagname');
            $query = $this->db->get_where('tags', array('postcard_id' => $id));
            return $query->result_array();
        }

        // deletes all tags from a postcard
        // $id : the postcard id from the postcard that the tags will be deleted
        public function delete_tags($id)
        {
            $this->db->delete('tags', array('postcard_id' => $id));
        }

        // gets the username of a user
        // $id : the id of the user
        public function get_username($id) {
            return $this->postcards_model->get_element('username', array('id' => $id), 'user')['username'];
        }

        // gets a generic element from a table in the database
        // $attr : the attributes that will be selected on the query
        // $array : the array specifying the query
        // $table : the table of the query
        public function get_element($attr, $array, $table)
        {
            $this->db->select($attr);
            $this->db->where($array);
            $query = $this->db->get($table);
            return $query->row_array();
        }

        // gets all categories on the database ordered alphabetically by name (a-z)
        public function get_categories()
        {
            $this->db->order_by('name');
            $query = $this->db->get('categories');
            return $query->result_array();
        }

        // gets all types of postcards
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

        // gets all states of postcards
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

        // gets all filter subtypes
        public function get_filter_types()
        {
            $filters = array(
                'a' => 'All',
                'category_id' => 'Category',
                'country' => 'Country',
            );
            return $filters;
        }

        // gets all order types
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

        // gets all types of postcard to create a filter
        public function get_filter_postcards()
        {
            $filters = array(
                '1' => 'All',
                '2' => 'Collection',
                '3' => 'Swap',
            );
            return $filters;
        }

        // updates the settings
        public function update_settings($settings)
        {
            $this->db->where('id', $this->session->userdata['user_id']);
            $this->db->update('user', $settings);
        }

        // gets all favorite categories of the logged user, or nothing if the user doesn't have any
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

        // gets the name of a category given an id
        // $id : the id of the category
        public function get_category_name($id)
        {
            $this->db->select();
            $query = $this->db->get_where('categories', array('id' => $id));
            return $query->result_array();
        }

        // removes a favorite category
        public function remove_favorite_categories()
        {
            $this->db->delete('user_favorite_category', array('user_id' => $this->session->userdata['user_id']));
        }

        // sets a favorite category
        public function set_favorite_categories($category)
        {
            $this->db->insert('user_favorite_category', $category);
        }

        // updates the profile of the logged user
        public function update_profile($profile)
        {
            $this->db->where(array('id' => $this->session->userdata['user_id']));
            $this->db->update('user', $profile);
        }

        // delete all photos from the logged user
        public function delete_photos()
        {
            $profile_photo = $this->get_element('photo', array(
                'id' => $this->session->userdata['user_id']
                ),'user')['photo'];
            if ($profile_photo != 'user.png')
                unlink(dirname($_SERVER["SCRIPT_FILENAME"])."/assets/users/" . $profile_photo);

            $this->db->select('photo');
            $query = $this->db->get_where('postcards', array('user_id' => $this->session->userdata['user_id']));
            $postcards = $query->result_array();

            foreach ($postcards as $postcard) {
                if ($postcard['photo'] != 'user.png')
                    unlink(dirname($_SERVER["SCRIPT_FILENAME"])."/assets/postcards/" . $postcard['photo']);
            }
        }

        // deletes the account of the logged user (and hers/his photos)
        public function delete_account()
        {  
            $this->delete_photos();
            $this->db->delete('user', array('id' => $this->session->userdata['user_id']));
        }

        // get the user infomation
        public function get_user_info($id)
        {
            $query = $this->db->get_where('user', array('id' => $id));
            return $query->row_array();
        }
}
?>
