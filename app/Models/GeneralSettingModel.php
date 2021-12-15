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
        $this->db = db_connect();

        $this->request = \Config\Services::request();
    }

    //update settings
    public function update_settings()
    {
        $data = array(
            'application_name' => $this->request->getVar('application_name'),
            'site_lang' => $this->request->getVar('lang_id'),
            'timezone' => $this->request->getVar('timezone'),
            'copyright' => $this->request->getVar('copyright'),
            'contact_name' => $this->request->getVar('contact_name'),
            'contact_address' => $this->request->getVar('contact_address'),
            'contact_email' => $this->request->getVar('contact_email'),
            'contact_phone' => $this->request->getVar('contact_phone'),
            'contact_text' => $this->request->getVar('contact_text'),
        );

        return $this->builder()->where('id', 1)->update($data);
    }
}
