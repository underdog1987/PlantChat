<?php

	final class Ubicacion{
		
		private $idUbicacion;
		private $nbUbicacion;
		
		
		public function __construct($id=0){
			if((int)$id>0){
				$this->idUbicacion=$id;
			}
		}
		
		public function getIdUbicacion(){
			return $this->idUbicacion;
		}
	
		public function setIdUbicacion($idUbicacion){
			$this->idUbicacion = $idUbicacion;
		}
	
		public function getNbUbicacion(){
			return $this->nbUbicacion;
		}
	
		public function setNbUbicacion($nbUbicacion){
			$this->nbUbicacion = $nbUbicacion;
		}
			
	}

?>