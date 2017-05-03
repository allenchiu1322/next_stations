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

}

