<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends MY_Controller {

	public function __construct()
    {
   			parent::__construct();
			$this->load->helper(array('url', 'html', 'form'));

    }

	public function index()
	{
		if ($this->session->userdata('user_id')){
			return redirect('AdminController/dashboard');
		} else {
			$this->load->view('users/view_login');
		}
	}

	public function login()
	{
		$this->load->helper(array('url', 'html', 'form'));
		$this->load->library('form_validation');
		
		//$this->form_validation->set_rules('email', 'Email', 'required|trim');
		//$this->form_validation->set_rules('password', 'Password', 'required|trim');
		/*$this->form_validation->set_error_delimiters('<div class="errors">', '</div>');*/

		if ($this->form_validation->run('admin_login_rules')) {

			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$this->db->where(array('email' => $email, 'password' => md5($password)));
			$login_id = $this->db->get($this->table_users)->row()->user_id;
			$user_status = $this->db->get($this->table_users)->row()->user_status;

			if ($login_id) {
				if ($user_status == 'verified') {
					$this->session->set_userdata('user_id', $login_id);
					return redirect('AdminController/dashboard');
				} else {
					$this->session->set_flashdata('login_failed', 'Email is not verified.');
					redirect('LoginController');

				}
			} else {
				// authenticate failed
				// $this->load->view('users/view_invalid_login');

				$this->session->set_flashdata('login_failed', 'Invalid Email/Password.');
				redirect('LoginController');
			}
			

		}else {
			//echo "failed";
			//echo validation_errors();

			$this->load->view('users/view_login');

		}

	}

	public function forgotPassword()
	{
		$this->load->view('users/view_forgot_password');

	}

	public function viewChangePassword()
	{
		$this->load->view('users/view_change_password');

	}

	public function changePassword()
	{
				$this->load->helper(array('url', 'html', 'form'));
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim');
		//$this->form_validation->set_error_delimiters('<div class="errors">', '</div>');
	
			if($this->form_validation->run() == TRUE ) {
				//$this->print($this->input->post());
				$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');

			$user_id = $this->session->userdata('user_id');
			$this->db->where(array('user_id' => 3, 'password' => md5($current_password)));
			$this->print($this->db->get($this->table_users)->result());

			}else {
	$this->load->view('users/view_change_password');
}



	}

}
