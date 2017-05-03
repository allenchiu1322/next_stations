<?php
namespace App\Next_stations\Services;

use App\Next_stations\Repositories\AdminRepository;
use App\Next_stations\Repositories\RouteRepository;
use App\Next_stations\Repositories\StationRepository;

class DataFetchService {

    protected $adminRepository;
    protected $routeRepository;
    protected $stationRepository;

    public function __construct() {
        $this->adminRepository = new AdminRepository;
        $this->routeRepository = new RouteRepository;
        $this->stationRepository = new StationRepository;
    }

    public function fetch_data($param) {
        $check = TRUE;

        //檢查參數
        if ($check) {
            if (!in_array($param->action, array('all_routes'))) {
                $check = FALSE;
                $message = 'action ERROR';
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
