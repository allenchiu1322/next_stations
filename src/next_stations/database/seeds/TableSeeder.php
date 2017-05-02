<?php

use Illuminate\Database\Seeder;

use App\Next_stations\Repositories\AdminRepository;
use App\Next_stations\Repositories\RouteRepository;
use App\Next_stations\Repositories\StationRepository;

class TableSeeder extends Seeder
{
    protected $adminRepository;
    protected $routeRepository;
    protected $stationRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository;
        $this->routeRepository = new RouteRepository;
        $this->stationRepository = new StationRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        /*
         * test command:
         * php artisan migrate:reset;php artisan migrate;php artisan db:Seeder
         */
        $this->_fill_admin();
        $this->_fill_route();
        $this->_fill_station();
    }

    /**
     * 交通業者部份
     */
    private function _fill_admin() {
        $data = [
            ['台灣高鐵', ''],
            ['台北捷運', ''],
            ['高雄捷運', ''],
        ];
        foreach ($data as $v) {
            DB::table('admin')->insert([
                'name' => $v[0],
                'name_en' => $v[1],
            ]);
        }
    }

    /**
     * 路線部份
     */
    private function _fill_route() {
        $data = [
            '台灣高鐵' => [
                ['主線', '']
            ]
        ];
        foreach ($data as $k => $v) {
            $id = $this->adminRepository->get_admin_id_by_name($k);
            foreach ($v as $v2) {
                DB::table('route')->insert([
                    'admin' => $id,
                    'name' => $v2[0],
                    'name_en' => $v2[1],
                ]);
            }
        }
    }

    /**
     * 車站部份
     */
    private function _fill_station() {
        $data = [
            '台灣高鐵,主線' => [
                ['南港', '', ''],
                ['台北', '', ''],
                ['板橋', '', ''],
                ['桃園', '', ''],
                ['新竹', '', ''],
                ['苗栗', '', ''],
                ['台中', '', ''],
                ['彰化', '', ''],
                ['雲林', '', ''],
                ['嘉義', '', ''],
                ['台南', '', ''],
                ['左營', '', ''],
            ]
        ];
        foreach ($data as $k => $v) {
            //取出業者名稱
            $tmp = explode(',', $k);
            $admin = $tmp[0];
            $admin_id = $this->adminRepository->get_admin_id_by_name($admin);
            $route_id = $this->routeRepository->get_route_id_by_name($k);
            //車站順序參數
            $seq = 0;
            foreach ($v as $v2) {
                $seq++;
                //找同業者同名車站，若已存在則不新增
                $station_id = $this->stationRepository->get_station_id_by_name($admin . ',' . $v2[0]);
                if ($station_id == FALSE) {
                    $station_id = DB::table('station')->insertGetId([
                        'admin' => $admin_id,
                        'route' => $route_id,
                        'name' => $v2[0],
                        'name_en' => $v2[1],
                        'code' => $v2[2],
                    ]);
                }
                //車站順序資料
                $ret = DB::table('sequence')->insert([
                    'admin' => $admin_id,
                    'route' => $route_id,
                    'station' => $station_id,
                    'sequence' => $seq,
                ]);
            }
        }
    }
}
