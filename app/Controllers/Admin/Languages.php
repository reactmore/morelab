<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\EmailModel;
use App\Models\LanguageModel;
use App\Models\ProfileModel;

class Languages extends BaseController
{

    protected $languageModel;

    public function __construct()
    {
        $this->languageModel = new LanguageModel();
    }

    public function index()
    {
        $data["title"] = trans("language_settings");
        $data["languages"] = model('LanguageModel')->builder()->get()->getResultObject();

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
            'name'      => 'required|max_length[200]',
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
        $data['title'] = trans("update_language");
        //get language
        $data['language'] = $this->languageModel->asObject()->find($id);

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
            'name'      => 'required|max_length[200]',
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
}
