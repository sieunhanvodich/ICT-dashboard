<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		$this->load->database();
	}


	/**
	 * index function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function index($username = false) {
		
		if ($username === false) {
			redirect(base_url());
			return;
		}
		
		// create the data object
		$data = new stdClass();
		
		// get user id from username
		$user_id = $this->user_model->get_user_id_from_username($username);
		
		// create the user object
		$user = $this->user_model->get_user($user_id);
	
		// create breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url('admin/all_users') . '">Home</a></li>';
		$breadcrumb .= '<li class="active">' . $username . '</li>';
		$breadcrumb .= '</ol>';
		
		// create a button to permit profile edition
		$edit_button = '<a href="' . base_url('user/' . $user->username . '/edit') . '" class="btn btn-xs btn-success">Edit your account</a>';
		$update_profile_button = '<a href="' . base_url('user/' . $user->username . '/update_profile') . '" class="btn btn-xs btn-success">Update profile</a>';
		
		// assign created objects to the data object
		$data->user       = $user;
		$data->breadcrumb = $breadcrumb;
		if (isset($_SESSION['username']) && $_SESSION['username'] === $username) {
			// user is on his own profile
			$data->edit_button = $edit_button;
			$data->update_profile_button = $update_profile_button;
		} else {
			// user is not on his own profile
			$data->edit_button = null;
			$data->update_profile_button = null;
		}
		
		$this->load->view('header');
		$this->load->view('user/profile/profile', $data);
		$this->load->view('footer');
		
	}
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[20]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			if ($this->send_email($email,$password,$username) == FALSE){
				redirect(base_url('register'));
			}
			else {
				if($this->user_model->create_user($username, $email, $password)) {
				
					// user creation ok
					// successfully sent mail
	                $this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Registered! Please check your email and log in!!!</div>');
					$this->load->view('header');
					$this->load->view('user/register/register', $data);
					$this->load->view('footer');
				} 
				else {
				
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
				}
			}
		}
	}


		
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
			
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['logged_in']    = (bool)true;
				/*$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;*/
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				
				// user login ok
				redirect(base_url('public_info/all_users'));
				
			} else {
				
				// login failed
				$data->error = 'Wrong username or password.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			redirect(base_url('login'));
			
		} else {
			redirect('/');		
		}	
	}
	
	/**
	 * email_validation function.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $hash
	 * @return void
	 */
	public function email_validation($username, $hash) {
		
		// create the data object
		$data = new stdClass();
		
		// avoid blank at the end of the url
		$hash = trim($hash);
		
		if ($this->user_model->confirm_account($username, $hash)) {
			
			// account validation ok
			$data->success = 'Congratulation, your email address has been confirmed and your account is now validated! Please <a href="' . base_url('login') . '">login</a>.';
			$this->load->view('header');
			$this->load->view('user/register/confirmation', $data);
			$this->load->view('footer');
			
		} else {
			
			// account validation failed
			$data->error = 'An error has occurred, your email address cannot be validated. Please contact the website administrator.';
			$this->load->view('header');
			$this->load->view('user/register/confirmation', $data);
			$this->load->view('footer');
			
		}
		
	}
	
	/**
	 * edit function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function edit($username = false) {
		
		// a user cann only edit his own profile
		if ($username === false || $username !== $_SESSION['username']) {
			redirect(base_url());
		}
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and form validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// form validation 
		$password_required_if = $this->input->post('password') ? '|required' : ''; // if there is something on password input, current password is required
		$this->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[20]|alpha_numeric|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another username.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]', array('is_unique' => 'The email you entered already exists in our database.'));
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim' . $password_required_if . '|callback_verify_current_password');
		$this->form_validation->set_rules('password', 'New Password', 'trim|min_length[6]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|min_length[6]');
		
		// get the user object
		$user_id = $this->user_model->get_user_id_from_username($username);
		$user    = $this->user_model->get_user($user_id);
		
		// create breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url('admin/all_users') . '">Home</a></li>';
		$breadcrumb .= '<li><a href="' . base_url('user/' . $username) . '">' . $username . '</a></li>';
		$breadcrumb .= '<li class="active">Edit</li>';
		$breadcrumb .= '</ol>';
		
		// assign objects to the data object
		$data->user       = $user;
		$data->breadcrumb = $breadcrumb;
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
			$this->load->view('header');
			$this->load->view('user/profile/edit', $data);
			$this->load->view('footer');
			
		} else {
			
			$user_id = $_SESSION['user_id'];
			$update_data = [];
			
			if ($this->input->post('email') != '') {
				$update_data['email'] = $this->input->post('email');
			}
			if ($this->input->post('password') != '') {
				$update_data['password'] = $this->input->post('password');
			}
			
			// avatar upload
			if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])) {
				
				// setup upload configuration and load upload library
				$config['upload_path']      = './uploads/avatars/';
				$config['allowed_types']    = 'gif|jpg|png';
				$config['max_size']         = 2048;
				$config['max_width']        = 1024;
				$config['max_height']       = 1024;
				$config['file_ext_tolower'] = true;
				$config['encrypt_name']     = true;

				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload()) {
					// upload NOT ok
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('upload_form', $error);
				
				} else {
					
					// Upload ok send name to $updated_data
					$update_data['avatar'] = $this->upload->data('file_name');
					
				}
				
			}
			
			// if everything is ok
			if ($this->user_model->update_user($user_id, $update_data)) {
				
				// fix the fact that a new avatar was not shown until page refresh
				if(isset($update_data['avatar'])) {
					$data->user->avatar = $update_data['avatar'];
				}
			
				else {
					
					// create a success message
					$data->success = 'Your profile has been successfully updated!';
					
					// send success message to the views
					$this->load->view('header');
					$this->load->view('user/profile/edit', $data);
					$this->load->view('footer');
					
				}
				
			} else {
				
				// update user not ok : this should never happen
				$data->error = 'There was a problem updating your account. Please try again.';
				
				//send errors to the views
				$this->load->view('header');
				$this->load->view('user/profile/edit', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}

	
	
	/**
	 * delete function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function delete($username = false) {
		
		// a user cann only delete his own profile and must be logged in
		if ($username == false || !isset($_SESSION['username']) || $username !== $_SESSION['username']) {
			redirect(base_url());
			return;
		}
		
		if (isset($_SESSION['username']) || $_SESSION['username'] === $username) {
			$data = new stdClass();
			$user_id          = $this->user_model->get_user_id_from_username($username);
			$this->user_model->delete_user($user_id);
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			redirect(base_url('login'));
		} else {	
			// a user cann only delete his own profile and must be logged in
			redirect(base_url());			
		}	
	}
	
	/**
	 * verify_current_password function.
	 * 
	 * @access public
	 * @param string $str
	 * @return bool
	 */
	public function verify_current_password($str) {
		
		if ($str != '') {
			
			if ($this->user_model->resolve_user_login($_SESSION['username'], $str) === true) {
				return true;
			}
			$this->form_validation->set_message('verify_current_password', 'The {field} field does not match your password.');
			return false;	
		}
		return true;	
	}

	public function update_profile($username = false) {
		
		if ($username == false || !isset($_SESSION['username']) || $username !== $_SESSION['username']) {
			redirect(base_url());
			return;
		}
		// create the data object
		$data = new stdClass();
		// load form helper and validation library
		$this->load->helper('form');

		$user_id = $this->user_model->get_user_id_from_username($username);
		$user    = $this->user_model->get_user($user_id);
			
		// create breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url('admin/all_users') . '">Home</a></li>';
		$breadcrumb .= '<li><a href="' . base_url('user/' . $username) . '">' . $username . '</a></li>';
		$breadcrumb .= '<li class="active">Update_details</li>';
		$breadcrumb .= '</ol>';
		
		$data->user       = $user;
		$data->breadcrumb = $breadcrumb;
			
		$user_id = $_SESSION['user_id'];
		$update_data = [];
		
		if ($this->input->post('fullname') != '') {
			$update_data['fullname'] = $this->input->post('fullname');
		}
		if ($this->input->post('title') != '') {
			$update_data['title'] = $this->input->post('title');
		}
		if ($this->input->post('position') != '') {
			$update_data['position'] = $this->input->post('position');
		}
		if ($this->input->post('affiliation') != '') {
			$update_data['affiliation'] = $this->input->post('affiliation');
		}
		if ($this->input->post('publication') != '') {
			$update_data['publication'] = $this->input->post('publication');
		}
		if ($this->input->post('sup_student') != '') {
			$update_data['sup_student'] = $this->input->post('sup_student');
		}

		if ($this->input->post('project') != '') {
			$update_data['project'] = $this->input->post('project');
		}

		if ($this->user_model->update_user($user_id, $update_data)) {
			// create a success message
			$data->success = 'Your profile has been successfully updated!';
			
			// send success message to the views
			$this->load->view('header');
			$this->load->view('user/profile/update_details', $data);
			$this->load->view('footer');
		}
		
		else {
				
			// user creation failed, this should never happen
			$data->error = 'There was a problem. Please try again.';
			
			// send error to the view
			$this->load->view('header');
			$this->load->view('user/profile/update_details', $data);
			$this->load->view('footer');
			
		}		
		
	}

	function send_email($email,$password,$username){
 		$config['useragent']    = 'CodeIgniter';
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.googlemail.com';
        $config['smtp_user']    = 'chuyendivote001@gmail.com'; 
        $config['smtp_pass']    = 'ict12345'; 
        $config['smtp_port']    = 465;
        $config['wordwrap']     = TRUE;    
        $config['wrapchars']    = 76;
        $config['mailtype']     = 'html';
        $config['charset']      = 'iso-8859-1';
        $config['validate']     = FALSE;
        $config['priority']     = 3;
        $config['newline']      = "\r\n";
        $config['crlf']         = "\r\n";

        $this->load->library('email', array('mailtype'=>'html'));
        $this->email->initialize($config);
        $this->email->from('ICTlab.noreply@gmail.com','ICTLab');
        $this->email->to($email);
        $this->email->subject('Welcome to ICTlab');
        $message = "Thanks for signing up ! <br/>
      				<br/>
			        Your account has been created. <br/>
			        Here are your login details.   <br/>
			        ----------------------------------  <br/>
			        User name   : $username  <br/>
			        Password    : $password  <br/>
			        ----------------------------------	<br/>
			        <br/>               
			        Sincerely,";
            
        $this->email->message($message);
        return $this->email->send();
	}
}
	
