<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_states';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'country_id'];

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

        $paginateData = $this->select('location_states.*, location_countries.name as country_name, location_countries.status as country_status')
            ->join('location_countries', 'location_states.country_id = location_countries.id');

        $status = trim($this->request->getGet('country'));
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('location_states.country_id', clean_number($status));
        }

        $search = trim($this->request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('location_states.name', clean_str($search))
                ->groupEnd();
        }



        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'state'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    public function add_state()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'country_id' => $this->request->getVar('country_id')
        );

        return $this->insert($data);
    }

    //update state
    public function update_state($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'country_id' => $this->request->getVar('country_id')
        );


        return $this->update($id, $data);
    }

    //get states by country
    public function get_states_by_country($country_id)
    {
        return $this->asObject()->where('country_id', clean_number($country_id))->findAll();
    }

    //delete country
    public function delete_state($id)
    {
        $id = clean_number($id);
        $state = $this->asObject()->find($id);
        if (!empty($state)) {
            return $this->delete($state->id);
        }
        return false;
    }
}
