<?php
/**
 */
//error_reporting(-1);

final class UbicacionDAO extends AppDAO{

    /* Prievate */
    private function findAll(){
		return FALSE;
	}
    
	private function findById($t){
		$ret=FALSE;
		$t=(int)$t;
		$q="
			SELECT
				[idUbicacion]
				,[nbUbicacion]
			FROM
				[b021mx].[dbo].[t021002_Ubicacion]
			WHERE
				[idUbicacion] = '".$t."';
		";
		if($res=$this->driver->runQuery($q)){
			if(mssql_num_rows($res)===1){
				$ret=mssql_fetch_assoc($res);
			}
		}else{
			throw new Exception('No se puede obtener la lista de Ubicaciones');
		}
		return $ret;
	}
	

	////////////////////////////
    /* Public implementations */
	////////////////////////////
	
    public function getAll($x){
		throw new Exception('No implementable');
	}
	
	public function getById($t){
		$ret=NULL;
		$t=(int)$t;
		$tmp=$this->findById($t);
		if(is_array($tmp) /*&& count($tmp)>0 */){
			$ret=new Ubicacion;
			$ret->setIdUbicacion($tmp['idUbicacion']);
			$ret->setNbUbicacion($tmp['nbUbicacion']);
		}
		return $ret;
	}
	
	public function getScopeIdentity(){
		return $this->scopeIdentity;
	}
	
	public function save($obj){
		$ret=FALSE;
		return $ret;
	}
	
	
	public function __construct(){
		parent::__construct();	
	}
	

}

//test
/*
echo '<hr />';
$foo = new ChatDAO();


die(var_dump($foo));
*/

?>