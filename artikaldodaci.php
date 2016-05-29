<?php
 
/*
 * Artikli:
 */
 
// array for JSON response
$response = array();
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
// get all products from products table
$id=$_REQUEST['id'];
//prvo trazimo sve grupe dodataka vezane za ovaj artikal
$result = mysql_query("SELECT ad.dodatakgrupa_id as dg_id, dg.tip as dg_tip, dg.naziv as dg_naziv " .
	" from artikaldodatakgrupa ad " .
    " inner join dodatakgrupa dg on (ad.dodatakgrupa_id = dg.dodatakgrupa_id) " .
    " where ad.artikal_id = '$id';") or die(mysql_error());
 
// check for empty result


if (mysql_num_rows($result) > 0) 
{
    $response["zahtjevi"] = array();
	
	
    while ($row = mysql_fetch_array($result)) 
	{
        $grupa= array(
          'dg_id'=>$row['dg_id'],
		  'dg_tip'=>$row['dg_tip'],
		  'dg_naziv'=>$row['dg_naziv'],
         );
		 
		$grupa_id=$row['dg_id']; 
		 
		//za svaku grupu dodataka, trazimo konkretne zahtjeve
		$result2 = mysql_query("SELECT dgs.defaultradio, d.dodatak_id, d.naziv as dodatak_naziv " .
          " from dodatakgrupastavka dgs " .
          " inner join dodatak d on (dgs.dodatak_id = d.dodatak_id) " .
          " where dgs.dodatakgrupa_id = '$grupa_id';") or die(mysql_error());		
		   
		
		$grupa['opcije'] = array();
		
		while ($row2 = mysql_fetch_array($result2)) 
		{				
			array_push($grupa['opcije'], 			
				array(			
						'dodatak_id'=>$row2['dodatak_id'],
						'dodatak_naziv'=>$row2['dodatak_naziv'],
						'defaultradio'=>$row2['defaultradio'],
				)			
			);	
		}
		 
        array_push($response["zahtjevi"], $grupa);
    }
    // success
    //$response["success"] = 1;
    echo json_encode($response);

} 
else 
{
    // no products found
    //$response["success"] = 0;
    //$response["message"] = "No groups found";
 
    // echo no users JSON
    echo json_encode($response);
}
?>