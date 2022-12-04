<?php
	include 'credenciales.php';
	$con= mysqli_connect(HOST, USER, PASS, DB);
	session_start();
	if (!isset($_SESSION['id'])) {
		header("Location: login.php");
	}elseif ($_SESSION['email']=="admin@server.com" && $_SESSION['pass']=="serveradmin") {
		$sql="SELECT dominio FROM webs";
		$dominios=mysqli_query($con,$sql);
		$id="admin";
	}else{
		$id=$_SESSION["id"];
		$mensaje=" ";
		if (isset($_GET['crear'])) {
			$conca=$id.$_GET['nameWeb'];
			$sql="SELECT * FROM webs";
			$res=mysqli_query($con,$sql);
			if(mysqli_num_rows($res)>0){
				while ($fila=mysqli_fetch_array($res)) {
					if($fila['dominio']==$conca){
						$mensaje="Este dominio ya existe.";
					}
				}
				if($mensaje!="Este dominio ya existe."){
					$sql="INSERT INTO webs (idUsuario, dominio) VALUES ('$id', '$conca');";
					if(mysqli_query($con,$sql)){
						$mensaje="Dominio agregado correctamente.";
						shell_exec("./wix.sh ../".$conca);
						shell_exec("chmod 777 ".$conca);
					}else{
						$mensaje="Error de sql.";
					}
				}
			}else{
				$sql="INSERT INTO webs (idUsuario, dominio) VALUES ('$id', '$conca');";
					if(mysqli_query($con,$sql)){
						$mensaje="Dominio agregado correctamente.";
						shell_exec("./wix.sh ../".$conca);
						shell_exec("chmod 777 ".$conca);
					}else{
						$mensaje="Error de sql.";
					}
			}
		}

		$sql="SELECT dominio FROM webs where idUsuario = '$id'";
		$dominios=mysqli_query($con,$sql);
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Bienvenido</title>
</head>
<body>
	<h3 align="center">Bienvenido a tu panel!</h3>
	<p align="center"><a href="logout.php">Cerrar sesión de <?php echo $id;?></a></p><br>
	<?php 
		if ($id!="admin") {
	?>
			<fieldset align="center">
			<legend>Generar Web de: </legend>
			<form method="get">
				<p>Nombre de la Web: <input type="text" name="nameWeb" required></p>
				<p><input type="submit" name="crear" value="Crear web"></p>
				
			</form>
		</fieldset>
		<p align="center"><?php if(!empty($mensaje)){echo $mensaje;} ?></p>
	<?php 
		}
	?>
	

	<?php
		while ($fila=mysqli_fetch_array($dominios)) { 
	?>
			<p align="center">
				<a href="../<?php echo $fila['dominio'];?>">
					<?php echo $fila['dominio']; ?>
				</a>
				<a href="descargar.php?zip=<?php echo $fila['dominio'];?>">Descargar</a>
				<a href="borrar.php?domi=<?php echo $fila['dominio'];?>">Eliminar</a>
			</p>
	<?php
		}
	?>
	

</body>
</html>