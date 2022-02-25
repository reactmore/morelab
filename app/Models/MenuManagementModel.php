<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuManagementModel extends Model
{
    protected $table_menu_category  = 'user_menu_category';
    protected $table_menu           = 'user_menu';
    protected $table_submenu        = 'user_submenu';

    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
        $this->request = \Config\Services::request();
    }

    public function getMenuCategory()
    {
        return $this->db->table($this->table_menu_category)->orderBy('position_order')
            ->get()->getResultArray();
    }
    public function getMenu()
    {
        return $this->db->table($this->table_menu)->orderBy('position_order')
            ->get()->getResultArray();
    }

    public function getMenuByUrl($menuUrl)
    {
        return $this->db->table('user_menu')
            ->where(['url' => $menuUrl])
            ->get()->getRowArray();
    }

    public function getSubmenu()
    {
        return $this->db->table($this->table_submenu)->orderBy('position_order')
            ->get()->getResultArray();
    }

    public function get_data_by_name($database, $key, $values)
    {
        $sql = "SELECT * FROM $database WHERE $database.$key = ?";
        $query = $this->db->query($sql, array(clean_str($values)));
        return $query->getRow();
    }

    //check if username is unique
    public function is_unique_input(int $options, $keys, $value, $id = 0)
    {
        if ($options === 1) {
            $data = $this->get_data_by_name($this->table_menu_category, $keys, $value);
            //if id doesnt exists
            if ($id == 0) {
                if (empty($data)) {
                    return true;
                } else {
                    return false;
                }
            }
            if ($id != 0) {
                if (!empty($data) && $data->id != $id) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        if ($options === 2) {
            $data = $this->get_data_by_name($this->table_menu, $keys, $value);
            //if id doesnt exists
            if ($id == 0) {
                if (empty($data)) {
                    return true;
                } else {
                    return false;
                }
            }
            if ($id != 0) {
                if (!empty($data) && $data->id != $id) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        if ($options === 3) {
            $data = $this->get_data_by_name($this->table_submenu, $keys, $value);
            //if id doesnt exists
            if ($id == 0) {
                if (empty($data)) {
                    return true;
                } else {
                    return false;
                }
            }
            if ($id != 0) {
                if (!empty($data) && $data->id != $id) {
                    return false;
                } else {
                    return true;
                }
            }
        }
    }

    public function addMenuCategory()
    {

        $data = array(
            'menu_category' => $this->request->getVar('menu_category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'position_order' => clean_number($this->request->getVar('menu_category_order', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
        );

        $this->db->transBegin();
        $this->db->table($this->table_menu_category)->insert($data);

        $get_id = $this->db->insertID();

        // give access
        $this->db->table('user_access')->insert([
            'role_id'  =>  user()->role,
            'menu_category_id'  =>  $get_id,
        ]);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function editMenuCategory($id)
    {
        $data = array(
            'menu_category' => $this->request->getVar('menu_category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'position_order' => clean_number($this->request->getVar('menu_category_order', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
        );

        return $this->builder($this->table_menu_category)->where('id', $id)->update($data);
    }

    public function delete_menu_category($id)
    {
        $id = clean_number($id);
        $menu = $this->get_data_by_name($this->table_menu_category, 'id', $id);
        if (!empty($menu)) {
            return $this->builder($this->table_menu_category)->where('id', $menu->id)->delete();
        }
        return false;
    }

    public function addMenu()
    {
        $data = array(
            'menu_category' => $this->request->getVar('menu_category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'title' => $this->request->getVar('menu_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'url' => $this->request->getVar('menu_url', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'icon' => $this->request->getVar('menu_icon', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'parent' => 0,
            'position_order' => clean_number($this->request->getVar('menu_order', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
        );

        $this->db->transBegin();
        $this->db->table($this->table_menu)->insert($data);

        $get_id = $this->db->insertID();

        // give access
        $this->db->table('user_access')->insert([
            'role_id'  =>  user()->role,
            'menu_id'  =>  $get_id,
        ]);

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function editMenu($id)
    {
        $data = array(
            'menu_category' => $this->request->getVar('menu_category', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'title' => $this->request->getVar('menu_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'url' => $this->request->getVar('menu_url', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'icon' => $this->request->getVar('menu_icon', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'parent' => 0,
            'position_order' => clean_number($this->request->getVar('menu_order')),
        );

        return $this->builder($this->table_menu)->where('id', $id)->update($data);
    }

    public function delete_menu($id)
    {
        $id = clean_number($id);
        $menu = $this->get_data_by_name($this->table_menu, 'id', $id);
        if (!empty($menu)) {
            return $this->builder($this->table_menu)->where('id', $menu->id)->delete();
        }
        return false;
    }

    public function addSubMenu()
    {
        $menu_id = $this->request->getVar('menu_parent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->db->transBegin();
        $this->db->table($this->table_submenu)->insert([
            'menu'  =>  $menu_id,
            'title' => $this->request->getVar('submenu_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'url'   => $this->request->getVar('submenu_url', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'position_order' => clean_number($this->request->getVar('submenu_order')),
        ]);

        $get_id = $this->db->insertID();

        // give access
        $this->db->table('user_access')->insert([
            'role_id'  =>  user()->role,
            'submenu_id'  =>  $get_id,
        ]);

        $menu = $this->db->table($this->table_menu)->select('parent')->where(['id' => $menu_id])->get()->getRowObject();
        if ($menu->parent != 1) {
            $this->db->table($this->table_menu)->update(['parent' => 1], ['id' =>  $menu_id]);
        }


        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function editSubMenu($id)
    {
        $menu_id = $this->request->getVar('menu_parent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cache_parent_id = $this->request->getVar('_cache_menu_parent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $this->db->transBegin();
        $this->db->table($this->table_submenu)->update(
            [
                'menu'  =>  $menu_id,
                'title' => $this->request->getVar('submenu_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'url'   => $this->request->getVar('submenu_url', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
                'position_order' => clean_number($this->request->getVar('submenu_order')),
            ],
            [
                'id' =>  $id
            ]
        );

        $menu = $this->db->table($this->table_menu)->select('parent')->where(['id' => $menu_id])->get()->getRowObject();
        if ($menu->parent != 1) {
            $this->db->table($this->table_menu)->update(['parent' => 1], ['id' =>  $menu_id]);
        }

        $checkMenu =  $this->db->table($this->table_submenu)
            ->where([
                'menu' => $cache_parent_id,
            ])
            ->countAllResults();

        if ($checkMenu === 0) {
            $this->db->table($this->table_menu)->update(['parent' => 0], ['id' =>  $cache_parent_id]);
        }


        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }

    public function delete_submenu($id)
    {
        $id = clean_number($id);
        $menu = $this->get_data_by_name($this->table_submenu, 'id', $id);

        $this->db->transBegin();
        $this->db->table($this->table_submenu)->delete(['id' =>  $id]);
        $checkMenu =  $this->db->table($this->table_submenu)
            ->where([
                'menu' => $menu->menu,
            ])
            ->countAllResults();

        if ($checkMenu === 0) {
            $this->db->table($this->table_menu)->update(['parent' => 0], ['id' =>  $menu->menu]);
        }

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            return false;
        } else {
            $this->db->transCommit();
            return true;
        }
    }
}
