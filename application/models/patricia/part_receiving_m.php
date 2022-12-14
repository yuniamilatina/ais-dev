<?php
	/**
	* 
	*/
	class part_receiving_m extends CI_Model
	{
		

	    function get_receiving($date)
	    {
	    	$query = $this->db->query(";WITH CTE_KANBAN (NOROW, CHR_BACK_NO, CHR_RAKNO) AS (
				SELECT ROW_NUMBER() OVER(PARTITION BY CHR_BACK_NO ORDER BY CHR_RAKNO DESC) AS NOROW,
				CHR_BACK_NO, CHR_RAKNO FROM TM_KANBAN GROUP BY  CHR_BACK_NO, CHR_RAKNO
			),
CTE_PART_RECEIVING (CHR_PDS_NUMBER, CHR_LOAD_NUMBER, CHR_BACK_NO , CHR_PART_NO , CHR_RAKNO, CHR_NAMA_PART, CHR_NAMA_VENDOR, CHR_STATUS, INT_QUANTITY, CHR_CREATED_BY,
CHR_CREATED_DATE, CHR_CREATED_TIME) AS (
			
			SELECT 
			a.CHR_PDS_NUMBER, a.CHR_LOAD_NUMBER, b.CHR_BACK_NO, a.CHR_PART_ID , k.CHR_RAKNO, b.CHR_NAMA_PART, b.CHR_NAMA_VENDOR, CHR_STATUS, a.INT_QUANTITY,
			a.CHR_CREATED_BY, a.CHR_CREATED_DATE, LEFT(CHR_CREATED_TIME,4) AS CHR_CREATED_TIME
			
			FROM TM_RECEIVING as a 
			LEFT JOIN TM_STO as b on a.CHR_PART_ID = b.CHR_ID_PART 
			INNER JOIN TT_PDS as c on a.CHR_PDS_NUMBER = c.CHR_PDS_NO AND b.CHR_KODE_VENDOR = c.CHR_SUPPLIER_ID
			LEFT JOIN CTE_KANBAN as k on k.CHR_BACK_NO = b.CHR_BACK_NO
			where NOROW = 1 
			AND 
			a.CHR_CREATED_DATE > (CONVERT([char](10),DATEADD(DAY,  -7, GETDATE()) ,(112)))
				AND a.CHR_PART_ID IN (
'32151540510',
'32151540540',
'32151540560',
'32151540570',
'32151550310',
'32153110620',
'32153110630',
'32153110720',
'32153110790',
'32153110800',
'32153150110',
'32153150460',
'32153150470',
'32153150520',
'32153150570',
'32153153550',
'32153153560',
'32153153570',
'32153153580',
'32153153590',
'32153153600',
'32153153610',
'32153310190',
'32153310220',
'32153310250',
'32153350101',
'32153350171',
'32153350310',
'32153350320',
'32153350460',
'32153350640',
'32153350650',
'32153350660',
'32153350670',
'32159258032',
'32159258080',
'32159430370',
'32159430380',
'32159430420',
'32159430460',
'32159430470',
'32159430480',
'32159430490',
'32159440270',
'32159440330',
'32159450180',
'32159450190',
'32159450200',
'32159460500',
'32159460710',
'32159460720',
'32159460730',
'32159460740',
'32159460750',
'32159460760',
'32159460770',
'32159460780',
'32159470300',
'32159470310',
'32159480240',
'32159480260',
'32159612110',
'32159632230',
'32159640320',
'32159640340',
'32159652020',
'32159672150',
'32151540470',
'32151540610',
'32151530080',
'32151550290',
'32151540450',
'32153350600',
'32153350400',
'32153350350',
'32153350590',
'32151661510',
'32153110850',
'32159652040',
'32151550140',
'32159940320',
'32159940340',
'32151540550',
'32151550330',
'32151544010',
'32151540590',
'32151540580',
'32151648580',
'32153350410',
'32151658570',
'32159248010',
'32153350450',
'32153350050',
'32151648570',
'32153150490',
'32151668810',
'32151940150',
'32151642110',
'32151652320',
'32153150410',
'32153150510',
'32153350270',
'32153350210',
'32151540600',
'32151546030',
'32151662470',
'32153310230',
'32151642210',
'32151652430',
'32153350060',
'32153110740',
'32151940110',
'32153350180',
'32151632210',
'32151648590',
'32151662440',
'32153350220',
'32151652310',
'32151652210',
'32153110810',
'32151668540',
'32151632120',
'32151651920',
'32151662220',
'32151642220',
'32151662210',
'32153350440'
				)
				GROUP BY 
			a.CHR_PDS_NUMBER, a.CHR_LOAD_NUMBER, a.CHR_PART_ID , b.CHR_ID_PART ,
			b.CHR_BACK_NO,
			a.CHR_STATUS ,
			k.CHR_RAKNO,
			SUBSTRING(a.CHR_CREATED_DATE,1,4) ,
			SUBSTRING(a.CHR_CREATED_DATE,5,2) ,
			SUBSTRING(a.CHR_CREATED_DATE,7,2) ,
			SUBSTRING(a.CHR_CREATED_TIME,1,2) ,
			SUBSTRING(a.CHR_CREATED_TIME,3,2) ,
			b.CHR_NAMA_PART, b.CHR_NAMA_VENDOR, a.INT_QUANTITY, 
			a.CHR_CREATED_BY, a.CHR_CREATED_DATE, LEFT(CHR_CREATED_TIME,4) 
)
,
CTE_GROUP_PART_RECEIVING (NOROWK, CHR_STATUS, CHR_PDS_NUMBER, CHR_LOAD_NUMBER, CHR_BACK_NO , CHR_PART_NO , CHR_RAKNO, CHR_NAMA_PART, CHR_NAMA_VENDOR, INT_QUANTITY,
		CHR_CREATED_DATE, CHR_CREATED_TIME) AS (
	SELECT 
		ROW_NUMBER() OVER(PARTITION BY CHR_PDS_NUMBER, CHR_LOAD_NUMBER, CHR_BACK_NO , CHR_PART_NO , CHR_RAKNO, CHR_NAMA_PART, CHR_NAMA_VENDOR, INT_QUANTITY
		ORDER BY CHR_STATUS, CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC) AS NOROWK,
		CHR_STATUS, CHR_PDS_NUMBER, CHR_LOAD_NUMBER, CHR_BACK_NO , CHR_PART_NO , CHR_RAKNO, CHR_NAMA_PART, CHR_NAMA_VENDOR, INT_QUANTITY,
		CHR_CREATED_DATE, CHR_CREATED_TIME
	FROM CTE_PART_RECEIVING
)

SELECT CHR_PDS_NUMBER, CHR_LOAD_NUMBER, CHR_BACK_NO , CHR_PART_NO , CHR_RAKNO, CHR_NAMA_PART, CHR_NAMA_VENDOR, INT_QUANTITY,
		CHR_CREATED_DATE, CHR_CREATED_TIME,
		CASE 
			WHEN
			DATEADD(HOUR, 24, CONVERT(DATETIME,
				SUBSTRING(CHR_CREATED_DATE,1,4) + '-' +
				SUBSTRING(CHR_CREATED_DATE,5,2) + '-' +
				SUBSTRING(CHR_CREATED_DATE,7,2) + ' ' +
				SUBSTRING(CHR_CREATED_TIME,1,2) + ':' +
				SUBSTRING(CHR_CREATED_TIME,3,2) + ':' + '00' + '.000'
			)) > GETDATE() 
			THEN CHR_STATUS 
			WHEN CHR_STATUS <> 'Unchecked' THEN CHR_STATUS
			ELSE 'Unchecked'
		END AS CHR_STATUS
FROM CTE_GROUP_PART_RECEIVING WHERE NOROWK = 1 
ORDER BY CHR_CREATED_DATE DESC, CHR_CREATED_TIME DESC");
	        return $query->result();
		}
		
	    function update($id,$status)
	    {
	    	$this->db->where('INT_RECEIVING_ID', $id);
	        $this->db->update('TM_RECEIVING', $status);
		}

		function update_load($id, $data)
	    {
	    	$this->db->where('CHR_PDS_NUMBER', $id['CHR_PDS_NUMBER']);
	    	$this->db->where('CHR_PART_ID', $id['CHR_PART_NO']);
	        $this->db->update('TM_RECEIVING', $data);
		}
	    
	}
?>