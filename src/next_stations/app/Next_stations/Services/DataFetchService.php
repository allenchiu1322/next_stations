<?php
namespace App\Next_stations\Services;

use App\Next_stations\Repositories\AdminRepository;
use App\Next_stations\Repositories\RouteRepository;
use App\Next_stations\Repositories\StationRepository;
use App\Next_stations\Repositories\SequenceRepository;

class DataFetchService {

    protected $adminRepository;
    protected $routeRepository;
    protected $stationRepository;
    protected $sequenceRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository;
        $this->routeRepository = new RouteRepository;
        $this->stationRepository = new StationRepository;
        $this->sequenceRepository = new SequenceRepository;
    }

    public function fetch_data($param) {
        $check = TRUE;

        //檢查參數
        if ($check) {
            if (!in_array($param->action, array('all_routes',
                'stations_in_a_route', 'search_stations',
                'query_station'))) {
                $check = FALSE;
                $message = 'action ERROR';
            }
        }

        //查路線上所有車站需要帶入路線ID
        if ($param->action == 'stations_in_a_route') {
            if (!isset($param->route_id) || !is_numeric($param->route_id)) {
                $check = FALSE;
                $message = 'param ERROR';
            }
            if (isset($param->direction) && ($param->direction == '2')) {
                $direction = '2';
            } else {
                $direction = '1';
            }
        }

        //查車站需要有搜尋參數
        if ($param->action == 'search_stations') {
            if (!isset($param->search_string) || ($param->search_string == '')) {
                $check = FALSE;
                $message = 'param ERROR';
            }
        }

        //查車站資訊需要有車站ID
        if ($param->action == 'query_station') {
            if (!isset($param->station_id) || !is_numeric($param->station_id)) {
                $check = FALSE;
                $message = 'param ERROR';
            }
        }

        //執行操作
        if ($check) {
            if ($param->action == 'all_routes') {
                $admins = $this->adminRepository->all_admins();
                $routes = $this->routeRepository->all_routes();
                $body = [
                    'admins' => $admins,
                    'routes' => $routes,
                ];
                $message = 'OK';
            } else if ($param->action == 'stations_in_a_route') {
                $stations = $this->sequenceRepository->all_stations_in_a_route($param->route_id, $direction);
                $body = [
                    'stations' => $stations,
                ];
                $message = 'OK';
            } else if ($param->action == 'search_stations') {
                $stations = $this->stationRepository->search_stations($param->search_string);
                $body = [
                    'stations' => $stations,
                ];
                $message = 'OK';
            } else if ($param->action == 'query_station') {
                $station = $this->stationRepository->query_station($param->station_id);
                $body = [
                    'station' => $station,
                ];
                $message = 'OK';
            }
        }

        if ($check) {
            if (isset($body)) {
                return array('result' => '200', 'message' => $message, 'body' => $body);
            } else {
                return TRUE;
            }
        } else {
            return array('result' => '403', 'message' => $message);
        }

    }

}
