<html> 
<head> 
<style type="text/css"> 
<!-- 
.box { 
    font-family: Arial, Helvetica, sans-serif; 
    font-size: 12px; 
    border: 1px solid #000000; 
} 
--> 
</style> 
</head> 

<body> 
<? 

define("NAMETHUMB", "/tmp/thumbtemp");

//mysql_connect("localhost", "dalton", "cienfuegos") or die("Could not connect: " . mysql_error());
mysql_connect("mysql.jmremedia.com", "daltonbar", "aticoflove") or die("Could not connect: " . mysql_error());
mysql_select_db("alped_vin") or die(mysql_error());

if(isset($_POST['upload'])) 
{ 
        $fileName = $_FILES['userfile']['name']; 
        $tmpName  = $_FILES['userfile']['tmp_name']; 
        $fileSize = $_FILES['userfile']['size']; 
        $fileType = $_FILES['userfile']['type']; 
        
        
        //imagen grande
        $img_id = imagecreatefromjpeg($tmpName);
        if (imagesx($img_id)>650)
			  {
					$width=650;					
				  $img_width = imagesx($img_id); 
				  $img_height = imagesy($img_id); 
				  $height = floor(($width / $img_width) * $img_height); 
				  $dst_img = imagecreatetruecolor($width,$height); 
				  imagecopyresampled($dst_img,$img_id,0,0,0,0,$width,$height,$img_width,$img_height);     
					imagejpeg($dst_img,NAMETHUMB); 
				     
				  $fp = fopen(NAMETHUMB, 'r'); 
				  $content = fread($fp, filesize(NAMETHUMB)); 
				  $content = addslashes($content); 
				  fclose($fp); 
				  imagedestroy($dst_img); 
				}
				else
				{
					$fp = fopen($tmpName, 'r'); 
	        $content = fread($fp, $fileSize); 
	        $content = addslashes($content); 
	        fclose($fp);					
				}

        if(!get_magic_quotes_gpc()) 
        { 
            $fileName = addslashes($fileName); 
        } 
        
        //imagen pequeya
        $img_id = imagecreatefromjpeg($tmpName);
        if (imagesx($img_id)>100)
			  {
					$width=100;					
				  $img_width = imagesx($img_id); 
				  $img_height = imagesy($img_id); 
				  $height = floor(($width / $img_width) * $img_height); 
				  $dst_img = imagecreatetruecolor($width,$height); 
				  imagecopyresampled($dst_img,$img_id,0,0,0,0,$width,$height,$img_width,$img_height);     
					imagejpeg($dst_img,NAMETHUMB); 
				     
				  $fp = fopen(NAMETHUMB, 'r'); 
				  $content2 = fread($fp, filesize(NAMETHUMB)); 
				  $content2 = addslashes($content2); 
				  fclose($fp); 
				  imagedestroy($dst_img); 
				}
				else
				{
					$fp = fopen($tmpName, 'r'); 
	        $content2 = fread($fp, $fileSize); 
	        $content2 = addslashes($content); 
	        fclose($fp);					
				}
         
        $query = "INSERT INTO files (f_noticia, f_type, f_blob, f_blob_mini ) ". 
                 "VALUES (0, '$fileType', '$content', '$content2');"; 

        mysql_query($query) or die('Error, query failed');                    
        $result=mysql_query(" SELECT LAST_INSERT_ID();") or die('Error, query failed');
         
        $imageUrl= '/action/viewImage.php?size=mini&id='.mysql_result($result, 0);
        echo "<script>image_1 = new Image();\n image_1.src = '$imageUrl';\n window.opener.SetUrl('$imageUrl', image_1.height, image_1.width, '' );\n window.close();\n</script>"; 
        mysql_close();
        	
        // Borra archivos temporales si es que existen
  			@unlink(NAMETHUMB);
} 
else
{        
?> 
<form action="" method="post" enctype="multipart/form-data" name="uploadform"> 
  <table width="350" border="0" cellpadding="1" cellspacing="1" class="box"> 
    <tr>  
      <td width="246"><input type="hidden" name="MAX_FILE_SIZE" value="5000000"><input name="userfile" type="file" class="box" id="userfile"> 
         </td> 
      <td width="80"><input name="upload" type="submit" class="box" id="upload" value="  Upload  "></td> 
    </tr> 
  </table> 
</form> 
<? } ?>
</body> 
</html> 
