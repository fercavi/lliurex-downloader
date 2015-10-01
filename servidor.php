<?php
$carpeta = "./isos";
$subcarpeta = "/releases";
$sufix = "_64bits";
$imatge="/img";

$versions = array();
$sabors = array();
$isos = array();
$arxius = buscaIsos();
for($i=0;$i<count($arxius);$i++){
  $carpetes = explode("/",$arxius[$i][0]);
  //afegim versions diferents
  $possibleversio = substr($carpetes[2],0,5);   //llevem la part de 64bits
  if (!in_array($possibleversio,$versions)){
    $versions[]=$possibleversio;
  }
   //afegim sabors diferents
  $arxiuiso=$carpetes[4];
  $filtre =str_replace("_","-",$arxiuiso);
  $filtre = str_replace(".","-",$filtre);
  $_sabors = explode("-",$filtre);
  $_possiblesabor = $_sabors[1];
  if (!in_array($_possiblesabor,$sabors)){
    $sabors[]=$_possiblesabor;
  }
  $arquitectura = 0;//per defecte 32 bits; calculem arquitectura i nom
  $nomarquitectura = "32 bits";
  if (es64bits($arxius[$i][0])) {
    $arquitectura = 1;
    $nomarquitectura = "64 bits";
  }
  //creem l'element iso'
  $iso = array(
    "versio"=>$possibleversio,
    "sabor"=>array_search($_possiblesabor,$sabors),
    "url"=>$arxius[$i][0],
    "nom"=>$possibleversio." " . $_possiblesabor . " " . $nomarquitectura,
    "arquitectura"=>$arquitectura,
    "latest"=>0,
  );
  $isos[]=$iso;
  
}
var_export($versions);



//Funcions auxiliars
function es64bits($cadena){
  $result = false;
  if (strpos($cadena,'64bits') !== false) {
    $result = true;
  }
  return $result;
}
function buscaIsos(){
  $arxius = array();
  $Directory = new RecursiveDirectoryIterator("./isos/");
  $It = new RecursiveIteratorIterator($Directory);
  $Regex = new RegexIterator($It,'/^.+\.iso$/i',RecursiveRegexIterator::GET_MATCH);
  foreach($Regex as $v){
    $arxius[]=$v;
  }
  return $arxius;
}


?>