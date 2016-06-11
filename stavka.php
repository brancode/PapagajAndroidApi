 <?php
 
// include db connect class
require_once __DIR__ . '\db_connect.php';
 
// connecting to db
$db = new DB_CONNECT();
 
if($_SERVER['REQUEST_METHOD'] == "POST")
{
 // Get data
 $sto_id = isset($_POST['sto_id']) ? mysql_real_escape_string($_POST['sto_id']) : "";
 $korisnik_id = isset($_POST['korisnik_id']) ? mysql_real_escape_string($_POST['korisnik_id']) : "";
 $artikal_id = isset($_POST['artikal_id']) ? mysql_real_escape_string($_POST['artikal_id']) : "";
 $kolicina = isset($_POST['kolicina']) ? mysql_real_escape_string($_POST['kolicina']) : "";
 
 
	// Trazimo temp_porudzbadok - za sad pretpostavka da ga imamo
	$sql = " select pd.`temp_porudzbadok_id` as pdid, pd.`broj` " .
		" from temp_porudzbadok pd " .
		" where pd.sto_id='$sto_id' and pd.korisnik_id='$korisnik_id';";
	$result = mysql_query($sql) or die(mysql_error());
 
	echo "br" . mysql_num_rows($result);
 
	if (mysql_num_rows($result) > 0) 
	{
		$row = mysql_fetch_array($result);
		$pd = (int)$row['pdid'];
	}  
	
	
	$sql2 = " insert into temp_porudzba (temp_porudzbadok_id, artikal_id, cijena, kolicina, nc, popust) " .
		" SELECT '$pd', a.`artikal_id`, z.`pcpdv`, '$kolicina' ,z.`nc`, 0 " .	
		" from artikal a " .
		" inner join zalihe z on a.`artikal_id`=z.`artikal_id` " .
		" where a.`artikal_id`='$artikal_id' ";
 
 
 $qur = mysql_query($sql2);
 if($qur){$json = array("status" => 1, "msg" => "Done");}
 else {$json = array("status" => 0, "msg" => "Error");}
 
}

else
{
 $json = array("status" => 0, "msg" => "Request method not accepted");
}
 
@mysql_close($conn);
 
/* Output header */
 header('Content-type: application/json');
 echo json_encode($json);
 
?>