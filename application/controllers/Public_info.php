<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class Public_info extends CI_Controller {

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
		$this->load->library('grocery_CRUD');
	}

	public function all_users(){
		$this->load->view('header');
		$this->load->view('user/all_users');
		$this->load->view('footer');
	}

	public function posts(){
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true){
			$crud = new grocery_CRUD();
			$crud->set_table('posts');
			$crud->columns('topic', 'created_at','updated_at');
			$crud->set_subject('News and Events');
	        $crud->display_as('topic', 'Topic')
	        	 ->display_as('updated_at', 'Last update')
	        	 ->display_as('created_at', 'Created at')
	        	 ->display_as('content', 'Content');
  			$crud->unset_export()
	             ->unset_print()
	             ->unset_add()
	             ->unset_edit()
	             ->unset_delete();
	        			 
			$output = $crud->render();
			 
			$this->load->view('header');
			$this->load->view('posts',$output);
			$this->load->view('footer');
		}
	}

}