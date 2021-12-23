<?php

namespace App\Controllers;

class AjaxController extends BaseController
{




    public function __construct()
    {
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
}
