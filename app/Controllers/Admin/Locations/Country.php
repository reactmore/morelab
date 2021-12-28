<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\BaseController;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class Country extends BaseController
{
    protected $countryModel;

    public function __construct()
    {
        $this->countryModel = new CountryModel();
        $this->stateModel = new StateModel();
    }

    public function index()
    {
        $data['title'] = trans('country');
        $data["active_tab"] = 'country';

        // Paginations
        $paginate = $this->countryModel->DataPaginations();

        $data['country'] =  get_cached_data('country_page_' . $paginate['current_page']);
        if (empty($data['country'])) {
            $data['country'] =   $paginate['country'];
            set_cache_data('country_page_' . $paginate['current_page'], $data['country']);
        }
        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');


        return view('admin/locations/country', $data);
    }

    public function saved_country_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name'              => 'required|max_length[200]',
            'continent_code'    => 'required|max_length[200]',
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
                if ($this->countryModel->update_country($id)) {
                    reset_cache_data_on_change();
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->countryModel->add_country()) {
                    reset_cache_data_on_change();
                    $this->session->setFlashData('success', trans("msg_suc_added"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            }
        } else {
            $this->session->setFlashData('errors_form', $validation->listErrors());
            return redirect()->back()->withInput()->with('error', $validation->getErrors());
        }
    }

    public function delete_country_post()
    {
        $id = $this->request->getVar('id');

        if (count($this->stateModel->get_states_by_country($id)) > 0) {
            $this->session->setFlashData('error', trans("msg_error_row"));
        } else {
            if ($this->countryModel->delete_country($id)) {
                reset_cache_data_on_change();
                $this->session->setFlashData('success', trans("msg_suc_deleted"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }
}
