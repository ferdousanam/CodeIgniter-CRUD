<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
	public function __construct() {
		parent:: __construct();
		$this->load->model('Product_M', 'product');
		$this->load->model('Category_M', 'category');
	}

	public function index() {
		$this->load->library('pagination');
		$config = array(
			'base_url' => site_url('product/index'),
			'per_page' =>2,
			'total_rows' => $this->product->num_rows(),
			'full_tag_open'=>"<ul class='pagination'>",
			'full_tag_close'=>"</ul>",
			'first_link' => 'First',
			'first_tag_open' =>"<li>",
			'first_tag_close' =>"</li>",
			'next_link' =>"Next",
			'next_tag_open' =>"<li>",
			'next_tag_close' =>"</li>",
			'prev_link' =>"Prev",
			'prev_tag_open' =>"<li>",
			'prev_tag_close' =>"</li>",
			'last_link' =>"Last",
			'last_tag_open' =>"<li>",
			'last_tag_close' =>"</li>",
			'num_tag_open' =>"<li>",
			'num_tag_close' =>"<li>",
			'cur_tag_open' =>"<li class='active'><a>",
			'cur_tag_close' =>"</a></li>"
		);
		$this->pagination->initialize($config);

		$products = $this->product->productList($config['per_page'],$this->uri->segment(3));
		$data = array(
			'title' => 'Product',
			'products' => $products
		);
		$this->load->view('Product/index', $data);
	}

	public function add() {
		$categories = $this->category->get_all_categories();
		$data = array(
			'title' => 'Add Product',
			'categories' => $categories
		);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->load->library('form_validation');

			$upload_config = array(
				'upload_path' => './uploads/',
				'allowed_types' => 'gif|jpg|png'
			);
			$this->load->library('upload', $upload_config);

			$this->form_validation->set_rules('product_name', 'Product', 'required');
			$this->form_validation->set_rules('product_category', 'Product Category', 'required|integer');
			$this->form_validation->set_rules('product_price', 'Product Price', 'required|numeric');
			if ($this->form_validation->run() && $this->upload->do_upload('product_image')) {
				$upload_data = $this->upload->data();
				$image_path = $upload_data['raw_name'] . $upload_data['file_ext'];
				$data_insert = array(
					'product_name' => $this->input->post('product_name'),
					'cat_id' => $this->input->post('product_category'),
					'image' => $this->input->post('product_image'),
					'product_price' => $this->input->post('product_price'),
					'image' => $image_path
				);
				if ($this->product->create($data_insert)) {
					$this->session->set_flashdata('msg', 'Product added successfully');
					$this->session->set_flashdata('msg_class', 'alert-success');
				} else {
					$this->session->set_flashdata('msg', 'Product not added Please try again!!');
					$this->session->set_flashdata('msg_class', 'alert-danger');
				}
				return redirect('product');
			} else {
				$upload_error = $this->upload->display_errors();
				$data['upload_error'] = $upload_error;
				$this->load->view('product/add', $data);
			}
		} else {
			$this->load->view('product/add', $data);
		}
	}

	public function edit($id) {
		$categories = $this->category->get_all_categories();
		$product = $this->product->get_product_by_id($id);
		$data = array(
			'title' => 'Update Product',
			'product' => $product,
			'categories' => $categories
		);
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->update($id);
		} else {
			$this->load->view('product/edit', $data);
		}
	}

	public function update($id) {
		$categories = $this->category->get_all_categories();
		$product = $this->product->get_product_by_id($id);
		$data = array(
			'title' => 'Update Product',
			'product' => $product,
			'categories' => $categories
		);
		$this->load->library('form_validation');

		$upload_config = array(
			'upload_path' => './uploads/',
			'allowed_types' => 'gif|jpg|png'
		);
		$this->load->library('upload', $upload_config);

		$this->form_validation->set_rules('product_name', 'Product', 'required');
		$this->form_validation->set_rules('product_category', 'Product Category', 'required|integer');
		$this->form_validation->set_rules('product_price', 'Product Price', 'required|numeric');
		if ($this->form_validation->run()) {
			$data_update = array(
				'product_name' => $this->input->post('product_name'),
				'cat_id' => $this->input->post('product_category'),
				'product_price' => $this->input->post('product_price')
			);
			if ($_FILES["product_image"]["error"] != 4){
				if ($this->upload->do_upload('product_image')) {
					$file = "./uploads/".$product[0]->image;
					if (is_file($file)){
						if (unlink($file)){
							$upload_data = $this->upload->data();
							$image_path = $upload_data['raw_name'] . $upload_data['file_ext'];
							$data_update['image'] = $image_path;
						}
					} else {
						$upload_data = $this->upload->data();
						$image_path = $upload_data['raw_name'] . $upload_data['file_ext'];
						$data_update['image'] = $image_path;
					}
				} else {
					$upload_error = $this->upload->display_errors();
					$data['upload_error'] = $upload_error;
					$this->load->view('product/edit', $data);
				}
			}

			if ($this->product->update($id, $data_update)) {
				$this->session->set_flashdata('msg', 'Product Updated successfully');
				$this->session->set_flashdata('msg_class', 'alert-success');
			} else {
				$this->session->set_flashdata('msg', 'Product not updated Please try again!!');
				$this->session->set_flashdata('msg_class', 'alert-danger');
			}
			return redirect('product');
		} else {
			$this->load->view('product/edit', $data);
		}
	}

	public function delete() {
		$id = $this->input->post('id');
		if ($this->product->delete($id)) {
			$this->session->set_flashdata('msg', 'Delete Successfully');
			$this->session->set_flashdata('msg_class', 'alert-success');
		} else {
			$this->session->set_flashdata('msg', 'Please try again..Not deleted');
			$this->session->set_flashdata('msg_class', 'alert-danger');
		}
		return redirect('product');
	}
}
