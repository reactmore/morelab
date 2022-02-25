<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Bcrypt;


class ProfileModel extends Model
{

    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Custom 
    protected $bcrypt;
    protected $session;
    protected $db;
    protected $request;

    public function __construct()
    {
        parent::__construct();



        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->agent = $this->request->getUserAgent();
    }

    //update profile
    public function update_profile($user_id)
    {

        $data = array(
            'username' => clean_str(strtolower($this->request->getVar('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS))),
            'fullname' => clean_str($this->request->getVar('fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
            'slug' => remove_special_characters($this->request->getVar('slug')),
            'email' => clean_str($this->request->getVar('email', FILTER_SANITIZE_EMAIL)),
            'mobile_no' => $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'about_me' => $this->request->getVar('about_me', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        $_image_id = $this->request->getVar('newimage_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($_image_id)) {
            $imageModel = new ImagesModel();
            $image =  $imageModel->get_image($_image_id);
            if (!empty($image)) {
                $uploadModel = new UploadModel();
                $data["avatar"] = $uploadModel->avatar_upload(user()->id, FCPATH . $image->image_default);
                //delete old
                delete_file_from_server(user()->avatar);
                // $data["avatar"] = $image->image_default;
            }
        }

        $this->session->set('vr_user_old_email', user()->email);
        return $this->builder()->where('id', $user_id)->update($data);
    }

    //check email updated
    public function check_email_updated($user_id)
    {
        if (get_general_settings()->email_verification == 1) {
            $userModel = new UsersModel();
            $user = $userModel->get_user($user_id);
            if (!empty($user)) {
                if (!empty($this->session->get('vr_user_old_email')) && $this->session->get('vr_user_old_email') != $user->email) {
                    //send confirm email
                    $emailModel = new EmailModel();
                    $emailModel->send_email_activation($user->id);
                    $data = array(
                        'email_status' => 0
                    );
                    return $this->builder()->where('id', $user->id)->update($data);
                }
            }
            if (!empty($this->session->get('vr_user_old_email'))) {
                $this->session->remove('vr_user_old_email');
            }
        }
        return false;
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->request->getVar('old_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'password' => $this->request->getVar('password', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'password_confirm' => $this->request->getVar('password_confirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        return $data;
    }

    //change password
    public function change_password($old_password_exists)
    {
        $user = user();
        if (!empty($user)) {
            $data = $this->change_password_input_values();
            if ($old_password_exists == 1) {
                //password does not match stored password.
                if (!password_verify($data['old_password'], $user->password)) {
                    $this->session->setFlashData('errors_form', trans("wrong_password_error"));
                    return false;
                }
            }
            $data = array(
                'password' => password_hash($data['password'], PASSWORD_BCRYPT)
            );

            if ($this->builder()->where('id', $user->id)->update($data)) {
                $this->session->set("vr_sess_user_ps", md5($data['password']));
                return true;
            }
        } else {

            return false;
        }
    }

    //update address
    public function update_address($user_id)
    {

        $data = array(
            'country_id' => $this->request->getVar('country_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'state_id' => $this->request->getVar('state_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'city_id' => $this->request->getVar('city_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'address' => $this->request->getVar('address', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'zip_code' => $this->request->getVar('zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );

        $_image_id = $this->request->getVar('newimage_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!empty($_image_id)) {
            $this->change_avatar($_image_id);
        }

        $this->session->set('vr_user_old_email', user()->email);
        return $this->builder()->where('id', $user_id)->update($data);
    }

    private function change_avatar($_image_id)
    {
        $imageModel = new ImagesModel();
        $image =  $imageModel->get_image($_image_id);
        if (!empty($image)) {
            $uploadModel = new UploadModel();
            $data["avatar"] = $uploadModel->avatar_upload(user()->id, FCPATH . $image->image_default);
            delete_file_from_server(user()->avatar);
        }
    }
}
