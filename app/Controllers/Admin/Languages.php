<?php

namespace App\Controllers\Admin;


use App\Models\LanguageModel;
use App\Models\LanguageTranslationsModel;


class Languages extends AdminController
{

    protected $languageModel;
    protected $LanguageTranslationsModel;

    public function __construct()
    {
        $this->languageModel = new LanguageModel();
        $this->LanguageTranslationsModel = new LanguageTranslationsModel();
    }

    public function index()
    {
        $data = array_merge($this->data, [
            'title' => trans('language_settings'),
            'languages' => model('LanguageModel')->builder()->get()->getResultObject()

        ]);

        return view('admin/language/languages', $data);
    }

    /**
     * Set Language Post
     */
    public function set_language_post()
    {
        if ($this->languageModel->set_language()) {
            $this->session->setFlashData('success', trans("language") . " " . trans("msg_suc_updated"));
            $this->session->setFlashData("mes_set_language", 1);
            return redirect()->to($this->agent->getReferrer());
        } else {
            $this->session->setFlashData('form_data', $this->language_model->input_values());
            $this->session->setFlashData('error_form', trans("msg_error"));
            $this->session->setFlashData("mes_set_language", 1);
            return redirect()->to($this->agent->getReferrer());
        }
    }

    /**
     * Add Language Post
     */
    public function add_language_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs

        $rules = [
            'name' => [
                'label'  => trans('language_name'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'short_form' => [
                'label'  => trans('short_form'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'language_code' => [
                'label'  => trans('language_code'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'text_editor_lang' => [
                'label'  => trans('text_editor_language'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],

        ];

        if ($this->validate($rules)) {

            $language_id = $this->languageModel->add_language();

            if (!empty($language_id)) {
                $this->session->setFlashData('success', trans("language") . " " . trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('form_data', $this->language_model->input_values());
                $this->session->set_flashdata('errors_form', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Edit Language
     */
    public function edit_language($id)
    {
        $data = array_merge($this->data, [
            'title' => trans('edit_translations'),
            'language' => $this->languageModel->asObject()->find($id)

        ]);


        if (empty($data['language']->id)) {
            return redirect()->to($this->agent->getReferrer());
        }

        return view('admin/language/update_language', $data);
    }

    /**
     * Update Language Post
     */
    public function language_edit_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'name' => [
                'label'  => trans('language_name'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'short_form' => [
                'label'  => trans('short_form'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'language_code' => [
                'label'  => trans('language_code'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'text_editor_lang' => [
                'label'  => trans('text_editor_language'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');

            if ($this->languageModel->update_language($id)) {
                $this->session->setFlashData('success', trans("language") . " " . trans("msg_suc_updated"));
                return redirect()->to(admin_url() . 'language-settings');
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Delete Language Post
     */
    public function delete_language_post()
    {
        $id = $this->request->getVar('id');

        $language = $this->languageModel->asObject()->find($id);

        if ($language->id == 1) {
            $this->session->setFlashData('error', trans("msg_language_delete"));
            exit();
        }
        if ($this->languageModel->delete_language($id)) {
            $this->session->setFlashData('success', trans("language") . " " . trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }

    /**
     * Translations
     */
    public function translations($id)
    {

        $data = array_merge($this->data, [
            'title' => trans('edit_translations'),
            'language' => $this->languageModel->asObject()->find($id)

        ]);


        if (empty($data['language']->id)) {
            return redirect()->to($this->agent->getReferrer());
        }

        //get paginated translations
        $data['paginate'] = $this->LanguageTranslationsModel->TranslatePaginate($data['language']->id);
        $data['pager'] =  $data['paginate']['pager'];

        return view('admin/language/translations', $data);
    }

    /**
     * Add Language Post
     */
    public function add_translations_post()
    {
        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'lang_id' => [
                'label'  => trans('id'),
                'rules'  => 'required',
                'errors' => [
                    'required' => trans('form_validation_required'),

                ],
            ],
            'label' => [
                'label'  => trans('label'),
                'rules'  => 'required|max_length[200]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),

                ],
            ],
            'translation' => [
                'label'  => trans('translation'),
                'rules'  => 'required|max_length[200]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),

                ],
            ],

        ];

        if ($this->validate($rules)) {

            $label = $this->request->getVar('label');
            if (!$this->LanguageTranslationsModel->is_unique_translations($label)) {
                $this->session->setFlashData('error', trans("msg_label_unique_error"));
                return redirect()->to($this->agent->getReferrer());
            }

            $language_translations = $this->LanguageTranslationsModel->add_translations();
            if (!empty($language_translations)) {
                $this->session->setFlashData('success', trans("translation") . " " . trans("msg_suc_added"));
                return redirect()->to($this->agent->getReferrer());
            } else {
                $this->session->setFlashData('error_form', trans("msg_error"));
                return redirect()->to($this->agent->getReferrer());
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    /**
     * Update Translations Post
     */
    public function update_translation_post()
    {
        $data = array(
            "translation" => $this->request->getVar('translation')
        );

        if ($this->LanguageTranslationsModel->update($this->request->getVar('id'), $data)) {
            $this->session->setFlashData('success', trans("msg_updated"));
        } else {
            echo json_encode('0');
        }
    }
}
