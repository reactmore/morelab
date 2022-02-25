<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\AdminController;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class City extends AdminController
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

        $data = array_merge($this->data, [
            'title'     => trans('city'),
            'active_tab'     => 'city',
        ]);


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
            'name' => [
                'label'  => trans('name'),
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'country_id' => [
                'label'  => trans('country'),
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
            'state_id' => [
                'label'  => trans('state'),
                'rules'  => 'required|max_length[100]',
                'errors' => [
                    'required' => trans('form_validation_required'),
                    'max_length' => trans('form_validation_max_length'),
                ],
            ],
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
