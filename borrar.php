<?php
	if (isset($_GET['domi'])) {
		$domi=$_GET['domi'];
		include 'credenciales.php';
		$con= mysqli_connect(HOST, USER, PASS, DB);
		$sql="DELETE FROM webs WHERE dominio = '$domi'";
		$res=mysqli_query($con,$sql);
		$respuesta=shell_exec("rm -r ../".$domi);
		$respuesta=shell_exec("rm -r ../".$domi.".zip");
		header("Location: panel.php");
	}
	
?>