## Introducció
lliurex-downloader és el descarregador genèric d'imatges iso de LliureX, es pot modificar fàcilment per a fer un gestor de descàrregues d'altre tipus. Consta de dos part, una client que mostrarà la informació, i un servidor que a partir dels arxius .iso i del nom de la ruta crearà les categories (sabors), versions, idiomes... 

## Dependències 
Depen de bootstrap, bootstrap-dialog i de jquery


## Funcionament 
### Client (lliurex-downloader.js)
Per a funcionar necessitarà que el servidor (servidor.php, es pot canviar en carregaInicial()) li passe les següents variables:
    altres_versions: text "altres versions"
    
    versio_actual: Versió actual si es disposa de diferents versions
    
    descarrega: text que apareixerà als botons de descàrrega
    
    idioma_versions: text "versions"
    
    idioma_mesopcions : text que apareixerà al botó per seleccionar més opcions
    
    imatges:vector de tots els arxius a abaixar, més avall s'explicarà
    
    sabors: vector de tots els sabors, més avant s'explicarà
    
    versions: llista de totes les versions disponibles
    
    A banda, la version carrega inicial rebrà tres paràmentres:
    
    contenedorglobal: classe del contenedor de la capçalera, per bootstrap recomanat que siga 'container'
    
    contenedorEstructura: identificador de les caixes on estaran tots els sabors a abaixar
    
#### vector sabors
el vector sabors serà un vector on cada element tindrà:
   
   nom: Nom del sabor (a l'idioma seleccionat)
   
   img: ruta de la imatge (podria ser una diferent per idioma, depen del servidor, això no està implementat)
   
   codi: codi del sabor per indentificar-lo
   
   descripcio: descripcio llarga(a l'idioma seleccionat)
#### vector imatges
el  vector d'imatges contindrà, entre altres coses les url per a abaixar:
    url: url del arxiu per abaixar
    
    arquitectura: senyala l'arquitectura, de moment 0: 32 bits, 1 :64 bits
    
    nom: nom genèric de la imatge
    
    nomarxiu: última part de la url, el nom complet de l'arxiu
    
#### Altres punts
En cas de no tindre imatges per a una arquitectura en el popup de l'arquitectura no apareixerà l'opció d'eixa arquitectura
Si un sabor no té cap imatge, no apareixerà eixe sabor al llistat
Els idiomes s'han d'afegir a mà a l'array conversioidiomes, per exemple, si vullguerem angles, hauriem d'efegir una entrada (per exemple {codi:'eng',nom:'English'})

#### Inicialització
Es proporciona un arxiu d'inicialització d'exemple, index.php, amb una funció que diferencia entre valencià i espanyol, amb les etiquetes script, div... necessàries per fer-lo funcionar:
```javascript
...
<script>  
        function getIdioma(){
        var idioma= 'val',
        language = window.navigator.userLanguage || window.navigator.language;
        if (language.search('es-')!=-1)
          idioma='cas';
        return idioma;
        }
  
</script>
    

<body onLoad="carregaInicial('container','contenedorEstructura',getIdioma())">

  <div class='container'><hr/></div>
  <div id='contenedorEstructura'></div>
  ...
```
###servidor
####Imatges
El servidor bàsicament recorrerà un directori buscant tots els arxius .iso, i a partir de la ruta extraurà versions i sabors. Afegirà manualment MD5SUM i berry. Ordenarà les versions per nombre.
####Idiomes
Per a saber en quin idioma es vol els textos, el sistema agarrarà el valor $_GET["idioma"], i buscarà dins de la carpeta "./lang" l'arxiu "lang/idioma.php (per exemple lang/val.php per a valencià), que contindrà els textos corresponents a l'array  $lang_array.php
per exemple, per a valencià:

```php

$lang_array = array(
  "client_nom"=>"Client",
  "client"=>"El LliureX Model de Centre (amb versió per a servidors i clients) amplia el tradicional model d'aula. En el model d'aula, les aules d'informàtica formen una xarxa independent que disposa d'un servidor a què es poden connectar tant estacions de treball com clients lleugers (clients). El nou model de centre, a més, permet la interconnexió de les diverses aules amb un servidor de centre. ",
  "escriptori_nom"=>"LliureX Escriptori",
  "escriptori"=>"LliureX Escriptori és l'adaptació de la distribució LliureX genèrica, dissenyada per als ordinadors personals, de la sala del professorat, secretaries, etc. És a dir, està destinada a instal·lar-se en els ordinadors que no depenen d'un servidor (que no es troben dins de l'aula d'informàtica, o en la biblioteca...).",
  "infantil_nom"=>"LliureX Infantil",
  "infantil"=>"LliureX Infantil és l'adaptació LliureX per als nivells educatius d'Infantil i primers cursos de Primària.",
  "musica_nom"=>"LliureX Música",
  "musica"=>"LliureX Música és l'adaptació LliureX per als equips multimèdia, amb necessitats de programari específic, d'àudio, vídeo i multimèdia.",
  "pime_nom"=>"LliureX Pime",
  "pime"=> "LliureX Pime és una adaptació qus'ha desenvolupat per al seu ús en pimes i en cicles formatius. Inclou una selecció d'aplicacions adaptades a l'entorn empresarial i s'han eliminat els programes orientats als nivells educatius d'infantil, primària i secundària, així com les aplicacions de suport a la docència. És per estos motius que el Lliurex-Pime és un bon candidat per a aquelles pimes que desitgen iniciar-se en el programari lliure, especialment per a les de la Comunitat Valenciana, ja que l'entorn està traduït al valencià i al castellà, com en la resta d'adaptacions del LliureX.",
  "servidor_nom"=>"Servidor",
  "servidor"=>"El LliureX Model de Centre (amb versió per a servidors i clients) amplia el tradicional model d'aula. En el model d'aula, les aules d'informàtica formen una xarxa independent que disposa d'un servidor a què es poden connectar tant estacions de treball com clients lleugers (clients). El nou model de centre, a més, permet la interconnexió de les diverses aules amb un servidor de centre.",  
  "lleuger"=>"LliureX Lleuger és l'adaptació de la distribució LliureX amb uns requeriments de maquinari menors i que, per tant, permet la reutilització d'equipament de baix rendiment que no complix els requisits mínims per a la utilització com a estació de treball independent LliureX Escriptori (Desktop).",
  "lleuger_nom"=> "LliureX Lleuger",
  "baixa"=>"Baixa",  
  "altres_versions"=>"Altres Versions",
  "versions"=>"versions",
  "descarrega"=>"descàrrega",
  "mesopcions"=>"Més opcions",
  "berry"=>"Imatge de client lleuger per a Raspberry",
  "berry_nom"=>"LliureX Berry",
);
```
