<?php

$fc0 = $_POST['fmp3'];
$fc1 = $_POST['fogg'];
$fc2 = $_POST['bgplayer'];
$fc3 = $_POST['lrplayer'];
$fc4 = $_POST['bgsautplay'];
$fc5 = $_POST['bgsloop'];
$fc6 = $_POST['plicon'];
$fc7 = $_POST['paicon'];
$fc8 = $_POST['sticon'];
$fc9 = $_POST['vdicon'];
$fc10 = $_POST['vuicon'];
$fc11 = $_POST['pin'];
$fc12 = $_POST['hi'];

$fp = fopen( 'sbgs_settings.txt','w');

if (!$fp) {
	echo 'ERROR: No ha sido posible abrir el archivo. Revisa su nombre y sus permisos. <a href="javascript:history.back();">Back</a>'; exit;
} 
else 
{
	fputs($fp, $fc0."|".$fc1."|".$fc2."|".$fc3."|".$fc4."|".$fc5."|".$fc6."|".$fc7."|".$fc8."|".$fc9."|".$fc10."|".$fc11."|".$fc12);

	fclose($fp);

	header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>