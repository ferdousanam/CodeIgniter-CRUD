<?php
/**
 * Created by PhpStorm.
 * User: Ferdous Anam
 * Date: 18-03-2019
 * Time: 9:55 PM
 */

class Product_M extends CI_Model {
	public function __construct() {
		$this->load->database();
	}

	public function show() {
		$query = $this->db->select('*')
			->from('tbl_category')
			->join('tbl_product', 'tbl_category.id = tbl_product.cat_id');
		return $query->get()->result();
	}

	public function productList($limit,$offset)
	{
		$query = $this->db->select('*')
			->from('tbl_category')
			->join('tbl_product', 'tbl_category.id = tbl_product.cat_id')
			->limit($limit,$offset)
			->get();

		return $query->result();
	}

	public function num_rows()
	{
		$q=$this->db->select()
			->from('tbl_product')
			->get();
		return $q->num_rows();

	}

	public function get_product_by_id($id) {
		$query = $this->db->select('*')
			->from('tbl_category')
			->join('tbl_product', 'tbl_category.id = tbl_product.cat_id')
			->where('tbl_product.id', $id);
		return $query->get()->result();
	}

	public function create($array) {
		return $this->db->insert('tbl_product', $array);
	}

	public function update($id, $field){
		$this->db->where('id', $id);
		$this->db->update('tbl_product', $field);
		if($this->db->affected_rows() > 0){
			return true;
		}else{
			return false;
		}
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$this->db->delete('tbl_product');
		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
