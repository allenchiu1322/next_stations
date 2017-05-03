<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Admin;
use App\Station;
use App\Sequence;

class StationRepository {

    /**
     * 用名稱查車站ID
     */
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

    /**
     * 搜尋車站資訊
     */
    public function search_stations($search_string) {
        $ret = Station::where([
            ['name', 'LIKE', '%' . $search_string . '%'],
        ])
        ->select('id', 'name')
        ->get();
        return $ret;
    }

    /**
     * 取得單一車站資訊
     */
    public function query_station($station_id) {
        $ret = Station::where([
            ['id', '=', $station_id],
        ])
        ->get();
        return $ret;
    }

}

