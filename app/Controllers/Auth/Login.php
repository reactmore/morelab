<?php

namespace App\Controllers\Auth;

use App\Models\UsersModel;
use Exception;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Github;

use stdClass;

class Login extends AuthController
{
    public function index()
    {
        if ($this->session->get('vr_sess_logged_in') == TRUE) {
            return redirect()->to(base_url('/'));
        }

        $data['title'] = trans('login');

        return view('Auth/Login', $data);
    }

    public function admin_login_post()
    {
        $userModel = new UsersModel();

        $rules = [
            'email' => [
                'label'  => trans('email'),
                'rules'  => 'required|min_length[4]|max_length[100]|valid_email',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'min_length' => trans('form_validation_min_length'),
                    'max_length' => trans('form_validation_max_length'),
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
            ],
            'password' => [
                'label'  => trans('password'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),
                ],
            ],

        ];

        if ($this->validate($rules)) {

            $user = $userModel->get_user_by_email($this->request->getVar('email'));
            if (!empty($user) && $user->role != 1 && get_general_settings()->maintenance_mode_status == 1) {
                $this->session->setFlashData('errors_form', "Site under construction! Please try again later.");
                return redirect()->back();
            }

            if ($userModel->login()) {
                //remember user
                $remember_me = $this->request->getVar('remember_me');
                if ($remember_me == 1) {
                    $this->response->setCookie('_remember_user_id', user()->id, time() + 86400);
                }
                return redirect()->to(admin_url())->withCookies();
            } else {

                return redirect()->back()->withInput();
            }
        } else {

            $this->session->setFlashData('errors_form', $this->validator->listErrors());
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
    }

    /**
     * Logout
     */
    public function Logout()
    {
        //unset user data
        $this->session->remove('vr_sess_user_id');
        $this->session->remove('vr_sess_user_email');
        $this->session->remove('vr_sess_user_role');
        $this->session->remove('vr_sess_logged_in');
        $this->session->remove('vr_sess_app_key');
        $this->session->remove('vr_sess_user_ps');
        helper_deletecookie("remember_user_id");
        return redirect()->to('/');
    }

    /**
     * Connect with Google
     */
    public function connect_with_google()
    {

        $provider = new Google([
            'clientId' => get_general_settings()->google_client_id,
            'clientSecret' => get_general_settings()->google_client_secret,
            'redirectUri' => base_url() . '/auth/connect-with-google',
        ]);

        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {

            // If we don't have an authorization code then get one
            $authUrl = $provider->getAuthorizationUrl();
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set('g_login_referrer', $this->agent->getReferrer());
            header('Location: ' . $authUrl);
            exit();
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $user = $provider->getResourceOwner($token);

                $g_user = new stdClass();
                $g_user->id = $user->getId();
                $g_user->email = $user->getEmail();
                $g_user->name = $user->getName();
                $g_user->avatar = $user->getAvatar();

                $userModel = new UsersModel();
                $userModel->login_with_google($g_user);

                if (!empty($this->session->get('g_login_referrer'))) {
                    return redirect()->to($this->session->get('g_login_referrer'))->withCookies();
                } else {
                    return redirect()->to(base_url());
                }
            } catch (Exception $e) {
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }

    /**
     * Connect with Github
     */
    public function connect_with_github()
    {

        $provider = new Github([
            'clientId' => get_general_settings()->github_client_id,
            'clientSecret' => get_general_settings()->github_client_secret,
            'redirectUri' => base_url() . '/auth/connect-with-github',
        ]);

        if (!empty($_GET['error'])) {
            // Got an error, probably user denied access
            exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
        } elseif (empty($_GET['code'])) {

            // If we don't have an authorization code then get one
            $options = [
                'scope' => ['user', 'user:email', 'repo'] // array or string
            ];

            $authUrl = $provider->getAuthorizationUrl($options);
            $_SESSION['oauth2state'] = $provider->getState();
            $this->session->set('g_login_referrer', $this->agent->getReferrer());
            header('Location: ' . $authUrl);
            exit();
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
            // State is invalid, possible CSRF attack in progress
            unset($_SESSION['oauth2state']);
            exit('Invalid state');
        } else {
            // Try to get an access token (using the authorization code grant)
            $token = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            // Optional: Now you have a token you can look up a users profile data
            try {
                // We got an access token, let's now get the owner details
                $user = $provider->getResourceOwner($token);

                $g_user = new stdClass();
                $g_user->id = $user->getId();
                $g_user->email = $user->getEmail();
                $g_user->name = $user->getName();
                $g_user->avatar = "https://avatars.githubusercontent.com/u/{$user->getId()}";

                $userModel = new UsersModel();
                $userModel->login_with_github($g_user);



                if (!empty($this->session->get('g_login_referrer'))) {
                    return redirect()->to($this->session->get('g_login_referrer'))->withCookies();
                } else {
                    return redirect()->to(base_url());
                }
            } catch (Exception $e) {
                // Failed to get user details
                exit('Something went wrong: ' . $e->getMessage());
            }
        }
    }
}
