<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class CityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_cities';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'country_id', 'state_id'];

    // Custom 
    protected $session;
    protected $request;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function DataPaginations()
    {

        $show = 15;
        if ($this->request->getGet('show')) {
            $show = $this->request->getGet('show');
        }

        $paginateData = $this->select('location_cities.*, location_countries.name as country_name, location_states.name as state_name')
            ->join('location_countries', 'location_cities.country_id = location_countries.id')
            ->join('location_states', 'location_cities.state_id = location_states.id');

        $country = trim($this->request->getGet('country'));
        if (!empty($country)) {
            $this->builder()->where('location_cities.country_id', clean_number($country));
        }

        $state = trim($this->request->getGet('state'));
        if (!empty($country)) {
            $this->builder()->where('location_cities.state_id', clean_number($state));
        }

        $search = trim($this->request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('location_countries.name', clean_str($search))
                ->groupEnd();
        }



        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'city'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    //add city
    public function add_city()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'country_id' => $this->request->getVar('country_id'),
            'state_id' => $this->request->getVar('state_id')
        );

        return $this->insert($data);
    }

    //update city
    public function update_city($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'country_id' => $this->request->getVar('country_id'),
            'state_id' => $this->request->getVar('state_id')
        );


        return $this->update($id, $data);
    }

    //get cities by state
    public function get_cities_by_state($state_id)
    {
        return $this->asObject()->where('state_id', clean_number($state_id))->findAll();
    }

    //delete country
    public function delete_city($id)
    {
        $id = clean_number($id);
        $city = $this->asObject()->find($id);
        if (!empty($city)) {
            return $this->delete($city->id);
        }
        return false;
    }
}
