<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\BaseController;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class State extends BaseController
{
    protected $stateModel;
    protected $countryModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->countryModel = new CountryModel();
    }

    public function index()
    {
        $data['title'] = trans('state');
        $data["active_tab"] = 'state';

        // Paginations
        $data['paginate'] = $this->stateModel->DataPaginations();
        $data['pager'] =  $data['paginate']['pager'];

        $data['countries'] = $this->countryModel->asObject()->findAll();

        return view('admin/locations/state', $data);
    }
}
