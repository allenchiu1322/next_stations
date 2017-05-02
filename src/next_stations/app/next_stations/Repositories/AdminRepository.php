<?php
namespace App\Next_stations\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Admin;

class AdminRepository {

    public function get_admin_id_by_name($name) {
        //用名稱取ID
        $ret = Admin::where('name', '=', $name)->get();
        return $ret[0]->id;
    }

}

