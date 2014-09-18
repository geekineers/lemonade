<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class AnnouncementController extends BaseController
{

    protected $branchRepository;
    protected $allowanceRepository;
    protected $employeeRepository;
    protected $employeeDeductionRepository;
    protected $announcementRepository;
    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository            = new BranchRepository();
        $this->employeeRepository          = new EmployeeRepository();
        $this->allowanceRepository         = new AllowanceRepository();
        $this->employeeAllowanceRepository = new EmployeeAllowanceRepository();
        $this->announcementRepository      = new AnnouncementRepository();
        $this->load->library('session');

    }

    public function save()
    {
        $title   = $this->input->post('title');
        $content = $this->input->post('content');

        $data = [
            'author'  => $this->employeeRepository->getLoginUser($this->sentry->getUser())->id,
            'title'   => $title,
            'content' => $content
        ];
        $this->announcementRepository->postAnnouncement($data);

        redirect('/dashboard');
    }

    public function index()
    {

        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']    = "Announcements";
        $data['branches'] = $this->announcementRepository->all();
        $this->render('announcements/index.twig.html', $data);

    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->announcementRepository->where('id','=',$id)->delete();
        $this->sendJSON(['status'=>'ok']);
    }
}
