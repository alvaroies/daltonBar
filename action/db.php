<?php

function conectarBD()
{

	$enlace = mysqli_connect("127.0.0.1", "root", "", "daltonbar");

	if (!$enlace) {
		echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
		echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
		echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
	 return $enlace;
}

function desconectarBD($conexion)
{
 mysqli_close($conexion);
}

?>