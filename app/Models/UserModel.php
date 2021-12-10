<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Bcrypt;


class UserModel extends Model
{

    protected $table            = 'users';
    protected $primaryKey       = 'id';

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
        // $this->builder = $this->table('mytable');
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

    //update last seen time
    public function update_last_seen()
    {
        // if ($this->auth_check) {
        //     //update last seen
        //     $data = array(
        //         'last_seen' => date("Y-m-d H:i:s"),
        //     );
        //     $this->db->where('id', $this->auth_user->id);
        //     $this->db->update('users', $data);
        // }
    }

    //remember me
    public function remember_me($user_id)
    {
        helper_setcookie('remember_user_id', $user_id);
    }

    //check remember
    public function check_remember()
    {
        $user_id = get_cookie('remember_user_id');
        if (!empty($user_id)) {
            $user = $this->get_user($user_id);
            if (!empty($user)) {
                $this->login_direct($user);
            }
        }
    }

    //login direct
    public function login_direct($user)
    {
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
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->session->get('vr_sess_logged_in') == true && $this->session->get('vr_sess_app_key') == config('app')->AppKey && !empty($this->session->get('vr_sess_user_id'))) {
            $sess_user_id = @clean_number($this->session->get('vr_sess_user_id'));
            if (!empty($sess_user_id)) {
                $sess_pass = $this->session->get("vr_sess_user_ps");
                $user = $this->get_user($sess_user_id);
                if (!empty($user) && !empty($sess_pass) && md5($user->password) == $sess_pass) {
                    return $user;
                }
            }
        }
        return false;
    }

    public function userPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('users.*, roles_permissions.role_name as role')
            ->join('roles_permissions', 'users.role = roles_permissions.role');

        $search = trim($request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('username', clean_str($search))
                ->orLike('email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status'));
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('status', clean_number($status));
        }

        $email_status = trim($request->getGet('email_status'));
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('email_status', clean_number($email_status));
        }

        $role = trim($request->getGet('role'));
        if (!empty($role)) {
            $this->builder()->where('role', clean_str($role));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'users'  =>  $result,
            'pager'     => $this->pager,
        ];
    }
}
