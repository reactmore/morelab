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
        $data['paginate'] = $this->cityModel->DataPaginations();
        $data['pager'] =  $data['paginate']['pager'];

        $data['countries'] = $this->countryModel->asObject()->findAll();
        $data['states'] = $this->stateModel->asObject()->findAll();

        return view('admin/locations/city', $data);
    }
}
