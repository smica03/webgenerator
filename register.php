 <?php
	include 'credenciales.php';
	$con= mysqli_connect(HOST, USER, PASS, DB);
	$sql="SELECT * FROM usuarios";
	$res=mysqli_query($con,$sql);
	if (isset($_SESSION['id'])) {
		header("Location: panel.php");
	}elseif (isset($_GET['confirmar'])) {
		$email=$_GET['email'];
		$pass1=$_GET['pass1'];
		$pass2=$_GET['pass2'];

		if ($pass1!=$pass2) {
			$mensaje="Las contraseñas deben ser iguales.";
		}elseif (mysqli_num_rows($res)>0) {
			while($aux=mysqli_fetch_array($res)){
				if($aux['email']=$email){
					$mensaje="Este email ya ha sido registrado.";
				}else{
					$sql="INSERT INTO usuarios (email, password) VALUES ('$email', '$pass1');";
					if (mysqli_query($con,$sql)) {
						$mensaje="Usuario registrado correctamente.";
						header("Location: login.php");
					}
				}
			}
		}else{
			$sql="INSERT INTO usuarios (email, password) VALUES ('$email', '$pass1');";
			if (mysqli_query($con,$sql)) {
				$mensaje="Usuario registrado correctamente.";
				header("Location: login.php");
			}
		}

	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registrarse es simple</title>
</head>
<body>	
	<h3 align="center">Registrarse es simple!</h3><br>
	<form method="get" align="center">
		<p>Ingrese mail: <input type="email" name="email" required></p>
		<p>Ingrese contraseña: <input type="password" name="pass1" required></p>
		<p>Ingrese contraseña nuevamente:<input type="password" name="pass2" required></p>
		<p><input type="submit" name="confirmar" value="Confirmar"></p>
	</form>
	<p align="center"><?php if(!empty($mensaje)){echo $mensaje;}?></p>
</body>
</html>