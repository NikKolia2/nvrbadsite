<?php
class ModelModuleNvrbadsite extends Model
{
    public function getRecordByUrl($url){
        $query = $this->db->query("SELECT url, description FROM ". DB_PREFIX . "nvrbadsite WHERE url='".$url."'");

        return $query->row;
    }
}