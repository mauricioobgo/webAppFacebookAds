<?php
global $prefijo;
global $smarty;

// manejador cx base de datos 
require($prefijo."db/DBO.php");
require($prefijo."db/requires.ini.php");




// incluir smarty 
/**/
require($_SERVER["DOCUMENT_ROOT"] . "/Smarty/libs/Smarty.class.php");
$smarty = new Smarty();
$smarty->compile_check = true;
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';


function printVar($variable, $title= "") {
$var= print_r($variable, true);
echo "<pre style='background-color:#dddd00; border: dashed thin #000000; font-size:12px'><strong>[$title]</strong>".$var."<br/>";
//echo var_dump($variable);
echo"</pre>";
}
?>