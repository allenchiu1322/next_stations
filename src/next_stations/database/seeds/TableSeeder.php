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
            ['高雄捷運', ''],
            ['高雄輕軌', ''],
            ['桃園捷運', ''],
            ['台北捷運', ''],
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
            '高雄輕軌' => [
                ['環狀線', ''],
            ],
            '桃園捷運' => [
                ['機場線', ''],
            ],
            '台北捷運' => [
                ['板南線', ''],
                ['淡水信義線', ''],
                ['文湖線', ''],
                ['松山新店線', ''],
                ['中和新蘆線（迴龍）', ''],
                ['中和新蘆線（蘆洲）', ''],
                ['新北投支線', ''],
                ['小碧潭支線', ''],
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
            '高雄輕軌,環狀線' => [
                ['籬仔內', 'Lizihnei', 'C1', 0],
                ['凱旋瑞田', 'Kaisyuan Rueitian', 'C2', 0],
                ['前鎮之星', 'Cianjhen Star', 'C3', 0],
                ['凱旋中華', 'Kaisyuan Jhonghua', 'C4', 0],
                ['夢時代', 'Dream Mall', 'C5', 0],
                ['經貿園區', 'Commerce and Trade Park', 'C6', 0],
                ['軟體園區', 'Software Technology Park', 'C7', 0],
                ['高雄展覽館', 'Kaohsiung Exhibition Center', 'C8', 0],
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
            '台北捷運,板南線' => [
                ['頂埔', 'Dingpu', 'BL01', 0],
                ['永寧', 'Yongning', 'BL02', 0],
                ['土城', 'Tucheng', 'BL03', 0],
                ['海山', 'Haishan', 'BL04', 0],
                ['亞東醫院', 'Far Eastern Hospital', 'BL05', 0],
                ['府中', 'Fuzhong', 'BL06', 0],
                ['板橋', 'Banqiao', 'BL07', 0],
                ['新埔', 'Xinpu', 'BL08', 0],
                ['江子翠', 'Jiangzicui', 'BL09', 0],
                ['龍山寺', 'Longshan Temple', 'BL10', 0],
                ['西門', 'Ximen', 'BL11', 1],
                ['台北車站', 'Taipei Main Station', 'BL12', 1],
                ['善導寺', 'Shandao Temple', 'BL13', 0],
                ['忠孝新生', 'Zhongxiao Xinsheng', 'BL14', 1],
                ['忠孝復興', 'Zhongxiao Fuxing', 'BL15', 1],
                ['忠孝敦化', 'Zhongxiao Dunhua', 'BL16', 0],
                ['國父紀念館', 'S.Y.S. Memorial Hall', 'BL17', 0],
                ['市政府', 'Taipei City Hall', 'BL18', 0],
                ['永春', 'Yongchun', 'BL19', 0],
                ['後山埤', 'Houshanpi', 'BL20', 0],
                ['昆陽', 'Kunyang', 'BL21', 0],
                ['南港', 'Nangang', 'BL22', 0],
                ['南港展覽館', 'Taipei Nangang Exhibition Center', 'BL23', 1],
            ],
            '台北捷運,淡水信義線' => [
                ['象山', 'Xiangshan', 'R02', 0],
                ['台北101/世貿', 'Taipei 101/World Trade Center', 'R03', 0],
                ['信義安和', 'Xinyi Anhe', 'R04', 0],
                ['大安', 'Daan', 'R05', 1],
                ['大安森林公園', 'Daan Park', 'R06', 0],
                ['東門', 'Dongmen', 'R07', 1],
                ['中正紀念堂', 'C.K.S. Memorial Hall', 'R08', 1],
                ['台大醫院', 'NTU Hospital', 'R09', 0],
                ['台北車站', 'Taipei Main Station', 'R10', 1],
                ['中山', 'Zhongshan', 'R11', 1],
                ['雙連', 'Shuanglian', 'R12', 0],
                ['民權西路', 'Minquan W. Rd.', 'R13', 1],
                ['圓山', 'Yuanshan', 'R14', 0],
                ['劍潭', 'Jiantan', 'R15', 0],
                ['士林', 'Shilin', 'R16', 0],
                ['芝山', 'Zhishan', 'R17', 0],
                ['明德', 'Mingde', 'R18', 0],
                ['石牌', 'Shipai', 'R19', 0],
                ['唭哩岸', 'Qilian', 'R20', 0],
                ['奇岩', 'Qiyan', 'R21', 0],
                ['北投', 'Beitou', 'R22', 1],
                ['復興崗', 'Fuxinggang', 'R23', 0],
                ['忠義', 'Zhongyi', 'R24', 0],
                ['關渡', 'Guandu', 'R25', 0],
                ['竹圍', 'Zhuwei', 'R26', 0],
                ['紅樹林', 'Hongshulin', 'R27', 0],
                ['淡水', 'Tamsui', 'R28', 0],
            ],
            '台北捷運,文湖線' => [
                ['動物園', 'Taipei Zoo', 'BR01', 0],
                ['木柵', 'Muzha', 'BR02', 0],
                ['萬芳社區', 'Wanfang Community', 'BR03', 0],
                ['萬芳醫院', 'Wanfang Hospital', 'BR04', 0],
                ['辛亥', 'Xinhai', 'BR05', 0],
                ['麟光', 'Linguang', 'BR06', 0],
                ['六張犁', 'Liuzhangli', 'BR07', 0],
                ['科技大樓', 'Technology Building', 'BR08', 0],
                ['大安', 'Daan', 'BR09', 1],
                ['忠孝復興', 'Zhongxiao Fuxing', 'BR10', 1],
                ['南京復興', 'Nanjing Fuxing', 'BR11', 1],
                ['中山國中', 'Zhongshan Junior High School', 'BR12', 0],
                ['松山機場', 'Songshan Airport', 'BR13', 0],
                ['大直', 'Dazhi', 'BR14', 0],
                ['劍南路', 'Jiannan Rd.', 'BR15', 0],
                ['西湖', 'Xihu', 'BR16', 0],
                ['港墘', 'Gangqian', 'BR17', 0],
                ['文德', 'Wende', 'BR18', 0],
                ['內湖', 'Neihu', 'BR19', 0],
                ['大湖公園', 'Dahu Park', 'BR20', 0],
                ['葫洲', 'Huzhou', 'BR21', 0],
                ['東湖', 'Donghu', 'BR22', 0],
                ['南港軟體園區', 'Nangang Software Park', 'BR23', 0],
                ['南港展覽館', 'Taipei Nangang Exhibition Center', 'BR24', 1],
            ],
            '台北捷運,松山新店線' => [
                ['新店', 'Xindian', 'G01', 0],
                ['新店區公所', 'Xindian District Office', 'G02', 0],
                ['七張', 'Qizhang', 'G03', 1],
                ['大坪林', 'Dapinglin', 'G04', 0],
                ['景美', 'Jingmei', 'G05', 0],
                ['萬隆', 'Wanlong', 'G06', 0],
                ['公館', 'Gongguan', 'G07', 0],
                ['台電大樓', 'Taipower Building', 'G08', 0],
                ['古亭', 'Guting', 'G09', 1],
                ['中正紀念堂', 'C.K.S. Memorial Hall', 'G10', 1],
                ['小南門', 'Xiaonanmen', 'G11', 0],
                ['西門', 'Ximen', 'G12', 1],
                ['北門', 'Beimen', 'G13', 0],
                ['中山', 'Zhongshan', 'G14', 1],
                ['松江南京', 'Songjiang Nanjing', 'G15', 1],
                ['南京復興', 'Nanjing Fuxing', 'G16', 1],
                ['台北小巨蛋', 'Taipei Arena', 'G17', 0],
                ['南京三民', 'Nanjing Sanmin', 'G18', 0],
                ['松山', 'Songshan', 'G19', 0],
            ],
            '台北捷運,中和新蘆線（迴龍）' => [
                ['南勢角', 'Nanshijiao', 'O01', 0],
                ['景安', 'Jingan', 'O02', 0],
                ['永安市場', 'Yongan Market', 'O03', 0],
                ['頂溪', 'Dingxi', 'O04', 0],
                ['古亭', 'Guting', 'O05', 1],
                ['東門', 'Dongmen', 'O06', 1],
                ['忠孝新生', 'Zhongxiao Xinsheng', 'O07', 1],
                ['松江南京', 'Songjiang Nanjing', 'O08', 1],
                ['行天宮', 'Xingtian Temple', 'O09', 0],
                ['中山國小', 'Zhongshan Elementary School', 'O10', 0],
                ['民權西路', 'Minquan W. Rd.', 'O11', 1],
                ['大橋頭', 'Daqiaotou', 'O12', 1],
                ['台北橋', 'Taipei Bridge', 'O13', 0],
                ['菜寮', 'Cailiao', 'O14', 0],
                ['三重', 'Sanchong', 'O15', 0],
                ['先嗇宮', 'Xianse Temple', 'O16', 0],
                ['頭前庄', 'Touqianzhuang', 'O17', 0],
                ['新莊', 'Xinzhuang', 'O18', 0],
                ['輔大', 'Fu Jen University', 'O19', 0],
                ['丹鳳', 'Danfeng', 'O20', 0],
                ['迴龍', 'Huilong', 'O21', 0],
            ],
            '台北捷運,中和新蘆線（蘆洲）' => [
                ['大橋頭', 'Daqiaotou', 'O12', 1],
                ['三重國小', 'Sanchong Elementary School', 'O50', 0],
                ['三和國中', 'Sanhe Junior High School', 'O51', 0],
                ['徐匯中學', 'St. Ignatius High School', 'O52', 0],
                ['三民高中', 'Sanmin Senior High School', 'O53', 0],
                ['蘆洲', 'Luzhou', 'O54', 0],
            ],
            '台北捷運,新北投支線' => [
                ['北投', 'Beitou', 'R22', 1],
                ['新北投', 'Xinbeitou', 'R22A', 0],
            ],
            '台北捷運,小碧潭支線' => [
                ['七張', 'Qizhang', 'G03', 1],
                ['小碧潭', 'Xiaobitan', 'G03A', 0],
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
            ['高雄捷運,凱旋', '高雄輕軌,前鎮之星', '1'],
            ['台北捷運,板橋', '台灣高鐵,板橋', '1'],
            ['台北捷運,台北車站', '台灣高鐵,台北', '1'],
            ['台北捷運,台北車站', '桃園捷運,台北車站', '1'],
            ['台北捷運,北門', '桃園捷運,台北車站', '1'],
            ['台北捷運,南港', '台灣高鐵,南港', '1'],
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
