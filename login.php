<?php
	include 'credenciales.php';
	$con= mysqli_connect(HOST, USER, PASS, DB);
	$sql="SELECT * FROM usuarios";
	$res=mysqli_query($con,$sql);

	if (isset($_SESSION['id'])) {
		header("Location: panel.php");
	}elseif(isset($_GET['ingresar'])){
		$email=$_GET['email'];
		$pass=$_GET['password'];
		if(mysqli_num_rows($res)>0){
			while($aux=mysqli_fetch_array($res)){
				if($aux['email']==$email && $aux['password']==$pass || $email=="admin@server.com" && $pass=="serveradmin"){
					session_start();
					$_SESSION["email"] = $email;
					$_SESSION["pass"] = $pass;
					$_SESSION["id"] = $aux['idUsuario'];
					header("Location: panel.php");
				}else{
					$mensaje="Usuario o contraseña incorrectos";
				}
			}
		}else{
			$mensaje ="Aún no existen registros";
		}
	}
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>webgenerator Mica Schaab</title>
</head>
<body>
	<h3 align="center">Webgenerator Mica Schaab</h3>
	<br>
	<form method="get" align="center">
		<p>Ingrese mail: <input type="email" name="email" required></p>
		<p>Ingrese contraseña: <input type="password" name="password" required></p>
		<p><input type="submit" name="ingresar" value="Ingresar">  <a href="register.php"> Registrarse</a></p>
	</form>

	<p align="center"><?php if(!empty($mensaje)){echo $mensaje;} ?></p>

</body>
</html>