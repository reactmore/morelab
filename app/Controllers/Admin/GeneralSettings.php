<?php

namespace App\Controllers\Admin;

use App\Models\EmailModel;
use App\Models\GeneralSettingModel;
use App\Models\UploadModel;

class GeneralSettings extends AdminController
{

    protected $languageModel;
    protected $LanguageTranslationsModel;

    public function __construct()
    {
        $this->GeneralSettingModel = new GeneralSettingModel();
    }

    public function index()
    {

        $data = array_merge($this->data, [
            'title'     => trans('general_settings'),
            'active_tab'     => 'general_settings',
            'selected_lang'     => $this->request->getGet('lang'),

        ]);

        if (empty($data["selected_lang"])) {
            $data["selected_lang"] = get_general_settings()->site_lang;
            return redirect()->to(admin_url() . "settings/general?lang=" . $data["selected_lang"]);
        }


        $data['settings'] = get_general_settings();


        return view('admin/settings/general_settings', $data);
    }

    public function settings_post()
    {

        if ($this->GeneralSettingModel->update_settings()) {
            $this->session->setFlashData('success', trans("settings") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData("mes_settings", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Recaptcha Settings Post
     */
    public function recaptcha_settings_post()
    {

        if ($this->GeneralSettingModel->update_recaptcha_settings()) {
            $this->session->setFlashData('success', trans("google_recaptcha") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_recaptcha", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData("mes_recaptcha", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Maintenance Mode Post
     */
    public function maintenance_mode_post()
    {
        if ($this->GeneralSettingModel->update_maintenance_mode_settings()) {
            $this->session->setFlashData('success', trans("maintenance") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_maintenance", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData("mes_maintenance", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    public function email_settings()
    {

        $data = array_merge($this->data, [
            'title'     => trans('email_settings'),
            'active_tab'     => 'email_settings',
            'settings'     => get_general_settings(),
            'protocol'     => $this->request->getVar('protocol'),

        ]);

        if (empty($data["protocol"])) {
            $data['protocol'] = $data["settings"]->mail_protocol;
            return redirect()->to(admin_url() . "settings/email?protocol=" . $data["protocol"]);
        }
        if ($data["protocol"] != "smtp" && $data["protocol"] != "mail") {
            $data['protocol'] = "smtp";
            return redirect()->to(admin_url() . "settings/email?protocol=smtp");
        }


        return view('admin/settings/email_settings', $data);
    }

    /**
     * Update Email Settings Post
     */
    public function email_settings_post()
    {

        if ($this->GeneralSettingModel->update_email_settings()) {
            $this->session->setFlashData('success', trans("msg_updated"));
            $this->session->setFlashData('message_type', "email");
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData('message_type', "email");
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Update Email Verification Settings Post
     */
    public function email_verification_settings_post()
    {

        if ($this->GeneralSettingModel->email_verification_settings()) {
            $this->session->setFlashData('success', trans("msg_updated"));
            $this->session->setFlashData('message_type', "verification");
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            $this->session->setFlashData('message_type', "verification");
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Send Test Email Post
     */
    public function send_test_email_post()
    {

        $email = $this->request->getVar('email');
        $subject = get_general_settings()->application_name . " Test Email";
        $message = "<p>This is a test email.</p>";
        $emailModel = new EmailModel();
        $this->session->setFlashData('message_type', "send_email");
        if (!empty($email)) {
            if (!$emailModel->send_test_email($email, $subject, $message)) {
                return redirect()->to($this->agent->getReferrer());
            }
            $this->session->setFlashData('success', trans("msg_email_sent"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
        return redirect()->to($this->agent->getReferrer());
    }

    public function social_settings()
    {

        $data = array_merge($this->data, [
            'title'     => trans('social_login_configuration'),
            'active_tab'     => 'social_settings',
            'settings'     => get_general_settings(),


        ]);

        return view('admin/settings/social_settings', $data);
    }

    /**
     * Social Login Facebook Post
     */
    public function social_login_facebook_post()
    {
        check_admin();
        if ($this->GeneralSettingModel->update_social_facebook_settings()) {
            $this->session->setFlashData('msg_social_facebook', '1');
            $this->session->setFlashData('success', trans("configurations") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Social Login Google Post
     */
    public function social_login_google_post()
    {
        check_admin();
        if ($this->GeneralSettingModel->update_social_google_settings()) {
            $this->session->setFlashData('msg_social_google', '1');
            $this->session->setFlashData('success', trans("configurations") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Social Login Github Post
     */
    public function social_login_github_post()
    {
        check_admin();
        if ($this->GeneralSettingModel->update_social_github_settings()) {
            $this->session->setFlashData('msg_social_github', '1');
            $this->session->setFlashData('success', trans("configurations") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Visual Settings
     */
    public function visual_settings()
    {


        $data = array_merge($this->data, [
            'title'     => trans('visual_settings'),
            'active_tab'     => 'visual_settings',
            'visual_settings'     => get_general_settings(),


        ]);



        return view('admin/settings/visual_settings', $data);
    }

    /**
     * Update Settings Post
     */
    public function visual_settings_post()
    {

        $uploadModel = new UploadModel();
        if ($this->GeneralSettingModel->update_visual_settings()) {
            $this->session->setFlashData('success', trans("visual_settings") . " " . trans("msg_suc_updated"));
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Visual Settings
     */
    public function cache_system_settings()
    {


        $data = array_merge($this->data, [
            'title'     => trans('cache_system'),
            'active_tab'     => 'cache_system',
            'settings'     => get_general_settings(),


        ]);

        return view('admin/settings/cache_system', $data);
    }

    public function cache_system_post()
    {

        if ($this->request->getVar('action') == "reset") {
            reset_cache_data();
            $this->session->setFlashData('success', trans("msg_reset_cache"));
        } else {

            if ($this->GeneralSettingModel->update_cache_system()) {

                $this->session->setFlashData('success', trans("msg_updated"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
        return redirect()->to($this->agent->getReferrer());
    }
}
