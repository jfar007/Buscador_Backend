<?php

class Data
{
	private $id;
	private $direccion;
	private $ciudad;
	private $telefono;
	private $codigo_postal;
	private $tipo;
	private $precio;
	
	 // function __construct($id){
		// $this->id = $id;
	// }
	

	
	public function __construct($id, $direccion, $ciudad, $telefono, $codigo_postal, $tipo, $precio){
		$this->id = $id;
		$this->direccion = $direccion;
		$this->ciudad = $ciudad;
		$this->telefono = $telefono;
		$this->codigo_postal = $codigo_postal;
		$this->tipo = $tipo;
		$this->precio = $precio;
	}

	
	function getId(){
		return $this->id;	
	}
	
	function getDireccion(){
		return $this->direccion;	
	}
	
	function getCiudad(){
		return $this->ciudad;	
	}
	
	function getTelefono(){
	    return $this->telefono;
	}
	
	function getCodigoPostal(){
		return $this->codigo_postal;	
	}
	
	function getTipo(){
		return $this->tipo;	
	}
	
	function getPrecio(){
	    return $this->precio;	
	}
	function printObject(){
// 	    $record->Id =  $this->id;
// 	    $record->Direccion =  $this->direccion;
// 	    $record->direccion =  $this->direccion;
// 	    $record->ciudad = $this->ciudad;
// 	    $record->telefono = $this->telefono;
// 	    $record->codigo_postal =  $this->codigo_postal;
// 	    $record->tipo  = $this->tipo;
// 	    $record->precio =$this->precio;
// 	    return $record;
	    return $this;
	}
}

?>