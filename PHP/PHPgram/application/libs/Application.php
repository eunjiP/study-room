<?php
namespace application\libs;
// inclued할 경우 라이브러리에 받아 놓으면 다른 파일에 하지 않아도 됨
require_once "application/utils/UrlUtils.php";
require_once "application/utils/SessionUtils.php";

class Application{
    
    public $controller;
    public $action;
    private static $modelList = [];

    public function __construct() {        
        $urlPaths = getUrlPaths();
        $controller = isset($urlPaths[0]) && $urlPaths[0] != '' ? $urlPaths[0] : 'board';
        $action = isset($urlPaths[1]) && $urlPaths[1] != '' ? $urlPaths[1] : 'index';

        if (!file_exists('application/controllers/'. $controller .'Controller.php')) {
            echo "해당 컨트롤러가 존재하지 않습니다.";
            exit();
        }

        if(!in_array($controller, static::$modelList)) {
            $modelName = 'application\models\\' . $controller . 'model';
            static::$modelList[$controller] = new $modelName();
        }

        $controllerName = 'application\controllers\\' . $controller . 'controller';                
        $model = static::$modelList[$controller];
        new $controllerName($action, $model);
    }
}