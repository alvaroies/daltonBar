<?php 
	header("Content-Type: text/html; charset=utf-8"); 
	session_start();
	setcookie("identificado", "no", time() + (86400 * 30), "/"); // 86400 = 1 day

	include("action/db.php");

	if(isset($_POST["user"]) && isset($_POST["pass"]))
	{	
		$_SESSION['identificado'] = "N";

		$con = conectarBD();
		// Este código no permite SQL Injection
		//$stmt = mysqli_prepare($con, "SELECT count(*) as kk FROM users WHERE u_name=? AND u_pass=? ");
		//mysqli_stmt_bind_param($stmt, 'ss', $_POST["user"], $_POST["pass"]);
		//mysqli_stmt_execute($stmt);
		//$result = mysqli_stmt_get_result($stmt);

		$ql = "SELECT count(*) as kk FROM users WHERE u_name='".$_POST["user"]."' AND u_pass='".$_POST["pass"]."';";
		$result = mysqli_query($con, $ql);

		if(mysqli_num_rows($result)==1)
		{
			$prod = mysqli_fetch_array($result);
			$cuser = $prod["kk"];
			if ($cuser==1)
			{
				$_SESSION['identificado'] = "Y";
				setcookie("identificado", "yes", time() + (86400 * 30), "/"); // 86400 = 1 day
				//echo "<script>alert('Identificado correctamente');self.location.href='http://".$_SERVER['SERVER_ADDR']."';</script>";
				echo "<script>alert('Identificado correctamente');self.location.href='/';</script>";
			}
		}
		desconectarBD($con);
	}
	if(!isset($_SESSION['identificado']) || $_SESSION['identificado'] != "Y")
	{
		$_SESSION['identificado'] = "N";
		unset($_SESSION['identificado']);
		setcookie("identificado", "no");
		echo "<script>alert('Usuario no válido');</script>";
	}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,900" rel="stylesheet">
    <link rel="stylesheet" href="/css/main2.css">
    <title>Login</title>
</head>
<body>
    <div class="login__container">
       <div class="login__top">
          <img  class="login__img" src="/img/miniatura_asir.png" alt="">
          <h2 class="login__title">Acceso Web <span>ASIR</span></h2>
       </div>
        
        <form class="login__form" action="admin.php" method="POST">
            <input name="user" type="text" placeholder="&#128100; username" required autofocus>
            <input name="pass" type="password" placeholder="&#x1F512; password" required>
            <input class="btn__submit" type="submit" value="ENTRAR">
            <a class="form__recover" href="">Olvidaste la contraseña?</a>
        </form>
    </div>
</body>
</html>