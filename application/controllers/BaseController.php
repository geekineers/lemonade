<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class BaseController extends CI_Controller
{

    protected $sentry;

    public function __construct()
    {

        parent::__construct();
        $this->sentry = Sentry::createSentry();
    
        $user = $this->sentry->getUser();
        if(isset($user)){
        	define('COMPANY_ID', $user->company_id);
        }

        // get_instance()->load->library('session');
        
    	// dd($user->getGroups()[0]['name']);
    }
    public function render($template, $data = [])
    {
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/Welcome.php */
