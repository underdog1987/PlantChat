<?php

	final class Planta{
		
		private $idPlanta;
		private $nbPlanta;
		private $txDescripcion;
		private $idUbicacion;
		
		public function __construct($id=0){
			if((int)$id>0){
				$this->idPlanta=$id;
			}
		}
		
		public function getIdPlanta(){
			return $this->idPlanta;
		}
	
		public function setIdPlanta($idPlanta){
			$this->idPlanta = $idPlanta;
		}
	
		public function getNbPlanta(){
			return $this->nbPlanta;
		}
	
		public function setNbPlanta($nbPlanta){
			$this->nbPlanta = $nbPlanta;
		}
	
		public function getTxDescripcion(){
			return $this->txDescripcion;
		}
	
		public function setTxDescripcion($txDescripcion){
			$this->txDescripcion = $txDescripcion;
		}
	
		public function getIdUbicacion(){
			return $this->idUbicacion;
		}
	
		public function setIdUbicacion(Ubicacion $idUbicacion){
			$this->idUbicacion = $idUbicacion;
		}
			
	}

?>