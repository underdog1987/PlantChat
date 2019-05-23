<?php

	final class Message{
		
		private $idMensaje;
		private $idFrom; // Planta envia
		private $idReplyTo; // Planta a la que contesta o NULL
		private $txMensaje;
		private $fhMensaje;
		
		
		public function __construct($id=0){
			if((int)$id>0){
				$this->idMensaje=$id;
			}
		}
		
		public function getIdMensaje(){
			return $this->idMensaje;
		}
	
		public function setIdMensaje($idMensaje){
			$this->idMensaje = $idMensaje;
		}
	
		public function getIdFrom(){
			return $this->idFrom;
		}
	
		public function setIdFrom(Planta $idFrom){
			$this->idFrom = $idFrom;
		}
	
		public function getIdReplyTo(){
			return $this->idReplyTo;
		}
	
		public function setIdReplyTo(Planta $idReplyTo){
			$this->idReplyTo = $idReplyTo;
		}
	
		public function getTxMensaje(){
			return $this->txMensaje;
		}
	
		public function setTxMensaje($txMensaje){
			$this->txMensaje = $txMensaje;
		}
	
		public function getFhMensaje(){
			return $this->fhMensaje;
		}
	
		public function setFhMensaje($fhMensaje){
			$this->fhMensaje = $fhMensaje;
		}
		
			
	}

?>