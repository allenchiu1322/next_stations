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
            ['桃園捷運', ''],
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
            '桃園捷運' => [
                ['機場線', ''],
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
                ['南港', '', '', 0],
                ['台北', '', '', 0],
                ['板橋', '', '', 0],
                ['桃園', '', '', 0],
                ['新竹', '', '', 0],
                ['苗栗', '', '', 0],
                ['台中', '', '', 0],
                ['彰化', '', '', 0],
                ['雲林', '', '', 0],
                ['嘉義', '', '', 0],
                ['台南', '', '', 0],
                ['左營', '', '', 0],
            ],
            '高雄捷運,紅線' => [
				['小港', 'Siaogang', 'R3', 0],
				['高雄國際機場', 'Kaohsiung International Airport', 'R4', 0],
				['草衙', 'Caoya', 'R4A', 0],
				['前鎮高中', 'Cianjhen senior high school', 'R5', 0],
				['凱旋', 'Kaisyuan', 'R6', 0],
				['獅甲', 'Shihjia', 'R7', 0],
				['三多商圈', 'Sanduo Shopping District', 'R8', 0],
				['中央公園', 'Central Park', 'R9', 0],
				['美麗島', 'Formosa Boulevard', 'R10/O5', 1],
				['高雄車站', 'Kaohsiung Main Station', 'R11', 0],
				['後驛', 'Houyi', 'R12', 0],
				['凹子底', 'Aozihdi', 'R13', 0],
				['巨蛋', 'Kaohsiung Arena', 'R14', 0],
				['生態園區', 'Ecological District', 'R15', 0],
				['左營', 'Zuoying', 'R16', 0],
				['世運', 'World Games', 'R17', 0],
				['油廠國小', 'Oil Refinery Elementary School', 'R18', 0],
				['楠梓加工區', 'Nanzih Export Processing Zone', 'R19', 0],
				['後勁', 'Houjing(NKMU)', 'R20', 0],
				['都會公園', 'Metropolitan Park', 'R21', 0],
				['青埔', 'Cingpu(NKFUST)', 'R22', 0],
				['橋頭糖廠', 'Ciaotou Sugar Refinery', 'R22A', 0],
				['橋頭火車站', 'Ciaotou Station', 'R23', 0],
				['南岡山', 'Gangshan South', 'R24', 0],
            ],
            '高雄捷運,橘線' => [
				['西子灣', 'Sizihwan', 'O1', 0],
				['鹽埕埔', 'Yanchengpu', 'O2', 0],
				['市議會', 'City Council', 'O4', 0],
				['美麗島', 'Formosa Boulevard', 'R10/O5', 1],
				['信義國小', 'Sinyi Elementary School', 'O6', 0],
				['文化中心', 'Cultural Center', 'O7', 0],
				['五塊厝', 'Wukuaicuo', 'O8', 0],
				['技擊館', 'Martial Arts Stadium', 'O9', 0],
				['衛武營', 'Weiwuying', 'O10', 0],
				['鳳山西站', 'Fongshan West', 'O11', 0],
				['鳳山', 'Fongshan', 'O12', 0],
				['大東', 'Dadong', 'O13', 0],
				['鳳山國中', 'Fongshan Junior High School', 'O14', 0],
				['大寮', 'Daliao', 'OT1', 0],
            ],
            '桃園捷運,機場線' => [
				['台北車站', 'Taipei Main Station', 'A1', 0],
				['三重', 'Sanchong', 'A2', 0],
				['新北產業園區', 'New Taipei Industrial Park', 'A3', 0],
				['新莊副都心', 'Xinzhuang Fuduxin', 'A4', 0],
				['泰山', 'Taishan', 'A5', 0],
				['泰山貴和', 'Taishan Guihe', 'A6', 0],
				['體育大學', 'National Taiwan Sport University', 'A7', 0],
				['長庚醫院', 'Chang Gung Memorial Hospital', 'A8', 0],
				['林口', 'Linkou', 'A9', 0],
				['山鼻', 'Shanbi', 'A10', 0],
				['坑口', 'Kengkou', 'A11', 0],
				['機場第一航廈', 'Airport Terminal 1', 'A12', 0],
				['機場第二航廈', 'Airport Terminal 2', 'A13', 0],
				['機場旅館', 'Airport Hotel', 'A14a', 0],
				['大園', 'Dayuan', 'A15', 0],
				['橫山', 'Hengshan', 'A16', 0],
				['領航', 'Linghang', 'A17', 0],
				['高鐵桃園站', 'Taoyuan HSR Station', 'A18', 0],
				['桃園體育園區', 'Taoyuan Sports Park', 'A19', 0],
				['興南', 'Xingnan', 'A20', 0],
				['環北', 'Huanbei', 'A21', 0],
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
                        'transfer_type' => $v2[3],
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
            ['台灣高鐵,台北', '桃園捷運,台北車站', '1'],
            ['台灣高鐵,桃園', '桃園捷運,高鐵桃園站', '1'],
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
