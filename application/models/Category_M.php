<?php
/**
 * Created by PhpStorm.
 * User: Ferdous Anam
 * Date: 18-03-2019
 * Time: 10:42 PM
 */

class Category_M extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function get_all_categories(){
		$query = $this->db->get('tbl_category');
		return $query->result();
	}
}
