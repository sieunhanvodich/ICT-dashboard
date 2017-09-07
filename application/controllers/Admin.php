<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('session'));
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
	}

	public function staffs(){
		if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true){
			$crud = new grocery_CRUD();
			/*$crud->set_theme('datatables');
*/			$crud->set_table('users');
			$crud->columns('title', 'fullname','email','position');
			$crud->field_type('password', 'hidden')
	             ->field_type('avatar', 'hidden')
	             ->field_type('username', 'hidden');
	           
	        $crud->set_subject('Staff');
	        $crud->display_as('fullname', 'Full name')
	        	 ->display_as('sup_student', 'Supervised student');
			/*$crud->unset_delete();
			$crud->unset_edit();*/
			if($this->session->userdata('is_admin') == 1){
				$crud->unset_export()
		             ->unset_print()
		             ->unset_add();
		    }
	        else{
	        	$crud->unset_export()
		             ->unset_print()
		             ->unset_add()
		             ->unset_edit()
		             ->unset_delete()
		             ->field_type('is_admin', 'hidden');
	        }
	    }
		else{
			redirect(base_url('login'));
		}

		$output = $crud->render();
			 
		$this->load->view('header');
		$this->load->view('staffs',$output);
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

	        $crud->required_fields('topic','content');
			/*$crud->unset_delete();
			$crud->unset_edit();*/
			if($this->session->userdata('is_admin') == 1){
				$crud->unset_export()
		             ->unset_print();
		    }
	  		else{
	  			$crud->unset_export()
		             ->unset_print()
		             ->unset_add()
		             ->unset_edit()
		             ->unset_delete();
	  		}
	        	
			 
			$output = $crud->render();
			 
			$this->load->view('header');
			$this->load->view('posts',$output);
			$this->load->view('footer');
		}
		else{
			redirect(base_url('login'));
		}
	}
}