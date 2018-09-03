<?php

require_once('settlement.inc.php');

function wager_update($sql, $id){
	$lower = strtolower($sql);
	$lower = str_replace(' ','', $lower);
	$lower = str_replace("'",'', $lower);
	if('updateweb_db_ioset' != substr($lower,0,18)) return;

	if(strpos($lower, 'result_type=0')) {/*
		$result = mysql_query( "select m_name,result_type,pay_type,betscore,m_result from web_db_io where id='$id'" );
		$row = mysql_fetch_array( $result );
		if($row['result_type']==1 and $row['pay_type']==1){
			$aa=$row['betscore']+$row['m_result'];
			mysql_query("update web_members set money=money-$aa where m_name='$row[m_name]'");
		}*/
		settlement_cancel($id);
	}
	
	return mysql_query($sql);
}

?>