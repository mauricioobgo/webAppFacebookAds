<?php
class dbFbManager{
    //variables públicas inicializadas para manejo general desde index
	public $PowerArray=array();
	public $idFanpage='';
	public $collection='';
   
	//conexión a mongo
	public function mongoConnect(){
		/**** Config mongo ****/
		$dbhost = 'localhost';
		$collection=$this->collection;
		$dbname = 'deeploy_web_app';
		$mongo = new MongoClient("mongodb://$dbhost");
		$barredora = $mongo->$dbname;
		return $barredora->$collection;
		/****/
	}
    //Conexión a db de mysql Fanpages
	public function dbFanpages(){
        $res= array();
        //DB_DataObject::debuglevel(0);
    	$dbFanpage=DB_DataObject::Factory('Ad_account');
    	$dbFanpage->find();
    	$i=0;
    	while ($dbFanpage->fetch()) {
    		$res[$i]->id=$dbFanpage->id;
    		$res[$i]->act_fanpage=$dbFanpage->act_fanpage;
    		$i++;
    	}

    	$dbFanpage->free();
    	return $res;
	}
    //Reduce dimensiones Json
	public function arrayDestroyer($arrayDimensions){
		foreach ($arrayDimensions['data'] as $key => $value) {
			$newArray=$this->arrayReacher($key,$value,'');
		}
		return $this->PowerArray;
	}
   //Recorre cada una de las dimensiones de un arreglo
	public function arrayReacher($num,$arrayN,$father){
   			$father= ($father=="") ? "data" : $father ;
	    	foreach ($arrayN as $key => $value) {
				$father1="";
				if(is_array($value)){
					$father1=(is_int($key)) ? "" : $father."_".$key  ;
					$this->arrayReacher($num,$value,$father1);
				} else{
                  $this->PowerArray[$num][$father."_".$key]=$value;
                  $this->PowerArray[$num]['id']=$this->idFanpage;
                  $this->PowerArray[$num]['date']=date("Y-m-d H:i:s");
				}

	    	}

	}

	//función de inserción o actualización de registro
	public function MongoInsert(){
		$connectMongo=$this->mongoConnect($this->collection);
		$compare;
		$arrayTesting=array();
		foreach ($this->PowerArray as $powerBank ) {
			$arrayTesting=$powerBank;
			$mongoQuery=iterator_to_array($connectMongo->find(['data_id'=>$arrayTesting['data_id']]));

			if(!empty($mongoQuery)){
				foreach ($mongoQuery as $index ) {	
				  $arreglo=$arrayTesting;
			      $compare=$this->comparingArray($index,$arrayTesting);

			      if($compare==1 ){
			      	printVar($arrayTesting);
			        $connectMongo->insert($arrayTesting);  
			        $mongoQuery=[];    	
			        $arreglo=[];
			      }
			    }
			}else{
			    $connectMongo->insert($powerBank);	
			}
		}
		
		$connectMongo->close;
	}
    //compara los arreglos para saber si es nuevo o se presento algun cambio
	function comparingArray($arrayMongo= array(),$arrayM=array()){
		$arrayDeus;
		$booleanVariable=0;
		foreach ($arrayMongo as $key => $value  ) {
			if($key!='_id' && $key!='date' && $key!='id' ){
				$arrayDeus[$key]=$value;
			}
		}
		foreach ($arrayDeus as $index => $nom) {
			foreach ($arrayM as $index2 => $nom2) {
			        if($index==$index2){
			        	if($nom!=$nom2){
			        		$booleanVariable= 1;
			        	}
			        }	
			}
		}
		return $booleanVariable;
	}
    // Método búsqueda de campañas registradas en Mongo
	public function campaignMongo(){
		$connectMongo=$this->mongoConnect($this->collection);
		$mongoQuery=iterator_to_array($connectMongo->find());
		if(!empty($mongoQuery)){
			$i=0;
			foreach ($mongoQuery as $key => $value) {
				$arrayN[$i]=$value['data_id'];
				$i++;
			}	
			$connectMongo->close;
			return $arrayN;
	    }
	}


}
?>
