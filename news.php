<?php header("Content-Type: text/html; charset=utf-8"); 
	session_start();
	$npp = 3;
	
	if (isset($_COOKIE['identificado'])&&$_COOKIE['identificado']=='no')
	{
		unset($_SESSION['identificado']);
	}
?>

<html>
	<head>
		<script src="js/main.js" type="text/javascript"></script>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>	
		
	<?php		
		if (!isset($_GET["cat"]))
			die("Categoria no valida");
	?>
	
	<body bgcolor="#734F11" topmargin="0" leftmargin="0" onLoad="parent.changeImg2('<?php echo $_GET["cat"];?>');">
	
	<!-- CAM: Nueva noticia -->
	<?php					
		if ((isset($_SESSION['identificado'])&&$_SESSION['identificado']=='Y') || (isset($_COOKIE['identificado'])&&$_COOKIE['identificado']=='yes'))
		{
			$_SESSION['identificado'] = "Y";
	?>		
		<a class="list3" href="javascript:openFc('<?php echo $_GET["cat"]; ?>')">Nuevo artículo</a>	
	<?php
		}
	?>
	<!-- CAM: FIN Nueva noticia -->
		
		
	<!-- Inicio Visualiacion de las noticias -->	
<?php
	include("action/db.php");
	
	//Codigo para borrar
	if (isset($_GET["borrar"])&&$_GET["borrar"]!="")
	{
		$ql="update noticias SET n_fecha_baja=now() WHERE n_id=".$_GET["borrar"];
		$con = conectarBD();
		$result = mysqli_query($con, $ql);
		desconectarBD($con);
	}
	
	if(isset($_GET["pag"]) && $_GET["pag"]!=1)
		$inicio=$npp*($_GET["pag"]-1);
	else
		$inicio=0;
		
	$ql="SELECT n_id,n_asunto,n_html,DATE_FORMAT(n_fecha,'%d/%m/%Y') as fecha FROM noticias WHERE n_tipo='".$_GET["cat"]."' AND n_fecha_baja is null ORDER BY n_fecha desc LIMIT ".$inicio.",".$npp;
	
	$con = conectarBD();
	$result = mysqli_query($con, $ql);
	desconectarBD($con);

	$count = mysqli_num_rows($result);
	
	for ($i=0; $i < $count; $i++) 
	{
		$prod = mysqli_fetch_array($result);
		$c_id = $prod["n_id"];
		$n_asunto = $prod["n_asunto"];
		$n_html = $prod["n_html"];
		$n_fecha = $prod["fecha"];
?>

<!-- CAM: Muestra las noticias -->
<table width="100%" style="border: 1px solid #000000;" cellspacing="3" cellpadding="0">
	<?php	
		if (isset($_SESSION['identificado'])&&$_SESSION['identificado']=='Y')
		{
	?>
	<tr>
		<td class="list3"><a href="javascript:eliminar(<?php echo $c_id;?>,'<?php echo $_GET["cat"]; ?>');">Borrar</a> - <a href="javascript:openFc2(<?php echo $c_id;?>,'<?php echo $_GET["cat"]; ?>');">Editar</a></td>
	</tr>
	<?php
		}
	?>
	
	<?php if ($count!=1) { ?>
	<tr>
		<td class="list2"><table border="0" width="100%" class="list3"><tr><td align="left"><?php echo $n_asunto; ?></td><td align="right">Fecha: <?php echo $n_fecha;?></td></tr></table></td>
	</tr>
	<?php } ?>
	<tr>
		<td class="list2" ><table border="0" width="100%" class="list3"><tr><td><?php echo $n_html; ?></td></tr></table></td>
	</tr>
</table>
<br>
<!-- FIN Muestra las noticias -->

<?php
	}
?>
	<!-- FIN Visualiacion de las noticias -->
	
	
	<!-- PAGINACION -->
	<div align="center" class="list3">
	<?php
		$ql="SELECT count(*) as cantidad FROM noticias WHERE n_tipo='".$_GET["cat"]."' AND n_fecha_baja is null ";

		$con = conectarBD();
		$result = mysqli_query($con, $ql);
		desconectarBD($con);
		//$totalNot = mysqli_result($result, 0,"cantidad");
		$kk1 = mysqli_fetch_row($result);
		$totalNot = $kk1[0];
				
		if(!isset($_GET["pag"]))
			$pag=1;
		else
			$pag=$_GET["pag"];
			
		if($totalNot<=$npp)
			$pag=1;			
			
		if ($pag!=1)
			print '<a href="news.php?cat='.$_GET["cat"].'&pag='.($pag-1).'"><<</a>&nbsp;';
			
		for ($i=1;$i<(($totalNot/$npp)+1);$i++)
			if ($pag==$i)
				print $i.'&nbsp;';
			else
				print '<a href="news.php?cat='.$_GET["cat"].'&pag='.$i.'">'.$i.'</a>&nbsp;';

		if ($pag<($totalNot/$npp))
			print'&nbsp;<a href="news.php?cat='.$_GET["cat"].'&pag='.($pag+1).'">>></a>';				
	?>		
</div>
	<!-- FIN PAGINACION -->

</body>
</html>