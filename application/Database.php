<?php 
class Database
{
    public static function con() {
    	$conn = OCILogon("system", "prueba123", "xe", "AL32UTF8");	
		if (!$conn){
			echo "Conexion es invalida" . var_dump ( OCIError() );
			die();
		}
    	return $conn;
    }
}
?>