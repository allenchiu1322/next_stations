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
         * php artisan migrate:reset;php artisan migrate;php artisan db:seed
         */
        $this->_fill_admin();
        $this->_fill_route();
        $this->_fill_station();
        $this->_fill_transfer();
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
            ],
            '高雄捷運' => [
                ['紅線', ''],
                ['橘線', '']
            ],
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
            ],
            '高雄捷運,紅線' => [
				['小港', 'Siaogang', 'R3'],
				['高雄國際機場', 'Kaohsiung International Airport', 'R4'],
				['草衙', 'Caoya', 'R4A'],
				['前鎮高中', 'Cianjhen senior high school', 'R5'],
				['凱旋', 'Kaisyuan', 'R6'],
				['獅甲', 'Shihjia', 'R7'],
				['三多商圈', 'Sanduo Shopping District', 'R8'],
				['中央公園', 'Central Park', 'R9'],
				['美麗島', 'Formosa Boulevard', 'R10/O5'],
				['高雄車站', 'Kaohsiung Main Station', 'R11'],
				['後驛', 'Houyi', 'R12'],
				['凹子底', 'Aozihdi', 'R13'],
				['巨蛋', 'Kaohsiung Arena', 'R14'],
				['生態園區', 'Ecological District', 'R15'],
				['左營', 'Zuoying', 'R16'],
				['世運', 'World Games', 'R17'],
				['油廠國小', 'Oil Refinery Elementary School', 'R18'],
				['楠梓加工區', 'Nanzih Export Processing Zone', 'R19'],
				['後勁', 'Houjing(NKMU)', 'R20'],
				['都會公園', 'Metropolitan Park', 'R21'],
				['青埔', 'Cingpu(NKFUST)', 'R22'],
				['橋頭糖廠', 'Ciaotou Sugar Refinery', 'R22A'],
				['橋頭火車站', 'Ciaotou Station', 'R23'],
				['南岡山', 'Gangshan South', 'R24'],
            ],
            '高雄捷運,橘線' => [
				['西子灣', 'Sizihwan', 'O1'],
				['鹽埕埔', 'Yanchengpu', 'O2'],
				['市議會', 'City Council', 'O4'],
				['美麗島', 'Formosa Boulevard', 'R10/O5'],
				['信義國小', 'Sinyi Elementary School', 'O6'],
				['文化中心', 'Cultural Center', 'O7'],
				['五塊厝', 'Wukuaicuo', 'O8'],
				['技擊館', 'Martial Arts Stadium', 'O9'],
				['衛武營', 'Weiwuying', 'O10'],
				['鳳山西站', 'Fongshan West', 'O11'],
				['鳳山', 'Fongshan', 'O12'],
				['大東', 'Dadong', 'O13'],
				['鳳山國中', 'Fongshan Junior High School', 'O14'],
				['大寮', 'Daliao', 'OT1'],
            ],
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

    /**
     * 轉乘資訊部份
     */
    private function _fill_transfer() {
        $data = [
            ['台灣高鐵,左營', '高雄捷運,左營', '1'],
        ];
        foreach ($data as $k => $v) {
            $station_a = $this->stationRepository->get_station_id_by_name($v[0]);
            $station_b = $this->stationRepository->get_station_id_by_name($v[1]);
            $ret = DB::table('transfer')->insert([
                'station_a' => $station_a,
                'station_b' => $station_b,
                'type' => $v[2],
            ]);
        }
    }
}
