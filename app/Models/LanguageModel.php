<?php

namespace App\Models;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'languages';
    protected $primaryKey       = 'id';

    // Custom 

    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();


        $this->session = session();
        $this->request = \Config\Services::request();
        $this->languageTranslationsModel = new LanguageTranslationsModel();
    }

    //input values
    public function input_values()
    {
        $data = array(
            'name' => $this->request->getVar('name', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'short_form' => $this->request->getVar('short_form', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'language_code' => $this->request->getVar('language_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'language_order' => $this->request->getVar('language_order', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'text_direction' => $this->request->getVar('text_direction', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'text_editor_lang' => $this->request->getVar('text_editor_lang', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'status' => $this->request->getVar('status', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        return $data;
    }

    //add language
    public function add_language()
    {
        $data = $this->input_values();

        $save_id = $this->protect(false)->insert($data);

        if ($save_id) {
            $translations =  $this->languageTranslationsModel->builder()->where('lang_id', 1)->get()->getResult();
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $data_translation = array(
                        'lang_id' => $save_id,
                        'label' => $translation->label,
                        'translation' => $translation->translation
                    );

                    $this->languageTranslationsModel->builder()->insert($data_translation);
                }
            }

            return $save_id;
        }
        return false;
    }

    //update language
    public function update_language($id)
    {

        $language = $this->asObject()->find($id);

        if (!empty($language->id)) {
            $data = $this->input_values();
            if ($this->builder()->where('id', $language->id)->update($data)) {
                return true;
            }
        }

        return false;
    }


    //delete language
    public function delete_language($id)
    {
        $language = $this->asObject()->find($id);
        if (!empty($language->id)) {
            $translations =   $this->languageTranslationsModel->builder()->where('lang_id', clean_number($language->id))->get()->getResult();

            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    //delete translations
                    $this->languageTranslationsModel->delete($translation->id);
                }
            }
            //delete settings
            if ($this->delete($language->id)) {
                return true;
            }
        }
        return false;
    }

    //set language
    public function set_language()
    {
        $generalSettingsModel = new GeneralSettingModel();

        $data = array(
            'site_lang' => $this->request->getVar('site_lang', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        );

        $lang = $this->asObject()->find($data['site_lang']);

        if (!empty($lang->id)) {
            return $generalSettingsModel->builder()->where('id', 1)->update($data);
        }

        return false;
    }
}
