<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageTranslationsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'language_translations';
    protected $primaryKey       = 'id';

    // Custom 

    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();


        $this->session = session();
        $this->request = \Config\Services::request();
    }

    //input values
    public function input_values()
    {
        $data = array(
            'label' => strtolower($this->request->getVar('label')),
            'translation' => $this->request->getVar('translation'),
        );
        return $data;
    }

    // public function get_paginated_translations($lang_id, $per_page, $offset)
    // {
    //     $where = [
    //         "lang_id" => clean_number($lang_id)
    //     ];

    //     $this->_translations_filter();
    //     return parent::get_all_where($where, $per_page, $offset, 'id')->result();
    // }

    // public function get_translation_count($lang_id)
    // {
    //     $where = [
    //         "lang_id" => clean_number($lang_id)
    //     ];

    //     $this->_translations_filter();
    //     return parent::get_all_where($where)->num_rows();
    // }

    // protected function _translations_filter()
    // {
    //     $q = trim($this->input->get('q'));

    //     if (!empty($q)) {
    //         $this->db->group_start();
    //         $this->db->like('label', clean_str($q));
    //         $this->db->or_like('translation', clean_str($q));
    //         $this->db->group_end();
    //     }
    // }

    // //add language
    // public function add_translations()
    // {

    //     foreach ($this->language_model->get_all_where(array('deleted' => 0))->result() as $item) {

    //         $data_translation = array(
    //             'lang_id' => $item->id,
    //             'label' => strtolower($this->input->post('label')),
    //             'translation' => $this->input->post('translation'),
    //         );

    //         $insert = parent::save($data_translation);
    //     }

    //     if ($insert) {
    //         return true;
    //     }

    //     return false;
    // }

    // //update translation
    // public function update_translation($id, $translation)
    // {

    //     $data = array('translation' => $translation);

    //     parent::save($data, $id);
    // }
}
