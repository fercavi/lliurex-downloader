<!DOCTYPE html>
<html lang="ca">
  <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <script>
      //inicialitzacio
      var versio_actual='15.05';
      var idioma_altres_versions='Altres versions';
      var idioma_versions = 'Versions';
      var idioma_descarrega = "Descarrega";
      var sabors=[
        {
        codi:0,
        nom:'LliureX Client',
        descripcio:'El LliureX Model de Centre (amb versió per a servidors i clients) amplia el tradicional model d&apos;aula. En el model d&apos;aula, les aules d&apos;informàtica formen una xarxa independent que disposa d&apos;un servidor a què es poden connectar tant estacions de treball com clients lleugers (clients). El nou model de centre, a més, permet la interconnexió de les diverses aules amb un servidor de centre.',
        img:'img/lliurex-client.png',          
       }
       ,
       {
       codi:1,
       nom:'Lliurex Escriptori',
       descripcio:'LliureX Escriptori és l&apos;adaptació de la distribució LliureX genèrica, dissenyada per als ordinadors personals, de la sala del professorat, secretaries, etc. És a dir, està destinada a instal·lar-se en els ordinadors que no depenen d&apos;un servidor (que no es troben dins de l&apos;aula d&apos;informàtica, o en la biblioteca...).',
       img:'img/lliurex-escriptori.png',
       },
      ];
      var arquitectures=[
       {
         codi:0,
         nom:'32 bits',
       },
       {
         codi:1,
         nom:'64 bits',
       },
       {
         codi:2,
         nom:'Raspberry',
        } 
      ]
      var versions=[
        "13.06",
        "14.06",
        "15.05",
      ];
      var imatges=[
        {
          versio:'13.06',
          sabor:0,
          url:'isos/13.06/releases/lliurex-client_1306.iso',
          nom:'13.06 latest',
          arquitectura:0,
          latest:1,
        },
        {
          versio:'13.06',
          sabor:0,
          url:'isos/13.06/releases/lliurex-client_1306_2.iso',
          nom:'13.06 vella',
          arquitectura:0,
          latest:0,
        },
        {
          versio:'13.06',
          sabor:0,
          url:'isos/13.06/eleases/lliurex-client_amd64_1306.iso',
          nom:'13.06 64 latest',
          arquitectura:1,
          latest:1,
        },
        {
          versio:'13.06',
          sabor:0,
          url:'isos/13.06/releases/lliurex-client_amd64_1306_2.iso',
          nom:'13.06 64 vella',
          arquitectura:1,
          latest:0,
        },        
        {          
          versio:'13.06',
          sabor:'1',       
          nom:'13.06 única',
          url :'isos/13.06/releases/lliurex-escriptori_1306.iso',
          arquitectura:0,
          latest:0,
        }
      ];
     //fi del bloc d'inicialització'
      function aplicarFiltreImatges(orige,filtre,valor){
        var imatgesFiltrades = [];
        for(var i=0;i<orige.length;i++){
          if (orige[i][filtre]==valor){
            imatgesFiltrades.push(orige[i]);
          }
        }
        return imatgesFiltrades;
      } 
      function descarrega(url){
        location.replace(url);
      }
      function mostraOpcionsDescarrega(versio,sabor){
        //arquitectura 0 =32 bits
        //arquitectura 1 = 64 bits
         //seleccionem totes les imatges de la versió i sabor corresponent
         var filtre = aplicarFiltreImatges(imatges,'versio',versio);
         filtre = aplicarFiltreImatges(filtre,'sabor',sabor);
         //l'unica cosa que falta ser'
         var filtre32bits=aplicarFiltreImatges(filtre,'arquitectura',0);         
         var filtre32bitslatest=aplicarFiltreImatges(filtre32bits,'latest',1);
         var filtre64bits=aplicarFiltreImatges(filtre,'arquitectura',1);
         var filtre64bitslatest=aplicarFiltreImatges(filtre64bits,'latest',1);
         var url32=filtre32bits[0].url;
         var url64=filtre64bits[0].url;
         //var html='<div id="menu"><div class="list-group panel"><a href="#" class="list-group-item active " data-parent="#menu" data-toggle="collapse" data-target="#d32bits">32 bits<span class="glyphicon glyphicon-save" onclick="descarrega(&apos;'+url32+'&apos;)"></span><span class="badge">'+filtre32bits.length+'</span></a>';         
         var html='<div id="menu"><div class="list-group panel"><a href="#" class="list-group-item active ">32 bits <span class="btn btn-info" onclick="descarrega(&apos;'+url32+'&apos;)" style="float:right;">'+idioma_descarrega+'<span class="glyphicon glyphicon-save"></span></span><span class="glyphicon glyphicon-plus" style="float:right" data-parent="#menu" data-toggle="collapse" data-target="#d32bits" ></span> </a>';
         html +="<div id='d32bits' class='sublinks collapse'>";
         for(var i=0;i<filtre32bits.length;i++){
          //html +='<a class="list-group-item " href="'+filtre32bits[i].url+'">'+filtre32bits[i].nom+'</a>';
          html +='<a class="list-group-item " href="#">'+filtre32bits[i].nom+'<span class="btn btn-info" onclick="descarrega(&apos;'+filtre32bits[i].url+'&apos;)" style="float:right">'+idioma_descarrega+'<span class="glyphicon glyphicon-save"></span></span></a>';
         }
         html +='</div>';
         html+='<div class="list-group panel"><a href="#" class="list-group-item active ">64 bits <span class="btn btn-info" onclick="descarrega(&apos;'+url64+'&apos;)" style="float:right;">'+idioma_descarrega+'<span class="glyphicon glyphicon-save"></span></span><span class="glyphicon glyphicon-plus" style="float:right" data-parent="#menu" data-toggle="collapse" data-target="#d64bits" ></span> </a>';
         html +="<div id='d64bits' class='sublinks collapse'>";
         for(var i=0;i<filtre64bits.length;i++){
          html +='<a class="list-group-item " href="#">'+filtre64bits[i].nom+'<span class="btn btn-info" onclick="descarrega(&apos;'+filtre64bits[i].url+'&apos;)" style="float:right">'+idioma_descarrega+'<span class="glyphicon glyphicon-save"></span></span></a>';
         }
         html+='</div></div></div>';

         
         BootstrapDialog.show({
                                    title:idioma_versions + " " + versio,
                                    message:html,
                                    buttons:[
                                      {
                                        label:'ok',
                                        action: function(dialogItself){                      
                                        dialogItself.close();
                                      }
                                    }]
                                    });
      }
      function creaHtmlSabors(versio){
            var html ="";
            for (var j=0;j<sabors.length;j++){
              html += "<div class='row'><div class='col-md-10 col-md-offset-1'><div class='panel panel-info'>";
              html += "<div class='panel-heading'>";
              html += "<h3 class='panel-title'>"+sabors[j].nom+"</h3>";
              html += "</div>";
              html += "<div class='panel-content'>";
              html +="<ul class='span5 clearfix'>";
              
              html +="<img src='"+sabors[j].img+"' class='pull-left span2 clearfix' style='margin-right:10px'/>";
              html += "<a onClick='mostraOpcionsDescarrega("+versio+","+sabors[j].codi+")' class='btn btn-primary icon  pull-right' style='margin-top:10px;margin-right:10px'>"+idioma_descarrega+"</a>";
              html +="<h4> <a href='#' >"+sabors[j].nom+"</a></h4><small>"+sabors[j].descripcio+"</small>";
              html +="</ul>";              
              html +="</div></div></div></div>";
            }          
            return html;
      }
      function seleccionaVersio(versio){        
        htmlVersions=creaHtmlSabors(versio);
        $('#contenedorEstructura').html(htmlVersions);
        //$( ".panel" ).draggable();
      }
      function carregaInicial(){
        var html='<div class="row"><div class="dropdown col-md-6 col-md-offset-1"><button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+idioma_altres_versions+'<span class="caret"></span>  </button>';
        html +='<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
        for(var i=0;i<versions.length;i++){
              html +='<li><a href="#" onClick="seleccionaVersio(&apos;'+versions[i]+'&apos;)">'+versions[i]+'</a></li>';
        }        
        html +='</ul></div></div>';                
        htmlVersions=creaHtmlSabors(versio_actual);        
        $('.container').html(html);
        $('#contenedorEstructura').html(htmlVersions);
        //$( ".panel" ).draggable();
      }
    </script>
    </head>
    
    
<body onLoad="carregaInicial()">
  <div class='container'><hr/></div>
  <div id='contenedorEstructura'></div>
<script src="js/jquery.min.js"></script>    
 <script src="js/bootstrap.min.js"></script>
 <script src="js/bootstrap-dialog.js"></script> 
 <!--script src="js/jqueryui/jquery-ui.js"></script-->
</body>
</html>