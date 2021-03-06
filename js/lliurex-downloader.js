      //inicialitzacio
      var versio_actual='';//'15.05';
      var idioma_altres_versions='';//'Altres versions';
      var idioma_versions = '';//'Versions';
      var idioma_descarrega = '';//"Descarrega";
      var idioma_mesopcions = '';
      var idioma_versions_anteriors = '';
      var versio_processada;            
      var llistat_idiomes = [];
      var versions = [];
      var imatges = [];
      var idiomes = [];
      var _contenedor;
      var _contenedorEstructura;
      var versions_velles=[];
      var versions_velles_imatges=[];
      var dialegVersioVella;
      var tipusImatgesNormals = 0 ;
      var tipusImatgesVelles = 1;
      //caldrà afegir-los segons vagen incrementant-se els idiomes
      var conversioidiomes = [
        {
          codi:'val',
          nom:'Valencià',
        },
        {
          codi:'cas',
          nom:'Castellano',
        }
      ];
      function codiIdiomaAnom(codi){
        var nom='';
        for(var i=0;(i<conversioidiomes.length)&&(nom=='');i++){
          if(conversioidiomes[i].codi==codi)
            nom=conversioidiomes[i].nom;
        }        
        return nom;
      }
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
      function mostraOpcionsDescarrega(versio,sabor,tipus){
        //arquitectura 0 =32 bits
        //arquitectura 1 = 64 bits
         //seleccionem totes les imatges de la versió i sabor corresponent
         //segons el tipus elegim les imatges normals o les obsoletes (old_versions)
         _imatges = imatges;
         if (tipus==tipusImatgesVelles)
          _imatges = versions_velles_imatges;
         var filtre = aplicarFiltreImatges(_imatges,'versio',versio);
         filtre = aplicarFiltreImatges(filtre,'sabor',sabor);
         //l'unica cosa que falta ser'
         var filtre32bits=aplicarFiltreImatges(filtre,'arquitectura',0);         
         var filtre32bitslatest=aplicarFiltreImatges(filtre32bits,'latest',1);
         var filtre64bits=aplicarFiltreImatges(filtre,'arquitectura',1);
         var filtre64bitslatest=aplicarFiltreImatges(filtre64bits,'latest',1);
         //si no hi ha latest posem la primera
         if (filtre32bitslatest.length>0)
           url32=filtre32bitslatest[0].url;
         else
           if(filtre32bits.length>0)
              url32 = filtre32bits[0].url;
            else
              url32 = '';
          
        if (filtre64bitslatest.length>0)
           url64=filtre64bitslatest[0].url;
        else
           if(filtre64bits.length>0)
            url64=filtre64bits[0].url;         
          else
            url64 = '';
         var html='<div id="menu"><div class="list-group panel"><a href="#" class="list-group-item active ">32 bits <span style="border-radius:10px;float:right;position:relative;bottom:7px" class="btn btn-info" onclick="descarrega(&apos;'+url32+'&apos;)">'+idioma_descarrega+'&nbsp;<span class="glyphicon glyphicon-save"></span></span><span style="border-radius:10px;float:right;bottom:7px;position:relative" class="btn btn-info" data-parent="#menu" data-toggle="collapse" data-target="#d32bits" ">'+idioma_mesopcions+'&nbsp;<span class="glyphicon glyphicon-plus"></span> </span></a>';
         html +="<div id='d32bits' class='sublinks collapse'>";
         for(var i=0;i<filtre32bits.length;i++){          
          html +='<a class="list-group-item " href="#">'+filtre32bits[i].nom+'('+filtre32bits[i].nomarxiu+')<span  class="btn btn-info" onclick="descarrega(&apos;'+filtre32bits[i].url+'&apos;)" style="float:right;border-radius:10px;position:relative;vertival-align:middle;bottom:7px">'+idioma_descarrega+'&nbsp;<span class="glyphicon glyphicon-save"></span></span></a>';
         }
         html +='</div>';
         if(filtre64bits.length>0){
           //html+='<div class="list-group panel"><a href="#" class="list-group-item active ">64 bits <span class="btn btn-info" onclick="descarrega(&apos;'+url64+'&apos;)" style="float:right;border-radius:10px">'+idioma_descarrega+'&nbsp;<span class="glyphicon glyphicon-save"></span></span><span class="glyphicon glyphicon-plus" style="float:right" data-parent="#menu" data-toggle="collapse" data-target="#d64bits" ></span> </a>';
           html+='<div id="menu"><div class="list-group panel"><a href="#" class="list-group-item active ">64 bits <span style="border-radius:10px;float:right;position:relative;bottom:7px" class="btn btn-info" onclick="descarrega(&apos;'+url64+'&apos;)">'+idioma_descarrega+'&nbsp;<span class="glyphicon glyphicon-save"></span></span><span style="border-radius:10px;float:right;bottom:7px;position:relative" class="btn btn-info" data-parent="#menu" data-toggle="collapse" data-target="#d64bits" ">'+idioma_mesopcions+'&nbsp;<span class="glyphicon glyphicon-plus"></span> </span></a>';
           html +="<div id='d64bits' class='sublinks collapse'>";
           for(var i=0;i<filtre64bits.length;i++){
            html +='<a class="list-group-item " href="#">'+filtre64bits[i].nom+'('+filtre64bits[i].nomarxiu+')<span class="btn btn-info" style="border-radius:10px;float:right;position:relative;bottom:7px" onclick="descarrega(&apos;'+filtre64bits[i].url+'&apos;)" >'+idioma_descarrega+'&nbsp;<span class="glyphicon glyphicon-save"></span></span></a>';
           }
         html+="</div>";
         html+="</div>";
         }
         html+='</div></div>';

         
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
      function creaHtmlSabors(_imatges,versio,tipus){
            var html ="";
            var filtreVersio = aplicarFiltreImatges(_imatges,'versio',versio);                        
            for (var j=0;j<sabors.length;j++){                          
              var filtreSabor = aplicarFiltreImatges(filtreVersio,"sabor",sabors[j].codi);   
              if (filtreSabor.length>0){
                html += "<div class='row'><div class='col-md-10 col-md-offset-1'><div class='panel panel-info'>";
                html += "<div class='panel-heading'>";
                html += "<h3 class='panel-title'>"+sabors[j].nom+"</h3>";
                html += "</div>";
                html += "<div class='panel-content'>";
                html +="<ul class='span5 clearfix'>";
                
                html +="<img src='"+sabors[j].img+"' class='pull-left span2 clearfix' style='margin-right:10px'/>";
                html += "<a onClick='mostraOpcionsDescarrega(&apos;"+versio+"&apos;,"+sabors[j].codi+","+tipus+")' class='btn btn-primary icon  pull-right' style='margin-top:10px;margin-right:10px'>"+idioma_descarrega+"</a>";
                html +="<h4> <a href='#' >"+sabors[j].nom+"</a></h4><small>"+sabors[j].descripcio+"</small>";
                html +="</ul>";              
                html +="</div></div></div></div>";
              }
            }          
            return html;
      }
      function seleccionaVersio(versio){    
        $('#menuAltresVersions').removeClass('disabled');
        $('ul li ').removeClass('disabled');
        $('#menu'+versio.replace(".","_")).addClass('disabled');
        htmlVersions=creaHtmlSabors(imatges,versio,tipusImatgesNormals);
        versio_processada=versio;
        $('#'+_contenedorEstructura).html(htmlVersions);
        $('#h1versiolliurex').html('LliureX '+versio_processada);
      }
      function carregaInicial(contenedorglobal, contenedorEstructura,idiomaACarregar='val'){
        _contenedor = contenedorglobal;
        _contenedorEstructura = contenedorEstructura;
        var peticio={
          url:'servidor.php',
          type:'get',
          data:'idioma='+idiomaACarregar,
          success:function(result){                   
            data = JSON.parse(result);                
            sabors = data.sabors;
            idioma_altres_versions=data.altres_versions,
            versio_actual = data.versio_actual,
            versio_processada=versio_actual,
            idioma_descarrega = data.descarrega,
            idioma_versions = data.idioma_versions,
            idioma_selecciona_versio=data.idioma_selecciona_versio;
            idioma_mesopcions = data.mes_opcions;            
            idioma_versions_anteriors = data.idioma_versions_anteriors;
            versions = data.versions;
            versions_velles= data.versions_velles;
            versions_velles_imatges=data.versions_velles_imatges;
            imatges = data.imatges;
            idiomes = data.idiomes;            
            carregaInicialCallback(idiomaACarregar);
          }
        }
        $.ajax(peticio);
      }
      function carregaIdioma(codiidioma){      
        carregaInicial(_contenedor,_contenedorEstructura,codiidioma);        
      }
      function seleccionaVersioVella(versioVella){        
        var htmlVersions= creaHtmlSabors(versions_velles_imatges,versioVella,tipusImatgesVelles);        
        $('#'+_contenedorEstructura).html(htmlVersions);
        $('#h1versiolliurex').html('LliureX '+versioVella);
        dialegVersioVella.close();
      }
      function mostraPopUpSeleccioAltresVersions(){
        $('ul li ').removeClass('disabled');
        $('#menuAltresVersions').addClass('disabled');
        var html="<div class='list-group'>";
        for(var i=0;i<versions_velles.length;i++){
           html+="<button type='button' class='list-group-item' onClick='seleccionaVersioVella(&apos;"+versions_velles[i]+"&apos;)'>"+versions_velles[i]+"</button>";
        }
        html +='</div>';
        BootstrapDialog.show({
               title:idioma_selecciona_versio,
               message:html,
               buttons:[
                    {
                      label:'ok',
                      action: function(dialogItself){                      
                      dialogItself.close();
                   }
               }],
               onshow: function(dialegItself){
                dialegVersioVella = dialegItself;
               },
        });      
      }
      function carregaInicialCallback(idiomaACarregar){
        var html='<div class="row"><div class="col-md-3"><span id="h1versiolliurex" class="h1">LliureX '+versio_processada+'</span></div>';
        var htmlIdiomes = '<div id="llistatIdiomes" class="col-md-6 col-md-offset-0"></div>';        
        var htmlAltresVersions = '<div class="dropdown col-md-3"><button style="color:#777" class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+idioma_altres_versions+'<span class="caret"></span>  </button>';
        htmlAltresVersions +='<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
        for(var i=0;i<versions.length;i++){
              htmlAltresVersions +='<li id="menu'+versions[i].replace(".","_")+'"><a href="#" onClick="seleccionaVersio(&apos;'+versions[i]+'&apos;)">'+versions[i]+'</a></li>';
        }        
        htmlAltresVersions +="<li id='menuAltresVersions'><a href='#' onClick='mostraPopUpSeleccioAltresVersions()'>"+idioma_versions_anteriors+"</a></li>";
        htmlAltresVersions +='</ul></div>';        
        html += htmlAltresVersions + htmlIdiomes; 
        html +='</div>';
        
        htmlVersions=creaHtmlSabors(imatges,versio_actual,tipusImatgesNormals);        
        $('.'+_contenedor).html(html);
        $('#'+_contenedorEstructura).html(htmlVersions);
        var htmlIdiomes = "<ul class='nav nav-pills'>";
        for(var i=0;i<conversioidiomes.length;i++){
          var HTMLdisabled = '';                    
          if (conversioidiomes[i].codi==idiomaACarregar)
            HTMLdisabled = " class='disabled' " ;          
          htmlIdiomes +="<li role='presentation'  id='idioma_"+conversioidiomes[i].codi+"'"+HTMLdisabled+" onclick='carregaIdioma(&apos;"+conversioidiomes[i].codi+"&apos;)' ><a href='#'>&nbsp;"+codiIdiomaAnom(conversioidiomes[i].codi)+"</a></li>";
        }
        htmlIdiomes +='</ul>';        
        $('#llistatIdiomes').html(htmlIdiomes);        

      }