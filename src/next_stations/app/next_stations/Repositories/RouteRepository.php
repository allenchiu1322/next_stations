<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Admin;
use App\Route;

class RouteRepository {

    /**
     * 依名稱取路線ID
     */
    public function get_route_id_by_name($name) {
        //傳入的參數範例：「台北捷運,淡水信義線」
        //先查業者ID
        $base = explode(',', $name);
        //用名稱取業者ID
        $ret = Admin::where('name', '=', $base[0])->get();
        $admin_id = $ret[0]->id;
        if (is_numeric($admin_id)) {
            //用名稱和業者ID取路線ID
            $ret = Route::where([
                ['admin', '=', $admin_id],
                ['name', '=', $base[1]],
            ])->get();
            return $ret[0]->id;
        } else {
            return FALSE;
        }
    }

    /**
     * 取所有路線資料，含業者名稱
     */
    public function all_routes() {
        $ret = Route::
            join('admin', 'route.admin', '=', 'admin.id')
            ->select('admin.name as admin_name',
                'admin.id as admin_id',
                'route.*')->get();
        return $ret;
    }

}

