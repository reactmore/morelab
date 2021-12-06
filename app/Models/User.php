<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Bcrypt;


class User extends Model
{

    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [];


    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;


    // Custom 
    protected $bcrypt;
    protected $session;
    protected $db;
    protected $request;

    public function __construct()
    {
        parent::__construct();

        $this->bcrypt = new Bcrypt();
        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
    }

    //input values
    public function input_values()
    {
        $data = array(
            'fullname' => remove_special_characters($this->request->getVar('fullname')),
            'username' => strtolower(remove_special_characters($this->request->getVar('username'))),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password')
        );
        return $data;
    }

    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {
            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                $this->session->setFlashData('errors_form', 'Wrong password!');
                return false;
            }
            if ($user->status == 0) {
                $this->session->setFlashData('errors_form', 'Banned');
                return false;
            }
            //set user data
            $user_data = array(
                'vr_sess_user_id' => $user->id,
                'vr_sess_user_email' => $user->email,
                'vr_sess_user_role' => $user->role,
                'vr_sess_logged_in' => true,
                'vr_sess_user_ps' => md5($user->password),
                'vr_sess_app_key' => config('app')->AppKey,
            );
            $this->session->set($user_data);
            return true;
        } else {
            $this->session->setFlashData('errors_form', 'Wrong username or password!');
            return false;
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->get('vr_sess_logged_in') == true && $this->session->get('vr_sess_app_key') == config('app')->AppKey) {
            $sess_user_id = @clean_number($this->session->get('vr_sess_user_id'));
            if (!empty($sess_user_id) && !empty($this->get_user($sess_user_id))) {
                return true;
            }
        }
        return false;
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $sql = "SELECT * FROM users WHERE users.email = ?";
        $query = $this->db->query($sql, array(clean_str($email)));
        return $query->getRow();
    }

    //get user by id
    public function get_user($id)
    {
        $sql = "SELECT * FROM users WHERE users.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
    }
}
