<?php
require "Data.php";

$datos = array();

function loadData(){
    global  $datos;
    $data_file = fopen("../data-1.json","r");
    $data_readed = fread($data_file, filesize("../data-1.json"));
    $data = json_decode($data_readed, true);
    fclose($data_file);

	foreach ($data as $key => $value) {
		$dataph = new Data($value['Id'], $value['Direccion'],$value['Ciudad'],$value['Telefono'],$value['Codigo_Postal'],$value['Tipo'],$value['Precio']);
		$datos [$key] = $dataph;
    }
}

function ciudades(){
    global  $datos;
    $ciudades = [];
    if(is_array($datos)){
        foreach ($datos as $key => $value) {
            if(in_array($value->getCiudad(),$ciudades) == false){
                array_push($ciudades,$value->getCiudad());
            }       
        }
    }
    return $ciudades;
}

function tipo($ciudad = 0){
    global  $datos;
    $tipo = [];
    if($ciudad == 0){     
        if(is_array($datos)){
            foreach ($datos as $key => $value) {
                if(in_array($value->getTipo(),$tipo) == false){
                    array_push($tipo,$value->getTipo());
                }
            }
        }	
    }else{
        if(is_array($datos)){
            foreach ($datos as $key => $value) {
                if($value->getCiudad() == $ciudad){
                    if(in_array($value->getTipo(),$tipo) == false){
                        array_push($tipo,$value->getTipo());
                    }
                }
            }
        }
    }
    
    return $tipo;
}

function filtrarBusqueda($ciudad , $tipo  , $precio ){
    
   global  $datos;
   $inmueble = array();
   $encontre = false;
   $val1 = (int) substr($precio, 0, strrpos( $precio, ';', 0));
   $val2 = (int) substr($precio, (strrpos( $precio, ';', 0))+1);
  

    foreach ($datos as $key => $value) {
        $encontre = false;
        $precio2 = str_replace("$","",$value->getPrecio());
        $precio2 =  (int) str_replace(",","",$precio2);
        if($precio2 >= $val1 && $precio2 <= $val2){            
            if($ciudad ==  "" && $tipo ==  "" ){                
                    $encontre = true;
            }else if($ciudad ==  "" ){
                if($value->getTipo() == $tipo){
                   $encontre = true;    
                }
            }else{
                if($value->getCiudad() == $ciudad ){
                    if($tipo != ""){
                        if($value->getTipo() ==  $tipo){
                            $encontre = true;
                        }
                    }else{
                        $encontre = true;
                    }
                }
            }                    
        }
        if($encontre){
            array_push($inmueble,
                array("Id" => $value->getId(),
                    "Direccion" => $value->getDireccion(),
                    "Ciudad" =>$value->getCiudad(),
                    "Telefono" =>$value->getTelefono(),
                    "Codigo_Postal" =>$value->getCodigoPostal(),
                    "Tipo" =>$value->getTipo(),
                    "Precio" =>$value->getPrecio()
                ));            
        }
    }
    
    return $inmueble;
    
}

function mostrarTodos(){
    global  $datos;
    $all = array();
    foreach ($datos as $key => $value) {
        array_push($all, 
            array("Id" => $value->getId(),
                "Direccion" => $value->getDireccion(),
                "Ciudad" =>$value->getCiudad(),
                "Telefono" =>$value->getTelefono(),
                "Codigo_Postal" =>$value->getCodigoPostal(),
                "Tipo" =>$value->getTipo(),
                "Precio" =>$value->getPrecio()            
        ));
       
    }
    return $all;
}



loadData();

if(isset($_POST["initData"]) ){
    $resp['ciudades'] = ciudades();
    $resp['tipo'] = tipo();
    echo json_encode($resp);
}

if(isset($_POST["all"]) ){
    $resp['data'] = mostrarTodos();  
    echo json_encode($resp);
}

if(isset($_POST["selectCiudad"]) || isset($_POST["selectTipo"]) ||  isset($_POST["rangoPrecio"]) ){
    $resp['data'] = filtrarBusqueda($_REQUEST["selectCiudad"],$_REQUEST["selectTipo"],$_REQUEST["rangoPrecio"]);
    echo json_encode($resp);
}


?>