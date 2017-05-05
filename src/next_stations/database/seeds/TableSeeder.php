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
            ['台鐵', ''],
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
            '台鐵' => [
                ['西部幹線', ''],
                ['山線', ''],
                ['成追線', ''],
                ['屏東線', ''],
                ['南迴線', ''],
                ['宜蘭線', ''],
                ['北迴線', ''],
                ['台東線', ''],
                ['平溪線', ''],
                ['深澳線', ''],
                ['內灣線', ''],
                ['六家線', ''],
                ['集集線', ''],
                ['沙崙線', ''],
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
            '台鐵,西部幹線' => [
                ['基隆', 'Keelung', '', 0],
                ['三坑', 'Sankeng', '', 0],
                ['八堵', 'Badu', '', 1],
                ['七堵', 'Cidu', '', 0],
                ['百福', 'Baifu', '', 0],
                ['五堵', 'Wudu', '', 0],
                ['汐止', 'Sijhih', '', 0],
                ['汐科', 'Xike', '', 0],
                ['南港', 'Nangang', '', 0],
                ['松山', 'Songshan', '', 0],
                ['台北', 'Taipei', '', 0],
                ['萬華', 'Wanhua', '', 0],
                ['板橋', 'Banciao', '', 0],
                ['浮洲', 'Fuzhou', '', 0],
                ['樹林', 'Shulin', '', 0],
                ['南樹林', 'South Shulin', '', 0],
                ['山佳', 'Shanjia', '', 0],
                ['鶯歌', 'Yingge', '', 0],
                ['桃園', 'Taoyuan', '', 0],
                ['內壢', 'Neili', '', 0],
                ['中壢', 'Jhongli', '', 0],
                ['埔心', 'Pusin', '', 0],
                ['楊梅', 'Yangmei', '', 0],
                ['富岡', 'Fugang', '', 0],
                ['北湖', 'BaiHwu', '', 0],
                ['湖口', 'Hukou', '', 0],
                ['新豐', 'Sinfong', '', 0],
                ['竹北', 'Jhubei', '', 0],
                ['北新竹', 'North Hsinchu', '', 0],
                ['新竹', 'Hsinchu', '', 1],
                ['三姓橋', 'Sanxingqiao', '', 0],
                ['香山', 'Siangshan', '', 0],
                ['崎頂', 'Ciding', '', 0],
                ['竹南', 'Jhunan', '', 1],
                ['談文', 'Tanwan', '', 0],
                ['大山', 'Dashan', '', 0],
                ['後龍', 'Houlong', '', 0],
                ['龍港', 'Longgang', '', 0],
                ['白沙屯', 'Baishatun', '', 0],
                ['新埔', 'Sinpu', '', 0],
                ['通霄', 'Tongsiao', '', 0],
                ['苑裡', 'Yuanli', '', 0],
                ['日南', 'Rihnan', '', 0],
                ['大甲', 'Dajia', '', 0],
                ['台中港', 'Taichung Port', '', 0],
                ['清水', 'Cingshuei', '', 0],
                ['沙鹿', 'Shalu', '', 0],
                ['龍井', 'Longjing', '', 0],
                ['大肚', 'Dadu', '', 0],
                ['追分', 'Jhuifen', '', 1],
                ['彰化', 'Changhua', '', 1],
                ['花壇', 'Huatan', '', 0],
                ['大村', 'Datsun', '', 0],
                ['員林', 'Yuanlin', '', 0],
                ['永靖', 'Yongjing', '', 0],
                ['社頭', 'Shetou', '', 0],
                ['田中', 'Tianjhong', '', 0],
                ['二水', 'Ershuei', '', 1],
                ['林內', 'Linnei', '', 0],
                ['石榴', 'Shihliou', '', 0],
                ['斗六', 'Douliou', '', 0],
                ['斗南', 'Dounan', '', 0],
                ['石龜', 'Shihguei', '', 0],
                ['大林', 'Dalin', '', 0],
                ['民雄', 'Minsyong', '', 0],
                ['嘉北', 'ChiaPei', '', 0],
                ['嘉義', 'Chiayi', '', 0],
                ['水上', 'Shueishang', '', 0],
                ['南靖', 'Nanjing', '', 0],
                ['後壁', 'Houbi', '', 0],
                ['新營', 'Sinying', '', 0],
                ['柳營', 'Liouying', '', 0],
                ['林鳳營', 'Linfongying', '', 0],
                ['隆田', 'Longtian', '', 0],
                ['拔林', 'Balin', '', 0],
                ['善化', 'Shanhua', '', 0],
                ['南科', 'Nanke', '', 0],
                ['新市', 'Sinshih', '', 0],
                ['永康', 'Yongkang', '', 0],
                ['大橋', 'Daciao', '', 0],
                ['台南', 'Tainan', '', 0],
                ['保安', 'Baoan', '', 0],
                ['仁德', 'Rende', '', 0],
                ['中洲', 'Jhongjhou', '', 1],
                ['大湖', 'Dahu', '', 0],
                ['路竹', 'Lujhu', '', 0],
                ['岡山', 'Gangshan', '', 0],
                ['橋頭', 'Ciaotou', '', 0],
                ['楠梓', 'Nanzih', '', 0],
                ['新左營', 'Xinzuoying', '', 0],
                ['左營', 'Zuoying', '', 0],
                ['高雄', 'Kaohsiung', '', 0],
                ['鳳山', 'Fongshan', '', 0],
                ['後庄', 'Houjhuang', '', 0],
                ['九曲堂', 'Jioucyutang', '', 0],
                ['六塊厝', 'Lioukuaicuo', '', 0],
                ['屏東', 'Pingtung', '', 0],
            ],
            '台鐵,山線' => [
                ['竹南', 'Jhunan', '', 1],
                ['造橋', 'Zaociao', '', 0],
                ['豐富', 'Fongfu', '', 0],
                ['苗栗', 'Miaoli', '', 0],
                ['南勢', 'Nanshih', '', 0],
                ['銅鑼', 'Tongluo', '', 0],
                ['三義', 'Sanyi', '', 0],
                ['泰安', 'Taian', '', 0],
                ['后里', 'Houli', '', 0],
                ['豐原', 'Fongyuan', '', 0],
                ['潭子', 'Tanzih', '', 0],
                ['太原', 'Taiyuan', '', 0],
                ['台中', 'Taichung', '', 0],
                ['大慶', 'Dacing', '', 0],
                ['烏日', 'Wurih', '', 0],
                ['新烏日', 'Xinwuri', '', 0],
                ['成功', 'Chenggong', '', 1],
                ['彰化', 'Changhua', '', 1],
            ],
            '台鐵,成追線' => [
                ['追分', 'Jhuifen', '', 1],
                ['成功', 'Chenggong', '', 1],
            ],
            '台鐵,屏東線' => [
                ['屏東', 'Pingtung', '', 0],
                ['歸來', 'Gueilai', '', 0],
                ['麟洛', 'Linluo', '', 0],
                ['西勢', 'Sishih', '', 0],
                ['竹田', 'Jhutian', '', 0],
                ['潮州', 'Chaojhou', '', 0],
                ['崁頂', 'Kanding', '', 0],
                ['南州', 'Nanjhou', '', 0],
                ['鎮安', 'Jhenan', '', 0],
                ['林邊', 'Linbian', '', 0],
                ['佳冬', 'Jiadong', '', 0],
                ['東海', 'Donghai', '', 0],
                ['枋寮', 'Fangliao', '', 0],
            ],
            '台鐵,南迴線' => [
                ['枋寮', 'Fangliao', '', 0],
                ['加祿', 'Jialu', '', 0],
                ['內獅', 'Neishih', '', 0],
                ['枋山', 'Fangshan', '', 0],
                ['古莊', 'Gujhuang', '', 0],
                ['大武', 'Dawu', '', 0],
                ['瀧溪', 'Lunghsi', '', 0],
                ['金崙', 'Jinlun', '', 0],
                ['太麻里', 'Taimali', '', 0],
                ['知本', 'Jhihben', '', 0],
                ['康樂', 'Kangle', '', 0],
                ['台東', 'Taitung', '', 0],
            ],
            '台鐵,宜蘭線' => [
                ['八堵', 'Badu', '', 1],
                ['暖暖', 'Nuannuan', '', 0],
                ['四腳亭', 'Sihjiaoting', '', 0],
                ['瑞芳', 'Rueifang', '', 1],
                ['侯硐', 'Houtung', '', 0],
                ['三貂嶺', 'Sandiaoling', '', 1],
                ['牡丹', 'Mudan', '', 0],
                ['雙溪', 'Shuangsi', '', 0],
                ['貢寮', 'Gungliao', '', 0],
                ['福隆', 'Fulong', '', 0],
                ['石城', 'Shihcheng', '', 0],
                ['大里', 'Dali', '', 0],
                ['大溪', 'Dasi', '', 0],
                ['龜山', 'Gueishan', '', 0],
                ['外澳', 'Waiao', '', 0],
                ['頭城', 'Toucheng', '', 0],
                ['頂埔', 'Dingpu', '', 0],
                ['礁溪', 'Jiaohsi', '', 0],
                ['四城', 'Sihcheng', '', 0],
                ['宜蘭', 'Yilan', '', 0],
                ['二結', 'Erjie', '', 0],
                ['中里', 'Jhongli', '', 0],
                ['羅東', 'Luodong', '', 0],
                ['冬山', 'Dongshan', '', 0],
                ['新馬', 'Sinma', '', 0],
                ['蘇澳新', 'Suaosin', '', 1],
                ['蘇澳', 'Suao', '', 0],
            ],
            '台鐵,北迴線' => [
                ['蘇澳新', 'Suaosin', '', 1],
                ['永樂', 'Yongle', '', 0],
                ['東澳', 'Dongao', '', 0],
                ['南澳', 'Nanao', '', 0],
                ['武塔', 'Wuta', '', 0],
                ['漢本', 'Hanben', '', 0],
                ['和平', 'Heping', '', 0],
                ['和仁', 'Horen', '', 0],
                ['崇德', 'Chongde', '', 0],
                ['新城', 'Sincheng', '', 0],
                ['景美', 'Jingmei', '', 0],
                ['北埔', 'Beipu', '', 0],
                ['花蓮', 'Hualien', '', 0],
            ],
            '台鐵,台東線' => [
                ['花蓮', 'Hualien', '', 0],
                ['吉安', 'Jian', '', 0],
                ['志學', 'Jhihsyue', '', 0],
                ['平和', 'Pinghe', '', 0],
                ['壽豐', 'Shoufong', '', 0],
                ['豐田', 'Fongtian', '', 0],
                ['南平', 'Nanping', '', 0],
                ['鳳林', 'Fonglin', '', 0],
                ['萬榮', 'Wanrong', '', 0],
                ['光復', 'Guangfu', '', 0],
                ['大富', 'Dafu', '', 0],
                ['富源', 'Fuyuan', '', 0],
                ['瑞穗', 'Rueisuei', '', 0],
                ['三民', 'Sanmin', '', 0],
                ['玉里', 'Yuli', '', 0],
                ['東里', 'Dongli', '', 0],
                ['東竹', 'Dongjhu', '', 0],
                ['富里', 'Fuli', '', 0],
                ['池上', 'Chihshang', '', 0],
                ['海端', 'Haiduan', '', 0],
                ['關山', 'Guanshan', '', 0],
                ['瑞和', 'Rueihe', '', 0],
                ['瑞源', 'Rueiyuan', '', 0],
                ['鹿野', 'Luye', '', 0],
                ['山里', 'Shanli', '', 0],
                ['台東', 'Taitung', '', 0],
            ],
            '台鐵,平溪線' => [
                ['三貂嶺', 'Sandiaoling', '', 1],
                ['大華', 'Dahua', '', 0],
                ['十分', 'Shihfen', '', 0],
                ['望古', 'Wanggu', '', 0],
                ['嶺腳', 'Lingjiao', '', 0],
                ['平溪', 'Pingsi', '', 0],
                ['菁桐', 'Jingtong', '', 0],
            ],
            '台鐵,深澳線' => [
                ['八斗子', 'Badouzi', '', 0],
                ['海科館', 'Haikeguan', '', 0],
                ['瑞芳', 'Rueifang', '', 1],
            ],
            '台鐵,內灣線' => [
                ['北新竹', 'North Hsinchu', '', 0],
                ['千甲', 'Qianjia', '', 0],
                ['新莊', 'Xinzhuang', '', 0],
                ['竹中', 'Jhujhong', '', 0],
                ['上員', 'Shangyuan', '', 0],
                ['榮華', 'Ronghua', '', 0],
                ['竹東', 'Jhudong', '', 0],
                ['橫山', 'Hengshan', '', 0],
                ['九讚頭', 'jiouzantou', '', 0],
                ['合興', 'Hesing', '', 0],
                ['富貴', 'Fuguei', '', 0],
                ['內灣', 'Neiwan', '', 0],
            ],
            '台鐵,六家線' => [
                ['竹中', 'Jhujhong', '', 0],
                ['六家', 'Liujia', '', 0],
            ],
            '台鐵,集集線' => [
                ['二水', 'Ershuei', '', 1],
                ['源泉', 'Yuanciyuan', '', 0],
                ['濁水', 'Jhuoshuei', '', 0],
                ['龍泉', 'Lungcyuan', '', 0],
                ['集集', 'Jiji', '', 0],
                ['水里', 'Shueili', '', 0],
                ['車埕', 'Checheng', '', 0],
            ],
            '台鐵,沙崙線' => [
                ['中洲', 'Jhongjhou', '', 1],
                ['長榮大學', 'Chang Jung Christian University', '', 0],
                ['沙崙', 'Shalun', '', 0],
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
            ['台鐵,南港', '台灣高鐵,南港', '1'],
            ['台鐵,南港', '台北捷運,南港', '1'],
            ['台鐵,松山', '台北捷運,松山', '1'],
            ['台鐵,台北', '台灣高鐵,台北', '1'],
            ['台鐵,台北', '桃園捷運,台北車站', '1'],
            ['台鐵,台北', '台北捷運,台北車站', '1'],
            ['台鐵,板橋', '台灣高鐵,板橋', '1'],
            ['台鐵,板橋', '台北捷運,板橋', '1'],
            ['台鐵,六家', '台灣高鐵,新竹', '1'],
            ['台鐵,豐富', '台灣高鐵,苗栗', '1'],
            ['台鐵,新烏日', '台灣高鐵,台中', '1'],
            ['台鐵,沙崙', '台灣高鐵,台南', '1'],
            ['台鐵,新左營', '台灣高鐵,左營', '1'],
            ['台鐵,新左營', '高雄捷運,左營', '1'],
            ['台鐵,高雄', '高雄捷運,高雄車站', '1'],
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
