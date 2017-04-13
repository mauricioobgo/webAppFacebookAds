<?php

class fbBusinessManager extends dbFbManager
{

	
	//constructor
	function __construct() {
	}
    //Define idFanpage
	function getIdFanpage($id){
		$this->idFanpage=$id;
	}
	function getCollection($collection){
		$this->collection=$collection;	
	}

	//Genera un nuevo token por cada nueva solicitud
	function genToken(){
		return 'access_token=coloque su token de acceso a facebook aqui';
	}
	//Realiza el request dado un token y un nueva url 
	function app_request ($url="") {
		$proxy="si tiene proxy coloquelo";
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_PROXY, $proxy);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	    $result = curl_exec($curl);
	    curl_close($curl);
	    return (array) (object) json_decode($result,true);
	}
    // Constructor de url para realizar petición
    //$id,$fields,$access_token,$tipoAccount
	function urlConstructor($idrequest,$requestType,$field,$limit){
		$url_bs='https://graph.facebook.com/v2.5/';
        $url=$url_bs.$idrequest.'/'.$requestType.'?fields='.urlencode($field).'&limit='.$limit.'&'.$this->genToken();
        return $url;
	}
	//Consulta todas campañas activas de cierto idFanpage
	function queryCampaign(){
		//colección a utilizar
		$this->collection='campaign';
		$field='name,id,objective,can_use_spend_cap,buying_type,start_time,stop_time,updated_time,created_time';
		$limit=100;//máximo de campañas a traer
		$url=$this->urlConstructor($this->idFanpage,'campaigns',$field,$limit);
     	$campaigns=$this->app_request($url);
     	//si existe un previous en el primer request se almacena en una variable
     	$next=(isset($campaigns['paging']['next']))? array_push($campaigns,$this->nextOrPrevious($campaigns['paging']['next'],'next')):'';
     	$previous=(isset($campaigns['paging']['previous']))? array_push($campaigns,$this->nextOrPrevious($campaigns['paging']['previous'],'previous')):'';

        return $campaigns;   

	}
	//Consulta los ads referentes a una campaña
	function queryAd(){
		//Colección a utilizar
		$this->collection='ad';
		$field='name,id,insights,reachestimate,targetingsentencelines';
		$limit=20;//máximo de campañas a traer
		$url=$this->urlConstructor($this->idFanpage,'ads',$field,$limit);
		echo $url;
		$ads=$this->app_request($url);
		$arrayAd=$ads;
		$next=(isset($ads['paging']['next']))? array_push($arrayAd,$this->nextOrPrevious($ads['paging']['next'],'next')):'';
     	$previous=(isset($ads['paging']['previous']))? array_push($arrayAd,$this->nextOrPrevious($ads['paging']['previous'],'previous')):'';
		return $arrayAd;
	}
    //método que recorre si es prevoius o next y realiza peticiones
	function nextOrPrevious($nextPrevious,$type){
		$x=2;
		$arreglo=array();
        $solicitude;
        
		while ($x>1) {
	        $solicitude=$this->app_request($nextPrevious);
			array_push($arreglo,$solicitude);
			if(isset($solicitude['paging'][$type])==true){
				$nextPrevious =$solicitude['paging'][$type];

			}else{
				$x=0;
			}
			//sleep(10);
		}
		return $arreglo;
	}
    
}

//act_992212804156827/campaigns?fields=name,id,objective,ads{id,name,campaign_id},can_use_spend_cap,buying_type,start_time,stop_time,updated_time,created_time&limit=100


//$url="https://graph.facebook.com/v2.5/".$idFanpageFb."?fields=".$fields.".limit(".$limite."){".implode(",", $camposTraer)."}&".$app_access_token;
//$url="https://graph.facebook.com/v2.4/".$idFanpageFb."?fields=".$fields.".limit(".$limite."){".implode(",", $camposTraer)."}&".$app_access_token;

?>


