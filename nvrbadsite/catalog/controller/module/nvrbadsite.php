<?php
class ControllerModuleNvrbadsite extends Controller {

    public function index() {   
        ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
        $this->language->load('module/nvrbadsite');
        $this->load->model('module/nvrbadsite');

        $url = $this->request->get['url'];
        if(preg_match_all("/((?:[a-z][a-z\\.\\d\\-]+)\\.(?:[a-z][a-z\\-]+))(?![\\w\\.])/", $url, $result, PREG_PATTERN_ORDER)){
            $record = $this->model_module_nvrbadsite->getRecordByUrl($result[0][0]);
        }else {
            echo "";
        }

        echo json_encode($record);
		
    }
}