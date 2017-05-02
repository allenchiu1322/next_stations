<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Admin;
use App\Station;

class StationRepository {

    public function get_station_id_by_name($name) {
        //傳入的參數範例：「台北捷運,中山」
        //先查業者ID
        $base = explode(',', $name);
        //用名稱取業者ID
        $ret = Admin::where('name', '=', $base[0])->get();
        $admin_id = $ret[0]->id;
        if (is_numeric($admin_id)) {
            //用名稱和業者ID取車站ID
            $ret = Station::where([
                ['admin', '=', $admin_id],
                ['name', '=', $base[1]],
            ])->get();
            if (sizeof($ret) > 0) {
                return $ret[0]->id;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}

