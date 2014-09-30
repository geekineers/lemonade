<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class HolidayController extends BaseController
{

    protected $holidayRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository   = new BranchRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->load->library('session');

        $this->holidayRepository = new HolidayRepository($this->sentry);
    }

    public function index()
    {
        $data['company']       = $this->company;
        $data['alert_message'] = ($this->session->flashdata('message') == null) ? null : $this->session->flashdata('message');
        $data['user']          = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']         = "Holidays";
        $data['holiday_years'] = HolidayYear::all();
        $this->render('holidays/index.twig.html', $data);

    }

    public function add($year)
    {
        $data = $this->input->post();
     	$data['holiday_type'] = ($data['holiday_type'] != "") ? $data['holiday_type'] : $data['holiday_type_select'];
     	unset($data['holiday_type_select']);
     	// dd($data);
        $this->holidayRepository->create($data);
        redirect('settings/holidays/' . $year, 'location');
    }

    public function update($year)
    {
        $holidays = $this->input->post('holiday');
        $this->holidayRepository->updateDays($holidays);
        redirect('settings/holidays/' . $year, 'location');
    }

    public function generateYear()
    {
        $year = $this->input->post('year');
        $this->holidayRepository->generateHoliday($year);

        redirect('settings/holidays/' . $year, 'location');
    }

    public function holidayPerYear($year)
    {
        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['year']     = $year;
        $data['holidays'] = $this->holidayRepository->getAllHoliday($year);
        $data['title']    = $year . " Holidays";
        $data['company']  = $this->company;
        $this->render('holidays/year.twig.html', $data);

    }

    public function delete()
    {
        $year = $this->input->get('year');

        HolidayYear::where('year', '=', $year)->delete();
        Holiday::where('year', '=', $year)->delete();
        redirect('settings/holidays/', 'location');

    }

}
