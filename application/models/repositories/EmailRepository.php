<?php
use Payslips as Payslips;
use Respect\Validation\Validator as Validator;

class EmailRepository extends BaseRepository {

	protected $employeeRepository,$payrollGroupRepository,$payslipsGroupRepository;
	public function __construct()
	{
		$this->class = new Payslips();

		$this->employeeRepository = new EmployeeRepository();
        $this->payrollGroupRepository= new PayrollGroupRepository();
        $this->payslipsGroupRepository = new PayslipsGroupRepository();
	}

	public function sendEmail($email=null,$subject=null,$message=null)
	{
		$instance = get_instance();
		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'ssl://smtp.sendgrid.net',
		    'smtp_port' => 465,
		    'smtp_user' => 'naroejesus',
		    'smtp_pass' => 'oxygen05',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1'
		);
		$instance->load->library('email',$config);
		$instance->email->set_newline("\r\n");
	    $instance->email->from('admin@lemon.com'); // change it to yours
	    $instance->email->to($email);// change it to yours
	    $instance->email->subject($subject);
	    $instance->email->message($message);

	    return $instance->email->send();
	}
}