<?php

namespace App\Models\Locations;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'location_countries';
    protected $primaryKey       = 'id';
    protected $allowedFields = ['name', 'status', 'continent_code'];

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


        $paginateData = $this->select('location_countries.*');


        $search = trim($this->request->getGet('search'));
        if (!empty($search)) {
            $this->builder()->groupStart()
                ->like('location_countries.namr', clean_str($search))
                ->orLike('location_countries.continent_code', clean_str($search))
                ->groupEnd();
        }

        $status = trim($this->request->getGet('status'));
        if ($status != null && ($status == 1 || $status == 0)) {
            $this->builder()->where('location_countries.status', clean_number($status));
        }

        $result = $paginateData->asObject()->paginate($show, 'default');

        return [
            'country'  =>  $result,
            'pager'     => $this->pager,
            'current_page' => $this->pager->getCurrentPage('default'),
        ];
    }

    //add country
    public function add_country()
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'continent_code' => $this->request->getVar('continent_code'),
            'status' => $this->request->getVar('status')
        );

        return $this->insert($data);
    }

    //update country
    public function update_country($id)
    {
        $data = array(
            'name' => $this->request->getVar('name'),
            'continent_code' => $this->request->getVar('continent_code'),
            'status' => $this->request->getVar('status')
        );


        return $this->update($id, $data);
    }

    //get countries by continent
    public function get_countries_by_continent($continent_code)
    {
        return $this->asObject()->where('continent_code', clean_str($continent_code))->findAll();
        // return $this->db->where('continent_code', clean_str($continent_code))->order_by('name')->get('location_countries')->result();
    }

    //delete country
    public function delete_country($id)
    {
        $id = clean_number($id);
        $country = $this->asObject()->find($id);
        if (!empty($country)) {
            return $this->delete($country->id);
        }
        return false;
    }
}
