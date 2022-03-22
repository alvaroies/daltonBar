<?php header("Content-Type: text/html; charset=utf-8"); 
	session_start();

	include("action/db.php");
	
	if (!isset($_SESSION['identificado'])||$_SESSION['identificado']!='Y')
		die("Usuario no identificado en el sistema");
?> 

<html>
  <head>
    <title>Editor de noticias</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body leftmargin="0" topmargin="0">
<?php

if (isset($_POST['FCKeditor1']))
{
	if ($_POST['id']=="")
	{
		// va el codigo que truca la visualizacion de imagenes		
		$temp=explode('viewImage.php',$_POST['FCKeditor1']);
		$temp2="";
		for ($i=count($temp)-1;$i>=0;$i--)
		{
				if ($i==0)
					$temp[$i] = substr($temp[$i], 0,strrpos ($temp[$i],'<'))."<a border='0' target='_blank' href='/action/viewImage.php?id=".$id."'>".substr($temp[$i],strrpos ($temp[$i],'<')).'viewImage.php'; 
				if ($i==count($temp)-1)
				{
					$id=substr($temp[$i],strpos($temp[$i], "id=")+strlen('id='));
					$id=substr($id,0,strpos($id,'"'));
					$temp[$i] = substr($temp[$i], 0,strpos ($temp[$i],'>')-1)." border='0' /></a>".substr($temp[$i],strpos ($temp[$i],'>')+1); 
				}
				if ($i!=0 && $i!=(count($temp)-1) )
				{
					$temp[$i] = substr($temp[$i], 0,strrpos ($temp[$i],'<'))."<a border='0' target='_blank' href='/action/viewImage.php?id=".$id."'>".substr($temp[$i],strrpos ($temp[$i],'<')).'viewImage.php'; 
					$id=substr($temp[$i],strpos($temp[$i], "id=")+strlen('id='));
					$id=substr($id,0,strpos($id,'"'));
					$temp[$i] = substr($temp[$i], 0,strpos ($temp[$i],'>')-1)." border='0' /></a>".substr($temp[$i],strpos ($temp[$i],'>')+1); 
				}					
				$temp2=$temp[$i].$temp2;
		}	
		// Fin del chanchullo

		// El chanchullo de antes no funciona bien.... Esta linea lo soluciona
		$temp2=$_POST['FCKeditor1'];

		$ql="INSERT into noticias(n_tipo,n_asunto,n_html,n_fecha) values ('".$_POST['cat']."','".addslashes($_POST['asunto'])."','".addslashes($temp2)."',now())";
		$con = conectarBD();
		mysqli_query($con, $ql);
		desconectarBD($con);
	}
	else
	{
		$ql="UPDATE noticias SET n_asunto='".addslashes($_POST['asunto'])."',n_html='".addslashes($_POST['FCKeditor1'])."' WHERE n_id=".$_POST['id']."";
		$con = conectarBD();
		mysqli_query($con, $ql);
		desconectarBD($con);
	}
	echo '<script>opener.location.href="news.php?cat='.$_POST['cat'].'";window.close();</script>';
}
else
{
	include("lib/FCKeditor/fckeditor.php") ;
	
	$id="";
	$html="";
	$asunto="";
	if (isset($_GET['id'])&& $_GET['id']!="" )
	{
		$ql="SELECT n_id,n_asunto,n_html,n_fecha FROM noticias WHERE n_id='".$_GET["id"]."' ";

		$con = conectarBD();
		$result = mysqli_query($con, $ql);
		desconectarBD($con);
		if(mysqli_num_rows($result)==1)
		{
			$prod = mysqli_fetch_array($result);
			$id = $prod["n_id"];
			$asunto = $prod["n_asunto"];
			$html = $prod["n_html"];
		}
	}
?>		
    <form name="f1" action="manage.php" method="post">
    	<input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>">
    	<input type="hidden" name="id" value="<?php echo $id; ?>">
    		Asunto: <input type="text" name="asunto" value="<?php echo $asunto; ?>">
			<?php
			$oFCKeditor = new FCKeditor('FCKeditor1') ;
			$oFCKeditor->BasePath = '/lib/FCKeditor/';
			$oFCKeditor->Value = $html;
			$oFCKeditor->Width  = '100%' ;
			$oFCKeditor->Height = '500' ;
			$oFCKeditor->Create() ;
			?> 
    </form>    
<?php
}
?>
  </body>
</html>