<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\BaseController;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class City extends BaseController
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
        $data['title'] = trans('city');
        $data["active_tab"] = 'city';

        // Paginations
        $paginate = $this->cityModel->DataPaginations();

        $data['city'] =  get_cached_data('city_page_' . $paginate['current_page']);
        if (empty($data['city'])) {
            $data['city'] =   $paginate['city'];
            set_cache_data('city_page_' . $paginate['current_page'], $data['city']);
        }
        $data['paginations'] =  $paginate['pager']->Links('default', 'custom_pager');


        $data['countries'] = $this->countryModel->asObject()->findAll();
        $data['states'] = $this->stateModel->asObject()->findAll();

        return view('admin/locations/city', $data);
    }

    public function saved_city_post()
    {

        $validation =  \Config\Services::validation();

        //validate inputs
        $rules = [
            'name'              => 'required|max_length[200]',
            'country_id'    => 'required',
            'state_id'    => 'required',
        ];

        if ($this->validate($rules)) {
            $id = $this->request->getVar('id');
            if (!empty($id)) {
                if ($this->cityModel->update_city($id)) {
                    reset_cache_data_on_change();
                    $this->session->setFlashData('success', trans("msg_updated"));
                    return redirect()->to($this->agent->getReferrer());
                } else {
                    $this->session->setFlashData('error', trans("msg_error"));
                    return redirect()->to($this->agent->getReferrer());
                }
            } else {
                if ($this->cityModel->add_city()) {
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

    public function delete_city_post()
    {
        $id = $this->request->getVar('id');


        if ($this->cityModel->delete_city($id)) {
            reset_cache_data_on_change();
            $this->session->setFlashData('success', trans("msg_suc_deleted"));
        } else {
            $this->session->setFlashData('error', trans("msg_error"));
        }
    }
}
