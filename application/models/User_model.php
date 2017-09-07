<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();
		$this->load->library('email');
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $email
	 * @param string $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $email, $password) {
			
		$data = array(
			'username'   => $username,
			'email'      => $email,
			'password'   => $this->hash_password($password),
			'created_at' => date('Y-m-j H:i:s')
		);
		
		return $this->db->insert('users', $data);
		
	}
	

	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {
		
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('username', $username);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
		
	}
	
	/**
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param string $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');
		
	}
	
	/**
	 * get_username_from_user_id function.
	 * 
	 * @access public
	 * @param int $user_id
	 * @return string
	 */
	public function get_username_from_user_id($user_id) {
		
		$this->db->select('username');
		$this->db->from('users');
		$this->db->where('id', $user_id);

		return $this->db->get()->row('username');
		
	}
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param int $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}

	
	/**
	 * get_users function.
	 * 
	 * @access public
	 * @return object
	 */
	public function get_users() {
		
		$this->db->from('users');
		return $this->db->get()->result();
		
	}
	
	
	/**
	 * update_user function.
	 * 
	 * @access public
	 * @param int $user_id
	 * @param array $update_data
	 * @return bool
	 */
	public function update_user($user_id, $update_data) {
		
		// if user wants to update its password, hash the given password
		if (array_key_exists('password', $update_data)) {
			$update_data['password'] = $this->hash_password($update_data['password']);
		}
		
		if (!empty($update_data)) {
			
			$this->db->where('id', $user_id);
			return $this->db->update('users', $update_data);
			
		}
		return false;
		
	}
	
	/**
	 * delete_user function.
	 * 
	 * @access public
	 * @param int $user_id
	 * @return bool
	 */
	public function delete_user($user_id) {
		
		// delete all user topics, posts and delete user account
		$this->db->where('id', $user_id);
		$this->db->delete('users');
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param string $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param string $password
	 * @param string $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
}
