<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Transfer;
use App\Station;

class TransferRepository {

    /**
     * 取得站外轉乘可達車站
     */
    public function transfer_stations($station_id) {
        //去車站對應找
        $ret = Transfer::where('station_a', '=', $station_id)
            ->orWhere('station_b', '=', $station_id)
            ->select('station_a', 'station_b')
            ->get();
        //製作車站參數
        $stations = [];
        foreach ($ret as $v) {
            if ($v['station_a'] == $station_id) {
                $stations[] = $v['station_b'];
            } else if ($v['station_b'] == $station_id) {
                $stations[] = $v['station_a'];
            }
        }
        //取得車站路線資料
        $ret = Station::whereIn('station.id', $stations)
            ->join('admin', 'station.admin', '=', 'admin.id')
            ->join('route', 'station.route', '=', 'route.id')
            ->select('station.id', 'station.name',
                'admin.name as admin_name', 'route.name as route_name')
            ->get();
        return $ret;
    }

}

