<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\ImagesModel;

class File extends BaseController
{

    /**
     * Upload Image File
     */
    public function upload_image_file()
    {
        $imagesModel = new ImagesModel();
        $imagesModel->upload_image();
    }

    /**
     * Get Images
     */
    public function get_images()
    {
        $imagesModel = new ImagesModel();

        $images =  $imagesModel->get_images($this->file_count);
        $this->print_images($images);
    }

    /**
     * Select Image File
     */
    public function select_image_file()
    {
        $file_id = $this->request->getVar('file_id');
        $imagesModel = new ImagesModel();
        $file =  $imagesModel->get_image($file_id);
        if (!empty($file)) {
            echo base_url() . $file->image_mid;
        }
    }

    /**
     * Laod More Images
     */
    public function load_more_images()
    {
        $min = $this->request->getVar('min');
        $imagesModel = new ImagesModel();
        $images =  $imagesModel->get_more_images($min, $this->file_per_page);
        $this->print_images($images);
    }

    /**
     * Search Images
     */
    public function search_image_file()
    {
        $imagesModel = new ImagesModel();
        $search = trim($this->request->getVar('search'));
        $images =  $imagesModel->search_images($search);
        $this->print_images($images);
    }

    /**
     * Print Images
     */
    public function print_images($images)
    {
        $data = array(
            'result' => 0,
            'content' => ''
        );
        if (!empty($images)) :
            foreach ($images as $image) :
                $img_base_url = base_url();

                $data['content'] .= '<div class="col-file-manager" id="img_col_id_' . $image->id . '">';
                $data['content'] .= '<div class="file-box" data-file-id="' . $image->id . '" data-mid-file-path="' . $image->image_mid . '" data-default-file-path="' . $image->image_default . '" data-slider-file-path="' . $image->image_slider . '" data-big-file-path="' . $image->image_big . '" data-file-storage="' . $image->storage . '" data-file-base-url="' . $img_base_url . '">';
                $data['content'] .= '<div class="image-container">';
                $data['content'] .= '<img src="' . $img_base_url . $image->image_slider . '" alt="" class="img-responsive">';
                $data['content'] .= '</div>';
                if (!empty($image->file_name)) :
                    $data['content'] .= '<span class="file-name">' . html_escape($image->file_name) . '</span>';
                endif;
                $data['content'] .= '</div> </div>';
            endforeach;
        endif;
        $data['result'] = 1;
        echo json_encode($data);
    }

    /**
     * Delete Image File
     */
    public function delete_image_file()
    {
        $imagesModel = new ImagesModel();
        $file_id = $this->request->getVar('file_id');
        $imagesModel->delete_image($file_id);
    }
}
