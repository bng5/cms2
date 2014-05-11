<?php

/* 
seccion *
idioma *

cat = null
pagina = 1
rpp = 25
buscar = null
ordenAleat = false
orden = 'orden'
orden_dir = 1
recursivo = false

*/

/*
 * búsqueda se podría usar para items y categorías
 */

//require_once 'cms2/v2.1/DB.php';

class Busqueda_Items implements ArrayAccess {

	private $_seccion;
	private $_idioma;
	private $_attrsDinamicos = array();
	
	private $_categorias = array();
	private $_pagina = 1;
	private $_rpp = 25;
	private $_buscar = null;
	private $_ordenAleatorio = false;
	private $_orden = 'orden';
	private $_ordenAsc = 1;
	private $_recursivo = false;
	private $_busquedaDinamica = array();

	public function __construct($seccion, $idioma) {
		$this->_seccion = $seccion;
		$this->_idioma = $idioma;

		// fetch_fields y cargar attrsDinamicos
		//$this->_attrsDinamicos
	}

	public function setCategorias() {
		foreach(func_get_args() AS $cat) {
			if(is_int($cat))
				$this->_categorias[] = $cat;
		}
	}

	public function setPagina($valor) {
		if(is_int($valor))
			$this->_pagina = $valor;
	}

	public function setRpp($valor){
		if(is_int($valor))
			$this->_rpp = $valor;
	}

	public function setBuscar($valor){
		if(is_string($valor))
			$this->_buscar = $valor;
	}

	public function setOrdenAleatorio($valor){
		if(is_bool($valor))
			$this->_ordenAleatorio = $valor;
	}

	public function setOrden($valor){
		//if(is_int($valor))
		$this->_orden = $valor;
	}

	public function setOrdenAsc($valor){
		if(is_bool($valor))
			$this->_ordenAsc = $valor;
	}

	public function setRecursivo($valor){
		if(is_bool($valor))
			$this->_recursivo = $valor;
	}

	public function __get($atributo) {
		$atributo = '_'.$atributo; 
		return $this->$atributo;
	}


	public function offsetExists($clave) {
		return array_key_exists($clave, $this->_attrsDinamicos);
	}

	public function offsetGet($clave) {
		return $this->_attrsDinamicos[$clave];
	}

	public function offsetSet($clave, $valor) {
		$this->_attrsDinamicos[$value['id']] = $value;
	}

	public function offsetUnset($clave) {
		unset($this->_attrsDinamicos[$clave]);
	}

}



$busqueda = new Busqueda_Items($seccion, $idioma);
echo $busqueda->rpp;
//$listado = Publicacion_Items($busqueda);

?>

