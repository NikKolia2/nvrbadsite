<?php
class ModelModuleNvrbadsite extends Model
{
    public function insert($data){
        foreach ($data['nvrbadsite_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "nvrbadsite SET  language_id = '" . (int)$language_id . "', url = '" . $this->db->escape($value['url']) . "', description = '" . $this->db->escape($value['description']) . "'");
		}
    }

    public function update($id, $data){
    
        foreach ($data['nvrbadsite_description'] as $language_id => $value) {
			$this->db->query("UPDATE " . DB_PREFIX . "nvrbadsite SET  language_id = '" . (int)$language_id . "', url = '" . $this->db->escape($value['url']) . "', description = '" . $this->db->escape($value['description']) . "' WHERE id = '".(int)$id."'");
		}
    }

    public function getRecords($data){
       
        $language_id = $this->config->get('config_language_id');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nvrbadsite WHERE language_id = '" . (int)$language_id . "'");
		
        return $query->rows;
    }

    public function getRecord($id){

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "nvrbadsite WHERE id = '" . (int)$id . "'");
		
        $record_data = [];
        foreach ($query->rows as $result) {
			$record_data[$result['language_id']] = array(
				'url' =>  $result["url"],
				'description'      => $result['description'],
				'id'     => $result['id'],
			);
		}

        return $record_data;
    }

    public function getRecordByUrl($url){
        $query = $this->db->query("SELECT url, description FROM ". DB_PREFIX . "nvrbadsite WHERE url='".$url."'");

        return $query->row;
    }
    
    public function deleteRecord($id){
       
        $this->db->query("DELETE FROM " . DB_PREFIX . "nvrbadsite WHERE id = '" . (int)$id . "'");
        $this->cache->delete('nvrbadsite');
    }

    public function getTotalRecords($data = array())
	{
		$sql = "SELECT COUNT(DISTINCT id) AS total FROM " . DB_PREFIX . "nvrbadsite";

		$sql .= " WHERE language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

}