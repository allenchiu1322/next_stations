<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Sequence;

class SequenceRepository {

    /**
     * 取某路線所有車站
     */
    public function all_stations_in_a_route($id, $direction = '1') {
        //處理方向參數
        if ($direction == '2') {
            $orderby = 'desc';
        } else {
            $orderby = 'asc';
        }
        $ret = Sequence::where('sequence.route', '=', $id)
            ->join('station', 'sequence.station', '=', 'station.id')
            ->select('station.id', 'station.name', 'station.code')
            ->orderby('sequence.sequence', $orderby)
            ->get();
        return $ret;
    }

    /**
     * 取得鄰近車站
     */
    public function neighbor_stations($station_id) {
        //先取得車站在哪個路線上的哪個位置
        $ret = Sequence::where([
            ['station', '=', $station_id],
        ])
        ->select('route', 'sequence')
        ->get();
        //再取得鄰近車站的ID
        $data = [];
        foreach ($ret as $v) {
            $ret2 = Sequence::where([
                ['sequence.route', '=', $v['route']],
            ])
            ->whereIn('sequence.sequence',
                [$v['sequence'] + 1, $v['sequence'] - 1])
            ->join('station', 'sequence.station', '=', 'station.id')
            ->join('route', 'sequence.route', '=', 'route.id')
            ->select('sequence.route', 'sequence.station',
                'station.name as station_name',
                'route.name as route_name')
            ->get();
            $data[] = $ret2;
        }
        return $data;
    }

}

