<?php
$carpeta = "./isos";
$subcarpeta = "/releases";
$sufix = "_64bits";
$imatge="img/";
$versio_actual = "15.05";


$versions = array();
$sabors = array();
$sabors_complets = array();
$isos = array();



//ara mirem els idiomes
$_idiomes = buscaArxius('./lang',".php");
$llistat_idiomes = array();
for($i=0;$i<count($_idiomes);$i++){
  $nomidioma= basename($_idiomes[$i][0],'.php');
  $llistat_idiomes[]=$nomidioma;
}
//ara mirem quin idioma és el triat
$idioma_seleccionat = 'val'; //per defecte
if (isset($_GET["idioma"])){
   $_idioma = $_GET["idioma"];   
  if (file_exists('./lang/'.$_idioma. '.php')){
    $idioma_seleccionat=$_GET["idioma"];
  }
}
require_once('./lang/'.$idioma_seleccionat. '.php'); //les descripcions de la interfície en l'idioma corresponent estaran en $lang_array


//processem totes les isos per afegir-les al vector i tindre una base de dades
$arxius = buscaArxius("./isos/",".iso");
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
//ara creem la base de dades de sabors
for($i=0;$i<count($sabors);$i++){
  $sabors_complets[]=array(
    "codi"=>$i,
    "nom"=>$lang_array[$sabors[$i]."_nom"],
    "descripcio"=>$lang_array[$sabors[$i]],
    "img"=>$imatge."lliurex-".$sabors[$i].".png",  
    );  
}
$result = array(
  "sabors"=>$sabors_complets,
  "altres_versions"=>$lang_array["altres_versions"],
  "idioma_versions"=>$lang_array["versions"],
  "descarrega"=>$lang_array["descarrega"],
  "versio_actual"=>$versio_actual,
  "versions"=>$versions,
  "imatges"=>$isos,
);
echo json_encode($result);




//Funcions auxiliars
function es64bits($cadena){
  $result = false;
  if (strpos($cadena,'64bits') !== false) {
    $result = true;
  }
  return $result;
}
function buscaArxius($ruta,$filtre){
  $arxius = array();
  $Directory = new RecursiveDirectoryIterator($ruta);
  $It = new RecursiveIteratorIterator($Directory);  
  $Regex = new RegexIterator($It,'/^.+\\'.$filtre.'$/i',RecursiveRegexIterator::GET_MATCH);
  foreach($Regex as $v){
    $arxius[]=$v;
  }
  return $arxius;
}


?>