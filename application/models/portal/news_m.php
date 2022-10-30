<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class news_m extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private $tbl_name = "TT_PORTAL_NEWS";
    
    function get_news() {
       $query = $this->db->query("SELECT INT_ID_NEWS, CHR_NEWS_TITLE, CHR_URL_IMAGE, CHR_NEWS_DESC, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME  FROM TT_PORTAL_NEWS
                                    WHERE CHR_FLG_DEL = 0
                                    ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME DESC ");
        	
        return $query->result();
    }
    
    function get_top_news(){
        $query = $this->db->query("SELECT TOP 1 INT_ID_NEWS, CHR_NEWS_TITLE, CHR_URL_IMAGE, CHR_NEWS_DESC, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME  FROM TT_PORTAL_NEWS
                                    WHERE CHR_FLG_DEL = 0
                                    ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME DESC ");
        	
        return $query->result();
    }
    
    function get_by_id($id) {
        $query = $this->db->query("SELECT INT_ID_NEWS, CHR_NEWS_TITLE, CHR_URL_IMAGE, CHR_NEWS_DESC, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME  FROM TT_PORTAL_NEWS
                                    WHERE CHR_FLG_DEL = 0 AND INT_ID_NEWS = '$id' 
                                    ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME DESC ");
        return $query->result();
    }
    
    public function find($select='',$where='',$order='',$limit='',$start='0',$group='',$join=''){
                $db_1 = $this->load->database();
            
		if(!empty($select)) $this->db->select($select,false);
		if(!empty($where)) $this->db->where($where);
		if(!empty($order)) $this->db->order_by($order);
		if(!empty($limit)) $this->db->limit($limit,$start);
		if(!empty($group)) $this->db->group_by($group);
		
  
		if(!empty($join)&&is_array($join)){
			if(!empty($join['table']) && !empty($join['on'])) {
				$join = array($join);
			}
			
			foreach($join as $item){
				if(!empty($item['table']) && !empty($item['on'])) {
					if(!empty($item['pos'])){
						$this->db->join($item['table'],$item['on'],$item['pos']);
					}else{
						$this->db->join($item['table'],$item['on']);
					}
				}
			}
		}
		
		return $this->db->get($this->tbl_name)->result();
	}
        
    function add($data) {
        if (is_array($data)) {
            return $this->db->insert($this->tbl_name, $data);
        }

        return false;
    }
    
    function save($data) {
        $this->db->insert($this->tbl_name, $data);
    }

    function get_data($id) {
        $hasil = $this->db->query("SELECT INT_ID_NEWS, CHR_NEWS_TITLE, CHR_NEWS_DESC, CHR_URL_IMAGE, CHR_CREATED_BY, CHR_CREATED_DATE, CHR_CREATED_TIME  FROM TT_PORTAL_NEWS
                                    WHERE CHR_FLG_DEL = 0 AND INT_ID_NEWS = '$id'
                                    ORDER BY CHR_CREATED_DATE, CHR_CREATED_TIME DESC ");

        return $hasil;
    }

    function get_data_news($npk) {
        $query = $this->db->query(" SELECT U.CHR_NPK, U.CHR_REGIS_DATE, U.CHR_USERNAME, R.CHR_ROLE, U.INT_ID_ROLE
                                    FROM  TM_USER  U 
                                    INNER JOIN TM_ROLE R ON R.INT_ID_ROLE = U.INT_ID_ROLE   
                                    WHERE U.CHR_NPK = '$npk'");
        return $query;
    }

    function delete($id) {
        $data = array('CHR_FLG_DEL' => 1);

        $this->db->where('INT_ID_NEWS', $id);
        $this->db->update($this->tbl_name, $data);
    }

    function update($data, $id) {
        $this->db->where('INT_ID_NEWS', $id);
        $this->db->update($this->tbl_name, $data);
    }

        
}

?>
