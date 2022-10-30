<?php
	/**
	* 
	*/
	class part_chart_m extends CI_Model
	{
		

	    function get_spek($partno)
	    {
	    	$query = $this->db->query("SELECT a.INT_SPECIFICATION_ID,a.CHR_SPECIFICATION from TM_SPECIFICATION as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART where b.CHR_ID_PART = '".$partno."' group by a.INT_SPECIFICATION_ID,a.CHR_SPECIFICATION ");
	        return $query->result();
		}

		function get_param($partno)
	    {
	    	$query = $this->db->query("SELECT distinct a.CHR_ID_PARAM,b.CHR_PARAMETER from PRD.TT_HASIL_UKUR_PART_L as a join PRD.TM_PARAMETER_CEK_PART as b on a.CHR_ID_PARAM = b.CHR_ID_PARAM where a.CHR_PARTNO = '".$partno."'");
	        return $query->result();
		}
		
		function get_top_spec_by_partno_comp($partno){
			$query = $this->db->query("SELECT TOP 1 a.INT_SPECIFICATION_ID,a.CHR_SPECIFICATION from TM_SPECIFICATION as a join TM_STO as b on a.CHR_COMPONENT_ID = b.CHR_ID_PART where b.CHR_ID_PART = '".$partno."' group by a.INT_SPECIFICATION_ID,a.CHR_SPECIFICATION ");
	        return $query->result();
		}

	    function get_spek_name($id)
	    {
	    	$query = $this->db->query("SELECT a.CHR_SPECIFICATION from TM_SPECIFICATION as a where a.INT_SPECIFICATION_ID = ".$id."")->row();
	        return $query;
		}
		function get_param_name($id)
	    {
	    	$query = $this->db->query("SELECT CHR_PARAMETER from PRD.TM_PARAMETER_CEK_PART where CHR_ID_PARAM = ".$id."")->row();
	        return $query;
	    }
	    
	    function get_component()
	    {
	    	$query = $this->db->query("SELECT CHR_ID_PART,CHR_BACK_NO FROM TM_STO 
				WHERE CHR_ID_PART IN (
						'32153110620',
						'32153110630',
						'32153150110',
						'32159440270',
						'32159460500',
						'32159470300',
						'32159470310',
						'32159480240',
						'32159460770',
						'32159440330',
						'32159430420',
						'32159460750',
						'32159460720',
						'32159460740',
						'32159430460',
						'32159450180',
						'32159460730',
						'32159450200',
						'32159430370',
						'32159430470',
						'32159460760',
						'32159430480',
						'32159450190',
						'32159460780',
						'32159430490',
						'32159460710',
						'32153150570',
						'32153153560',
						'32153153550',
						'32153153570',
						'32153153580',
						'32153153600',
						'32153153610',
						'32153150520',
						'32153153590',
						'32159430380',
						'32159470310',
						'32159480240',
						'32159440270',
						'32159460500',
						'32159470300',
						'32159430420',
						'32159460770',
						'32159480260',
						'32159440330',
						'32153150110',
						'32153150460',
						'32153150470',
						'32153110620',
						'32153110630',
						'32159430380',
						'32159480240',
						'32159440270',
						'32153150110',
						'32153110620',
						'32153110800',
						'32153110720',
						'32153110790',
						'32153310250',
						'32153350460',
						'32153350101',
						'32153350171',
						'32153310190',
						'32153350660',
						'32153350670',
						'32153350640',
						'32153350650',
						'32153310220',
						'32153350310',
						'32153350320',
						'32159612110',
						'32159652020',
						'32159632230',
						'32159672150',
						'32159640320',
						'32159640340',
						'32151540540',
						'32151540570',
						'32151550310',
						'32151540510',
						'32151540560',
						'32159460740',
						'32159460730',
						'32159430470',
						'32159460710',
						'32153150570',
						'32153153570',
						'32153153580',
						'32159258032',
						'32159258080'
						)
				group by CHR_ID_PART,CHR_BACK_NO");
       		return $query->result();
	    }
	    
		
		function get_part_inline()
	    {
	    	$query = $this->db->query("SELECT A.CHR_PART_NO AS CHR_ID_PART, B.CHR_BACK_NO 
				FROM TM_PARTS A 
				LEFT JOIN TM_KANBAN B ON A.CHR_PART_NO = B.CHR_PART_NO
				WHERE A.CHR_PART_NO IN (SELECT DISTINCT CHR_PARTNO FROM PRD.TT_HASIL_UKUR_PART_L)
					AND B.CHR_KANBAN_TYPE IN ('5','6')
				group by A.CHR_PART_NO, B.CHR_BACK_NO");
       		return $query->result();
		}
		
		function get_spek_inline($partno)
	    {
	    	$query = $this->db->query("SELECT CHR_POS_L_SUB, CHR_POS_W_SUB, CHR_POS_L_DISC, CHR_POS_W_DISC from TW_CEK_PRODUCT where CHR_PART_ID = '".$partno."'");
	        return $query->result();
		}

		function get_prod_order($partno, $spek)
	    {
			if($spek == 'W_SUB'){
				$query = $this->db->query("SELECT DISTINCT CHR_PRD_ORDER_NO from TW_CEK_PRODUCT where CHR_PART_ID = '".$partno."' AND CHR_POS_W_SUB IS NOT NULL");
			} else if($spek == 'L_SUB'){
				$query = $this->db->query("SELECT DISTINCT CHR_PRD_ORDER_NO from TW_CEK_PRODUCT where CHR_PART_ID = '".$partno."' AND CHR_POS_L_SUB IS NOT NULL");
			} else if($spek == 'W_DIS'){
				$query = $this->db->query("SELECT DISTINCT CHR_PRD_ORDER_NO from TW_CEK_PRODUCT where CHR_PART_ID = '".$partno."' AND CHR_POS_W_DISC IS NOT NULL");
			} else if($spek == 'L_DIS'){
				$query = $this->db->query("SELECT DISTINCT CHR_PRD_ORDER_NO from TW_CEK_PRODUCT where CHR_PART_ID = '".$partno."' AND CHR_POS_L_DISC IS NOT NULL");
			}
	        return $query->result();
		}

		function get_data($part,$spek)
	    {
	    	$query = $this->db->query("SELECT top 30 a.CHR_COMPONENT_ID, b.DEC_NILAI
					from TT_CHECK_SHEET as a join TT_DETAIL_CHECKSHEET as b on b.INT_ID_CHECKSHEET= a.INT_CHECKSHEET_ID 
					join TM_SPECIFICATION as c on c.CHR_COMPONENT_ID= a.CHR_COMPONENT_ID
					where a.CHR_COMPONENT_ID= '".$part."' and b.INT_SPECIFICATION_ID = ".$spek."
					group by b.INT_ID_CHECKSHEET,a.CHR_COMPONENT_ID, b.DEC_NILAI,a.CHR_CREATED_DATE
					order by a.CHR_CREATED_DATE desc");
	        if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return $this->db->query("SELECT 0 CHR_COMPONENT_ID, 0 DEC_NILAI")->result();
	        }
	    }

		function get_data_inline($part, $spek,$date_from,$date_to)
	    {			
			// $query = $this->db->query("SELECT CHR_PARTNO as CHR_PART_ID, max(CHR_HASIL_UKUR) as MAX_NILAI,MIN(CHR_HASIL_UKUR) as MIN_NILAI, CHR_DATE_CREATE
			// 							from PRD.TT_HASIL_UKUR_PART_L
			// 							where CHR_PARTNO= '".$part."' and CHR_ID_PARAM= '".$spek."' AND CHR_HASIL_UKUR IS NOT NULL and (CHR_DATE_CREATE BETWEEN '$date_from' AND '$date_to')
			// 							group by CHR_PARTNO,CHR_DATE_CREATE
			// 							order by CHR_DATE_CREATE asc");
					$query = $this->db->query("SELECT CHR_PARTNO as CHR_PART_ID, CHR_HASIL_UKUR as DEC_NILAI, CHR_DATE_CREATE
					from PRD.TT_HASIL_UKUR_PART_L
					where CHR_PARTNO= '".$part."' and CHR_ID_PARAM= '".$spek."' AND CHR_HASIL_UKUR IS NOT NULL and (CHR_DATE_CREATE between '$date_from' and '$date_to')
					order by CHR_DATE_CREATE, CHR_TIME_CREATE desc");
				
	        if ($query->num_rows() > 0) {
	            return $query->result();
	        } else {
	            return $this->db->query("SELECT 0 CHR_PART_ID, 0 DEC_NILAI")->result();
	        }
		}

		function get_margin($part,$spek)
	    {
	    	$query = $this->db->query("SELECT a.DEC_STD,a.DEC_TOLERANSI_MIN,a.DEC_TOLERANSI_MAX,(Cast(a.DEC_STD_MIN as DECIMAL(6, 2))) as DEC_STD_MIN,(Cast(a.DEC_STD_MAX as DECIMAL(6, 2))) as DEC_STD_MAX,a.CHR_SPECIFICATION from TM_SPECIFICATION as a where a.CHR_COMPONENT_ID= '".$part."' and a.INT_SPECIFICATION_ID = ".$spek."");
	        if($query->num_rows() > 0){
				return $query->row();
			}else{
				return $this->db->query("SELECT 0 DEC_STD, 0 DEC_TOLERANSI_MIN, 0 DEC_TOLERANSI_MAX")->row();
			}
		}

		function get_data_max($part, $spek,$date_from,$date_to){
			$query = $this->db->query("select max(CHR_HASIL_UKUR) as max from PRD.TT_HASIL_UKUR_PART_L where CHR_PARTNO= '".$part."' and CHR_ID_PARAM= '".$spek."' AND CHR_HASIL_UKUR IS NOT NULL 
										and CHR_DATE_CREATE between '$date_from' and '$date_to'");
			return $query->row();
		}

		function get_data_min($part, $spek,$date_from,$date_to){
			$query = $this->db->query("select min(CHR_HASIL_UKUR) as min from PRD.TT_HASIL_UKUR_PART_L where CHR_PARTNO= '".$part."' and CHR_ID_PARAM= '".$spek."' AND CHR_HASIL_UKUR IS NOT NULL 
										and CHR_DATE_CREATE between '$date_from' and '$date_to'");
			return $query->row();
		}
		
		function get_margin_inline($part, $spek)
	    {
			
				$query = $this->db->query("SELECT TOP 1 b.CHR_STD_MIN as DEC_TOLERANSI_MIN, b.CHR_STD_MAX as DEC_TOLERANSI_MAX,(Cast(b.CHR_STD_MIN as DECIMAL(6, 2))) as DEC_STD_MIN,(Cast(b.CHR_STD_MAX as DECIMAL(6, 2))) as DEC_STD_MAX FROM PRD.TT_HASIL_UKUR_PART_L a 
											inner join PRD.TM_DATA_UKUR_PART b on a.CHR_PARTNO=b.CHR_PARTNO 
											inner join PRD.TM_DATA_SPEC_PART c on c.CHR_ID_SPEC=b.CHR_ID_SPEC 
											inner join PRD.TM_PARAMETER_CEK_PART d on d.CHR_ID_PARAM=c.CHR_ID_PARAM
											WHERE a.CHR_PARTNO= '".$part."' and d.CHR_ID_PARAM='".$spek."'");
			
			// $query_cek = $this->db->query("SELECT TOP 1 CHR_PARTNO
			// 		from PRD.TT_HASIL_UKUR_PART
			// 		where CHR_PARTNO= '".$part."'");
	    	
	        if($query->num_rows() > 0){
				return $query->row();
			}else{
				return $this->db->query("SELECT 0 DEC_TOLERANSI_MIN, 0 DEC_TOLERANSI_MAX")->row();
			}
		}

		function get_prod_no_exist($part, $spek){
			// if($spek == 'W_SUB'){
			// 	$query = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO
			// 	from TW_CEK_PRODUCT
			// 	where CHR_PART_ID= '".$part."' AND CHR_POS_W_SUB IS NOT NULL
			// 	order by CHR_DATE, CHR_TIME desc");
			// } else if($spek == 'L_SUB'){
			// 	$query = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO
			// 	from TW_CEK_PRODUCT
			// 	where CHR_PART_ID= '".$part."' AND CHR_POS_L_SUB IS NOT NULL
			// 	order by CHR_DATE, CHR_TIME desc");
			// } else if($spek == 'W_DIS'){
			// 	$query = $this->db->query("SELECT TOP 1 CHR_PRD_ORDER_NO
			// 	from TW_CEK_PRODUCT
			// 	where CHR_PART_ID= '".$part."' AND CHR_POS_W_DISC IS NOT NULL
			// 	order by CHR_DATE, CHR_TIME desc");
			// } else if($spek == 'L_DIS'){
				$query = $this->db->query("SELECT TOP 1 CHR_PRD_NO
				from PRD.TT_HASIL_UKUR_PART_L
				where CHR_PARTNO= '".$part."' AND CHR_ID_PARAM='".$spek."'
				order by CHR_DATE_CREATE, CHR_TIME_CREATE desc");
			// }

			$query_cek = $this->db->query("SELECT TOP 1 CHR_PARTNO
					from PRD.TT_HASIL_UKUR_PART_L
					where CHR_PARTNO= '".$part."'");

			if($query_cek->num_rows() > 0){
				return $query->row();
			}else{
				return $this->db->query("SELECT '-' CHR_PRD_NO")->row();
			}
		}
	    
	}
?>