<?php

require_once 'MsSQLDBConfig.php';

class MsSQLDrive{

    // Propiedades //

    private $cnnID;			// ID de la conexión
    private $queryID;		// ID del resultado de la consulta
    private $error;			// error de mssql.

    private $queries_executed;		// cuantas queries lleva
    static private $instance;		// Singleton
    
    private $config;

    private function __construct(){
    	mssql_min_error_severity(1);
        $this->queries_executed=0;
    }

    public static function getInstance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self;
         }
         return self::$instance;
    }

    public function __clone() {
        trigger_error("Cannot clone",E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error("Cannot deserialize",E_USER_ERROR);
    }

    public function setConfig(MsSQLDB2Config $config) {
        $this->config = $config;
    }
    
    public function getConfig() {
        return $this->config;
    }
	
	public function getError(){
		return $this->error;	
	}

    
    function connect(){
        try{
			$this->setConfig(new MsSQLDB2Config);
			//$this->cnnID=@mssql_pconnect($this->config->getDbServer(), $this->config->getDbUser(), $this->config->getDbPassword());
			$this->cnnID=@mssql_pconnect($this->config->getDbServer(), $this->config->getDbUser(), $this->config->getDbPassword());
            if($this->cnnID){
                if(@mssql_select_db($this->config->getDbName(),$this->cnnID)){
                    return $this->cnnID;
                }else{
                    $this->error=mssql_get_last_message();
                    return 0;
                }
            }else{
                $this->error=mssql_get_last_message();
                return 0;
            }            
        } catch (Exception $ex) {
            //require_once '../classes/views/system/500.php';
        }

    }


    function runQuery($sql_query){
        if(trim($sql_query)===""){
            $this->error="El argumento no es opcional. Origen RUNQUERY()";
            return 0;
        }else{
            $this->queryID=@mssql_query($sql_query,$this->cnnID);
        }
        if(!$this->queryID){
            $this->error=mssql_get_last_message();
            return 0;
        }else{
            $this->queries_executed=$this->queries_executed+1;
            return $this->queryID;
        }
    }
	
    static function isRunnable(){
        if(!function_exists("mssql_connect")){
            $ret=false;	
        }else{
            $ret=true;
        }
        return $ret;
    }


}