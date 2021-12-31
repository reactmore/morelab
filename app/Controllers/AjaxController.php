<?php

namespace App\Controllers;

use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;

class AjaxController extends BaseController
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

    /**
     * Run Internal Cron
     */
    public function run_internal_cron()
    {
        if (!$this->request->isAJAX()) {
            // ...
            exit();
        }

        //delete old sessions
        $db = db_connect();
        $db->query("DELETE FROM ci_sessions WHERE timestamp < DATE_SUB(NOW(), INTERVAL 3 DAY)");
        //add last update
        $this->GeneralSettingModel->builder()->where('id', 1)->update(['last_cron_update' => date('Y-m-d H:i:s')]);
    }

    /**
     * Switch Mode
     */
    public function switch_visual_mode()
    {

        $vr_dark_mode = 0;
        $dark_mode = $this->request->getVar('dark_mode');
        if ($dark_mode == 1) {
            $vr_dark_mode = 1;
        }

        set_cookie([
            'name' => '_vr_dark_mode',
            'value' =>  $vr_dark_mode,
            'expire' => time() + (86400 * 30),


        ]);

        return redirect()->to($this->agent->getReferrer())->withCookies();
        exit();
    }

    //activate inactivate countries
    public function activate_inactivate_countries()
    {
        $action = $this->request->getVar('action');

        $status = 1;
        if ($action == "inactivate") {
            $status = 0;
        }
        $data = array(
            'status' => $status
        );

        $this->countryModel->builder()->update($data);
    }

    //get countries by continent
    public function get_countries_by_continent()
    {
        $key = $this->request->getVar('key');
        $countries = $this->countryModel->get_countries_by_continent($key);
        if (!empty($countries)) {
            foreach ($countries as $country) {
                echo "<option value='" . $country->id . "'>" . html_escape($country->name) . "</option>";
            }
        }
    }

    //get states by country
    public function get_states_by_country()
    {
        $country_id = $this->request->getVar('country_id');
        $states = $this->stateModel->get_states_by_country($country_id);
        $status = 0;
        $content = '';
        if (!empty($states)) {
            $status = 1;
            $content = '<option value="">' . trans("state") . '</option>';
            foreach ($states as $state) {
                $content .= "<option value='" . $state->id . "'>" . html_escape($state->name) . "</option>";
            }
        }

        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }



    //get states
    public function get_states()
    {
        $country_id = $this->request->getVar('country_id');
        $states = $this->stateModel->get_states_by_country($country_id);
        $status = 0;
        $content = '';
        if (!empty($states)) {
            $status = 1;
            $content = '<option value="">' . trans("state") . '</option>';
            foreach ($states as $item) {
                $content .= '<option value="' . $item->id . '">' . html_escape($item->name) . '</option>';
            }
        }
        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }

    //get cities
    public function get_cities()
    {
        $state_id = $this->request->getVar('state_id');
        $cities = $this->cityModel->get_cities_by_state($state_id);
        $status = 0;
        $content = '';
        if (!empty($cities)) {
            $status = 1;
            $content = '<option value="">' . trans("city") . '</option>';
            foreach ($cities as $item) {
                $content .= '<option value="' . $item->id . '">' . html_escape($item->name) . '</option>';
            }
        }
        $data = array(
            'result' => $status,
            'content' => $content
        );
        echo json_encode($data);
    }

    //show address on map
    public function show_address_on_map()
    {
        $country_text = $this->request->getVar('country_text');
        $country_val = $this->request->getVar('country_val');
        $state_text = $this->request->getVar('state_text');
        $state_val = $this->request->getVar('state_val');
        $city_text = $this->request->getVar('city_text');
        $city_val = $this->request->getVar('city_val');
        $address = $this->request->getVar('address');
        $zip_code = $this->request->getVar('zip_code');




        $data["map_address"] = "";

        if (!empty($country_val)) {
            $data["map_address"] = $data["map_address"] . $country_text;
        }

        if (!empty($state_val)) {
            $data["map_address"] = $data["map_address"] . ' ' . $state_text . " ";
        }

        if (!empty($city_val)) {
            $data["map_address"] = $data["map_address"] . $city_text . " ";
        }


        if (!empty($address)) {
            $data["map_address"] =  $address . " " . $zip_code;

            if (!empty($zip_code)) {
                $data["map_address"] =  $address . " " . $zip_code;
            }
        }


        return view('admin/includes/_load_map', $data);
    }
}
