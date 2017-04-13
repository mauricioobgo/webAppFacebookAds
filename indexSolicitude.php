<?php
require('db/requires.php');
include("class/class.db_fbManager.php");
include("class/class.fbbusiness.php");

//inicialización de objeto
$fb=new fbBusinessManager();

$adAccounts	=$fb->dbFanpages();

//Inserción de  de Campañas
/*foreach ($adAccounts as $actId) {
	echo '<pre>';
	$fb->getIdfanpage($actId->act_fanpage);
    $ads=$fb->queryCampaign();
    $fb->arrayDestroyer($ads);
    $fb->MongoInsert();
}*/
//inserción de Ads
$campaigns=$fb->getCollection('campaign');
$campaignArray=$fb->campaignMongo($campaigns);
foreach ($campaignArray as $key ) {
  $fb->getIdfanpage($key);
  $adsPosted=$fb->queryAd();  
  $fb->arrayDestroyer($adsPosted);
  $fb->MongoInsert();
  $fb->PowerArray=[];
}





/*
bon bon bum
act_992212804156827 Campaign
6037810067537 Ad
$token=$fb->genToken();
$url=$fb->urlConstructor($token);
echo $url;
$request=$fb->app_request($url);
echo"<pre>";
print_r($request);*/

//Petición para saber cuentas a las que tengo acceso en Business Manager
//967024390009002/adaccounts?
//peticion para saber cuantos adds tiene un id de una campaña
//act_992212804156827/campaigns?fields=name,id,objective,ads.limit(10){id,updated_time,insights,name}&limit=50
//$url="https://graph.facebook.com/v2.5/".$idFanpageFb."?fields=".$fields.".limit(".$limite."){".implode(",", $camposTraer)."}&".$app_access_token;
//AddaccountId
//    {
//      "id": "act_1168860329825406",
//      "account_id": "1168860329825406"
//    },
//    {
//
//          "id": "act_197552393930663",
//      "account_id": "197552393930663"

?>


