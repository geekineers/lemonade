<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class WithholdingtaxController extends BaseController
{

    protected $employeeRepository,
    $branchRepository,
    $payrollGroupRepository,
    $wtConfigRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository       = new BranchRepository();
        $this->payrollGroupRepository = new PayrollGroupRepository();
        $this->wtConfigRepository     = new WTConfigsRepository();
    }

    public function index()
    {
        $data['sets'] = $this->wtConfigRepository->all();
        $this->render('settings/wt-config.twig.html', $data);
    }

    public function store()
    {
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range']   = $this->input->post('to_range');
        $data['period']     = $this->input->post('period');
        $data['dependents'] = $this->input->post('dependents');
        $data['index']      = $this->input->post('index');
        $data['status']     = $this->input->post('status');
        $data['exemption']  = $this->input->post('exemption');

        $check = $this->wtConfigRepository->createWt($data);

        if ($check) {
            redirect('/settings/wt-config');
        } else {
            dd($check);
        }
    }

    public function update()
    {
        $id                 = $this->input->post('id');
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range']   = $this->input->post('to_range');
        $data['period']     = $this->input->post('period');
        $data['dependents'] = $this->input->post('dependents');
        $data['index']      = $this->input->post('index');
        $data['status']     = $this->input->post('status');
        $data['exemption']  = $this->input->post('exemption');

        $check = $this->wtConfigRepository->updateWt($data, $id);

        if ($check) {
            $this->sendJSON(['status' => 'ok']);
        } else {
            $this->sendJSON(['status' => 'error']);
        }
    }

    public function seeder()
    {

        $array = [
            // daily
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1, 'dependents' => 0, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 2, 'to_range' => 165, 'dependents' => 0, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 198, 'dependents' => 0, 'index' => 3, 'status' => 0.1, 'exemption' => 1.65],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 264, 'dependents' => 0, 'index' => 4, 'status' => 0.15, 'exemption' => 8.25],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 396, 'dependents' => 0, 'index' => 5, 'status' => 0.20, 'exemption' => 28.05],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 627, 'dependents' => 0, 'index' => 6, 'status' => 0.25, 'exemption' => 74.26],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 990, 'dependents' => 0, 'index' => 7, 'status' => 0.30, 'exemption' => 165.02],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1815, 'dependents' => 0, 'index' => 8, 'status' => 0.32, 'exemption' => 412.54],

            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1, 'dependents' => 1, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 248, 'dependents' => 1, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 281, 'dependents' => 1, 'index' => 3, 'status' => 0.1, 'exemption' => 1.65],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 347, 'dependents' => 1, 'index' => 4, 'status' => 0.15, 'exemption' => 8.25],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 479, 'dependents' => 1, 'index' => 5, 'status' => 0.20, 'exemption' => 28.05],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 710, 'dependents' => 1, 'index' => 6, 'status' => 0.25, 'exemption' => 74.26],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1073, 'dependents' => 1, 'index' => 7, 'status' => 0.30, 'exemption' => 165.02],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1898, 'dependents' => 1, 'index' => 8, 'status' => 0.32, 'exemption' => 412.54],

            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1, 'dependents' => 2, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 330, 'dependents' => 2, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 363, 'dependents' => 2, 'index' => 3, 'status' => 0.1, 'exemption' => 1.65],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 429, 'dependents' => 2, 'index' => 4, 'status' => 0.15, 'exemption' => 8.25],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 561, 'dependents' => 2, 'index' => 5, 'status' => 0.20, 'exemption' => 28.05],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 792, 'dependents' => 2, 'index' => 6, 'status' => 0.25, 'exemption' => 74.26],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1155, 'dependents' => 2, 'index' => 7, 'status' => 0.30, 'exemption' => 165.02],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1980, 'dependents' => 2, 'index' => 8, 'status' => 0.32, 'exemption' => 412.54],

            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1, 'dependents' => 3, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 413, 'dependents' => 3, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 446, 'dependents' => 3, 'index' => 3, 'status' => 0.1, 'exemption' => 1.65],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 512, 'dependents' => 3, 'index' => 4, 'status' => 0.15, 'exemption' => 8.25],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 644, 'dependents' => 3, 'index' => 5, 'status' => 0.20, 'exemption' => 28.05],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 875, 'dependents' => 3, 'index' => 6, 'status' => 0.25, 'exemption' => 74.26],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1238, 'dependents' => 3, 'index' => 7, 'status' => 0.30, 'exemption' => 165.02],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 2063, 'dependents' => 3, 'index' => 8, 'status' => 0.32, 'exemption' => 412.54],

            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1, 'dependents' => 4, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 495, 'dependents' => 4, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 528, 'dependents' => 4, 'index' => 3, 'status' => 0.1, 'exemption' => 1.65],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 594, 'dependents' => 4, 'index' => 4, 'status' => 0.15, 'exemption' => 8.25],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 726, 'dependents' => 4, 'index' => 5, 'status' => 0.20, 'exemption' => 28.05],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 957, 'dependents' => 4, 'index' => 6, 'status' => 0.25, 'exemption' => 74.26],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 1320, 'dependents' => 4, 'index' => 7, 'status' => 0.30, 'exemption' => 165.02],
            ['period' => 'daily', 'from_range' => 0, 'to_range' => 2145, 'dependents' => 4, 'index' => 8, 'status' => 0.32, 'exemption' => 412.54],

            // weely
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 0, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 962, 'dependents' => 0, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1154, 'dependents' => 0, 'index' => 3, 'status' => 0.1, 'exemption' => 9.62],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1538, 'dependents' => 0, 'index' => 4, 'status' => 0.15, 'exemption' => 48.08],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2308, 'dependents' => 0, 'index' => 5, 'status' => 0.20, 'exemption' => 163.46],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 3654, 'dependents' => 0, 'index' => 6, 'status' => 0.25, 'exemption' => 432.69],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 5769, 'dependents' => 0, 'index' => 7, 'status' => 0.30, 'exemption' => 961.54],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 10577, 'dependents' => 0, 'index' => 8, 'status' => 0.32, 'exemption' => 2403.85],

            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 1, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1442, 'dependents' => 1, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1635, 'dependents' => 1, 'index' => 3, 'status' => 0.1, 'exemption' => 9.62],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2019, 'dependents' => 1, 'index' => 4, 'status' => 0.15, 'exemption' => 48.08],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2788, 'dependents' => 1, 'index' => 5, 'status' => 0.20, 'exemption' => 163.46],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 4135, 'dependents' => 1, 'index' => 6, 'status' => 0.25, 'exemption' => 432.69],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 6250, 'dependents' => 1, 'index' => 7, 'status' => 0.30, 'exemption' => 961.54],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 11058, 'dependents' => 1, 'index' => 8, 'status' => 0.32, 'exemption' => 2403.85],

            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 2, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1923, 'dependents' => 2, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2115, 'dependents' => 2, 'index' => 3, 'status' => 0.1, 'exemption' => 9.62],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2500, 'dependents' => 2, 'index' => 4, 'status' => 0.15, 'exemption' => 48.08],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 3269, 'dependents' => 2, 'index' => 5, 'status' => 0.20, 'exemption' => 163.46],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 4615, 'dependents' => 2, 'index' => 6, 'status' => 0.25, 'exemption' => 432.69],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 6731, 'dependents' => 2, 'index' => 7, 'status' => 0.30, 'exemption' => 961.54],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 11538, 'dependents' => 2, 'index' => 8, 'status' => 0.32, 'exemption' => 2403.85],

            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 3, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2404, 'dependents' => 3, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2596, 'dependents' => 3, 'index' => 3, 'status' => 0.1, 'exemption' => 9.62],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2981, 'dependents' => 3, 'index' => 4, 'status' => 0.15, 'exemption' => 48.08],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 3750, 'dependents' => 3, 'index' => 5, 'status' => 0.20, 'exemption' => 163.46],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 5096, 'dependents' => 3, 'index' => 6, 'status' => 0.25, 'exemption' => 432.69],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 7212, 'dependents' => 3, 'index' => 7, 'status' => 0.30, 'exemption' => 961.54],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 12019, 'dependents' => 3, 'index' => 8, 'status' => 0.32, 'exemption' => 2403.85],

            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 4, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 2885, 'dependents' => 4, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 3077, 'dependents' => 4, 'index' => 3, 'status' => 0.1, 'exemption' => 9.62],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 3462, 'dependents' => 4, 'index' => 4, 'status' => 0.15, 'exemption' => 48.08],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 4231, 'dependents' => 4, 'index' => 5, 'status' => 0.20, 'exemption' => 163.46],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 5577, 'dependents' => 4, 'index' => 6, 'status' => 0.25, 'exemption' => 432.69],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 9692, 'dependents' => 4, 'index' => 7, 'status' => 0.30, 'exemption' => 961.54],
            ['period' => 'weekly', 'from_range' => 0, 'to_range' => 12500, 'dependents' => 4, 'index' => 8, 'status' => 0.32, 'exemption' => 2403.85],

            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 0, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 2083, 'dependents' => 0, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 2500, 'dependents' => 0, 'index' => 3, 'status' => 0.1, 'exemption' => 20.83],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 3333, 'dependents' => 0, 'index' => 4, 'status' => 0.15, 'exemption' => 104.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 5000, 'dependents' => 0, 'index' => 5, 'status' => 0.20, 'exemption' => 354.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 7917, 'dependents' => 0, 'index' => 6, 'status' => 0.25, 'exemption' => 937.50],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 12500, 'dependents' => 0, 'index' => 7, 'status' => 0.30, 'exemption' => 2083.33],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 22917, 'dependents' => 0, 'index' => 8, 'status' => 0.32, 'exemption' => 5208.33],

            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 1, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 3125, 'dependents' => 1, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 3542, 'dependents' => 1, 'index' => 3, 'status' => 0.1, 'exemption' => 20.83],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 4375, 'dependents' => 1, 'index' => 4, 'status' => 0.15, 'exemption' => 104.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 6042, 'dependents' => 1, 'index' => 5, 'status' => 0.20, 'exemption' => 354.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 8958, 'dependents' => 1, 'index' => 6, 'status' => 0.25, 'exemption' => 937.50],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 13542, 'dependents' => 1, 'index' => 7, 'status' => 0.30, 'exemption' => 2083.33],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 23958, 'dependents' => 1, 'index' => 8, 'status' => 0.32, 'exemption' => 5208.33],

            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 2, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 4167, 'dependents' => 2, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 4583, 'dependents' => 2, 'index' => 3, 'status' => 0.1, 'exemption' => 20.83],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 5417, 'dependents' => 2, 'index' => 4, 'status' => 0.15, 'exemption' => 104.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 7083, 'dependents' => 2, 'index' => 5, 'status' => 0.20, 'exemption' => 354.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 10000, 'dependents' => 2, 'index' => 6, 'status' => 0.25, 'exemption' => 937.50],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 14583, 'dependents' => 2, 'index' => 7, 'status' => 0.30, 'exemption' => 2083.33],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 25000, 'dependents' => 2, 'index' => 8, 'status' => 0.32, 'exemption' => 5208.33],

            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 3, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 5208, 'dependents' => 3, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 5625, 'dependents' => 3, 'index' => 3, 'status' => 0.1, 'exemption' => 20.83],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 6478, 'dependents' => 3, 'index' => 4, 'status' => 0.15, 'exemption' => 104.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 8125, 'dependents' => 3, 'index' => 5, 'status' => 0.20, 'exemption' => 354.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 11042, 'dependents' => 3, 'index' => 6, 'status' => 0.25, 'exemption' => 937.50],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 15625, 'dependents' => 3, 'index' => 7, 'status' => 0.30, 'exemption' => 2083.33],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 26042, 'dependents' => 3, 'index' => 8, 'status' => 0.32, 'exemption' => 5208.33],

            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 4, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 6250, 'dependents' => 4, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 6667, 'dependents' => 4, 'index' => 3, 'status' => 0.1, 'exemption' => 20.83],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 7500, 'dependents' => 4, 'index' => 4, 'status' => 0.15, 'exemption' => 104.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 9167, 'dependents' => 4, 'index' => 5, 'status' => 0.20, 'exemption' => 354.17],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 12083, 'dependents' => 4, 'index' => 6, 'status' => 0.25, 'exemption' => 937.50],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 16667, 'dependents' => 4, 'index' => 7, 'status' => 0.30, 'exemption' => 2083.33],
            ['period' => 'semi-monthly', 'from_range' => 0, 'to_range' => 27083, 'dependents' => 4, 'index' => 8, 'status' => 0.32, 'exemption' => 5208.33],
            // weely
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 0, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 4167, 'dependents' => 0, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 5000, 'dependents' => 0, 'index' => 3, 'status' => 0.1, 'exemption' => 41.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 6667, 'dependents' => 0, 'index' => 4, 'status' => 0.15, 'exemption' => 208.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 10000, 'dependents' => 0, 'index' => 5, 'status' => 0.20, 'exemption' => 708.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 15833, 'dependents' => 0, 'index' => 6, 'status' => 0.25, 'exemption' => 1875],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 25000, 'dependents' => 0, 'index' => 7, 'status' => 0.30, 'exemption' => 4166.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 45833, 'dependents' => 0, 'index' => 8, 'status' => 0.32, 'exemption' => 10416.67],

            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 1, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 6250, 'dependents' => 1, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 7083, 'dependents' => 1, 'index' => 3, 'status' => 0.1, 'exemption' => 41.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 8750, 'dependents' => 1, 'index' => 4, 'status' => 0.15, 'exemption' => 208.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 12083, 'dependents' => 1, 'index' => 5, 'status' => 0.20, 'exemption' => 708.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 17917, 'dependents' => 1, 'index' => 6, 'status' => 0.25, 'exemption' => 1875],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 27083, 'dependents' => 1, 'index' => 7, 'status' => 0.30, 'exemption' => 4166.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 47917, 'dependents' => 1, 'index' => 8, 'status' => 0.32, 'exemption' => 10416.67],

            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 2, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 8333, 'dependents' => 2, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 9167, 'dependents' => 2, 'index' => 3, 'status' => 0.1, 'exemption' => 41.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 10833, 'dependents' => 2, 'index' => 4, 'status' => 0.15, 'exemption' => 208.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 14167, 'dependents' => 2, 'index' => 5, 'status' => 0.20, 'exemption' => 708.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 20000, 'dependents' => 2, 'index' => 6, 'status' => 0.25, 'exemption' => 1875],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 29167, 'dependents' => 2, 'index' => 7, 'status' => 0.30, 'exemption' => 4166.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 50000, 'dependents' => 2, 'index' => 8, 'status' => 0.32, 'exemption' => 10416.67],

            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 3, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 10417, 'dependents' => 3, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 11250, 'dependents' => 3, 'index' => 3, 'status' => 0.1, 'exemption' => 3125],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 12917, 'dependents' => 3, 'index' => 4, 'status' => 0.15, 'exemption' => 3542],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 16620, 'dependents' => 3, 'index' => 5, 'status' => 0.20, 'exemption' => 4375],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 22083, 'dependents' => 3, 'index' => 6, 'status' => 0.25, 'exemption' => 6042],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 31250, 'dependents' => 3, 'index' => 7, 'status' => 0.30, 'exemption' => 8958],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 52083, 'dependents' => 3, 'index' => 8, 'status' => 0.32, 'exemption' => 13542],

            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 1, 'dependents' => 4, 'index' => 1, 'status' => 0, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 12500, 'dependents' => 4, 'index' => 2, 'status' => 0.05, 'exemption' => 0],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 13333, 'dependents' => 4, 'index' => 3, 'status' => 0.1, 'exemption' => 41.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 15000, 'dependents' => 4, 'index' => 4, 'status' => 0.15, 'exemption' => 208.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 18333, 'dependents' => 4, 'index' => 5, 'status' => 0.20, 'exemption' => 708.33],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 24167, 'dependents' => 4, 'index' => 6, 'status' => 0.25, 'exemption' => 1875],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 33333, 'dependents' => 4, 'index' => 7, 'status' => 0.30, 'exemption' => 4166.67],
            ['period' => 'monthly', 'from_range' => 0, 'to_range' => 54167, 'dependents' => 4, 'index' => 8, 'status' => 0.32, 'exemption' => 10416.67],
        ];
        $results = [];
        foreach ($array as $key => $value) {
            $results['period']     = $value['period'];
            $results['from_range'] = $key == 0 ? 0 : $array[$key - 1]['to_range']+1;
            ;
            $results['to_range']   = $value['to_range'];
            $results['dependents'] = $value['dependents'];
            $results['index']      = $value['index'];
            $results['status']     = $value['status'];
            $results['exemption']  = $value['exemption'];

            $this->wtConfigRepository->create($results);
        }
        echo "done";

    }
}
