<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function __construct()
    {
        parent::__construct();

        $this->session = session();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->db->query("SET sql_mode = ''");
    }

    //input values
    public function input_values()
    {
        $data = array(
            'username' => strtolower(remove_special_characters(trim($this->request->getVar('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS)))),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        return $data;
    }

    //add user
    public function add_user()
    {

        $data = $this->input_values();

        //secure password
        $data['fullname'] = $this->request->getVar('fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['mobile_no'] =  $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data["about_me"] = $this->request->getVar('about_me');
        $data["country_id"] = $this->request->getVar('country_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data["state_id"] = $this->request->getVar('state_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data["city_id"] = $this->request->getVar('city_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data["address"] = $this->request->getVar('address');
        $data["zip_code"] = $this->request->getVar('zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['role'] = $this->request->getVar('role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $data['status'] = 1;
        $data['email_status'] = 1;
        $data['token'] = generate_unique_id();
        $data['last_seen'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');



        return $this->protect(false)->insert($data);
    }

    //edit user
    public function edit_user($id)
    {
        $user = $this->get_user($id);
        if (!empty($user)) {
            $data = array(
                'username' => strtolower(remove_special_characters(trim($this->request->getVar('username')))),
                'fullname' => $this->request->getVar('fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'email' => $this->request->getVar('email', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'password' => empty($this->request->getVar('password')) ? $user->password : password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'slug' => $this->request->getVar('slug'),
                'about_me' => $this->request->getVar('about_me'),
                'mobile_no' => $this->request->getVar('mobile_no', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'role' => $this->request->getVar('role', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'country_id' => $this->request->getVar('country_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'state_id' => $this->request->getVar('state_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'city_id' => $this->request->getVar('city_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'address' => $this->request->getVar('address'),
                'zip_code' => $this->request->getVar('zip_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
            );

            $_image_id = $this->request->getVar('newimage_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (!empty($_image_id)) {
                $imageModel = new ImagesModel();
                $image =  $imageModel->get_image($_image_id);
                if (!empty($image)) {
                    $uploadModel = new UploadModel();
                    $data["avatar"] = $uploadModel->avatar_upload($user->id, FCPATH . $image->image_default);
                    //delete old
                    delete_file_from_server($user->avatar);
                }
            }

            return $this->protect(false)->update($user->id, $data);
        }
    }

    //ban user
    public function ban_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {

            $data = array(
                'status' => 0
            );
            return $this->protect(false)->update($user->id, $data);
        } else {
            return false;
        }
    }

    //remove user ban
    public function remove_user_ban($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 1
            );

            return $this->protect(false)->update($user->id, $data);
        } else {
            return false;
        }
    }

    //change user role
    public function change_user_role($id, $role)
    {
        $id = clean_number($id);
        $data = array(
            'role' => $role
        );

        return $this->protect(false)->update($id, $data);
    }



    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {
            //check password
            if (!password_verify($data['password'], $user->password)) {
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

    //login with google
    public function login_with_google($g_user)
    {
        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'google_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => "",
                    'user_type' => "google",
                    'status' => 1,
                    'role' => 1,
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                //download avatar
                $avatar = $g_user->avatar;
                if (!empty($avatar)) {
                    $uploadModel = new UploadModel();
                    $save_to = WRITEPATH . "uploads/tmp/avatar-" . uniqid() . ".jpg";
                    @copy($avatar, $save_to);
                    if (!empty($save_to) && file_exists($save_to)) {
                        $data["avatar"] = $uploadModel->avatar_upload(0, $save_to);
                    }
                    @unlink($save_to);
                }
                if (!empty($data['email'])) {
                    $this->protect(false)->insert($data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
                $this->login_direct($user);
            }
        }
    }

    //login with github
    public function login_with_github($g_user)
    {

        if (!empty($g_user)) {
            $user = $this->get_user_by_email($g_user->email);
            //check if user registered
            if (empty($user)) {
                if (empty($g_user->name)) {
                    $g_user->name = "user-" . uniqid();
                }
                $username = $this->generate_uniqe_username($g_user->name);
                $slug = $this->generate_uniqe_slug($username);
                //add user to database
                $data = array(
                    'github_id' => $g_user->id,
                    'email' => $g_user->email,
                    'email_status' => 1,
                    'token' => generate_unique_id(),
                    'username' => $username,
                    'slug' => $slug,
                    'avatar' => "",
                    'user_type' => "github",
                    'status' => 1,
                    'role' => 1,
                    'last_seen' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                );
                //download avatar
                $avatar = $g_user->avatar;
                if (!empty($avatar)) {
                    $uploadModel = new UploadModel();
                    $save_to = WRITEPATH . "uploads/tmp/avatar-" . uniqid() . ".jpg";
                    @copy($avatar, $save_to);
                    if (!empty($save_to) && file_exists($save_to)) {
                        $data["avatar"] = $uploadModel->avatar_upload(0, $save_to);
                    }
                    @unlink($save_to);
                }
                if (!empty($data['email'])) {
                    $this->protect(false)->insert($data);
                    $user = $this->get_user_by_email($g_user->email);
                    $this->login_direct($user);
                }
            } else {
                //login
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

    //register
    public function register()
    {


        $data = $this->input_values();
        $data['fullname'] = $this->request->getVar('fullname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //secure password
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['user_type'] = "registered";
        $data["slug"] = $this->generate_uniqe_slug($data["username"]);
        $data['status'] = 1;
        $data['token'] = generate_unique_id();
        $data['role'] = 1;
        $data['last_seen'] = date('Y-m-d H:i:s');

        $save_id = $this->protect(false)->insert($data);

        if ($save_id) {
            if (get_general_settings()->email_verification == 1) {
                $data['email_status'] = 0;
                $emailModel = new EmailModel();
                $emailModel->send_email_activation($save_id);
            } else {
                $data['email_status'] = 1;
            }

            return $this->get_user($save_id);
        } else {
            return false;
        }
    }

    //reset password
    public function reset_password($token)
    {
        $user = $this->get_user_by_token($token);
        if (!empty($user)) {

            $new_password = $this->request->getVar('password');
            $data = array(
                'password' => password_hash($new_password, PASSWORD_BCRYPT),
                'token' => generate_unique_id()
            );
            //change password
            $this->builder()->where('id', $user->id);
            return $this->builder()->update($data);
        }
        return false;
    }

    //check slug
    public function check_is_slug_unique($slug, $id)
    {

        $sql = "SELECT * FROM users WHERE users.slug = ? AND users.id != ?";
        $query = $this->db->query($sql, array(clean_str($slug), clean_number($id)));
        if (!empty($query->getRow())) {
            return true;
        }
        return false;
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->get_user_by_email($email);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }
        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //check if username is unique
    public function is_unique_username($username, $user_id = 0)
    {
        $user = $this->get_user_by_username($username);
        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }
        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }

    public function getUser($username = false, $userID = false)
    {
        if ($username) {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['username' => $username])
                ->get()->getRow();
        } elseif ($userID) {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->where(['users.id' => $userID])
                ->get()->getRow();
        } else {
            return $this->db->table('users')
                ->select('*,users.id AS userID,user_role.id AS role_id')
                ->join('user_role', 'users.role = user_role.id')
                ->get()->getRow();
        }
    }

    //get user by email
    public function get_user_by_email($email)
    {

        $sql = "SELECT * FROM users WHERE users.email = ?";
        $query = $this->db->query($sql, array(clean_str($email)));
        return $query->getRow();
    }

    //get user by username
    public function get_user_by_username($username)
    {
        $sql = "SELECT * FROM users WHERE users.username = ? ";
        $query = $this->db->query($sql, array(clean_str($username)));
        return $query->getRow();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $sql = "SELECT * FROM users WHERE users.slug = ?";
        $query = $this->db->query($sql, array(clean_str($slug)));
        return $query->getRow();
    }

    //get user by token
    public function get_user_by_token($token)
    {
        $sql = "SELECT * FROM users WHERE users.token = ?";
        $query = $this->db->query($sql, array(clean_str($token)));
        return $query->getRow();
    }

    //get user by id
    public function get_user($id)
    {
        $sql = "SELECT * FROM users WHERE users.id = ?";
        $query = $this->db->query($sql, array(clean_number($id)));
        return $query->getRow();
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

    //generate uniqe slug
    public function generate_uniqe_slug($username)
    {
        $slug = str_slug($username);
        if (!empty($this->get_user_by_slug($slug))) {
            $slug = str_slug($username . "-1");
            if (!empty($this->get_user_by_slug($slug))) {
                $slug = str_slug($username . "-2");
                if (!empty($this->get_user_by_slug($slug))) {
                    $slug = str_slug($username . "-3");
                    if (!empty($this->get_user_by_slug($slug))) {
                        $slug = str_slug($username . "-" . uniqid());
                    }
                }
            }
        }
        return $slug;
    }

    //generate uniqe username
    public function generate_uniqe_username($username)
    {
        $new_username = $username;
        if (!empty($this->get_user_by_username($new_username))) {
            $new_username = $username . " 1";
            if (!empty($this->get_user_by_username($new_username))) {
                $new_username = $username . " 2";
                if (!empty($this->get_user_by_username($new_username))) {
                    $new_username = $username . " 3";
                    if (!empty($this->get_user_by_username($new_username))) {
                        $new_username = $username . "-" . uniqid();
                    }
                }
            }
        }
        return $new_username;
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }
        //check role
        if (user()->role == 1) {
            return true;
        } else {
            return false;
        }
    }

    //is superadmin
    public function is_superadmin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }
        //check role
        if (user()->role == 1 && user()->id == 1) {
            return true;
        } else {
            return false;
        }
    }

    //verify email
    public function verify_email($user)
    {
        if (!empty($user)) {

            $data = array(
                'email_status' => 1,
                'token' => generate_unique_id()
            );

            return $this->protect(false)->update($user->id, $data);
        }
        return false;
    }

    //delete user
    public function delete_user($id)
    {
        $id = clean_number($id);
        $user = $this->get_user($id);
        if (!empty($user)) {
            if (file_exists(FCPATH . $user->avatar)) {
                @unlink(FCPATH . $user->avatar);
            }
            //delete account
            return $this->where('id', $id)->delete();
        }
        return false;
    }

    //update last seen time
    public function update_last_seen()
    {
        if (auth_check()) {
            //update last seen
            $data = array(
                'last_seen' => date("Y-m-d H:i:s"),
            );
            return $this->protect(false)->update(user()->id, $data);
        }
    }

    public function userPaginate()
    {
        $request = service('request');
        $show = 15;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }


        $paginateData = $this->select('users.*, user_role.role_name as role')
            ->join('user_role', 'users.role = user_role.id')
            ->where('users.role !=', 1);


        $search = trim($request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users.username', clean_str($search))
                ->orLike('users.fullname', clean_str($search))
                ->orLike('users.email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status'));
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users.status', clean_number($status));
        }

        $email_status = trim($request->getGet('email_status'));
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('users.email_status', clean_number($email_status));
        }

        $role = trim($request->getGet('role'));
        if (!empty($role)) {
            $this->builder()->where('users.role', clean_number($role));
        }

        $result = $paginateData->paginate($show, 'default');

        return [
            'users'  =>  $result,
            'pager'     => $this->pager,
        ];
    }

    //get paginated users
    public function get_paginated_admin($per_page, $offset)
    {
        $this->builder()->select('users.*, user_role.role_name as role')
            ->join('user_role', 'users.role = user_role.id')
            ->where('users.role', 1)
            ->where('users.deleted_at', null)
            ->orderBy('users.id', 'ASC');
        $this->filter_admin();

        $query = $this->builder()->get($per_page, $offset);

        return $query->getResultArray();
    }

    //get paginated users count
    public function get_paginated_admin_count()
    {
        $this->builder()->selectCount('id');
        $this->builder()->where('role', 'admin');
        $this->builder()->where('deleted_at', NULL);
        $this->filter_admin();
        $query = $this->builder()->get();
        return $query->getRow()->id;
    }

    public function filter_admin()
    {
        $request = service('request');
        $search = trim($request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('users.username', clean_str($search))
                ->orLike('users.fullname', clean_str($search))
                ->orLike('users.email', clean_str($search))
                ->groupEnd();
        }

        $status = trim($request->getGet('status'));
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('users.status', clean_number($status));
        }

        $email_status = trim($request->getGet('email_status'));
        if ($email_status != null && ($email_status == 1 || $email_status == 0)) {
            $this->builder()->where('users.email_status', clean_number($email_status));
        }
    }





    public function logout()
    {
        //unset user data
        $this->session->remove('vr_sess_user_id');
        $this->session->remove('vr_sess_user_email');
        $this->session->remove('vr_sess_user_role');
        $this->session->remove('vr_sess_logged_in');
        $this->session->remove('vr_sess_app_key');
        $this->session->remove('vr_sess_user_ps');
        helper_deletecookie("remember_user_id");
    }
}
