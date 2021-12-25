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

    // public function saved_country_post()
    // {
    //     //validate inputs
    //     $this->form_validation->set_rules('name', trans("name"), 'required|xss_clean|max_length[200]');

    //     if ($this->form_validation->run() === false) {
    //         $this->session->set_flashdata('errors', validation_errors());
    //         redirect($this->agent->referrer());
    //     } else {
    //         $id = $this->input->post('id', true);
    //         if (!empty($id)) {
    //             if ($this->location_model->update_country($id)) {
    //                 reset_cache_data($this, "st");
    //                 $this->session->set_flashdata('success', trans("msg_updated"));
    //                 redirect($this->agent->referrer());
    //             } else {
    //                 $this->session->set_flashdata('error', trans("msg_error"));
    //                 redirect($this->agent->referrer());
    //             }
    //         } else {
    //             if ($this->location_model->add_country()) {
    //                 reset_cache_data($this, "st");
    //                 $this->session->set_flashdata('success', trans("msg_added"));
    //                 redirect($this->agent->referrer());
    //             } else {
    //                 $this->session->set_flashdata('error', trans("msg_error"));
    //                 redirect($this->agent->referrer());
    //             }
    //         }
    //     }
    // }
}
