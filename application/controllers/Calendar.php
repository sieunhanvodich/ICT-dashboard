<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library(array('session'));
		$this->load->database();
		$this->load->helper('url');
	}

	public function seminar($year=null, $month=null){
		$this->load->model('Calendar_model');

		if(!$year){
			$year = date('Y');
		}

		if(!$month){
			$month = date('m');
		}

		if($day = $this->input->post('day')){
			$this->Calendar_model->add_calendar_data(
				"$year-$month-$day",
				$this->input->post('data')
			);
		}

		$data['calendar'] = $this->Calendar_model->generate($year, $month);
		$this->load->view('header');	
		$this->load->view('calendar/seminar_calendar', $data);
		$this->load->view('footer');
	}

	public function meeting($year=null, $month=null){
		$this->load->model('Meeting_model');

		if(!$year){
			$year = date('Y');
		}

		if(!$month){
			$month = date('m');
		}

		if($day = $this->input->post('day')){
			$this->Meeting_model->add_calendar_data(
				"$year-$month-$day",
				$this->input->post('data')
			);
		}

		$data['calendar'] = $this->Meeting_model->generate($year, $month);
		$this->load->view('header');	
		$this->load->view('calendar/meeting', $data);
		$this->load->view('footer');
	}

	public function discussion($year=null, $month=null){
		$this->load->model('Discussion_model');

		if(!$year){
			$year = date('Y');
		}

		if(!$month){
			$month = date('m');
		}

		if($day = $this->input->post('day')){
			$this->Discussion_model->add_calendar_data(
				"$year-$month-$day",
				$this->input->post('data')
			);
		}

		$data['calendar'] = $this->Discussion_model->generate($year, $month);
		$this->load->view('header');	
		$this->load->view('calendar/discussion', $data);
		$this->load->view('footer');
	}

}