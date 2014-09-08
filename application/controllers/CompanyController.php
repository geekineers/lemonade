<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once ('BaseController.php');

use Upload\Storage\FileSystem as FileSystem;

class CompanyController extends BaseController
{

    protected $companyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->mustBeLoggedIn();

        $path                     = realpath(APPPATH . '../uploads/');
        $this->fileSystem         = new FileSystem($path);
        $this->companyRepository  = new CompanyRepository();
        $this->employeeRepository = new EmployeeRepository();
        $this->logged_user        = $this->sentry->getUser();

        $this->company = $this->companyRepository->find($this->logged_user->company_id);

        $this->load->library('session');

    }

    public function index()
    {

        $data['user']     = $this->employeeRepository->getLoginUser($this->sentry->getUser());
        $data['new_user'] = $this->session->flashdata('new_user');
        $data['company']  = $this->company;
        $data['title']    = "Company Information";
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
            'company_name'           => $this->input->post('company_name'),
            'company_description'    => $this->input->post('company_description'),
            'company_address'        => $this->input->post('company_address'),
            'company_contact_number' => $this->input->post('company_contact_number'),
            'company_sss'            => $this->input->post('company_sss'),
            'company_rdo'            => $this->input->post('company_rdo'),
            'company_zip'            => $this->input->post('company_zip'),
            'company_philhealth'     => $this->input->post('company_philhealth'),
            'company_tel'            => $this->input->post('company_tel'),
            'line_of_business'       => $this->input->post('line_of_business'),
            'company_logo'           => $filename,
        );

        $save = $this->companyRepository->create($post);
        // dd($save);
        if ($save):
            try {
                // Success!
                $file->upload();
                redirect('/settings/company', 'location');
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
            }

        endif;

        $this->session->set_flashdata('message', $company_name . ' has been added.');

        redirect('/settings/company', 'location');

    }

    public function edit()
    {
        $id = $this->input->get('id');

        $data['user'] = $this->employeeRepository->getLoginUser($this->sentry->getUser());

        $data['title']  = "Branches";
        $data['branch'] = $this->branchRepository->find($id);

        $this->render('branch/edit.twig.html', $data);

    }

    public function update()
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
            'company_name'           => $this->input->post('company_name'),
            'company_description'    => $this->input->post('company_description'),
            'company_address'        => $this->input->post('company_address'),
            'company_contact_number' => $this->input->post('company_contact_number'),
            'company_sss'            => $this->input->post('company_sss'),
            'company_rdo'            => $this->input->post('company_rdo'),
            'company_zip'            => $this->input->post('company_zip'),
            'company_philhealth'     => $this->input->post('company_philhealth'),
            'company_tel'            => $this->input->post('company_tel'),
            'line_of_business'       => $this->input->post('line_of_business'),
            'company_logo'           => $filename,
        );

        $save = $this->company->update($post);
        // dd($save);

        if ($save):
            try {
                // Success!
                $file->upload();
                redirect('/settings/company', 'location');
            } catch (\Exception $e) {
                // Fail!
                $errors = $file->getErrors();
            }

        endif;

        $this->session->set_flashdata('message', $company_name . ' has been added.');

        redirect('/settings/company', 'location');

    }

    public function delete()
    {
        $id = $this->input->get('id');

        $branch_name = $this->branchRepository->find($id)->branch_name;

        $this->branchRepository->delete($id);
        $this->session->set_flashdata('message', $branch_name . ' has been deleted.');
        redirect('/branches', 'location');

    }

}
