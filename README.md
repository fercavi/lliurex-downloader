## Introducció
lliurex-downloader és el descarregador genèric d'imatges iso de LliureX, es pot modificar fàcilment per a fer un gestor de descàrregues d'altre tipus. Consta de dos part, una client que mostrarà la informació, i un servidor que a partir dels arxius .iso i del nom de la ruta crearà les categories (sabors), versions, idiomes... 

## Dependències 
Depen de bootstrap, bootstrap-dialog i de jquery


## Funcionament 
### Client (index.php)
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
    
