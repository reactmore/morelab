<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\BaseController;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class State extends BaseController
{
    protected $stateModel;
    protected $countryModel;
    protected $cityModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->countryModel = new CountryModel();
        $this->cityModel = new CityModel();
    }

    public function index()
    {
        $data['title'] = trans('state');
        $data["active_tab"] = 'state';

        // Paginations
        $paginate = $this->stateModel->DataPaginations();

        $data['state'] =  get_cached_data('state_page_' . $paginate['current_page']);

        if (empty($data['state'])) {

            $data['state'] =   $paginate['state'];
            set_cache_data('state_page_' . $paginate['current_page'], $data['state']);
        }

        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');
        $data['countries'] = $this->countryModel->asObject()->findAll();

        return view('admin/locations/state', $data);
    }

    public function saved_state_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name'              => 'required|max_length[200]',
            'country_id'    => 'required',
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
                if ($this->stateModel->update_state($id)) {
                    reset_cache_data_on_change();
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->stateModel->add_state()) {
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

    public function delete_state_post()
    {
        $id = $this->request->getVar('id');

        if (count($this->cityModel->get_cities_by_state($id)) > 0) {
            $this->session->setFlashData('error', trans("msg_error_row"));
        } else {
            if ($this->cityModel->delete_city($id)) {
                reset_cache_data_on_change();
                $this->session->setFlashData('success', trans("msg_suc_deleted"));
            } else {
                $this->session->setFlashData('error', trans("msg_error"));
            }
        }
    }
}
