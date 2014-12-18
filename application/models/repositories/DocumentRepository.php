<?php
use Document as Document;
use Upload\Storage\FileSystem as FileSystem;

class DocumentRepository extends BaseRepository
{
    protected $fileSystem;

    public function __construct()
    {
        $this->class = new Document;

        $path             = realpath(APPPATH . '../uploads/');
        $this->fileSystem = new FileSystem($path);
    }

    public function saveFile($input, $document_type)
    {
        $new_filename = uniqid();
        $file         = new \Upload\File('file', $this->fileSystem);
        $file->setName($new_filename);
        $data = array(
            'employee_id'      => (int) $input['employee_id'],
            'name'             => (string) $input['name'],
            'file_description' => (string) $input['description'],
            'file_name'        => (string) $file->getNameWithExtension(),
            'file_extension'   => (string) $file->getExtension(),
            'file_type'        => (string) $file->getMimetype(),
            'file_size'        => (string) $file->getSize(),
            'document_type'    => (string) $document_type
        );

        try {
            // Success!
            $file->upload();
        } catch (\Exception $e) {
            // Fail!
            $errors = $file->getErrors();
        }

        return $this->create($data);
    }

/**
 * Saves File Related to Employee ie. Resume File
 * @param $input input from form
 * @return [bool] - file saved.
 */
    public function saveDocument($input)
    {
        return $this->saveFile($input, 'document');
    }

    public function saveCertificate($input)
    {
        return $this->saveFile($input, 'certificate');
    }

    public function deleteFile($data)
    {
        $id   = $data['token'];
        $name = $data['name'];
        $eid  = $data['eid'];
        return $this->delete($data);
    }

}
