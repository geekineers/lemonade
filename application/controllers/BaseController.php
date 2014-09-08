<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class BaseController extends CI_Controller
{

    protected $sentry;
    public $logged_user, $company;
    protected $companyRepository;
    public function __construct()
    {

        parent::__construct();
        $this->sentry = Sentry::createSentry();

        $user = $this->sentry->getUser();
        if (isset($user)) {
            define('COMPANY_ID', $user->company_id);
        }

        // get_instance()->load->library('session');

        // dd($user->getGroups()[0]['name']);
        //
        //
    
            $this->logged_user       = $this->sentry->getUser();
            $this->companyRepository = new CompanyRepository();
            if($this->logged_user){
                $this->company           = $this->companyRepository->find($this->logged_user->company_id);
                
            }
            
        
   

    }
    public function render($template, $data = [])
    {
        $loader = new Twig_Loader_Filesystem(APPPATH . 'views');
        $twig   = new Twig_Environment($loader, array(
                // 'cache' => APPPATH.'/cache/views',
                'cache' => false
            ));

        echo $twig->render($template, $data);
    }

    public function mustBeLoggedIn()
    {
        if (!$this->sentry->check()) {
            redirect('/auth', 'location');
        }

    }
    public function mustBeLoggedOut()
    {
        if ($this->sentry->check()) {
            redirect('/dashboard', 'location');
        }

    }
    public function sendJSON($data)
    {
        try
        {
            return $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
         catch (Exception $e) {
            dd($e);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */
