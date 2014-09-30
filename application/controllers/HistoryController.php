<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class HistoryController extends BaseController
{

    protected $employeeRepository;

    protected $historyRepository;

    public function __construct()
    {
	  	parent::__construct();
        $this->mustBeLoggedIn();
    	$this->employeeRepository = new EmployeeRepository();
    	$this->historyRepository = new HistoryRepository();
    }

    public function save()
    {
    	$data['employee_id'] = $this->input->post('employee_id');
    	$data['action'] = $this->input->post('action');
    	$data['date_happened'] = $this->input->post('date_happened');
    	// dd($data);
    	$this->historyRepository->create($data);
    
    	redirect('/employees/' . $data['employee_id'] . '/profile');
    }



}