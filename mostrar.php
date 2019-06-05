<?php
/*
 * Archivo a guardar en actualizaciones en las que se conecta a la base 
 * de datos y cambia los valores de los extrafields para que se muestren
 * o escondan y QUE ESTEN EN LA POSICIÓN 123
 *
 * A parte se debe actualizar el archivo card.php con:
 * require_once 'mostrar.php';
 * mostrar();
 * 
 */

require '../conf/conf.php';

//Extraer variables de conf.php

$dbase=$dolibarr_main_db_name;
$usuario=$dolibarr_main_db_user;
$pass=$dolibarr_main_db_pass;
$host=$dolibarr_main_db_host;

function mostrar(){

//si tiene una acción, ya sea crear o editar se pone en modo 1 sino en 2
	
	$accion=$_GET['action'];
	
	if ($accion == ''){
		$value=2;
	}else{	
		$value=1;
	}

//conectar a la base de datos a partir de datos del phpini
	
	global $dbase, $usuario, $pass, $host;
	$con = mysqli_connect($host, $usuario, $pass , $dbase);

//errores
	
	if($con === false){
       die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
    }
    
//variables de extrafields que hay que esconder/mostrar y que esten en la condición de pos
	$j=0;
	$consulta="SELECT name FROM llx_extrafields WHERE pos=123";
	$resultado=$con->query($consulta);
	if($consulta->errno)die($consulta->error);
	while($fila=$resultado->fetch_array()){
		$vari[$j]=$fila[0];
		$j++;
	}
	
//hacer un ciclo de las variables a modificar

	$i=0;
	while ($i < count($vari)){
		//Modificación variables 
		$s="UPDATE llx_extrafields SET list = ".$value." WHERE name="."'".$vari[$i]."'";	
		mysqli_query($con,$s);
		$i++;
}
	mysqli_close($con); 
}



?>
