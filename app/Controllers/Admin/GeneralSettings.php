<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\EmailModel;
use App\Models\UploadModel;

class GeneralSettings extends BaseController
{

    public function index()
    {

        $data['title'] = trans("general_settings");
        $data['active_tab'] = 'general_settings';

        $data["selected_lang"] = $this->request->getVar('lang');

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

        $data['title'] = trans("email_settings");
        $data['active_tab'] = 'email_settings';
        $data['settings'] = get_general_settings();
        $data["protocol"] = $this->request->getVar('protocol');
        if (empty($data["protocol"])) {
            $data['protocol'] = $this->general_settings->mail_protocol;
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

        $data['title'] = trans("social_login_configuration");
        $data['active_tab'] = 'social_settings';

        $data['settings'] = get_general_settings();


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
     * Visual Settings
     */
    public function visual_settings()
    {

        $data['active_tab'] = 'visual_settings';
        $data['title'] = trans("visual_settings");
        $data['visual_settings'] = get_general_settings();

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
}
