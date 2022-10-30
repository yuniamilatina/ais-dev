<?php
	/**
	* 
	*/
	class progress_m extends CI_Model
	{
		private $tabel = 'dbo.TW_PART_INHOUSE';
		private $tabel1 = 'dbo.TM_PART_INHOUSE';
		
	    function get_technical() {
	        $query = $this->db->query("SELECT a.CHR_TM_NUMBER , a.CHR_PART_NAME, 
				a.CHR_MODEL, a.CHR_MAT, a.INT_QTY, a.CHR_PROJECT_NAME,
				CHR_PROG_RM, 
				CHR_PROG_MC1,
				CHR_PROG_MC2,
				CHR_PROG_HT,
				CHR_PROG_SG,
				CHR_PROG_WC,
				CHR_PROG_QC,
				CHR_PROG_FIN,
				CHR_START_MC1,
				b.CHR_STATUS_MC1 AS CHR_FINISH_MC1,
				b.CHR_START_SG AS CHR_START_SG,
				b.CHR_STATUS_SG AS CHR_FINISH_SG,
				b.CHR_START_WC AS CHR_START_WC,
				b.CHR_STATUS_WC AS CHR_FINISH_WC,
				b.CHR_START_MC2 AS CHR_START_MC2,
				b.CHR_STATUS_MC2 AS CHR_FINISH_MC2,
				b.CHR_REPAIR,
				b.CHR_STATUS_RM AS CHR_STATUS_RM,
				b.CHR_STATUS_MC1 AS CHR_STATUS_MC1,
				b.CHR_STATUS_HT AS CHR_STATUS_HT,
				b.CHR_STATUS_SG AS CHR_STATUS_SG,
				b.CHR_STATUS_WC AS CHR_STATUS_WC,
				b.CHR_STATUS_MC2 AS CHR_STATUS_MC2,
				b.CHR_STATUS_QC AS CHR_STATUS_QC,
				b.CHR_STATUS_FIN AS CHR_STATUS_FIN,

				DATEDIFF(hour, b.CHR_START_MC1, b.CHR_STATUS_MC1)
				 AS CHR_JAM_MC1, 
				 DATEDIFF(minute, b.CHR_START_MC1, b.CHR_STATUS_MC1) % 60
				 AS CHR_MENIT_MC1,

				DATEDIFF(hour, b.CHR_START_SG, b.CHR_STATUS_SG)
				 AS CHR_JAM_SG, 
				 DATEDIFF(minute, b.CHR_START_SG, b.CHR_STATUS_SG) % 60
				 AS CHR_MENIT_SG,

				DATEDIFF(hour, b.CHR_START_WC, b.CHR_STATUS_WC)
				 AS CHR_JAM_WC, 
				 DATEDIFF(minute, b.CHR_START_WC, b.CHR_STATUS_WC) % 60
				 AS CHR_MENIT_WC,

				DATEDIFF(hour, b.CHR_START_MC2, b.CHR_STATUS_MC2)
				 AS CHR_JAM_MC2, 
				 DATEDIFF(minute, b.CHR_START_MC2, b.CHR_STATUS_MC2) % 60
				 AS CHR_MENIT_MC2,

				--TOTAL DURATION JAM--
				DATEDIFF(hour, b.CHR_START_MC1, b.CHR_STATUS_MC1) + DATEDIFF(hour, b.CHR_START_SG, b.CHR_STATUS_SG) + DATEDIFF(hour, b.CHR_START_WC, b.CHR_STATUS_WC) + DATEDIFF(hour, b.CHR_START_MC2, b.CHR_STATUS_MC2) AS TOTAL_DURATION_JAM,

				--TOTAL DURATION MENIT--
				(DATEDIFF(minute, b.CHR_START_MC1, b.CHR_STATUS_MC1) + DATEDIFF(minute, b.CHR_START_SG, b.CHR_STATUS_SG) + DATEDIFF(minute, b.CHR_START_WC, b.CHR_STATUS_WC) + DATEDIFF(minute, b.CHR_START_MC2, b.CHR_STATUS_MC2)) % 60 AS TOTAL_DURATION_MENIT

				FROM dbo.TM_PART_INHOUSE a INNER JOIN dbo.TT_PROGRESS_PART_INHOUSE b ON a.CHR_TM_NUMBER = b.CHR_TM_NUMBER AND a.INT_FLG_DEL = 0 AND b.INT_FLG_DEL= 0 AND
				SUBSTRING(a.CHR_TM_NUMBER,9,2) = b.CHR_PROJECT AND b.CHR_PROJECT_NAME = b.CHR_PROJECT_NAME
				AND
				b.CHR_PROJECT != ''
				AND REPLACE(a.CHR_PROJECT_NAME,' ','') = REPLACE(b.CHR_PROJECT_NAME,' ','')
				AND b.CHR_PROJECT_NAME != '' "); 
	        return $query->result();
		} 
		
         function getDropdown(){
            $query = $this->db->query("SELECT DISTINCT CHR_PROJECT_NAME from TM_PART_INHOUSE where INT_FLG_DEL = 0");
            return $query->result();
        }
        function get_dashboard($data1, $data2) {
	        $query = $this->db->query("UPDATE TT_PROGRESS_PART_INHOUSE set CHR_PROJECT ='$data1' where SUBSTRING(CHR_TM_NUMBER,9,2) = '$data1'");
            $query = $this->db->query("UPDATE TT_PROGRESS_PART_INHOUSE set CHR_PROJECT ='' where SUBSTRING(CHR_TM_NUMBER,9,2) <> '$data1'");
            $query = $this->db->query("UPDATE TT_PROGRESS_PART_INHOUSE set CHR_PROJECT_NAME ='$data2' where SUBSTRING(CHR_TM_NUMBER,9,2) = '$data1'");
            $query = $this->db->query("UPDATE TT_PROGRESS_PART_INHOUSE set CHR_PROJECT_NAME ='' where SUBSTRING(CHR_TM_NUMBER,9,2) <> '$data1'");
	    }	    
        function get_duration(){
            $query = $this->db->query("SELECT CHR_TM_NUMBER, INT_FLG_DEL, CHR_STATUS_MC1 AS FIN_MC1, CHR_STATUS_SG AS FIN_SG, CHR_STATUS_WC AS FIN_WC, CHR_STATUS_MC2 AS FIN_MC2,
            CHR_START_MC1,
            CHR_START_SG,
            CHR_START_WC,
            CHR_START_MC2,
            CHR_STATUS_MC1,
            CHR_STATUS_SG,
            CHR_STATUS_WC,
            CHR_STATUS_MC2,
            CASE WHEN DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) / 60 < 0 THEN 0
				 ELSE DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) / 60
                 END AS CHR_JAM_MC1, 
            CASE WHEN DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) % 60 < 0 THEN 0
				 ELSE DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) % 60
                 END AS CHR_MENIT_MC1,
            CASE  WHEN DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) / 60 < 0 THEN 0
				 ELSE DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) / 60
                 END AS CHR_JAM_SG, 
            CASE WHEN DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) % 60 < 0 THEN 0
                ELSE DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) % 60
				 END AS CHR_MENIT_SG,
            CASE WHEN DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) / 60 < 0 THEN 0
                ELSE DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) / 60
				 END AS CHR_JAM_WC, 
            CASE WHEN DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) % 60 < 0 THEN 0
				 ELSE  DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) % 60
                 END AS CHR_MENIT_WC,
            CASE WHEN DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) / 60 < 0 THEN 0
				 ELSE DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) / 60 
                 END AS CHR_JAM_MC2, 
            CASE WHEN DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) % 60 < 0 THEN 0
                ELSE DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) % 60 
				END AS CHR_MENIT_MC2,
            (CASE WHEN DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) END 
            + CASE WHEN DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) < 0 THEN 0 ELSE  DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) END 
            + CASE WHEN DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) END 
            + CASE WHEN DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) END) / 60 AS TOTAL_JAM,
            (CASE WHEN DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_MC1, CHR_STATUS_MC1) END
            + CASE WHEN DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_SG, CHR_STATUS_SG) END
            + CASE WHEN DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_WC, CHR_STATUS_WC) END
            + CASE WHEN DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) < 0 THEN 0 ELSE DATEDIFF(minute, CHR_START_MC2, CHR_STATUS_MC2) END) % 60 AS TOTAL_MENIT
                from TW_PART_INHOUSE WHERE INT_FLG_DEL = 0 ");
            return $query->result();
        }
         function update($data, $id) {
            
	        $this->db->where('CHR_TM_NUMBER', $id);
	        $this->db->update($this->tabel, $data);
	    }
         function getDrop($project){
            $query = $this->db->query("SELECT DISTINCT CHR_PROJECT_NAME from ".$this->tabel1." where INT_FLG_DEL = 0 AND SUBSTRING(CHR_TM_NUMBER,9,2) ='$project' ");
            return $query->result();
        }

	}
?>