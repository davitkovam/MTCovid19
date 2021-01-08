<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<title>COVID-19 Regije</title>
<script src="https://d3js.org/d3.v6.min.js"></script>
<script src="https://d3js.org/d3-selection-multi.v1.min.js"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="https://d3js.org/topojson.v2.min.js"></script>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v0.min.js"></script>



<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://d3js.org/d3.v4.min.js"></script>
  

</head>

<body>

            <?php
            use App\Http\Controllers\EntryController;
            use App\Http\Controllers\NijzArrayController;
            use App\Http\Controllers\PopulationController;
            use App\Http\Controllers\SvetController;
            $niza=EntryController::getDictionary();
            $regioni=EntryController::getRegions();
            $dati = EntryController::getDates();
            $zemji=SvetController::getIsos();
            $tabelaSvet=SvetController::getTable();
            $tabelaSvetSmrt=SvetController::getTableDeaths();
            $tabelaSvetSmrtTocno=SvetController::getTableActualDeaths();
            $tabelaSvetSlucaiTocno=SvetController::getTableActualCases();?>
            <script>var reg=[];<?php
            foreach ($regioni as $r):
              ?>reg.push("<?php echo ($r)?>");
              <?php              
            endforeach;
            ?>
            var dat=[];<?php
            foreach ($dati as $d):
              ?>dat.push("<?php echo ($d)?>");
              <?php
            endforeach;
            ?>

            var doDataSmrt={};
            <?php
            foreach($dati as $d):
              ?>doDataSmrt["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                doDataSmrt["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (EntryController::getSmrti( $r, $d)); ?>/"<?php echo PopulationController::regija($r);?>";
                <?php
              endforeach;
            endforeach;
            ?>

            var doDataSmrtActual={};
            <?php
            foreach($dati as $d):
              ?>doDataSmrtActual["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                doDataSmrtActual["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (EntryController::getSmrti( $r, $d)); ?>;
                <?php
              endforeach;
            endforeach;
            ?>

          var grafSlucai={};
            <?php
            foreach($dati as $d):
              ?>grafSlucai["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                grafSlucai["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (NijzArrayController::getCasesOnDateInRegion($niza, $d, $r)); ?>;
                <?php
              endforeach;
            endforeach;
            ?>


            var doDataSlucai={};
            <?php
            foreach($dati as $d):
              ?>doDataSlucai["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                doDataSlucai["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (NijzArrayController::getCasesUntilDateInRegion($niza, $d, $r)); ?>/"<?php echo PopulationController::regija($r);?>";
                <?php
              endforeach;
            endforeach;
            ?>

          var doDataSlucaiActual={};
            <?php
            foreach($dati as $d):
              ?>doDataSlucaiActual["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                doDataSlucaiActual["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (NijzArrayController::getCasesUntilDateInRegion($niza, $d, $r)); ?>;
                <?php
              endforeach;
            endforeach;
            ?>



            var zem=[];<?php
            foreach ($zemji as $d):
              ?>zem.push("<?php echo ($d)?>");
              <?php
            endforeach;
            ?>  
             var svetActual={};

            <?php
            foreach($tabelaSvetSlucaiTocno as $niza):?>
              if(!("<?php echo ($niza[1]); ?>" in svetActual))
              {
                svetActual["<?php echo ($niza[1]); ?>"]={};
              }
              svetActual["<?php echo ($niza[1]); ?>"] ["<?php echo ($niza[0]); ?>"] = <?php echo ($niza[2]); ?>;<?php
            endforeach;
            ?>

            var svetSmrt={};

            <?php
            foreach($tabelaSvetSmrt as $niza):?>
              if(!("<?php echo ($niza[1]); ?>" in svetSmrt))
              {
                svetSmrt["<?php echo ($niza[1]); ?>"]={};
              }
              svetSmrt["<?php echo ($niza[1]); ?>"] ["<?php echo ($niza[0]); ?>"] = <?php echo ($niza[2]); ?>;<?php
            endforeach;
            ?>


            var svetSmrtActual={};

            <?php
            foreach($tabelaSvetSmrtTocno as $niza):?>
              if(!("<?php echo ($niza[1]); ?>" in svetSmrtActual))
              {
                svetSmrtActual["<?php echo ($niza[1]); ?>"]={};
              }
              svetSmrtActual["<?php echo ($niza[1]); ?>"] ["<?php echo ($niza[0]); ?>"] = <?php echo ($niza[2]); ?>;<?php
            endforeach;
            ?>
                        



            var svet={};

            <?php
            foreach($tabelaSvet as $niza):?>
              if(!("<?php echo ($niza[1]); ?>" in svet))
              {
                svet["<?php echo ($niza[1]); ?>"]={};
              }
              svet["<?php echo ($niza[1]); ?>"] ["<?php echo ($niza[0]); ?>"] = <?php echo ($niza[2]); ?>;<?php
            endforeach;
            ?>

            var grafSmrti={};
            for(var i=0;i<dat.length;i++)
            {
              grafSmrti[dat[i]]={};
              for(var j=0;j<reg.length;j++)
              {
                if(i==0)
                {
                  grafSmrti[dat[i]][reg[j].toUpperCase()]=doDataSmrtActual[dat[i]][reg[j].toUpperCase()];
                }
                else
                {
                  grafSmrti[dat[i]][reg[j].toUpperCase()]=doDataSmrtActual[dat[i]][reg[j].toUpperCase()]-doDataSmrtActual[dat[i-1]][reg[j].toUpperCase()];
                }
                
              }
            }



            var currNizaSvet=svet;
            var currNizaSlo=doDataSlucai;
            var currNizaGraf=grafSlucai;


            function lineGraph()
            {
              d3.selectAll('#graf').remove();
                
                yScale = d3.scaleLinear()
              .domain([0, Grafmax(currNizaGraf)])
              .range([visina/2.6, 0]);

              yAxis = d3.axisRight(yScale);

              line = d3.line()
            .x(function(d, i) { return xScale(i); }) 
            .y(function(d) { return yScale(d.y); }) 
            .curve(d3.curveMonotoneX);

                for (let i = 0; i < dat.length; i++) {
                  tabela[i] = i; 
                };

                
                for (let index = 0; index < tabela.length; index++) {
                  const element = tabela[index];
                  dataseter2[index] = { "y": funkcijaDobi(element) };
                }

                svg.append("path")
                    .datum(dataseter2)
                    .attr("id", "graf") 
                    .attr("class", "line") 
                    .attr("d", line);  

                svg.selectAll(".dot")
                    .data(dataseter2)
                  .enter().append("circle") 
                    .attr("class", "dot")
                    .attr("id", "graf") 
                    .attr("cx", function(d, i) { return xScale(i) })
                    .attr("cy", function(d) { return yScale(d.y) })
                    .attr("r", 2);


            }


            function Grafmax(niza)
            {
              var m=0;
              for(var i=0;i<reg.length;i++)
              {
                for(var j=0; j<dat.length;j++)
                {
                  m=Math.max(m, niza[dat[j]][reg[i].toUpperCase()]);
                }
              }
              return m;
              
            }

           

            function funkcijaDobi(d) { 
                var v = d;
                var dd = dat[v];
                var datt = currNizaGraf[dd]["VKUPNO"];
                return datt;  
            }
            
              

              var co_values={};
              var minis=-1;
              var maxis=-1;

              var slucai={};
              var printi={};
              var maxi=-1;
              var mini=-1;
              var reg_values={};


            function setupSvet(svet)
            {
              var minis=-1;
              var maxis=-1;
              for (iso in svet[currData])
              {
                if(iso !="AND" && iso !="SMR" && iso !="VAT" && iso !="BHR" && iso !="OWID_WRL" )
                {
                  if(maxis<svet[currData][iso] )
                  {
                    maxis=svet[currData][iso];
                  }
                  if(minis==-1 || minis>svet[currData][iso])
                  {
                    minis=svet[currData][iso];
                  }
                }
               
              }
            var razlikas=(maxis-minis)/5.0;
            for (var i=0; i<zem.length; i++)
              {
               if(parseFloat(svet[currData][zem[i].toUpperCase()])<=(parseFloat(minis)+0.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="#6EBD45";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+1.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="#E7D93B ";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+2.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="#F2A013";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+3.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="#C53030";
                }
                else if(svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+5*parseFloat(razlikas)))
                {
                   co_values[zem[i].toUpperCase()]="#1B262C";
                }
                else  
                {
                  co_values[zem[i].toUpperCase()]="#6EBD45";//"#1B262C";
                }
              }
              
            } 
            /*
            
            var totalCases = [];
            var totalCasesPerMilion = [];
            var totalDeaths = [];
            var totalDeathsPerMilion = [];
            var milijon = 1000000;

            for (let i = 0; i < dat.length; i++) {
              var datumm = dat[i];
              var steviloOkuzenihDoTegaDatuma =currNizaSlo[datumm]["VKUPNO"];
              totalCases[i] = steviloOkuzenihDoTegaDatuma;
              totalCasesPerMilion[i] = (steviloOkuzenihDoTegaDatuma)/milijon;
              var steviloMrtvihDoTegaDatuma = doDataSmrt[datumm]["VKUPNO"];
              totalDeaths[i] = steviloMrtvihDoTegaDatuma;
              totalDeathsPerMilion[i] = (steviloMrtvihDoTegaDatuma)/milijon;
            }

*/
            
              var tabela = [];
                var dataseter2 = [];

            function setupSlo(slucai){
              maxi=-1;
              mini=-1;
        
              <?php
              foreach($regioni as $r ):
              if($r!="Tujina" and $r!="Vkupno"):
              ?> 
                
                
                if(maxi<slucai[currData]["<?php echo(strtoupper($r)); ?>"])
                {
                  maxi=slucai[currData]["<?php echo(strtoupper($r)); ?>"];
                }
                if(mini==-1 || mini>slucai[currData]["<?php echo(strtoupper($r)); ?>"])
                {
                  mini=slucai[currData]["<?php echo(strtoupper($r)); ?>"];
                }
                
                
              <?php
              endif;
              endforeach;
              ?>
            
              var razlika=(maxi-mini)/5.0;
            
            
              for (var i=0; i<reg.length; i++)
              {
                  if(slucai[currData][reg[i].toUpperCase()]<=(parseFloat(mini)+parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#6EBD45";
                  }
                  else if (slucai[currData][reg[i].toUpperCase()]<=(parseFloat(mini)+2*parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#E7D93B ";
                  }
                  else if (slucai[currData][reg[i].toUpperCase()]<=(parseFloat(mini)+3*parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#F2A013 ";
                  }
                  else if (slucai[currData][reg[i].toUpperCase()]<=(parseFloat(mini)+4*parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#C53030 ";
                  }
                  else 
                  {
                    reg_values[reg[i].toUpperCase()]="#1B262C";
                  }
                  
              }
          }
          function getCases1(datum) {    
            var dan = formatDateDrugi(datum);
            var dd = currNizaSlo[dan]["VKUPNO"];
            return dd;
          }

          function formatDateDrugi(date) {
              var d = new Date(date),
                  month = '' + (d.getMonth() + 1),
                  day = '' + d.getDate(),
                  year = d.getFullYear();
                  ura = '00:00:00';

              if (month.length < 2) 
                  month = '0' + month;
              if (day.length < 2) 
                  day = '0' + day;

              var vrni = [year, month, day].join('-');
              var skupaj = [vrni , ura].join(' ');
              return skupaj;
          }

          function smeniNiza(sto) {
            var promeneto=false;
            var promenetoGraf=false;
              if(sto=="casesMil"&& currNizaSvet!=svet)
              {
                currNizaSvet=svet;
                currNizaSlo=doDataSlucai;
                if(currNizaGraf!=grafSlucai)
                {
                  currNizaGraf=grafSlucai;
                  promenetoGraf=true;
                }
                 promeneto=true;

              }
              else if(sto=="cases"&& currNizaSvet!=svetActual)
              {
                currNizaSvet=svetActual;
                currNizaSlo=doDataSlucaiActual;
                if(currNizaGraf!=grafSlucai)
                {
                  currNizaGraf=grafSlucai;
                  promenetoGraf=true;
                }
                promeneto=true;

              }
              else if(sto=="smrt"&& currNizaSvet!=svetSmrt)
              {
                currNizaSvet=svetSmrt;
                currNizaSlo=doDataSmrt;
                if(currNizaGraf!=grafSmrti)
                {
                  currNizaGraf=grafSmrti;
                  promenetoGraf=true;
                }
                promeneto=true;
              }
              else if(sto=="smrtMil"&& currNizaSvet!=svetSmrtActual)
              {
                currNizaSvet=svetSmrtActual;
                currNizaSlo=doDataSmrtActual;
                if(currNizaGraf!=grafSmrti)
                {
                  currNizaGraf=grafSmrti;
                  promenetoGrafi=true;
                }
                promeneto=true;
              }
              if(promeneto)
              {
                setupSvet(currNizaSvet);
                setupSlo(currNizaSlo);
                if(promenetoGraf)
                {
                   lineGraph();
                }


                d3.selectAll("path").filter(function(d){try{a =  d.properties.hasOwnProperty("ISO_A3");} catch{return false;} return d.properties.hasOwnProperty("ISO_A3");})
               .attr("fill",function(d){
              if(d.properties.ISO_A3 !=null)
              {
                if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
              
              }
              
            })
            .attr("stroke", function(d){
              if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
              
            });
            d3.selectAll("path").filter(function(d){try{a =  d.properties.hasOwnProperty("region");} catch{return false;} return d.properties.hasOwnProperty("region");})
                  .attr("fill", function(d){
                    if(d.properties.region !=null )
                    {
                      return reg_values[d.properties.region.toUpperCase()];
                    }
                    else
                    {
                      d.properties.region=d.properties.name;
                      return reg_values[d.properties.name.toUpperCase()];
                    }
                    
                  })
                  .attr("stroke",function(d){
                    if(d.properties.region !=null)
                    {
                      return reg_values[d.properties.region.toUpperCase()];
                    }
                    else
                    {
                      d.properties.region=d.properties.name;
                      return reg_values[d.properties.name.toUpperCase()];
                    }
                    
                  }); 
              }
          }
          
          </script>






<link rel="stylesheet" href="<?php echo asset('style.css')?>" type="text/css"> 


<div class="halfpage">
  <div class="kopcinja text-center">
  <h1>COVID-19</h1>
<div class="buttons">
		<button name="submit" class="action_btn submit" type="submit" value="cases" onclick="smeniNiza(this.value)">Total Cases</button>
		<button name="submit" class="action_btn cancel" type="submit" value="casesMil" onclick="smeniNiza(this.value)">Total Cases Per Million</button>
    <button name="submit" class="action_btn submit" type="submit" value="smrt" onclick="smeniNiza(this.value)">Total Deaths</button>
		<button name="submit" class="action_btn cancel" type="submit" value="smrtMil" onclick="smeniNiza(this.value)">Total Deaths Per Million</button>
</div>
  
  <p id="zaData">For date: </p>
  <div class="slidecontainer">
    <input type="range" min=0 max=200 value=200 class="slider" id="myRange">
  </div>

      <script>
      var slider = document.getElementById("myRange");
      var zaData = document.getElementById("zaData");
      slider.max=dat.length-1;
      slider.value=dat.length-1;
      var currData=dat[slider.value];
      zaData.innerHTML = "For date: "+currData;
      var output = slider.value;


      slider.oninput = function() {
        output = this.value;
        currData=dat[slider.value];
        zaData.innerHTML = "For date: "+currData;  
        setupSlo(currNizaSlo);
        setupSvet(currNizaSvet);




        d3.selectAll("path").filter(function(d){try{a =  d.properties.hasOwnProperty("region");} catch{return false;} return d.properties.hasOwnProperty("region");})
                  .attr("fill", function(d){
                    if(d.properties.region !=null )
                    {
                      return reg_values[d.properties.region.toUpperCase()];
                    }
                    else
                    {
                      d.properties.region=d.properties.name;
                      return reg_values[d.properties.name.toUpperCase()];
                    }
                    
                  })
                  .attr("stroke",function(d){
                    if(d.properties.region !=null)
                    {
                      return reg_values[d.properties.region.toUpperCase()];
                    }
                    else
                    {
                      d.properties.region=d.properties.name;
                      return reg_values[d.properties.name.toUpperCase()];
                    }
                    
                  }); 



        d3.selectAll("path").filter(function(d){try{a =  d.properties.hasOwnProperty("ISO_A3");} catch{return false;} return d.properties.hasOwnProperty("ISO_A3");})
            .attr("fill",function(d){
              if(d.properties.ISO_A3 !=null)
              {
                if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
              
              }
              
            })
            .attr("stroke", function(d){
              if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
              
            });
      
      
      }</script>
</div>
</div>
<div class="pagee">
<div class="legenda  text-center">
<b><p>Št. okuženih </p></b>
<b><p style="color: black;">> 1350</p></b>
<b><p style="color: red;">< 1350</p></b>
<b><p style="color: orange;">< 1000</p></b>
<b><p style="color: yellow;">< 600</p></b>
<b><p style="color: green;">< 300</p></b>
</div>
<div class="page first jumbotron text-center page" style="margin-bottom:0">
<h1>Slovenija</h1>
<p>Število primervo po regijah</p>
<br>
  

<script>
  setupSlo(currNizaSlo);


  var width = 900;
  var height = 500;
  var x=100;
  var canvas = d3.select(".first")
          .append("svg")
            .attr("width", width)
            .attr("height", height)
            .attr("class","prvi");
  
 
  d3.json("regional.geojson", function(data) {
  
  
    var group = canvas.selectAll("g")
          .data(data.features)
          .enter()
          .append("g");
          
    var projection = d3.geoMercator()
              .center(d3.geoCentroid(data))
              .scale(7000)
              .translate([width/2, height/2]);
    
    var path = d3.geoPath().projection(projection);
    
    var areas = group.append("path")
            .attr("d", path)
            .attr("fill",function(d){
              if(d.properties.region !=null)
              {
                return reg_values[d.properties.region.toUpperCase()];
              }
              else
              {
                d.properties.region=d.properties.name;
                return reg_values[d.properties.name.toUpperCase()];
              }
              
            })
            .attr("stroke",function(d){
              if(d.properties.region !=null)
              {
                return reg_values[d.properties.region.toUpperCase()];
              }
              else
              {
                d.properties.region=d.properties.name;
                return reg_values[d.properties.name.toUpperCase()];
              }
              
            });

  group.append("text")
      .attr("x", 50)
      .attr("y", 50);

  var div = d3.select("body").append("div")   
    .attr("class", "tooltip")               
    .style("opacity", 0);

  areas.on("mouseover", function(d) {
    
         var myRegion = d.properties.region;
        d3.selectAll("path").filter(function(d) { try{a = d.properties.region;} catch{return false;} return  d.properties.region == myRegion; })
          .attr("fill", "lightGray");
        div.transition()		
            .duration(200)		
            .style("opacity", .9) ;
        div.html((d.properties.region.replace("_", " ")+" - "+currNizaSlo[currData][d.properties.region.toUpperCase()]))
          .style("left", (d3.event.pageX - 20) + "px")
          .style("top", (d3.event.pageY + 6) + "px");
      })
      .on("mouseout", function(d) {
        var myRegion = d.properties.region;
        d3.selectAll("path").filter(function(d) {  try{a = d.properties.region;} catch{return false;} return   d.properties.region == myRegion; })
          .attr("fill", function(){
            if(d.properties.region !=null)
            {
              return reg_values[d.properties.region.toUpperCase()];
            }
            else
            {
              d.properties.region=d.properties.name;
              return reg_values[d.properties.name.toUpperCase()];
            }
            
          })
          div.transition()		
              .duration(200)		
              .style("opacity", 0)	  
          div.html((d.properties.region.replace("_", " ")+" - "+currNizaSlo[currData][d.properties.region.toUpperCase()]))
            .style("left", (d3.event.pageX - 20) + "px")
            .style("top", (d3.event.pageY + 6) + "px");
      });
  });

</script>
</div>

<div class="page third jumbotron text-center page" style="margin-bottom:0">
<h1>Svet</h1>
<p>Število primerov po državah</p>
 


 <script>
 
  
  setupSvet(currNizaSvet);
  var width = 990;
  var height = 500;
  var scale1 = 90;
  var x=200;


  var canvas1 = d3.select(".third")
          .append("svg")
            .attr("width", width)
            .attr("height", height)
            .attr("class","drugi");

  d3.json("countries.geojson", function(data) {
  
    var group1 = canvas1.selectAll("g")
          .data(data.features)
          .enter()
          .append("g");
          
    var projection1 = d3.geoMercator()
              .center(d3.geoCentroid(data))
              .scale(scale1)
              .translate([width/2, height/2]);
    
    var path = d3.geoPath().projection(projection1);
    
    var areas = group1.append("path")
            .attr("d", path)
            .attr("fill",function(d){
              if(d.properties.ISO_A3 !=null)
              {
                if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
               
              }
              
            })
            .attr("stroke", function(d){
              if(d.properties.ISO_A3 !=null)
              {
                if(!(d.properties.ISO_A3.toUpperCase() in co_values))
                {
                   co_values[d.properties.ISO_A3.toUpperCase()]="green";
                }
                return co_values[d.properties.ISO_A3.toUpperCase()];
              }
              
              
            });
    


    group1.append("text")
      .attr("x", 50)
      .attr("y", 50);
      var div = d3.select("body").append("div")   
    .attr("class", "tooltip")               
    .style("opacity", 0);


      areas.on("mouseover", function(d) {
      var myRegion = d.properties.ISO_A3;
          d3.selectAll("path").filter(function(d) { try{a = d.properties.ISO_A3;} catch{return false;} return d.properties.ISO_A3 == myRegion; })
            .attr("fill", "lightGray");
            div.transition()		
               .duration(200)		
               .style("opacity", .9);	  
          div.html((d.properties.ADMIN.replace("_", " ")+" - "+svet[currData][d.properties.ISO_A3.toUpperCase()]))
          .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");   
        })
        .on("mouseout", function(d) {
          var myRegion = d.properties.ISO_A3;

          d3.selectAll("path").filter(function(d) { try{a = d.properties.ISO_A3;} catch{return false;} return d.properties.ISO_A3 == myRegion; })
            .attr("fill", function(){
              if(d.properties.ISO_A3 !=null)
              {
                return co_values[d.properties.ISO_A3.toUpperCase()];
              }
              else
              {
                d.properties.ISO_A3=d.properties.ISO_A3;
                return co_values[d.properties.ISO_A3.toUpperCase()];
              }
              
            });
            div.transition()		
               .duration(200)		
               .style("opacity", 0);	  
          div.html((d.properties.ADMIN.replace("_", " ")+" - "+svet[currData][d.properties.ISO_A3.toUpperCase()]))
          .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");
        
        });
      

  });

</script>
</div>
</div>
</div>

<div class="pagee second jumbotron text-center" style="margin-bottom:0">
  <h1>Časovnica ukrepov</h1>
  <p>Kako so ukrepi vplivali na število okuženih in smrti</p> 

  <script>
		
  var sirina = 800;
  var visina = 400;

  var x = d3.time.scale()
    .range([0, sirina]);

  var y = d3.scale.linear()
    .range([0,5]);

var line = d3.svg.line()
  .x(function(d) {   return x(d.date); })
	.y(function(d) { return y(d.title); });
	
var div = d3.select("body").append("div")   
  .attr("class", "tooltip")               
  .style("opacity", 0);

var svg = d3.select(".second").append("svg")
  .attr("width", sirina )
  .attr("height", visina)
  .append("g");
            

var parseDate = d3.time.format("%Y-%m-%d");
var formatTime = d3.time.format("%e %b %-I:%M %p");
var formatCount = d3.format(",");


d3.csv("measures1.csv", function(error, data) {
  data.forEach(function(d) {
    d.date = parseDate.parse(d.date);
    d.sm_description = d.sm_description;
  });

x.domain(d3.extent(data, function(d) { return d.date; }))
  .range([5, sirina-5]);;
y.domain([0,10]);


var g = svg.selectAll()
  .data(data).enter().append("g");

g.append("circle")
  .attr("r", 4)
  .attr("cx", function(d) { return x(d.date); })
  .attr("cy", visina/2)
  .style("fill", "Tomato")
  .style("stroke","Gray")
  .style("stroke-width","0.5");
   
g.selectAll("circle")
  .on("mouseover", function(d) {	
    div.transition()		
            .duration(200)		
            .style("opacity", .9);	
        div.html(formatDateDrugi((d.date)))	
            .style("left", (d3.event.pageX - 20) + "px")
        .style("top", (d3.event.pageY + 6) + "px");
        })
  .on("click", function(d) {		
        div.transition()		
            .duration(200)		
            .style("opacity", .9);	
        div.html((d.sm_description))	
            .style("left", (d3.event.pageX - 20) + "px")
        .style("top", (d3.event.pageY + 6) + "px");
        })
  .on("dblclick", function(d) {	
    div.transition()		
            .duration(200)		
            .style("opacity", .9);	
        div.html(getCases1(d.date))	
            .style("left", (d3.event.pageX - 20) + "px")
        .style("top", (d3.event.pageY + 6) + "px");
        });

svg.append("text")      
  .attr("x", (sirina/2) )
  .attr("y",  (visina-100))
  .style("text-anchor", "middle")
  .attr("id", "besedilo")
  .text("Miška čez ~ ukrep ");

svg.append("text")      
  .attr("x", (sirina/2) )
  .attr("y",  (visina-100)+30)
  .style("text-anchor", "middle")
  .attr("id", "besedilo")
  .text("Klik ~ datum  ");

svg.append("text")      
  .attr("x", (sirina/2) )
  .attr("y",  (visina-100)+60)
  .style("text-anchor", "middle")
  .attr("id", "besedilo")
  .text("Dvojni klik ~ št.okuženih do tega datuma");


var xScale = d3.scaleTime()
  .domain([new Date("2020-03-04"), new Date(currData)])
  .range([5, sirina-5]);

var xAxis = d3.axisBottom(xScale)
  .tickFormat(d3.timeFormat("%b"));

var yAxis = d3.axisRight(yScale);
  
svg.append("g")
  .attr("class", "x axis")
  .attr("transform", "translate(0," + (visina-230) + ")")
  .call(xAxis);

svg.append("g")
  .attr("class", "y axis")
  .call(yAxis);
});

var n = dat.length;

var xScale = d3.scaleLinear()
    .domain([0, n-1]) 
    .range([5, sirina-5]); 

var yScale = d3.scaleLinear()
    .domain([0,  Grafmax(currNizaGraf)])
    .range([visina/2.6, 0]); 

var line = d3.line()
    .x(function(d, i) { return xScale(i); }) 
    .y(function(d) { return yScale(d.y); }) 
    .curve(d3.curveMonotoneX);

var tabela = [];
for (let i = 0; i < dat.length; i++) {
  tabela[i] = i; 
};

var dataseter2 = [];
for (let index = 0; index < tabela.length; index++) {
  const element = tabela[index];
  dataseter2[index] = { "y": funkcijaDobi(element) };
}

svg.append("path")
    .datum(dataseter2)
    .attr('id', 'graf') 
    .attr("class", "line") 
    .attr("d", line);  

svg.selectAll(".dot")
    .data(dataseter2)
  .enter().append("circle") 
    .attr("class", "dot") 
    .attr('id', 'graf')
    .attr("cx", function(d, i) { return xScale(i) })
    .attr("cy", function(d) { return yScale(d.y) })
    .attr("r", 2);

</script>



</div>


<div class="pagee foot jumbotron text-center" style="margin-bottom:0">
<h1>Viri:</h1>
  <p>NIJZ <br>
     Covid Sledilnik</p>
     <h1>Avtorja:</h1></p>
  <p>Marijana Davitkova <br> Erik Maglica </p>
  <h1>Univerza v Ljubljani</h1>
  <p>Multimedijske tehnologije <br> 2020</p>
</div>
</body>
</html>