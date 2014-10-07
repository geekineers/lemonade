<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

class SSSConfigController extends BaseController
{

    protected   $employeeRepository,
            $branchRepository, 
            $payrollGroupRepository,
    	    $sssConfigRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();
        $this->branchRepository       = new BranchRepository();
        $this->payrollGroupRepository = new PayrollGroupRepository();
        $this->sssConfigRepository = new SSSConfigsRepository();
        $this->employeeRepository   = new EmployeeRepository();
        $this->load->library('session');
    }

    public function index()
    {   
        $data['company'] = $this->company;
        $data['user']    = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['title'] = "SSS Config";
        $data['sets'] = $this->sssConfigRepository->all();
        $this->render('settings/sss-config.twig.html',$data);
    }

    public function store()
    {
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['monthly_salary_credit'] = $this->input->post('monthly_salary_credit');
        $data['ER'] = $this->input->post('er');
        $data['EE'] = $this->input->post('ee');
        $data['EC'] = $this->input->post('ec');
        $data['TTC'] = $this->input->post('ttc');


        $check = $this->sssConfigRepository->createSSS($data);
       
        if($check)
        {
           
            redirect('/settings/sss-config');
        }else{
            dd($check);
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data['from_range'] = $this->input->post('from_range');
        $data['to_range'] = $this->input->post('to_range');
        $data['monthly_salary_credit'] = $this->input->post('monthly_salary_credit');
        $data['ER'] = $this->input->post('er');
        $data['EE'] = $this->input->post('ee');
        $data['EC'] = $this->input->post('ec');
        $data['TTC'] = $this->input->post('ttc');

        $check = $this->sssConfigRepository->updateSSS($data,$id);
        
        if($check)
        {
            $this->sendJSON(['status'=>'ok']);
        }
        else
        {
            $this->sendJSON(['status'=>'error']);
        }
    }


    public function sssSeeder()
    {
            $sss_range = array(
              array('range'=> 1249.99, 'ER'=> 83.70,  'EE'=> 36.30 , 'TC'=> 120.00 , 'TTC'=> 110.00  ),
              array('range'=> 1749.99, 'ER'=> 120.50, 'EE'=> 54.50 ,'TC'=> 175.00 ,  'TTC'=> 165.00  ),
              array('range'=> 2249.99, 'ER'=> 157.30, 'EE'=> 72.70 ,'TC'=> 230.00 ,  'TTC'=> 220.00  ),
              array('range'=> 2749.99, 'ER'=> 194.20, 'EE'=> 90.80 ,'TC'=> 285.00 ,  'TTC'=> 275.00  ),
              array('range'=> 3249.99, 'ER'=> 231.00, 'EE'=> 109.00 ,'TC'=> 340.00 , 'TTC'=> 330.00  ),
              array('range'=> 3749.99, 'ER'=> 267.80, 'EE'=> 127.20 ,'TC'=> 395.00 , 'TTC'=> 385.00  ),
              array('range'=> 4249.99, 'ER'=> 304.70, 'EE'=> 145.30 ,'TC'=> 450.00 , 'TTC'=> 440.00  ),
              array('range'=> 4749.99, 'ER'=> 341.50, 'EE'=> 163.50 ,'TC'=> 505.00 , 'TTC'=> 495.00  ),
              array('range'=> 5249.99, 'ER'=> 378.30, 'EE'=> 181.70 ,'TC'=> 560.00 , 'TTC'=> 550.00  ),
              array('range'=> 5749.99, 'ER'=> 415.20, 'EE'=> 199.80 ,'TC'=> 615.00 , 'TTC'=> 605.00  ),
              array('range'=> 6249.99, 'ER'=> 452.00, 'EE'=> 218.00, 'TC'=> 670.00,  'TTC'=> 660.00  ),
              array('range'=> 6749.99, 'ER'=> 488.80, 'EE'=> 236.20, 'TC'=> 725.00,  'TTC'=> 715.00  ),
              array('range'=> 7249.99, 'ER'=> 525.70, 'EE'=> 254.30 ,'TC'=> 780.00,  'TTC'=> 770.00  ),
              array('range'=> 7749.99, 'ER'=> 562.50, 'EE'=> 272.50 ,'TC'=> 835.00,  'TTC'=> 825.00  ),
              array('range'=> 8249.99, 'ER'=> 599.30, 'EE'=> 290.70 ,'TC'=> 890.00,  'TTC'=> 880.00  ),
              array('range'=> 8749.99, 'ER'=> 636.20, 'EE'=> 308.80 ,'TC'=> 945.00,  'TTC'=> 935.00  ),
              array('range'=> 9249.99, 'ER'=> 673.00, 'EE'=> 327.00 ,'TC'=> 1000.00, 'TTC'=> 990.00  ),
              array('range'=> 9749.99, 'ER'=> 709.80, 'EE'=> 345.20 ,'TC'=> 1055.00, 'TTC'=> 1045.00 ),
              array('range'=> 10249.99,'ER'=> 746.70, 'EE'=> 363.30 ,'TC'=> 1110.00, 'TTC'=> 1100.00 ),
              array('range'=> 10749.99, 'ER'=> 783.50,'EE'=> 381.50 ,'TC'=> 1165.00, 'TTC'=> 1155.00 ),
              array('range'=> 11249.99,'ER'=> 820.30, 'EE'=> 399.70 ,'TC'=> 1220.00, 'TTC'=> 1210.00 ),
              array('range'=> 11749.99 ,'ER'=> 857.20,'EE'=> 417.80 ,'TC'=> 1275.00, 'TTC'=> 1265.00 ),
              array('range'=> 12249.99 ,'ER'=> 894.00,'EE'=> 436.00 ,'TC'=> 1330.00, 'TTC'=> 1320.00 ),
              array('range'=> 12749.99, 'ER'=> 930.80,'EE'=> 454.20, 'TC'=> 1385.00, 'TTC'=> 1375.00 ),
              array('range'=> 13249.99 ,'ER'=> 967.70,'EE'=> 472.30 ,'TC'=> 1440.00, 'TTC'=> 1430.00 ),
             array('range'=> 13749.99 ,'ER'=> 1004.50,'EE'=> 490.50, 'TC'=> 1495.00, 'TTC'=> 1485.00 ),
             array('range'=> 14249.99 ,'ER'=> 1041.30,'EE'=> 508.70, 'TC'=> 1550.00, 'TTC'=> 1540.00 ),
             array('range'=> 14749.99 ,'ER'=> 1078.20,'EE'=> 526.80, 'TC'=> 1605.00, 'TTC'=> 1595.00 ),
              array('range'=> 15249.99,'ER'=> 1135.00,'EE'=> 545.00, 'TC'=> 1680.00, 'TTC'=> 1650.00 ),
              array('range'=>15749.99, 'ER'=> 1171.80,'EE'=> 563.20, 'TC'=> 1735.00, 'TTC'=> 1705.00 ),
              array('range'=> 16000.99,'ER'=> 1208.70, 'EE'=> 581.30, 'TC'=> 1790.00,'TTC'=> 1760.00 )
        );
        
        foreach ($sss_range as $key => $value) {
            $data['from_range'] = $key == 0 ? 1000 : $sss_range[$key-1]['range']-.1 ;
            $data['to_range'] = $value['range'];
            $data['monthly_salary_credit'] = $value['range'];
            $data['ER'] = $value['ER'];
            $data['EE'] = $value['EE'];
            $data['EC'] = 0;
            $data['TTC'] =$value['TTC'];
            SSSConfigs::create($data);
        }
        
    }

}