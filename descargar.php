<?php
	if (isset($_GET['zip'])) {
		$zip=$_GET['zip'];
		shell_exec("zip -r ../".$zip.".zip ../".$zip);
		shell_exec("chmod 777 ../".$zip.".zip");
		header("Location: ../".$zip.".zip");
	}
	
?>