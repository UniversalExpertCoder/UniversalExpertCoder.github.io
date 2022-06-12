<?php

/**
 * 
 */
class LoginModel extends CI_Model
{
	
	public function validateLogin($username, $password)
	{
		$query = $this->db->where(['email' => $username, 'password' => $password])->get('users');

		if ($query->num_rows()) {
			//echo "<pre>";
			//print_r($query->result());exit();
			return $query->row()->user_id;
		} else {
			return FALSE;
		}
		
	}

	public function validate_login($username, $password)
	{
		$query = $this->db->where(['email' => $username, 'password' => $password])->get('users');

		if ($query->num_rows()) {
			return $query->result();
		} else {
			return FALSE;
		}
		
	}

	public function register($value)
	{
		$this->db->insert('users', $value);
		$insert_id = $this->db->insert_id();
		return $insert_id;

	}

	public function checkDuplicateEmail($email) {

	    $this->db->where('email', $email);

	    $query = $this->db->get('users');

	    $count_row = $query->num_rows();

	    if ($count_row > 0) {
	        return TRUE;
	    } else {
	        return FALSE;
	    }
	}

}

// INSERT INTO `users`(`username`, `password`, `email`) VALUES ('Rahul Yadav', '12345', 'rahul@gmail.com')
