<?php 
class Stats_model extends CI_model 
{
    public function get_countries($id)
    {
		$this->db->select('countries.name');
		$this->db->from('postcards');
		$this->db->join('countries', 'country = countries.id', 'inner');
		$this->db->where('postcards.user_id', $id);
        $this->db->where('is_swap', 0);
		$query = $this->db->get();
		$countries = array();
        foreach ($query->result_array() as $key => $element)
            array_push($countries, $element['name']);

        $json_countries = array();
        // cores do gráfico
        $color = array('#7E5691', '#77508A', '#724C85', '#6D4780', '#68427A');
        $i = 0;
		foreach (array_count_values($countries) as $key => $element)
		{
			$ele['value'] = $element;
			$ele['color'] = $color[$i];
			$ele['highlight'] = $color[$i];
			$ele['label'] = $key;
			array_push($json_countries, $ele);
            if ($i == sizeof($color)-1)
                $i = 0;
            else
                $i++;
		}
		echo json_encode($json_countries);
		return $json_countries;
    }

    public function get_categories($id)
    {
        $this->db->select('categories.name');
        $this->db->from('postcards');
        $this->db->join('categories', 'category_id = categories.id', 'inner');
        $this->db->where('postcards.user_id', $id);
        $this->db->where('is_swap', 0);
        $query = $this->db->get();
        $categories = array();
        foreach ($query->result_array() as $key => $element)
            array_push($categories, $element['name']);

        $json_categories = array();
        $color = array('#7E5691', '#77508A', '#724C85', '#6D4780', '#68427A');
        $i = sizeof($color)-1;
        foreach (array_count_values($categories) as $key => $element)
        {
            $ele['value'] = $element;
            $ele['color'] = $color[$i];
            $ele['highlight'] = $color[$i];
            $ele['label'] = $key;
            array_push($json_categories, $ele);
            if ($i == 0)
                $i = sizeof($color)-1;
            else
                $i--;
        }
        echo json_encode($json_categories);
        return $json_categories;
    }

    public function get_country_count($id)
    {
    	$this->db->select('count(distinct country) as count', false);
		$this->db->from('postcards');
		$this->db->where('user_id', $id);
    	$query = $this->db->get();
    	$values = $query->row_array();
    	return $values['count'];
    }

    public function get_favorites_count($id)
    {
		$this->db->from('user_favorite_postcard');
		$this->db->where('user_id', $id);
		return $this->db->count_all_results();
    }

    public function get_postcards_count($id, $swap)
    {
		$this->db->from('postcards');
		$this->db->where('user_id', $id);
		$this->db->where('is_swap', $swap);
		return $this->db->count_all_results();
    }

    public function get_popular_element($id, $element)
    {
    	$this->db->select($element . ', count(' . $element . ') as count', false);
    	$this->db->from('postcards');
    	$this->db->where('user_id', $id);
        if ($element == 'type' || $element == 'state')
            $this->db->where('is_swap', 0);
    	$this->db->group_by($element);
    	$this->db->order_by('count', 'desc');
    	$this->db->limit(1);
    	$query = $this->db->get();
    	$values = $query->row_array();
    	return $values[$element];
    }

    // gets the most popular postcard (based on favorites count) of the logged user
    public function get_popular_postcard()
    {
            $this->db->order_by('favorite_count', 'desc');
            $this->db->limit(1);
            $query = $this->db->get_where('postcards', array('user_id' => $this->session->userdata['user_id']));
            $postcards = $query->result_array();
            return $this->postcards_model->add_attr($postcards);
    }
}
?>