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
}
