<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once('BaseController.php');




class CompanyController extends BaseController {
	
	protected $companyRepository,
			  $company;

	public function __construct()
	{	
		parent::__construct();
		$this->mustBeLoggedIn();
		$this->companyRepository = new CompanyRepository();
		$this->employeeRepository = new EmployeeRepository();

		$this->company = $this->companyRepository->find(1);

		$this->load->library('session'); 

	}

	public function index()
	{

		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['company'] = $this->company;
		$this->render('company/index.twig.html', $data);

	}

	public function add()
	{

		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = "Branches";
		$this->render('branch/add.twig.html', $data);

	}

	public function save()
	{
		$company_name = $this->input->post('company_name');

			// Upload Picture 

		$file = new \Upload\File('logo', $this->fileSystem);
			// openssl_csr_export_to_file(csr, outfilename)ionally you can rename the file on upload
		$new_filename = uniqid();
		$file->setName($new_filename);

	  // Access data about the file that has been uploaded
		$data = array(
		    'name'       => $file->getNameWithExtension(),
		    'extension'  => $file->getExtension(),
		    'mime'       => $file->getMimetype(),
		    'size'       => $file->getSize(),
		    'md5'        => $file->getMd5(),
		    'dimensions' => $file->getDimensions()
		);

		// Try to upload file
	

		$filename = $file->getNameWithExtension();

		$post = array(
				'company_name' => $this->input->post('company_name'),
				'company_description' => $this->input->post('company_description'),
				'company_address' => $this->input->post('company_address'),
				'company_contact_number' => $this->input->post('company_contact_number'),
				'company_logo' => $filename,
			);

		$save = $this->companyRepository->create($post);
		// dd($save);
		$this->session->set_flashdata('message', $company_name .' has been added.');

		redirect('/settings/company', 'location');

	}

	public function edit()
	{
		$id = $this->input->get('id');

		$data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());
		
		$data['title'] = "Branches";
		$data['branch'] = $this->branchRepository->find($id);

		$this->render('branch/edit.twig.html', $data);

	}

	public function update()
	{
		$branch_name = $this->input->post('branch_name');
		$id = $this->input->post('id');
		$save = $this->branchRepository->update($this->input->post(), $id);
		$this->session->set_flashdata('message', $branch_name .' has been updated.');
		redirect('/branches', 'location');

	}

	public function delete()
	{
		$id = $this->input->get('id');

		$branch_name = $this->branchRepository->find($id)->branch_name;

		$this->branchRepository->delete($id);
		$this->session->set_flashdata('message', $branch_name .' has been deleted.');
		redirect('/branches', 'location');

	}

}
