<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class APIController extends CI_Controller {

	public $table_category = "table_category";
	public $table_child_category = "table_child_category";
	public $table_product = "table_product";
	public $table_users = "users";

	public function __construct()
    {
        parent::__construct();
		$this->load->helper(array('url'));
		$this->load->library(array('upload'));
	}

	public function index() {
	}

	public function login()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['user_information'] = array();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else if (empty($password)) {
				$response['status'] = false;
				$response['message'] = 'Please enter password';
				echo json_encode($response);
			} else {
				
				$this->db->where(array('email' => $email, 'password' => md5($password)));
				$login_id = $this->db->get($this->table_users)->row()->user_id;

				if ($login_id) {
					//credentials valid
					
					/*$response['status'] = true;
					$response['message'] = 'login success!';
					$user_information['email'] = $email;
					$user_information['password'] = $password;
					array_push($response['user_information'], $user_information);
					echo json_encode($response);*/
					
					$response['status'] = true;
					$response['message'] = 'Login successfully!';
					$user_information['user_id'] = $login_id;
					$user_information['email'] = $email;
					$user_information['password'] = $password;
					$response['user_information'] = array($user_information);
					echo json_encode($response);

				} else {
					// authenticate failed
					$response['status'] = false;
					$response['message'] = 'invalid email or password!';
					echo json_encode($response);	
				}
			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
	}

	public function login_information()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['user_information'] = array();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else if (empty($password)) {
				$response['status'] = false;
				$response['message'] = 'Please enter password';
				echo json_encode($response);
			} else {
				$this->db->where(array('email' => $email, 'password' => md5($password)));
				$login_information = $this->db->get($this->table_users)->row();

				if ($login_information) {
					$response['status'] = true;
					$response['message'] = 'Login successfully!';
					$response['user_information'] = $login_information;
					echo json_encode($response);
					
				} else {
					$response['status'] = false;
					$response['message'] = 'invalid email or password!';
					echo json_encode($response);
				}
				

			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
	}

	public function register() {
		$response = array();
		$response['status'] = false;
		$response['message'] = 'login failed';
		$response['user_information'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if (empty($username)) {
				$response['status'] = false;
				$response['message'] = 'Please enter username';
				echo json_encode($response);
			} else if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else if (empty($password)) {
				$response['status'] = false;
				$response['message'] = 'Please enter password';
				echo json_encode($response);
			} else {
				$data = array();
				$data['username'] = $username;
				$data['email'] = $email;
				$data['password'] = md5($password);
				$this->db->insert($this->table_users, $data);
				$insert_id = $this->db->insert_id();

				if ($insert_id) {
					//credentials valid
					
					$response['status'] = true;
					$response['message'] = 'Registered successfull!';
					$user_information['user_id'] = $insert_id;
					$user_information['username'] = $username;
					$user_information['email'] = $email;
					$user_information['password'] = md5($password);
					$response['user_information'] = array($user_information);
					echo json_encode($response);

				} else {
					// authenticate failed
					$response['status'] = false;
					$response['message'] = 'invalid username / email / password!';
					echo json_encode($response);
				}

			}
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function register_information()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = 'login failed';
		$response['user_information'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if (empty($username)) {
				$response['status'] = false;
				$response['message'] = 'Please enter username';
				echo json_encode($response);
			} else if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else if (empty($password)) {
				$response['status'] = false;
				$response['message'] = 'Please enter password';
				echo json_encode($response);
			} else {

				date_default_timezone_set('Asia/Kolkata');
				$date = date('Y-m-d H:i:s');

				$data = array();
				$data['username'] = $username;
				$data['email'] = $email;
				$data['password'] = md5($password);
				$data['birthday'] = $date;
				$data['created_at'] = $date;

				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$this->db->where('email', $email);
				    $check_duplicate_email = $this->db->get($this->table_users)->num_rows();

					if ($check_duplicate_email) {
						$response['status'] = false;
						$response['message'] = 'email already registered!';
						echo json_encode($response);
						
					} else {
						$this->db->insert($this->table_users, $data);
						$insert_id = $this->db->insert_id();

						if ($insert_id) {
							//credentials valid
							
							/*$response['status'] = true;
							$response['message'] = 'Registered successfull!';
							$user_information['user_id'] = $insert_id;
							$user_information['username'] = $username;
							$user_information['email'] = $email;
							$user_information['password'] = $password;
							$response['user_information'] = array($user_information);
							echo json_encode($response);*/

							$this->db->select('*');
							$this->db->where('user_id', $insert_id);
							$user_information = $this->db->get($this->table_users)->row();

							$response['status'] = true;
							$response['message'] = 'Registered successfull!';
							$response['user_information'][] = $user_information;
							echo json_encode($response);

						} else {
							// authenticate failed
							$response['status'] = false;
							$response['message'] = 'invalid username / email / password!';
							echo json_encode($response);
							
						}
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Enter valid email!';
					echo json_encode($response);
				}

			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function update_information()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = 'login failed';
		$response['user_information'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$username = $this->input->post('username');
			$email = $this->input->post('email');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if (empty($username)) {
				$response['status'] = false;
				$response['message'] = 'Please enter username';
				echo json_encode($response);
			} else if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$date = date('Y-m-d H:i:s');

				$data = array();
				$data['username'] = $username;
				$data['email'] = $email;
				$data['birthday'] = $date;
				$data['created_at'] = $date;

				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$this->db->where('email', $email);
					$check_duplicate_email = $this->db->get($this->table_users)->num_rows();

					if ($check_duplicate_email == 0) {
						$response['status'] = false;
						$response['message'] = 'Email not registered!';
						echo json_encode($response);
						
					} else {
						$this->db->where(array('user_id' => $user_id));
						$check_user_updated	= $this->db->update($this->table_users, $data);

						if ($check_user_updated) {
							//credentials valid
							
							/*$response['status'] = true;
							$response['message'] = 'Registered successfull!';
							$user_information['user_id'] = $user_id;
							$user_information['username'] = $username;
							$user_information['email'] = $email;
							$user_information['password'] = $password;
							$response['user_information'] = array($user_information);
							echo json_encode($response);*/

							$this->db->select('*');
							$this->db->where('user_id', $user_id);
							$user_information = $this->db->get($this->table_users)->row();

							$response['status'] = true;
							$response['message'] = 'Successfully updated!';
							$response['user_information'][] = $user_information;
							echo json_encode($response);

						} else {
							// authenticate failed
							$response['status'] = false;
							$response['message'] = 'invalid username / email / password!';
							echo json_encode($response);
							
						}
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Please enter valid email!';
					echo json_encode($response);
				}

			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function update_user_information()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['user_information'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$username = $this->input->post('username');
			$email = $this->input->post('email');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if (empty($username)) {
				$response['status'] = false;
				$response['message'] = 'Please enter username';
				echo json_encode($response);
			} else if (empty($email)) {
				$response['status'] = false;
				$response['message'] = 'Please enter email';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$date = date('Y-m-d H:i:s');

				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$this->db->where('email', $email);
					$check_duplicate_email = $this->db->get($this->table_users)->num_rows();

					if ($check_duplicate_email == 0) {
						$response['status'] = false;
						$response['message'] = 'Email not registered!';
						echo json_encode($response);
						
					} else {
						$data = array();
						$data['username'] = $username;
						$data['birthday'] = $date;
						$data['created_at'] = $date;
						
						$this->db->select('*')->from($this->table_users);
                		$this->db->where('user_id', $user_id);
						$this->db->where('email', $email);
						$check_user_updated = $this->db->get()->result_array();

						if ($check_user_updated) {
							$this->db->where('user_id', $user_id);
							$this->db->where('email', $email);
							$this->db->update($this->table_users, $data);

							$this->db->select('*');
							$this->db->where('user_id', $user_id);
							$this->db->where('email', $email);
							$user_information = $this->db->get($this->table_users)->row();

							$response['status'] = true;
							$response['message'] = 'Successfully updated!';
							$response['user_information'][] = $user_information;
							echo json_encode($response);

						} else {
							// authenticate failed
							$response['status'] = false;
							$response['message'] = 'Please enter valid credentials!';
							echo json_encode($response);
							
						}
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Please enter valid email!';
					echo json_encode($response);
				}

			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function change_password()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');

			if (!empty($user_id) && !empty($current_password) && !empty($new_password)) {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$decode_current_password = md5($current_password);

				$this->db->where('user_id', $user_id);
				$this->db->where('password', $decode_current_password);
				$query = $this->db->get('users');

    			if($query->num_rows() > 0) {
    				$data = array();
					$data['password'] = md5($new_password);
					$data['created_at'] = $created_at;
	    			$this->db->where('user_id', $user_id);
	    			$this->db->update('users', $data);

					$response['status'] = true;
					$response['message'] = 'Password updated successfully!';
					echo json_encode($response);
    			} else {
    				$response['status'] = false;
					$response['message'] = 'Current Password is not found!!';
					echo json_encode($response);
    			}
									
			} else {
				
				if (empty($user_id)) {
					$response['status'] = false;
					$response['message'] = 'Please enter user id';
					echo json_encode($response);
				} else if (empty($current_password)) {
					$response['status'] = false;
					$response['message'] = 'Please enter current password';
					echo json_encode($response);
				} else {
					$response['status'] = false;
					$response['message'] = 'Please enter new password';
					echo json_encode($response);
				}
				

			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
		
	}

	public function add_category()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_code = $this->input->post('category_code');
			$category_name = $this->input->post('category_name');
			$category_description = $this->input->post('category_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$category_image_file = $this->upload->do_upload('category_image_file');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if (empty($category_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category name';
				echo json_encode($response);
			} else if (empty($category_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category description';
				echo json_encode($response);
			} else if (empty($category_image_file)) {
				$response['status'] = false;
				$response['message'] = 'Please upload category image';
				echo json_encode($response);	
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$image_data = $this->upload->data();

				$data = array();  
				$data['category_code'] = $category_name;
				$data['category_name'] = $category_name;
				$data['category_description'] = $category_description;
				$data['category_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
				$data['user_id'] = $user_id;
				$data['category_status'] = "0";
				$data['category_created_on'] = $created_at;

				$this->db->insert($this->table_category, $data);
				$category_inserted_id = $this->db->insert_id();

				$this->db->select('*');
				$this->db->where('category_id', $category_inserted_id);
				$category = $this->db->get($this->table_category)->row();

				$response['status'] = true;
				$response['message'] = '';
				$response['data'][] = $category;
				echo json_encode($response);
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
	}

	public function update_category()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_id = $this->input->post('category_id');
			$category_name = $this->input->post('category_name');
			$category_description = $this->input->post('category_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);


			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if (empty($category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category id';
				echo json_encode($response);
			} else if (empty($category_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category name';
				echo json_encode($response);
			} else if (empty($category_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category description';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
				$check_articles = $this->db->get($this->table_category)->row();
				if ($check_articles) {

					$category_image_file = $this->upload->do_upload('category_image_file');

					if (empty($category_image_file)) {
						$response['status'] = false;
						$response['message'] = 'Please upload category image';
						echo json_encode($response);
					} else {
						$image_data = $this->upload->data();

						$data = array();  
						$data['category_name'] = $category_name;
						$data['category_description'] = $category_description;
						$data['category_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
						$data['category_status'] = "0";
						$data['category_created_on'] = $created_at;

						$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
						$articles_updated = $this->db->update($this->table_category, $data);
						if ($articles_updated) {
							$this->db->select('*');
							$this->db->where('category_id', $category_id);
							$articles = $this->db->get($this->table_category)->row();

							$response['status'] = true;
							$response['message'] = '';
							$response['data'][] = $articles;
							echo json_encode($response);
							
						} else {
							$response['status'] = false;
							$response['message'] = 'Category not updated!!';
							echo json_encode($response);
						}
						
					}

				} else {
					$response['status'] = false;
					$response['message'] = 'Category not found!!';
					echo json_encode($response);
				}
				
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
	}

	public function getCategory()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->db->select('*');
			$this->db->from($this->table_users);
			$this->db->join($this->table_category, $this->table_users.'.user_id = '.$this->table_category.'.user_id');

			$query = $this->db->get();
			if($query->num_rows() != 0)
			{
				$response['status'] = true;
				$response['message'] = '';
				$response['data'] = $query->result();
				echo json_encode($response);
			} else {
				$response['status'] = false;
				$response['message'] = 'data not found!!';
				echo json_encode($response);
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}
	}

	public function deleteCategory()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_id = $this->input->post('category_id');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category id';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
				$check_category = $this->db->get($this->table_category)->row();

				if ($check_category) {
					$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
					$check_category_deleted = $this->db->delete($this->table_category);

					if($check_category_deleted) {
						$response['status'] = true;
						$response['message'] = 'Category deleted successfully!!';
						echo json_encode($response);
					} else {
						$response['status'] = false;
						$response['message'] = 'Category not deleted!!';
						echo json_encode($response);
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Category not found!!';
					echo json_encode($response);
				}
			}

		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}
	}

	public function add_child_category()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_id = $this->input->post('category_id');
			$child_category_name = $this->input->post('child_category_name');
			$child_category_description = $this->input->post('child_category_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$child_category_image_file = $this->upload->do_upload('child_category_image_file');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category id';
				echo json_encode($response);
			} else if(empty($child_category_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category name';
				echo json_encode($response);
			} else if(empty($child_category_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category description';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
				$check_category = $this->db->get($this->table_category)->row();

				if ($check_category) {

					$image_data = $this->upload->data();

					$data = array();  
					$data['category_id'] = $category_id;
					$data['child_category_name'] = $child_category_name;
					$data['child_category_description'] = $child_category_description;
					$data['child_category_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
					$data['user_id'] = $user_id;
					$data['child_category_status'] = "0";
					$data['child_category_created_on'] = $created_at;

					$this->db->insert($this->table_child_category, $data);
					$child_category_inserted_id = $this->db->insert_id();

					if ($child_category_inserted_id) {
						$this->db->select('*');
						$this->db->where(array('child_category_id' => $child_category_inserted_id, 'user_id' => $user_id));
						$child_category_data = $this->db->get($this->table_child_category)->row();

						$response['status'] = true;
						$response['message'] = 'Child Category added successfully!!';
						$response['data'][] = $child_category_data;
						echo json_encode($response);
						
					} else {
						$response['status'] = false;
						$response['message'] = 'Child Category not added!!';
						echo json_encode($response);
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Category not found!!';
					echo json_encode($response);
				}
				
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}
	}

	public function update_child_category()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$child_category_id = $this->input->post('child_category_id');
			$child_category_name = $this->input->post('child_category_name');
			$child_category_description = $this->input->post('child_category_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($child_category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category id';
				echo json_encode($response);
			} else if(empty($child_category_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category name';
				echo json_encode($response);
			} else if(empty($child_category_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category description';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('child_category_id' => $child_category_id, 'user_id' => $user_id));
				$check_child_category = $this->db->get($this->table_child_category)->row();

				if ($check_child_category) {
					$child_category_image_file = $this->upload->do_upload('child_category_image_file');

					if(empty($child_category_image_file)) {
						$response['status'] = false;
						$response['message'] = 'Please upload child category image';
						echo json_encode($response);
					} else {
						$image_data = $this->upload->data();

						$data = array();  
						$data['child_category_id'] = $child_category_id;
						$data['child_category_name'] = $child_category_name;
						$data['child_category_description'] = $child_category_description;
						$data['child_category_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
						$data['user_id'] = $user_id;
						$data['child_category_status'] = "0";
						$data['child_category_created_on'] = $created_at;

						$this->db->where(array('child_category_id' => $child_category_id, 'user_id' => $user_id));
						$child_category_updated_id = $this->db->update($this->table_child_category, $data);

						if ($child_category_updated_id) {
							$this->db->select('*');
							$this->db->where(array('child_category_id' => $child_category_id, 'user_id' => $user_id));
							$child_category_data = $this->db->get($this->table_child_category)->row();

							$response['status'] = true;
							$response['message'] = 'Child Category updated successfully!!';
							$response['data'][] = $child_category_data;
							echo json_encode($response);
							
						} else {
							
							$response['status'] = false;
							$response['message'] = 'Child Category not updated!!';
							echo json_encode($response);
							
						}

					}
				} else {
					$response['status'] = false;
					$response['message'] = 'Child Category not found!!';
					echo json_encode($response);
					
				}
				
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function getChildCategory()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->db->select('*');
			$this->db->from($this->table_users);
			$this->db->join($this->table_child_category, $this->table_users.'.user_id = '.$this->table_child_category.'.user_id');

			$query = $this->db->get();
			if($query->num_rows() != 0)
			{
				$response['status'] = true;
				$response['message'] = '';
				$response['data'] = $query->result();
				echo json_encode($response);
			} else {
				$response['status'] = false;
				$response['message'] = 'data not found!!';
				echo json_encode($response);
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}
	}

	public function delete_child_category()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$child_category_id = $this->input->post('child_category_id');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($child_category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter child category id';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('child_category_id' => $child_category_id, 'user_id' => $user_id));
				$check_child_category = $this->db->get($this->table_child_category)->row();

				if ($check_child_category) {
					$this->db->where(array('child_category_id' => $child_category_id, 'user_id' => $user_id));
					$check_child_category_deleted = $this->db->delete($this->table_child_category);

					if($check_child_category_deleted) {
						$response['status'] = true;
						$response['message'] = 'Child Category deleted successfully!!';
						echo json_encode($response);
					} else {
						$response['status'] = false;
						$response['message'] = 'Child Category not deleted!!';
						echo json_encode($response);
					}
					
				} else {
					
					$response['status'] = false;
					$response['message'] = 'Child Category not found!!';
					echo json_encode($response);
					
				}
			}

		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}

	}

	public function add_product()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_id = $this->input->post('category_id');
			$product_name = $this->input->post('product_name');
			$product_description = $this->input->post('product_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category id';
				echo json_encode($response);
			} else if(empty($product_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product name';
				echo json_encode($response);
			} else if(empty($product_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product description';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
				$check_category = $this->db->get($this->table_category)->row();

				if ($check_category) {

					$product_image = $this->upload->do_upload('product_image');

					if (empty($product_image)) {
						$response['status'] = false;
						$response['message'] = 'Please upload product image';
						echo json_encode($response);
						
					} else {
						$image_data = $this->upload->data();

						$data = array();  
						$data['user_id'] = $user_id;
						$data['category_id'] = $category_id;
						$data['product_code'] = $product_name;
						$data['product_name'] = $product_name;
						$data['product_description'] = $product_description;
						$data['product_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
						$data['product_status'] = "0";
						$data['product_created_on'] = $created_at;

						$this->db->insert($this->table_product, $data);
						$product_inserted_id = $this->db->insert_id();

						if ($product_inserted_id) {
							$this->db->select('*');
							$this->db->where(array('product_id' => $product_inserted_id, 'user_id' => $user_id));
							$product_data = $this->db->get($this->table_product)->row();

							$response['status'] = true;
							$response['message'] = 'Product added successfully!!';
							$response['data'][] = $product_data;
							echo json_encode($response);
							
						} else {
							$response['status'] = false;
							$response['message'] = 'Product not added!!';
							echo json_encode($response);
						}
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Category not found!!';
					echo json_encode($response);
				}
				
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function update_product()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$category_id = $this->input->post('category_id');
			$product_id = $this->input->post('product_id');
			$product_name = $this->input->post('product_name');
			$product_description = $this->input->post('product_description');

			$config = array();
			$config['upload_path'] = './uploads/category/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($category_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter category id';
				echo json_encode($response);
			} else if(empty($product_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product id';
				echo json_encode($response);
			} else if(empty($product_name)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product name';
				echo json_encode($response);
			} else if(empty($product_description)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product description';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('category_id' => $category_id, 'user_id' => $user_id));
				$check_category = $this->db->get($this->table_category)->row();

				if ($check_category) {

					$product_image = $this->upload->do_upload('product_image');

					if (empty($product_image)) {
						$response['status'] = false;
						$response['message'] = 'Please upload product image';
						echo json_encode($response);
						
					} else {
						$image_data = $this->upload->data();

						$data = array();  
						$data['user_id'] = $user_id;
						$data['category_id'] = $category_id;
						$data['product_code'] = $product_name;
						$data['product_name'] = $product_name;
						$data['product_description'] = $product_description;
						$data['product_image'] = base_url()."uploads/category/".$image_data['raw_name'].$image_data['file_ext'];
						$data['product_status'] = "0";
						$data['product_created_on'] = $created_at;

						$this->db->where(array('product_id' => $product_id, 'user_id' => $user_id));
						$updated_product_id = $this->db->update($this->table_product, $data);

						if ($updated_product_id) {
							$this->db->select('*');
							$this->db->where(array('product_id' => $product_id, 'user_id' => $user_id));
							$product_data = $this->db->get($this->table_product)->row();

							$response['status'] = true;
							$response['message'] = 'Product updated successfully!!';
							$response['data'][] = $product_data;
							echo json_encode($response);
							
						} else {
							$response['status'] = false;
							$response['message'] = 'Product not added!!';
							echo json_encode($response);
						}
					}
					
				} else {
					$response['status'] = false;
					$response['message'] = 'Category not found!!';
					echo json_encode($response);
				}
				
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
			
		}

	}

	public function get_product()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';

		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
			$this->db->select('*');
			$this->db->from($this->table_users);
			$this->db->join($this->table_product, $this->table_users.'.user_id = '.$this->table_product.'.user_id');

			$query = $this->db->get();
			if($query->num_rows() != 0)
			{
				$response['status'] = true;
				$response['message'] = '';
				$response['data'] = $query->result();
				echo json_encode($response);
			} else {
				$response['status'] = false;
				$response['message'] = 'data not found!!';
				echo json_encode($response);
			}
			
		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}
	}

	public function delete_product()
	{
		$response = array();
		$response['status'] = false;
		$response['message'] = '';
		$response['data'] = array();		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$user_id = $this->input->post('user_id');
			$product_id = $this->input->post('product_id');

			if (empty($user_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter user id';
				echo json_encode($response);
			} else if(empty($product_id)) {
				$response['status'] = false;
				$response['message'] = 'Please enter product id';
				echo json_encode($response);
			} else {
				date_default_timezone_set('Asia/Kolkata');
				$created_at = date('Y-m-d H:i:s');

				$this->db->select('*');
				$this->db->where(array('product_id' => $product_id, 'user_id' => $user_id));
				$check_product = $this->db->get($this->table_product)->row();

				if ($check_product) {
					$this->db->where(array('product_id' => $product_id, 'user_id' => $user_id));
					$check_product_deleted = $this->db->delete($this->table_product);

					if($check_product_deleted) {
						$response['status'] = true;
						$response['message'] = 'Product deleted successfully!!';
						echo json_encode($response);
					} else {
						$response['status'] = false;
						$response['message'] = 'Product not deleted!!';
						echo json_encode($response);
					}
					
				} else {
					
					$response['status'] = false;
					$response['message'] = 'Product not found!!';
					echo json_encode($response);
					
				}
			}

		} else {
			$response['status'] = false;
			$response['message'] = 'Please select valid request..';
			echo json_encode($response);
		}

	}

}