<?php
		include("db.php");
		
    // just so we know it is broken
    error_reporting(E_ALL);
    // some basic sanity checks
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    	if (isset($_GET['size']) && $_GET['size']=='mini')
    		$temp="f_blob_mini";
    	else
    		$temp="f_blob";

        // get the image from the db
        $sql = "SELECT $temp,f_type FROM files WHERE f_id=".$_GET['id'];

        // the result of the query
        $con = conectarBD();
        $result = mysql_query("$sql",$con) or die("Invalid query: " . mysql_error());
        desconectarBD($con);

        // set the header for the image
        header("Content-type: ".mysql_result($result, 0,"f_type"));
        echo mysql_result($result, 0,$temp);
    }
    else {
        echo 'Please use a real id number';
    }
?>