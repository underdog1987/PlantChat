<?php
/**
 */
//error_reporting(-1);

final class MessageDAO extends AppDAO{

	private $plantDAO;

    /* Prievate */
	// Ultimos 50 mensajes
	private function findAll($x){
		$x=(int)$x;
		$ret=array();
		$t=(int)$t;
		$q="
		SELECT * FROM (
			SELECT TOP(".$x.")
				[idMensaje]
				,[idFrom]
				,[idReplyTo]
				,[txMensaje]
				,CONVERT(VARCHAR,[fhMensaje],103) + ' ' + CONVERT(VARCHAR,[fhMensaje],108) AS [fhMensaje]
			FROM
				[b021mx].[dbo].[t021300_Mensaje]
			ORDER BY idMensaje DESC
		) AS Sub1
		ORDER BY Sub1.idMensaje
			;
		";
		if($res=$this->driver->runQuery($q)){
			while($e=mssql_fetch_assoc($res)){
				$ret[]=$e;	
			}
		}else{
			throw new Exception('No se puede obtener la lista de Mensajes');
		}
		return $ret;
	}
    
	private function findById($id){
		return $NULL;
	}
	
	private function findLastId(){
		return;
	}
	
	private function __insert($ar){ // ete chi
		$ret=FALSE;
		$ar['idFrom']=(int)$ar['idFrom'];
		$ar['idReplyTo']=(int)$ar['idReplyTo'];
		$q="
		INSERT INTO
			[b021mx].[dbo].[t021300_Mensaje](
				[idFrom]
				,[idReplyTo]
				,[txMensaje]
				,[fhMensaje]
			)VALUES(
				'".$ar['idFrom']."'
				,'".$ar['idReplyTo']."'
				,'".$ar['txMensaje']."'
				,GETDATE()
			);
		";
		if($res=$this->driver->runQuery($q)){
			$ret=TRUE;
		}else{
			throw new Exception('No se pudo enviar el mensaje');
		}
		return $ret;
	}
	
	private function __update($ar){// Paramarcar como leídos
		global $SessionType;
		return NULL;
	}
	



	////////////////////////////
    /* Public implementations */
	////////////////////////////
	
    public function getByStatus($st){
		throw new NullBrainException('No implementable');
	}
	
	public function getAll($x){
		$x=(int)$x;
		$ret=NULL;
		$t=(int)$t;
		$tmp=$this->findAll($x);
		if(is_array($tmp) /*&& count($tmp)>0 */){
			$ret=new ArrayList;
			for($x=0;$x<count($tmp);$x++){
				$oTmp=new Message;
				$oTmp->setIdMensaje($tmp[$x]['idMensaje']);
				
				$p1=$this->plantDAO->getById($tmp[$x]['idFrom']);
				if($p1 instanceof Planta){
					$oTmp->setIdFrom($p1);
				}else{
					$oTmp->setIdFrom(new Planta($tmp[$x]['idFrom']));
				}
				
				if($tmp[$x]['idReplyTo']>0){
					$p1=$this->plantDAO->getById($tmp[$x]['idReplyTo']);
					if($p1 instanceof Planta){
						$oTmp->setIdReplyTo($p1);
					}else{
						$oTmp->setIdReplyTo(new Planta($tmp[$x]['idReplyTo']));
					}
				}else{
					$oTmp->setIdReplyTo(new Planta);
				}
				
				$oTmp->setTxMensaje($tmp[$x]['txMensaje']);
				$oTmp->setFhMensaje($tmp[$x]['fhMensaje']);
				$ret->add($oTmp);
				unset($oTmp, $p1);
			}
		}
		return $ret;
	}
	
	public function getById($id){
		throw new NullBrainException('No implementable');
	}
	
	public function getScopeIdentity(){
		//return $this->scopeIdentity;
		return 0;
	}
	
	public function save($obj){
		$ret=FALSE;
		if($obj instanceof Message){
			$ar['idFrom']=(int)$obj->getIdFrom()->getIdPlanta();
			$ar['idReplyTo']=(int)$obj->getIdReplyTo()->getIdPlanta();
			$ar['txMensaje']=$obj->gettxMensaje();
			$ret=$this->__insert($ar);
		}else{
			throw new NullPointerException('Se esperaba un objeto');
		}
		return $ret;
	}
	
	public function update($obj){
		throw new NullBrainException('No implementable');
	}
	
	public function search($term){
		return NULL;
	}
	
	public function __construct(){
		parent::__construct();
		$this->plantDAO = new PlantaDAO;
	}
	

}

//test
/*
echo '<hr />';
$foo = new MessageDAO();


die(var_dump($foo));
*/

?>