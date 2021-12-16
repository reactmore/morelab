<?php

namespace App\Models;

use CodeIgniter\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;

class UploadModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'general_settings';

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->validation =  \Config\Services::validation();
        $this->img_quality = 100;
    }

    //upload temp image
    public function upload_temp_image($file_name, $response)
    {
        $files = $this->request->getFiles();

        if (isset($files)) {
            if (empty($files)) {
                return null;
            }
        }

        $doUpload = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
            ]
        ]);

        if ($doUpload) {
            $img = $this->request->getFile($file_name);
            $img->move(WRITEPATH . 'uploads/tmp/', 'img_' . generate_unique_id());
            if ($img->isValid()) {
                if (isset($data['upload_data']['full_path'])) {
                    if ($response == 'array') {
                        return $data['upload_data'];
                    } else {
                        return $data['upload_data']['full_path'];
                    }
                }
            }
            return null;
        } else {
            return null;
        }
    }

    //logo image upload
    public function logo_upload($file_name)
    {
        $doUpload = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
            ]
        ]);

        if ($doUpload) {
            $img = $this->request->getFile($file_name);
            if ($img->isValid()) {
                $img->move(FCPATH . '/public/uploads/logo/', 'img_' . generate_unique_id() . '.' . $img->getClientExtension());
                if ($img->getTempName() != null) {
                    return 'uploads/logo/' . $img->getName();
                }
            }
            return null;
        } else {
            return null;
        }
    }
}
