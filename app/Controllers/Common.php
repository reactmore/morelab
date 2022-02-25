<?php

namespace App\Controllers;

use App\Models\GeneralSettingModel;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountryModel;
use App\Models\Locations\StateModel;
use App\Libraries\GoogleAnalytics;
use App\Models\UsersModel;

class Common extends BaseController
{
    protected $stateModel;
    protected $countryModel;
    protected $cityModel;
    protected $userModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->countryModel = new CountryModel();
        $this->cityModel = new CityModel();
        $this->GeneralSettingModel = new GeneralSettingModel();
        $this->analytics = new GoogleAnalytics();
        $this->userModel = new UsersModel();
    }

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

    public function getAnalyticsReport()
    {
        $endDate = date('Y-m-d', strtotime("today"));
        $startDate = date('Y-m-d', strtotime("first day of this month"));

        if (!empty($this->request->getVar('startDate'))) {
            $startDate = date('Y-m-d', strtotime($this->request->getVar('startDate')));
        }

        if (!empty($this->request->getVar('endDate'))) {
            $endDate = date('Y-m-d', strtotime($this->request->getVar('endDate')));
        }


        echo json_encode($this->analytics->getReportViews($startDate, $endDate));
    }

    public function getUsersRegister()
    {
        $endDate = date('Y-m-d', strtotime("today"));
        $startDate = date('Y-m-d', strtotime("first day of this month"));

        if (!empty($this->request->getVar('startDate'))) {
            $startDate = date('Y-m-d', strtotime($this->request->getVar('startDate')));
        }

        if (!empty($this->request->getVar('endDate'))) {
            $endDate = date('Y-m-d', strtotime($this->request->getVar('endDate')));
        }

        $data['latest'] = $this->getUsers($startDate, $endDate);
        $data['user_type'] = $this->getUsersAuth();


        echo json_encode($data);
    }

    private function getUsers($startDate, $endDate)
    {
        $this->userModel->builder('users')
            ->select('count(id) as users, DATE(created_at) as date')
            ->where('created_at <=', $endDate)
            ->where('created_at >=', $startDate)
            ->groupBy('date');


        $query =  $this->userModel->builder('users')->get();

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['day'][] = date("M-d", strtotime($row->date));
                $data['user'][] = (int) $row->users;
            }
        } else {
            $data['day'][] =  0;
            $data['user'][] = 0;
        }


        return $data;
    }

    private function getUsersAuth()
    {
        $this->userModel->builder('users')
            ->select('count(id) as users, user_type')
            ->groupBy('user_type');


        $query =  $this->userModel->builder('users')->get();

        if (!empty($query->getResult())) {
            $data = array();
            foreach ($query->getResult() as $row) {

                $data['type'][] = ucfirst($row->user_type);
                $data['user'][] = (int) $row->users;
            }
        } else {
            $data['type'][] =  0;
            $data['user'][] = 0;
        }


        return $data;
    }
}
