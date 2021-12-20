<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralSettingModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'general_settings';
    protected $primaryKey       = 'id';


    protected $useSoftDeletes   = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $updatedField  = 'updated_at';

    public function __construct()
    {
        parent::__construct();

        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function input_default()
    {
        $data = array(
            'updated_at' => date('Y-m-d H:i:s'),
        );

        return $data;
    }

    //update settings
    public function update_settings()
    {
        $data = $this->input_default();
        $data['application_name'] = $this->request->getVar('application_name');
        $data['site_lang'] = $this->request->getVar('lang_id');
        $data['timezone'] = $this->request->getVar('timezone');
        $data['copyright'] = $this->request->getVar('copyright');
        $data['contact_name'] = $this->request->getVar('contact_name');
        $data['contact_address'] = $this->request->getVar('contact_address');
        $data['contact_email'] = $this->request->getVar('contact_email');
        $data['contact_phone'] = $this->request->getVar('contact_phone');
        $data['contact_text'] = $this->request->getVar('contact_text');

        return $this->builder()->where('id', 1)->update($data);
    }

    //update email settings
    public function update_email_settings()
    {
        $data = array(
            'mail_protocol' => $this->request->getVar('mail_protocol'),
            'mail_library' => $this->request->getVar('mail_library'),
            'mail_title' => $this->request->getVar('mail_title'),
            'mail_encryption' => $this->request->getVar('mail_encryption'),
            'mail_host' => $this->request->getVar('mail_host'),
            'mail_port' => $this->request->getVar('mail_port'),
            'mail_username' => $this->request->getVar('mail_username'),
            'mail_password' => $this->request->getVar('mail_password'),
            'mail_reply_to' => $this->request->getVar('mail_reply_to'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }


    //update email verification settings
    public function email_verification_settings()
    {
        $data = array(
            'email_verification' => $this->request->getVar('email_verification'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }

    //update social facebook settings
    public function update_social_facebook_settings()
    {
        $data = array(
            'facebook_app_id' => trim($this->request->getVar('facebook_app_id')),
            'facebook_app_secret' => trim($this->request->getVar('facebook_app_secret'))
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }

    //update social google settings
    public function update_social_google_settings()
    {
        $data = array(
            'google_client_id' => trim($this->request->getVar('google_client_id')),
            'google_client_secret' => trim($this->request->getVar('google_client_secret'))
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }

    //update settings
    public function update_visual_settings()
    {
        $submit = $this->request->getVar('submit');

        // if ($submit == "pwa_settings") {

        //     $pwa_icons_0 = [
        //         "src" => $this->request->getVar('icon_0'),
        //         "sizes" => $this->request->getVar('icon_sizes_0'),
        //         "type" => $this->request->getVar('icon_type_0'),
        //     ];

        //     $pwa_icons_1 = [
        //         "src" => $this->request->getVar('icon_1'),
        //         "sizes" => $this->request->getVar('icon_sizes_1'),
        //         "type" => $this->request->getVar('icon_type_1'),
        //     ];
        //     $pwa_icons_2 = [
        //         "src" => $this->request->getVar('icon_2'),
        //         "sizes" => $this->request->getVar('icon_sizes_2'),
        //         "type" => $this->request->getVar('icon_type_2'),
        //     ];

        //     $pwa_setting = [
        //         "dir" => $this->request->getVar('dir'),
        //         "name" => $this->request->getVar('name'),
        //         "description" => $this->request->getVar('description'),
        //         "short_name" => $this->request->getVar('short_name'),
        //         "icons" => [$pwa_icons_0, $pwa_icons_1, $pwa_icons_2],
        //         "scope" => $this->request->getVar('scope'),
        //         "start_url" => $this->request->getVar('start_url'),
        //         "display" => $this->request->getVar('display'),
        //         "orientation" => $this->request->getVar('orientation'),
        //         "theme_color" => $this->request->getVar('theme_color'),
        //         "background_color" => $this->request->getVar('background_color'),
        //         "url" => $this->request->getVar('url'),
        //         "lang" => $this->request->getVar('lang'),
        //         "screenshots" => [],
        //     ];



        //     $new_manifest = json_encode($pwa_setting);
        //     file_put_contents('manifest.json', $new_manifest);

        //     $general_settings = array(
        //         'pwa_status' => $this->request->getVar('pwa_status')
        //     );

        //     $this->general_settings_model->save($general_settings, 1);
        // }

        if ($submit == "logo") {
            $uploadModel = new UploadModel();
            $logo_path = $uploadModel->logo_upload('logo');
            $logo_footer_path = $uploadModel->logo_upload('logo_dark');
            $logo_email_path = $uploadModel->logo_upload('logo_email');
            $favicon_path = $uploadModel->favicon_upload('favicon');
            if (!empty($logo_path)) {
                $data["logo_light"] = $logo_path;
            }
            if (!empty($logo_footer_path)) {
                $data["logo_dark"] = $logo_footer_path;
            }
            if (!empty($logo_email_path)) {
                $data["logo_email"] = $logo_email_path;
            }
            if (!empty($favicon_path)) {
                $data["favicon"] = $favicon_path;
            }
        }

        if (!empty($data)) {
            //update
            return $this->builder()->where('id', 1)->update($data);
        }

        return true;
    }

    //update maintenance mode settings
    public function update_maintenance_mode_settings()
    {
        $data = array(
            'maintenance_mode_title' => $this->request->getVar('maintenance_mode_title'),
            'maintenance_mode_description' => $this->request->getVar('maintenance_mode_description'),
            'maintenance_mode_status' => $this->request->getVar('maintenance_mode_status'),
        );

        if (empty($data["maintenance_mode_status"])) {
            $data["maintenance_mode_status"] = 0;
        }

        //update
        return $this->builder()->where('id', 1)->update($data);
    }

    //update recaptcha settings
    public function update_recaptcha_settings()
    {
        $data = array(
            'recaptcha_site_key' => $this->request->getVar('recaptcha_site_key'),
            'recaptcha_secret_key' => $this->request->getVar('recaptcha_secret_key'),
            'recaptcha_lang' => $this->request->getVar('recaptcha_lang'),
        );

        //update
        return $this->builder()->where('id', 1)->update($data);
    }
}
