<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'images';
    protected $primaryKey       = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->validation =  \Config\Services::validation();
    }

    //get image
    public function get_image($id)
    {
        $sql = "SELECT * FROM images WHERE id =  ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }

    //get images
    public function get_images($limit)
    {
        if (get_general_settings()->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE user_id = ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number(user()->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM images ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($limit)));
        }
        return $query->getResult();
    }

    //get more images
    public function get_more_images($last_id, $limit)
    {
        if (get_general_settings()->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE images.id < ? AND user_id = ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number(user()->id), clean_number($limit)));
        } else {
            $sql = "SELECT * FROM images WHERE images.id < ? ORDER BY images.id DESC LIMIT ?";
            $query = $this->db->query($sql, array(clean_number($last_id), clean_number($limit)));
        }
        return $query->getResult();
    }

    //search images
    public function search_images($search)
    {
        $like = '%' . $search . '%';
        if (get_general_settings()->file_manager_show_files != 1) {
            $sql = "SELECT * FROM images WHERE user_id = ? AND images.file_name LIKE ? ORDER BY images.id DESC";
            $query = $this->db->query($sql, array(clean_number(user()->id), $like));
        } else {
            $sql = "SELECT * FROM images WHERE images.file_name LIKE ? ORDER BY images.id DESC";
            $query = $this->db->query($sql, array($like));
        }
        return $query->getResult();
    }



    public function insert_image($data)
    {
        $image_data = array(
            'image_big' => $data["image_big"],
            'image_default' => $data["image_default"],
            'image_slider' => $data["image_slider"],
            'image_mid' => $data["image_mid"],
            'image_small' => $data["image_small"],
            'image_mime' => $data["image_mime"],
            'file_name' => $data["file_name"],
            'user_id' => user()->id,

        );

        return $this->builder()->insert($image_data);
    }

    //upload image
    public function upload_image()
    {
        $uploadModel = new UploadModel();
        $temp_data = $uploadModel->upload_temp_image('file', 'array');

        if (!empty($temp_data)) {
            $temp_path = $temp_data->getTempName() . $temp_data->getName();
            if ($temp_data->getClientExtension() == 'gif') {
                $gif_path = $uploadModel->post_gif_image_upload($temp_data->getName());
                $data["image_big"] = $gif_path;
                $data["image_default"] = $gif_path;
                $data["image_slider"] = $gif_path;
                $data["image_mid"] = $gif_path;
                $data["image_small"] = $gif_path;
                $data["image_mime"] = 'gif';
                $data["file_name"] = @$temp_data->getClientName();
            } else {
                $data["image_big"] = $uploadModel->post_big_image_upload($temp_path);
                $data["image_default"] = $uploadModel->post_default_image_upload($temp_path);
                $data["image_slider"] = $uploadModel->post_slider_image_upload($temp_path);
                $data["image_mid"] = $uploadModel->post_mid_image_upload($temp_path);
                $data["image_small"] = $uploadModel->post_small_image_upload($temp_path);
                $data["image_mime"] = 'jpg';
                $data["file_name"] = @$temp_data->getClientName();
            }


            $this->insert_image($data);
            $uploadModel->delete_temp_image($temp_path);
        }
    }



    //delete image
    public function update_image($id)
    {
        $image = $this->get_image($id);
        if (!empty($image)) {

            $data = [
                "alt" => $this->request->getVar('alt_name'),
                "file_name" => $this->request->getVar('file_name'),
                "captions" => $this->request->getVar('file_caption'),
                "descriptions" => $this->request->getVar('file_desc'),
            ];

            return $this->builder()->where('id', $id)->update($data);
        }
    }

    //delete image
    public function delete_image($id)
    {
        $image = $this->get_image($id);
        if (!empty($image)) {
            //delete image from server
            delete_file_from_server($image->image_big);
            delete_file_from_server($image->image_default);
            delete_file_from_server($image->image_slider);
            delete_file_from_server($image->image_mid);
            delete_file_from_server($image->image_small);
            return $this->builder()->where('id', $id)->delete();
        }
    }
}
