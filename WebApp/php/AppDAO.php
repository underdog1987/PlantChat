<?php

abstract class AppDAO {
    
	protected $driver;
	protected $connected;
	protected $scopeIdentity;
	
	/**
	 * Constructor
	 */
	function __construct(){

		try{
			$canRun=MsSQLDrive::isRunnable();
			if($canRun){
				$this->driver=MsSQLDrive::getInstance();
				//die(var_dump($this->driver));
				if($this->driver->connect()){
					//echo 'Connected and ready';
					$this->connected=TRUE;
				}else{
					$this->connected=FALSE;
				}
				$this->scopeIdentity=0;
			}else{
				throw new Exception('La extensión del driver no está habilidada');
			}
		}catch (Exception $Exception){
			die($Exception->getMessage());
		}
	}

	/**
	 * isConnected
	 * @return boolean Estado de conexion de $this->driver
	 */
	public function isConnected(){
		return $this->connected;
	}
	

    /* Public */
    abstract public function getAll($x);
	abstract public function getById($id);
	abstract public function getScopeIdentity();
	abstract public function save($obj);

    
}