<?php
// Core
	require_once './php/Collection.php';
	require_once './php/ArrayList.php';
	require_once './php/MsSQLDBConfig.php';
	require_once './php/MsSQLDrive.php';
	require_once './php/AppDAO.php';
	
// Models
	require_once './php/Ubicacion.php';
	require_once './php/Planta.php';
	require_once './php/Message.php';

// DAOS
	require_once './php/UbicacionDAO.php';
	require_once './php/PlantaDAO.php';
	require_once './php/MessageDAO.php';

	try{
		
		$pDAO= new PlantaDAO;
		$mDAO= new MessageDAO;
		switch($_GET['c']){
			case 'sendmessage':{
				$content=file_get_contents("php://input");
				if($content!==""){
					$toins=json_decode($content);
					// TODO
					// Sacar la planta que envia y si es valida entonces
					$from=(int)$toins->from;
					$mensajee=$toins->mensaje;
					$validar=$pDAO->getById($from);
					if($validar instanceof Planta){
						if(substr($mensajee,0,1)=='@'){ // "arrobaron" a una planta
							$idArrobado=(int)substr($mensajee,1,1);
							$oArrobado=$pDAO->getById($idArrobado);
							if($oArrobado instanceof Planta){
							}else{
								$oArrobado=new Planta;	
							}
							$mensajee=substr($mensajee,3);
						}else{
							$oArrobado=new Planta;	
						}
						// Armar el mensaje
						$oMensaje=new Message;
						$oMensaje->setIdFrom($validar);
						$oMensaje->setIdReplyTo($oArrobado);
						$oMensaje->setTxMensaje(htmlentities($mensajee,ENT_QUOTES));
						if($mDAO->save($oMensaje)){
							die("OK");
						}else{
							die("Failed");
						}
					}
				}
				break;	
			}
			case 'getmessagesweb':{
				$messages=$mDAO->getAll(50);
				$msgs='';
				for($m=0;$m<$messages->size();$m++){
					$msgs.=	'{"from":"'.$messages->getItem($m)->getIdFrom()->getNbPlanta().'","mensaje":"'.$messages->getItem($m)->getTxMensaje().'", "replyingTo":"'.$messages->getItem($m)->getIdReplyTo()->getNbPlanta().'", "fhMensaje":"'.$messages->getItem($m)->getFhMensaje().'"},';
				}
				$msgs=substr($msgs,0,-1);
				$out='{"mensajes":['.$msgs.']}';
				header("Content-Type: application/json");
				die($out);
				break;
			}
			case 'getmessagesplant':{
				$messages=$mDAO->getAll(1);
				$msgs='';
				for($m=0;$m<$messages->size();$m++){
					// ~ new Message
					// | field separator
					$msgs.=	'~'.$messages->getItem($m)->getIdFrom()->getIdPlanta().'|'.$messages->getItem($m)->getTxMensaje().'|'.(int)$messages->getItem($m)->getIdReplyTo()->getIdPlanta().'';
				}
				header("Content-Type: text/plain");
				die($msgs);
				break;
			}
			default:{
				throw new Exception('???');
				break;	
			}
		}
		
	}catch(Exception $e){
		die($e->getMessage());
	}
	
