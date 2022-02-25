<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageTranslationsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'language_translations';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['lang_id', 'label', 'translation'];

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
            'label' => strtolower($this->request->getVar('label', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
            'translation' => $this->request->getVar('translation', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );
        return $data;
    }

    public function TranslatePaginate($lang_id)
    {
        $request = service('request');

        $show = 50;
        if ($request->getGet('show')) {
            $show = $request->getGet('show');
        }

        $paginateData = $this->select('language_translations.*')
            ->where('language_translations.lang_id', clean_number($lang_id));

        $search = trim($request->getGet('q'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('language_translations.label', clean_str($search))
                ->orLike('language_translations.translation', clean_str($search))
                ->groupEnd();
        }



        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'translations'  =>  $result,
            'pager'     => $this->pager,
        ];
    }

    public function get_translations_by_label($label)
    {

        $sql = "SELECT * FROM language_translations WHERE language_translations.label = ?";
        $query = $this->db->query($sql, array(clean_str($label)));
        return $query->getRow();
    }

    public function is_unique_translations($value, $update_id = 0)
    {
        $data = $this->asObject()->where('label', $value)->find();

        //if id doesnt exists
        if ($update_id == 0) {
            if (empty($data)) {
                return true;
            } else {
                return false;
            }
        }

        if ($update_id != 0) {
            if (!empty($data->id) && $data->id != $update_id) {
                //username taken
                return false;
            } else {
                return true;
            }
        }
    }


    //add language
    public function add_translations()
    {
        $languageModel = new LanguageModel();
        foreach ($languageModel->asObject()
            ->findAll() as $item) {

            $data_translation = array(
                'lang_id' => $item->id,
                'label' => strtolower($this->request->getVar('label', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
                'translation' => $this->request->getVar('translation', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            );

            $insert = $this->save($data_translation);
        }

        if ($insert) {
            return true;
        }

        return false;
    }
}
