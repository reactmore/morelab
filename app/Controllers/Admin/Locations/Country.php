<?php

namespace App\Controllers\Admin\Locations;

use App\Controllers\Admin\BaseController;
use App\Models\Locations\CountryModel;

class Country extends BaseController
{
    protected $countryModel;

    public function __construct()
    {
        $this->countryModel = new CountryModel;
    }

    public function index()
    {
        $data['title'] = trans('country');
        $data["active_tab"] = 'country';

        // Paginations
        $data['paginate'] = $this->countryModel->DataPaginations();
        $data['pager'] =  $data['paginate']['pager'];


        return view('admin/locations/country', $data);
    }
}
