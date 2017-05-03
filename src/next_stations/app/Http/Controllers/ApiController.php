<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Next_stations\Services\ApiService;
use App\Next_stations\Services\DataFetchService;

class ApiController extends Controller
{

    protected $apiService;
    protected $dataFetchService;

    public function __construct() {
        $this->apiService = new ApiService;
        $this->dataFetchService = new DataFetchService;
    }

    public function build_api_param() {
        /*
        $param = [
            'action' => 'all_routes',
        ];
        $param = [
            'action' => 'stations_in_a_route',
            'route_id' => 2,
        ];
        $param = [
            'action' => 'search_stations',
            'search_string' => '橋',
        ];
        $param = [
            'action' => 'query_station',
            'station_id' => 35,
        ];
         */
        $param = [
            'action' => 'neighbor_stations',
            'station_id' => 35,
        ];
        return json_encode($param);
    }

    public function fetch_data(Request $request) {

        //參數檢查
        $param = json_decode($request->param);
        $check = TRUE;
        if (!$param) {
            $ret = $this->apiService->format_output('400', 'Param Error!');
            $check = FALSE;
        } else {
            $ret = $this->apiService->format_output('200', 'OK');
        }

        //處理資料
        if ($check) {
            $result = $this->dataFetchService->fetch_data($param);
            if ($result === TRUE) {
                $ret = $this->apiService->format_output('200', 'OK');
            } else {
                if (is_array($result)) {
                    if ((isset($result['result']) && isset($result['message']))) {
                        $ret = $this->apiService->format_output($result['result'], $result['message'], $result['body']);
                    } else {
                        $ret = $this->apiService->format_output('500', __FILE__ . __LINE__);
                    }
                } else {
                    $ret = $this->apiService->format_output('500', __FILE__ . __LINE__);
                }
            }

        }

        return $ret;

    }
}
