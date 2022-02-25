<?php

namespace App\Models;

use CodeIgniter\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic;

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


        $doUpload = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/jpeg,image/png]',
            ]
        ]);

        if ($doUpload) {
            $img = $this->request->getFile($file_name);
            $img->move(WRITEPATH . '/uploads/tmp/', 'img_' . generate_unique_id() . '.' . $img->getClientExtension());

            $data = array('upload_data' =>  $img);
            if ($img->getTempName() != null) {
                if ($response == 'array') {
                    return  $data['upload_data'];
                } else {
                    return $img->getTempName();
                }
            }

            return null;
        } else {
            return null;
        }
    }

    public function avatar_upload($user_id, $path)
    {
        $new_path = '/uploads/profile/avatar_' . $user_id . '_' . uniqid() . '.jpg';
        $img = ImageManagerStatic::make($path)->orientate();
        $img->fit(150, 150);
        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
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
                $img->move(FCPATH . '/uploads/logo/', 'img_' . generate_unique_id() . '.' . $img->getClientExtension());
                if ($img->getTempName() != null) {
                    return 'uploads/logo/' . $img->getName();
                }
            }
            return null;
        } else {
            return null;
        }
    }

    //favicon image upload
    public function favicon_upload($file_name)
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
                $img->move(FCPATH . '/uploads/logo/', 'favicon_' . uniqid() . '.' . $img->getClientExtension());
                if ($img->getTempName() != null) {
                    return 'uploads/logo/' . $img->getName();
                }
            }
            return null;
        } else {
            return null;
        }
    }

    //post gif image upload
    public function post_gif_image_upload($file_name)
    {
        $date_directory = $this->create_directory_by_date('images');
        rename(WRITEPATH . '/uploads/tmp/' . $file_name, FCPATH . '/uploads/images/' . $date_directory . $file_name);
        return '/uploads/images/' . $date_directory . $file_name;
    }

    //post gif image upload
    public function post_svg_image_upload($file_name)
    {
        $date_directory = $this->create_directory_by_date('images');
        rename(FCPATH . '/uploads/tmp/' . $file_name, FCPATH . 'uploads/images/' . $date_directory . $file_name);
        return 'uploads/images/' . $date_directory . $file_name;
    }

    //post big image upload
    public function post_big_image_upload($path)
    {
        $new_name = $this->create_directory_by_date('images') . 'image_750x500_' . uniqid() . '.jpg';
        $new_path = '/uploads/images/' . $new_name;
        $img = ImageManagerStatic::make($path)->orientate();
        $img->fit(750, 500);
        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
    }

    //post default image upload
    public function post_default_image_upload($path)
    {
        $new_name = $this->create_directory_by_date('images') . 'image_750x_' . uniqid() . '.jpg';
        $new_path = '/uploads/images/' . $new_name;
        $img = ImageManagerStatic::make($path)->orientate();

        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
    }

    //post slider image upload
    public function post_slider_image_upload($path)
    {
        $new_name = $this->create_directory_by_date('images') . 'image_600x460_' . uniqid() . '.jpg';
        $new_path = '/uploads/images/' . $new_name;
        $img = ImageManagerStatic::make($path)->orientate();
        $img->fit(600, 460);
        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
    }

    //post mid image upload
    public function post_mid_image_upload($path)
    {
        $new_name = $this->create_directory_by_date('images') . 'image_380x226_' . uniqid() . '.jpg';
        $new_path = '/uploads/images/' . $new_name;
        $img = ImageManagerStatic::make($path)->orientate();
        $img->fit(380, 226);
        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
    }

    //post small image upload
    public function post_small_image_upload($path)
    {
        $new_name = $this->create_directory_by_date('images') . 'image_140x98_' . uniqid() . '.jpg';
        $new_path = '/uploads/images/' . $new_name;
        $img = ImageManagerStatic::make($path)->orientate();



        $img->fit(140, 98);
        $img->save(FCPATH . $new_path, $this->img_quality);
        return $new_path;
    }

    //create directory by date
    public function create_directory_by_date($target_folder)
    {
        $year = date("Y");
        $month = date("m");

        $directory_year = FCPATH . "uploads/" . $target_folder . "/" . $year . "/";
        $directory_month = FCPATH . "uploads/" . $target_folder . "/" . $year . "/" . $month . "/";

        //If the directory doesn't already exists.
        if (!is_dir($directory_month)) {
            //Create directory.
            @mkdir($directory_month, 0755, true);
        }

        //add index.html if does not exist
        if (!file_exists($directory_year . "index.html")) {
            copy(APPPATH . "/index.html", $directory_year . "index.html");
        }
        if (!file_exists($directory_month . "index.html")) {
            copy(APPPATH . "/index.html", $directory_month . "index.html");
        }

        return $year . "/" . $month . "/";
    }

    //delete temp image
    public function delete_temp_image($path)
    {
        if (file_exists($path)) {
            @unlink($path);
        }
    }
}
