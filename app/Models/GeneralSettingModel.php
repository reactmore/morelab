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
        //         "src" => $this->input->post('icon_0', true),
        //         "sizes" => $this->input->post('icon_sizes_0', true),
        //         "type" => $this->input->post('icon_type_0', true),
        //     ];

        //     $pwa_icons_1 = [
        //         "src" => $this->input->post('icon_1', true),
        //         "sizes" => $this->input->post('icon_sizes_1', true),
        //         "type" => $this->input->post('icon_type_1', true),
        //     ];
        //     $pwa_icons_2 = [
        //         "src" => $this->input->post('icon_2', true),
        //         "sizes" => $this->input->post('icon_sizes_2', true),
        //         "type" => $this->input->post('icon_type_2', true),
        //     ];

        //     $pwa_setting = [
        //         "dir" => $this->input->post('dir', true),
        //         "name" => $this->input->post('name', true),
        //         "description" => $this->input->post('description', true),
        //         "short_name" => $this->input->post('short_name', true),
        //         "icons" => [$pwa_icons_0, $pwa_icons_1, $pwa_icons_2],
        //         "scope" => $this->input->post('scope', true),
        //         "start_url" => $this->input->post('start_url', true),
        //         "display" => $this->input->post('display', true),
        //         "orientation" => $this->input->post('orientation', true),
        //         "theme_color" => $this->input->post('theme_color', true),
        //         "background_color" => $this->input->post('background_color', true),
        //         "url" => $this->input->post('url', true),
        //         "lang" => $this->input->post('lang', true),
        //         "screenshots" => [],
        //     ];



        //     $new_manifest = json_encode($pwa_setting);
        //     file_put_contents('manifest.json', $new_manifest);

        //     $general_settings = array(
        //         'pwa_status' => $this->input->post('pwa_status', true)
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
}
