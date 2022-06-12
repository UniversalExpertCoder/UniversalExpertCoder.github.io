<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends MY_Controller {

	public function __construct()
    {
   			parent::__construct();
			$this->load->helper(array('url', 'html', 'form'));
			$this->load->library(array('form_validation', 'upload'));
      		if (!$this->session->userdata('user_id')) {
				return redirect('LoginController');
			}

    }

    public function index()
    {
    	$this->dashboard();
    }

	public function dashboard()
	{
		$user_id = $this->session->userdata('user_id');

		$users = $this->db->select('*')->from($this->table_users)->get()->result();
		$products = $this->db->select('*')->from($this->table_product)->get()->result();
		//$this->print(count($users));
		//$this->print($users);
		$category = $this->db->select()->from($this->table_category)->get();
		$number_category = $category->num_rows();

	   	$users = array(
	   		'users' => $users, 'number_users' => count($users),
	   		'products' => $products, 'number_products' => count($products),
	   	 'number_category' => $number_category
	   	);

		$this->load->view('admin/view_dashboard', $users);
	}

	public function profile()
	{
		$user_id = $this->session->userdata('user_id');
		$users = $this->db->select('*')->from($this->table_users)->where('user_id', $user_id)->get()->row();
		//$this->print($users);

		$this->load->view('admin/view_profile', ['user_detail' => $users]);
	}

	public function activityUser()
	{
		$user_id = $this->input->post('user_id');
		$users = array('user_status' => $this->input->post('user_status'));
		$user_updated = $this->db->where('user_id', $user_id)->update($this->table_users, $users);

		return $this->flash($user_updated, $this->input->post('profile_activity'), 'Something Error!!', 'AdminController/profile');

	}

	public function editUserProfile() {

		$user_id = $this->session->userdata('user_id');
		$user_detail = $this->db->select()->from($this->table_users)->where('user_id', $user_id)->get()->row();

		$this->load->view('admin/view_edit_profile', ['user_detail' => $user_detail]);
	}

	public function updateUserProfile() {
		//$this->print($_FILES['profile_image']['name']);
		$this->print($_FILES);
		//$this->print($this->input->post());

		$this->form_validation->set_rules('username','Username','trim|required|min_length[4]|max_length[40]');
		
		if($this->form_validation->run() == TRUE ) {

			if (empty($_FILES['profile_image']['name'])) {
				$user_id = $this->session->userdata('user_id');
				$users = array('username' => $this->input->post('username'));
				$user_updated = $this->db->where('user_id', $user_id)->update($this->table_users, $users);
				return $this->flash($user_updated, 'User Profile Updated...', 'User Profile Not Updated Error!!', 'AdminController/profile');
				
			} else {

				$config = array();
				$config['upload_path'] = './uploads/category/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$profile_image = $this->upload->do_upload('profile_image');
				
				if ($profile_image) {
					$user_image = $this->upload->data();
       				$user_file_name = $user_image['file_name'];

					$user_id = $this->session->userdata('user_id');

					$users = array('username' => $this->input->post('username'), 'user_profile_image' => $user_file_name);
					$user_updated = $this->db->where('user_id', $user_id)->update($this->table_users, $users);

					return $this->flash($user_updated, 'User Profile Updated!!', 'User Profile Not Updated Error!!', 'AdminController/profile');

				} else {

					$user_id = $this->session->userdata('user_id');
					$user_detail = $this->db->select()->from($this->table_users)->where('user_id', $user_id)->get()->row();
	   				$upload_error = array('user_detail' => $user_detail, 'upload_error' => $this->upload->display_errors());

					$this->load->view('admin/view_edit_profile', $upload_error);
				}

			}
       
		} else {
			$this->editUserProfile();
		}

	}

	public function notification()
	{

		$this->load->view('admin/view_notification');
	}

	public function category()
	{
		$this->load->library('pagination');

		$user_id = $this->session->userdata('user_id');
		$category = $this->db->select()->from($this->table_category)->where('user_id', $user_id)->get();
		$number_articles = $category->num_rows();

		$config = array();
		$config['base_url'] = base_url('AdminController/category');
		$config['per_page'] = 3;
		$config['total_rows'] = $number_articles;
		$config['num_links'] = $number_articles;
		$config['full_tag_open']= "<div class='pagination'>";
		$config['full_tag_close']= "</div>";
		$config['prev_link']= "Previous";
		$config['next_link']= "Next";
		/*$config['next_tag_open']= "<a>";
		$config['next_tag_close']= "</a>";
		$config['pre_tag_open']= "<a>";
		$config['pre_tag_close']= "</a>";
		$config['num_tag_open']= "<a>";
		$config['num_tag_close']= "</a>";*/
		$config['cur_tag_open']= "<a class='active'>";
		$config['cur_tag_close']= "</a>";

		//$this->print($config);
		$this->pagination->initialize($config);

		$limit = $config['per_page'];
		$offset = $this->uri->segment(3);

		$categories = $this->db->select()->from($this->table_category)->where('user_id', $user_id)->order_by('category_id', 'desc')->limit($limit, $offset)->get()->result();

		$this->load->view('admin/view_category', ['categories' => $categories]);
	}

	public function logout()
	{
		$this->session->unset_userdata('user_id');
		return redirect('LoginController');
	}

	public function addCategory()
	{
		$this->load->view('admin/view_add_category');

	}

	public function createCategory0() {
		$config = array();
		$config['upload_path'] = './uploads/category/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		/*$config['max_size']    = 100;
		$config['max_width']   = 1024;
		$config['max_height']  = 768;*/

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		$form_validation = $this->form_validation->run('add_category_rules');
		$category_image = $this->upload->do_upload('category_image');

		if ($form_validation && $category_image) {
			//unset($post['submit']);

			$image_data = $this->upload->data();
			
			$data = array();
			$data['category_name'] = $this->input->post('category_name');
			$data['category_description'] = $this->input->post('category_description');
			$data['category_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
			$data['user_id'] = $this->input->post('user_id');
			$data['category_status'] = '0';
			$data['category_created_on'] = $this->input->post('created_at');

			$articles = $this->db->insert($this->table_category, $data);
			
			return $this->flash($articles, '!! Category added !!', 'Category not added...', 'AdminController/category');

		} else {
			$upload_error = $this->upload->display_errors();
			$this->load->view('admin/view_add_category', compact('upload_error'));
		}
	}

	public function createCategory() {
		//$this->print($_FILES['category_image']['name']);
		//$this->print($_FILES);
		//$this->print($this->input->post());
		//$this->print($data);

		$this->form_validation->set_rules('category_name','Category Name','trim|required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('category_description','Category Description','trim|required|min_length[4]|max_length[40]');
		
		if($this->form_validation->run() == TRUE ) {
			$user_id = $this->session->userdata('user_id');

			if (empty($_FILES['category_image']['name'])) {

				$data = array();
				$data['category_name'] = $this->input->post('category_name');
				$data['category_description'] = $this->input->post('category_description');
				$data['category_image'] = 'default.png';
				$data['user_id'] = $user_id;
				$data['category_code'] = time();
				$data['category_status'] = '0';
				$data['category_created_on'] = date('Y-m-d H:i:s');

				$category_inserted = $this->db->insert($this->table_category, $data);

				return $this->flash($category_inserted, '!! Category added !!', 'Category not added...', 'AdminController/category');
				
			} else {

				$config = array();
				$config['upload_path'] = './uploads/category/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_filename'] = '255';
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = TRUE;
				$config['max_size']= '0';
				$config['max_width']   = '0';
				$config['max_height']  = '0';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$category_image = $this->upload->do_upload('category_image');
				
				if ($category_image) {
					$category_image_data = $this->upload->data();
					$category_file_name = $category_image_data['file_name'];

					$data = array();
					$data['category_name'] = $this->input->post('category_name');
					$data['category_description'] = $this->input->post('category_description');
					$data['category_image'] = $category_file_name;
					$data['user_id'] = $user_id;
					$data['category_code'] = time();
					$data['category_status'] = '0';
					$data['category_created_on'] = date('Y-m-d H:i:s');
					$category_inserted = $this->db->insert($this->table_category, $data);

					return $this->flash($category_inserted, '!! Category added !!', 'Category not added...', 'AdminController/category');

				} else {

	   				$upload_error = array('upload_error' => $this->upload->display_errors());

					$this->load->view('admin/view_add_category', $upload_error);
				}

			}
       
		} else {
			$this->addCategory();
		}
	}

	public function editCategory()
	{
		if ($_POST) {
			$category_id = $this->input->post('category_id');
			$this->session->set_userdata('category_id', $category_id);
		} else {
			$category_id = $this->session->userdata('category_id');
		}

		$category = $this->db->select()->from($this->table_category)->where('category_id', $category_id)->get()->row();
	   	$categories = array('category' => $category);

		$this->load->view('admin/view_edit_category', $categories);
	}

	public function updateCategory() {

		//$this->print($_FILES['category_image']['name']);
		//$this->print($_FILES);
		//$this->print($this->input->post());

		$this->form_validation->set_rules('category_name','Category Name','trim|required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('category_description','Category Description','trim|required|min_length[4]|max_length[40]');
		
		if($this->form_validation->run() == TRUE ) {

			if (empty($_FILES['category_image']['name'])) {
				//unset($post['submit']);

				$category_id = $this->input->post('category_id');
			
				$category = array('category_name' => $this->input->post('category_name'),'category_description' => $this->input->post('category_description'));
				$category_updated = $this->db->where('category_id', $category_id)->update($this->table_category, $category);

				return $this->flash($category_updated, 'Category Updated...', 'Category Not Updated Error!!', 'AdminController/category');

			} else {

				$config = array();
				$config['upload_path'] = './uploads/category/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$category_image = $this->upload->do_upload('category_image');
				
				if ($category_image) {
					$category_image_name = $this->upload->data();
       				$category_file_name = $category_image_name['file_name'];

       				$category_id = $this->input->post('category_id');

					$category = array('category_name' => $this->input->post('category_name'),'category_description' => $this->input->post('category_description'), 'category_image' => $category_file_name);
					$category_updated = $this->db->where('category_id', $category_id)->update($this->table_category, $category);

					return $this->flash($category_updated, 'Category Updated...', 'Category Not Updated Error!!', 'AdminController/category');

				} else {

					if ($_POST) {
						$category_id = $this->input->post('category_id');
						$this->session->set_userdata('category_id', $category_id);
					} else {
						$category_id = $this->session->userdata('category_id');
					}

					$category = $this->db->select()->from($this->table_category)->where('category_id', $category_id)->get()->row();
	   				$category_upload_error = array('category' => $category, 'upload_error' => $this->upload->display_errors());

					$this->load->view('admin/view_edit_category', $category_upload_error);
				}

			}
       
		} else {
			$this->editCategory();
		}
		
	}

	public function deleteCategory()
	{
		$delete_category = $this->input->post();

		$category_id = $delete_category['category_id'];
		$category_name = $delete_category['category_name'];
		$category = array('category_id' => $category_id);
		$category_deleted = $this->db->delete($this->table_category, $category);

		return $this->flash($category_deleted, $category_name.' Category Deleted...', 'Category Not Deleted...', 'AdminController/category');

	}

	public function activeCategory()
	{
		$active_category = $this->input->post();
		//echo "<pre>"; print_r($active_category); exit();

		$category_id = $active_category['category_id'];
		$category = array('category_status' => $this->input->post('category_status'));
		$category_updated = $this->db->where('category_id', $category_id)->update($this->table_category, $category);

		return $this->flashMessage($category_updated, $this->input->post('category_activity'), 'Something Error!!');

	}


	/************************************************************************************************************/

	public function addProducts()
	{
		$categories = $this->db->select('*')->from($this->table_category)->get()->result();
		
		$this->load->view('admin/view_add_products', ['categories' => $categories]);
	}

	public function products()
	{
		$products = $this->db->select('*')->from($this->table_product)->order_by('product_id', 'desc')->get()->result();
		$products_view = array('products' => $products);

		$this->load->view('admin/view_products', $products_view);
	}

	public function createProduct()
	{
		//$this->print($_FILES['category_image']['name']);
		//$this->print($_FILES);
		//$this->print($this->input->post());

		$this->form_validation->set_rules('product_name','Product Name','trim|required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('product_description','Product Description','trim|required|min_length[4]|max_length[40]');
		
		if($this->form_validation->run() == TRUE ) {
			$user_id = $this->session->userdata('user_id');

			if (empty($_FILES['product_image']['name'])) {

				$data = array();
				$data['product_name'] = $this->input->post('product_name');
				$data['product_description'] = $this->input->post('product_description');
				$data['product_image'] = 'default.png';
				$data['category_id'] = $this->input->post('category_id');
				$data['user_id'] = $user_id;
				$data['category_code'] = time();
				$data['product_code'] = time();
				$data['product_status'] = $this->input->post('product_activity_name');
				$data['product_created_on'] = date('Y-m-d H:i:s');

				$product_inserted = $this->db->insert($this->table_product, $data);

				return $this->flash($product_inserted, '!! Product added !!', 'Product not added...', 'AdminController/products');
				
			} else {

				$config = array();
				$config['upload_path'] = './uploads/category/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_filename'] = '255';
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = TRUE;
				$config['max_size']= '0';
				$config['max_width']   = '0';
				$config['max_height']  = '0';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$product_image = $this->upload->do_upload('product_image');
				
				if ($product_image) {
					$product_image_data = $this->upload->data();
					$product_file_name = $product_image_data['file_name'];

					$data = array();
					$data['product_name'] = $this->input->post('product_name');
					$data['product_description'] = $this->input->post('product_description');
					$data['product_image'] = $product_file_name;
					$data['category_id'] = $this->input->post('category_id');
					$data['user_id'] = $user_id;
					$data['category_code'] = time();
					$data['product_code'] = time();
					$data['product_status'] = $this->input->post('product_activity_name');
					$data['product_created_on'] = date('Y-m-d H:i:s');

					$product_inserted = $this->db->insert($this->table_product, $data);

					return $this->flash($product_inserted, '!! Product added !!', 'Product not added...', 'AdminController/products');
					
				} else {
					
					$categories = $this->db->select('*')->from($this->table_category)->get()->result();
	   				$upload_error = array('categories' => $categories, 'upload_error' => $this->upload->display_errors());

					$this->load->view('admin/view_products', $upload_error);
				}

			}
       
		} else {
			$this->addProducts();
		}		
	}

	public function editProductView()
	{
		if ($_POST) {
			$product_id = $this->input->post('product_id');
			$this->session->set_userdata('product_id', $product_id);
		} else {
			$product_id = $this->session->userdata('product_id');
		}

		$categories = $this->db->select('*')->from($this->table_category)->get()->result();
		$products = $this->db->select()->from($this->table_product)->where('product_id', $product_id)->get()->row();
		$products_view = array('products' => $products, 'categories' => $categories);

		$this->load->view('admin/view_edit_products', $products_view);

	}

	public function editProduct()
	{
		//$this->print($_FILES['category_image']['name']);
		//$this->print($_FILES);
		//$this->print($this->input->post());

		$this->form_validation->set_rules('product_name','Product Name','trim|required|min_length[4]|max_length[40]');
		$this->form_validation->set_rules('product_description','Product Description','trim|required|min_length[4]|max_length[40]');
		
		if($this->form_validation->run() == TRUE ) {
			$user_id = $this->session->userdata('user_id');
			$product_id = $this->input->post('product_id');

			if (empty($_FILES['product_image']['name'])) {

				$data = array();
				$data['product_name'] = $this->input->post('product_name');
				$data['product_description'] = $this->input->post('product_description');
				$data['category_id'] = $this->input->post('category_id');
				$data['user_id'] = $user_id;
				$data['category_code'] = time();
				$data['product_code'] = time();
				$data['product_status'] = $this->input->post('product_activity_name');
				$data['product_created_on'] = date('Y-m-d H:i:s');

				$product_inserted = $this->db->where('product_id', $product_id)->update($this->table_product, $data);

				return $this->flash($product_inserted, '!! Product updated !!', 'Product not updated...', 'AdminController/products');
				
			} else {

				$config = array();
				$config['upload_path'] = './uploads/category/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_filename'] = '255';
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = TRUE;
				$config['max_size']= '0';
				$config['max_width']   = '0';
				$config['max_height']  = '0';

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$product_image = $this->upload->do_upload('product_image');
				
				if ($product_image) {
					$product_image_data = $this->upload->data();
					$product_file_name = $product_image_data['file_name'];

					$data = array();
					$data['product_name'] = $this->input->post('product_name');
					$data['product_description'] = $this->input->post('product_description');
					$data['product_image'] = $product_file_name;
					$data['category_id'] = $this->input->post('category_id');
					$data['user_id'] = $user_id;
					$data['category_code'] = time();
					$data['product_code'] = time();
					$data['product_status'] = $this->input->post('product_activity_name');
					$data['product_created_on'] = date('Y-m-d H:i:s');

					$product_inserted = $this->db->where('product_id', $product_id)->update($this->table_product, $data);

					return $this->flash($product_inserted, '!! Product updated !!', 'Product not updated...', 'AdminController/products');
					
				} else {
					
					$categories = $this->db->select('*')->from($this->table_category)->get()->result();
	   				$upload_error = array('categories' => $categories, 'upload_error' => $this->upload->display_errors());

					$this->load->view('admin/view_products', $upload_error);
				}

			}
       
		} else {
			$this->products();
		}		
	}

	public function deleteProduct()
	{

		$product_id = $this->input->post('product_id');
		$product_name = $this->input->post('product_name');
		$product = array('product_id' => $product_id);
		$product_deleted = $this->db->delete($this->table_product, $product);

		return $this->flash($product_deleted, $product_name.' Product deleted...', 'Product not deleted...', 'AdminController/products');

	}

	public function activeProduct()
	{
		$product_id = $this->input->post('product_id');
		$product_name = $this->input->post('product_name');
		$product = array('product_status' => $this->input->post('product_status'));
		$product_status_updated = $this->db->where('product_id', $product_id)->update($this->table_product, $product);

		return $this->flash($product_status_updated, $product_name.' Product status updated...', 'Something Error!!', 'AdminController/products');

	}

	/************************************************************************************************************/

	public function flashMessage($isSuccessful = false, $successfulMessage = '', $failureMessage = '')
	{
		if ($isSuccessful) {
			$this->session->set_flashdata('dashboard_category_success', $successfulMessage);
			
		} else {
			$this->session->set_flashdata('dashboard_category_success', $failureMessage);
			
		}
		
		return redirect('AdminController/dashboard');
	}
	
	public function flash($isSuccessful = false, $successfulMessage = '', $failureMessage = '', $page = '')
	{
		if ($isSuccessful) {
			$this->session->set_flashdata('dashboard_category_success', $successfulMessage);
			
		} else {
			$this->session->set_flashdata('dashboard_category_success', $failureMessage);
			
		}
		
		return redirect($page);
	}

}
