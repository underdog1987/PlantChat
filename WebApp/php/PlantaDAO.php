<?php
/**
 */
//error_reporting(-1);

final class PlantaDAO extends AppDAO{
	
	private $uDAO;

    /* Prievate */
    private function findAll(){
		return FALSE;
	}
    
	private function findById($t){
		$ret=FALSE;
		$t=(int)$t;
		$q="
			SELECT
				[idPlanta]
				,[nbPlanta]
				,[txDescripcion]
				,[idUbicacion]
			FROM
				[b021mx].[dbo].[t021001_Planta]
			WHERE
				[idPlanta] = '".$t."';
		";
		if($res=$this->driver->runQuery($q)){
			if(mssql_num_rows($res)===1){
				$ret=mssql_fetch_assoc($res);
			}
		}else{
			throw new Exception('No se puede obtener la lista de Plantas');
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
			$ret=new Planta;
			$ret->setIdPlanta($tmp['idPlanta']);
			$ret->setNbPlanta($tmp['nbPlanta']);
			$ret->setTxDescripcion($tmp['txDescripcion']);
			
			$i=$this->uDAO->getById($tmp['idUbicacion']);
			if($i instanceof Ubicacion){
				$ret->setIdUbicacion($i);
			}else{
				$ret->setIdUbicacion(new Ubicacion($tmp['idUbicacion']));
			}
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
		$this->uDAO= new UbicacionDAO;
	}
	

}

//test
/*
echo '<hr />';
$foo = new ChatDAO();


die(var_dump($foo));
*/

?>