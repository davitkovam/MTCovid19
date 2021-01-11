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
            var currRegija="VKUPNO";

            function lineGraph()
            {
              d3.selectAll('#graf').remove();
              
                
                yScale = d3.scaleLinear()
              .domain([0, Grafmax(currNizaGraf, currRegija)])
              .range([(visina/2.6) + 1, 5]);

              yAxis = d3.axisRight(yScale);
              svg.append("g")
            .attr("class", "y axis")
            .attr("id", "graf")
            .call(yAxis);

              line = d3.line()
            .x(function(d, i) { return xScale(i); }) 
            .y(function(d) { return yScale(d.y); }) 
            .curve(d3.curveMonotoneX);

                for (let i = 0; i < dat.length; i++) {
                  tabela[i] = i; 
                };

                
                for (let index = 0; index < tabela.length; index++) {
                  const element = tabela[index];
                  dataseter2[index] = { "y": funkcijaDobi(element), "element":element };
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
                      .attr("datum", function(d){return d.element}) 
                      .attr('id', 'graf')
                      .attr("cx", function(d, i) { return xScale(i) })
                      .attr("cy", function(d) { return yScale(d.y) })
                      .attr("r", 2)
                      .on("mouseover", function(d) {	
                      div.transition()		
                              .duration(200)		
                              .style("opacity", .9);	
                          div.html(formatDateDrugi(dat[d.element]).substring(0, 10).split("-").reverse().join(".")+": "+funkcijaDobi(d.element)	)
                              .style("left", (d3.event.pageX - 20) + "px")
                          .style("top", (d3.event.pageY + 6) + "px");
                          })
                      .on("mouseout", function(d){
                        div.transition()		
                                .duration(200)		
                                .style("opacity", 0)	  
                            div.html(formatDateDrugi(dat[d.element]).substring(0, 10).split("-").reverse().join(".")+": "+funkcijaDobi(d.element)	)
                              .style("left", (d3.event.pageX - 20) + "px")
                              .style("top", (d3.event.pageY + 6) + "px");
                      });


            }


            function Grafmax(niza, regija)
            {
              var m=0;
             
                for(var j=0; j<dat.length;j++)
                {
                  m=Math.max(m, niza[dat[j]][regija]);
                }
              return m;
              
            }

           

            function funkcijaDobi(d) { 
                var v = d;
                var dd = dat[v];
                var datt = currNizaGraf[dd][currRegija];
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
            document.getElementById("svetzelena").innerHTML = "<" + Math.floor(parseFloat(minis)+0.5*parseFloat(razlikas)).toString();
            document.getElementById("svetzta").innerHTML = "<" + Math.floor(parseFloat(minis)+1.5*parseFloat(razlikas)).toString();
            document.getElementById("svetportokalova").innerHTML = "<" + Math.floor(parseFloat(minis)+2.5*parseFloat(razlikas)).toString();
            document.getElementById("svetcrvena").innerHTML = "<" + Math.floor(parseFloat(minis)+3.5*parseFloat(razlikas)).toString();
            document.getElementById("svetcrna").innerHTML = ">" + Math.floor(parseFloat(minis)+3.5*parseFloat(razlikas)).toString();
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
              if( Math.floor(parseFloat(mini)+4*parseFloat(razlika)).toString()=="0")
              {
                document.getElementById("slozelena").innerHTML = "<" +((parseFloat(mini)+parseFloat(razlika))*100).toFixed(2).toString()+"%";
              document.getElementById("slozta").innerHTML = "<" +((parseFloat(mini)+2*parseFloat(razlika))*100).toFixed(2).toString()+"%";
            document.getElementById("sloportokalova").innerHTML = "<" + ((parseFloat(mini)+3*parseFloat(razlika))*100).toFixed(2).toString()+"%";
            document.getElementById("slocrvena").innerHTML = "<" +((parseFloat(mini)+4*parseFloat(razlika))*100).toFixed(2).toString()+"%";
            document.getElementById("slocrna").innerHTML = ">" + ((parseFloat(mini)+4*parseFloat(razlika))*100).toFixed(2).toString()+"%";
              }
              else
              {
                document.getElementById("slozelena").innerHTML = "<" + Math.floor(parseFloat(mini)+parseFloat(razlika)).toString();
              document.getElementById("slozta").innerHTML = "<" + Math.floor(parseFloat(mini)+2*parseFloat(razlika)).toString();
            document.getElementById("sloportokalova").innerHTML = "<" + Math.floor(parseFloat(mini)+3*parseFloat(razlika)).toString();
            document.getElementById("slocrvena").innerHTML = "<" + Math.floor(parseFloat(mini)+4*parseFloat(razlika)).toString();
            document.getElementById("slocrna").innerHTML = ">" + Math.floor(parseFloat(mini)+4*parseFloat(razlika)).toString();
              }
              
            
            
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

          function nacrtajRegija(reg)
          {
            currRegija=reg;
            lineGraph();
          }
          function smeniNizaGraf(sto)
          {
            var promeneto=false;
            if(sto=="smrtGraf"&& currNizaGraf!=grafSmrti)
            {
              currNizaGraf=grafSmrti;
              document.getElementById("grafTekst").innerHTML="Kako so ukrepi vplivali na število umrlih na dan";
              promeneto=true;
            }
            else if(sto=="slucaiGraf"&& currNizaGraf!=grafSlucai)
            {
              currNizaGraf=grafSlucai;
              document.getElementById("grafTekst").innerHTML="Kako so ukrepi vplivali na število okuženih na dan";
              promeneto=true;
            }
            if(promeneto)
            {
              lineGraph();
            }
          }

          function smeniNiza(sto) {
            var promeneto=false;
            var promenetoGraf=false;
              if(sto=="casesMil"&& currNizaSvet!=svet)
              {
                currNizaSvet=svet;
                currNizaSlo=doDataSlucai;
                
                 promeneto=true;

              }
              else if(sto=="cases"&& currNizaSvet!=svetActual)
              {
                currNizaSvet=svetActual;
                currNizaSlo=doDataSlucaiActual;
               
                promeneto=true;

              }
              else if(sto=="smrt"&& currNizaSvet!=svetSmrtActual)
              {
                currNizaSvet=svetSmrtActual;
                currNizaSlo=doDataSmrtActual;
                
                promeneto=true;
              }
              else if(sto=="smrtMil"&& currNizaSvet!=svetSmrt)
              {
                currNizaSvet=svetSmrt;
                currNizaSlo=doDataSmrt;
                
                promeneto=true;
              }
              if(promeneto)
              {
                if(sto=="smrt")
                {
                  document.getElementById("slovenijapage").innerHTML = "Število smrti po regijah";
                  document.getElementById("svetpage").innerHTML = "Število smrti po državah";
                }
                else if(sto=="smrtMil")
                {
                  document.getElementById("slovenijapage").innerHTML = "Odstotek smrti glede na prebivalstvo po regijah";
                  document.getElementById("svetpage").innerHTML = "Število smrti na milijon prebivalcev po državah";
                }
                else if(sto=="cases")
                {
                  document.getElementById("slovenijapage").innerHTML = "Število okužb po regijah";
                  document.getElementById("svetpage").innerHTML = "Število okužb po državah";
                }
                else
                {
                  document.getElementById("slovenijapage").innerHTML = "Odstotek okužb glede na prebivalstvo po regijah";
                  document.getElementById("svetpage").innerHTML = "Število okužb na milijon prebivalcev po državah";
                }
                setupSvet(currNizaSvet);
                setupSlo(currNizaSlo);
               


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
  <h1 >COVID-19</h1>
  <br>
<div class="buttons">
    <button name="submit" class="action_btn cancel" type="submit" value="casesMil" onclick="smeniNiza(this.value)">Relativno število okuženih</button>
    <button name="submit" class="action_btn submit" type="submit" value="cases" onclick="smeniNiza(this.value)">Število okuženih</button>
    <button name="submit" class="action_btn cancel" type="submit" value="smrtMil" onclick="smeniNiza(this.value)">Relativno število smrti</button>
    <button name="submit" class="action_btn submit" type="submit" value="smrt" onclick="smeniNiza(this.value)">Število smrti</button>
</div>
  
  <br>
  <div class="slidecontainer">
    <input type="range" min=0 max=200 value=200 class="slider" id="myRange">
  </div>
  <p id="zaData">Za datum: </p>

      <script>
      var slider = document.getElementById("myRange");
      var zaData = document.getElementById("zaData");
      slider.max=dat.length-1;
      slider.value=dat.length-1;
      var currData=dat[slider.value];
      zaData.innerHTML = "Za datum: "+currData.split("-").reverse().join(".");
      var output = slider.value;


      slider.oninput = function() {
        output = this.value;
        currData=dat[slider.value];
        zaData.innerHTML = "Za datum: "+currData.split("-").reverse().join(".");  
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


<div class="page first jumbotron text-center page" style="margin-bottom:0">
<h1>Slovenija</h1>
<p id="slovenijapage">Odstotek okužb glede na prebivalstvo po regijah</p>
<br>
<div class="legendaslo  text-center">
<b><p id="slolegenda" >Št. primerov </p></b>
<b><p id="slocrna" style="color: #1B262C;">> 1350</p></b>
<b><p  id="slocrvena" style="color: #C53030;">< 1350</p></b>
<b><p  id="sloportokalova" style="color: #F2A013;">< 1000</p></b>
<b><p  id="slozta" style="color: #E7D93B ;">< 600</p></b>
<b><p  id="slozelena" style="color: #6EBD45;">< 300</p></b>
</div>
  

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
  .attr("width", "100px") 
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
<p id="svetpage">Število okužb na milijon prebivalcev po državah</p>
<div class="legendasvet  text-center">
<b><p id="svetlegenda">Št. primerov </p></b>
<b><p  id="svetcrna" style="color: #1B262C;">> 1350</p></b>
<b><p id="svetcrvena" style="color: #C53030;">< 1350</p></b>
<b><p  id="svetportokalova" style="color: #F2A013;">< 1000</p></b>
<b><p  id="svetzta"style="color: #E7D93B ;">< 600</p></b>
<b><p  id="svetzelena" style="color: #6EBD45;">< 300</p></b>
</div>
 


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
    .attr("width",  "100px")               
    .style("opacity", 0);


      areas.on("mouseover", function(d) {
      var myRegion = d.properties.ISO_A3;
          d3.selectAll("path").filter(function(d) { try{a = d.properties.ISO_A3;} catch{return false;} return d.properties.ISO_A3 == myRegion; })
            .attr("fill", "lightGray");
            div.transition()		
               .duration(200)		
               .style("opacity", .9);	  
          div.html((d.properties.ADMIN.replace("_", " ")+" - "+currNizaSvet[currData][d.properties.ISO_A3.toUpperCase()]))
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
          div.html((d.properties.ADMIN.replace("_", " ")+" - "+currNizaSvet[currData][d.properties.ISO_A3.toUpperCase()]))
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
  <p id="grafTekst">Kako so ukrepi vplivali na število okuženih na dan</p> 

  <div class="buttons">
  <button name="submit" class="action_btn cancel" type="submit" value="slucaiGraf" onclick="smeniNizaGraf(this.value)">Okuženi</button>
    <button name="submit" class="action_btn submit" type="submit" value="smrtGraf" onclick="smeniNizaGraf(this.value)">Umrli</button>
</div>
<br>
<div class="buttons">
 
  <select name="regija" id="regijaGraf" onChange="nacrtajRegija(this.value);">
  <option value="VKUPNO">Slovenija</option>
  <option value="GORENJSKA">Gorenjska</option>
  <option value="GORISKA">Goriška</option>
  <option value="JUGOVZHODNA_SLOVENIJA">Jugovzhodna Slovenija</option>
  <option value="KOROSKA">Koroška</option>
  <option value="OBALNO_KRASKA">Obalno kraška</option>
  <option value="OSREDNJESLOVENSKA">Osrednjeslovenska</option>
  <option value="PODRAVSKA">Podravska</option>
  <option value="POMURSKA">Pomurska</option>
  <option value="POSAVSKA">Posavska</option>
  <option value="PRIMORSKO_NOTRANJSKA">Primorsko notranjska</option>
  <option value="SAVINJSKA">Savinjska</option>
  <option value="ZASAVSKA">Zasavska</option>
</select>
</div>
<br>
<br>
 
  <script>
		
  var sirina = 1200;
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
  .attr("width", "100px")         
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
  .range([5, sirina-5]);
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
        div.html(formatDateDrugi(d.date).substring(0, 10).split("-").reverse().join(".") + ": " + (d.sm_description)	)
            .style("left", (d3.event.pageX - 20) + "px")
        .style("top", (d3.event.pageY + 6) + "px");
        })
  .on("mouseout", function(d){
    div.transition()		
               .duration(200)		
               .style("opacity", 0);	  
          div.html(formatDateDrugi(d.date).substring(0, 10).split("-").reverse().join(".")+ ": " + (d.sm_description))
          .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");
  });

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
  .attr("id", "graf")
  .call(yAxis);
});

var n = dat.length;

var xScale = d3.scaleLinear()
    .domain([0, n-1]) 
    .range([5, sirina-5]); 

var yScale = d3.scaleLinear()
    .domain([0,  Grafmax(currNizaGraf, currRegija)])
    .range([(visina/2.6) + 1, 5]); 

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
  dataseter2[index] = { "y": funkcijaDobi(element), "element":element };
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
    .attr("datum", function(d){return d.element}) 
    .attr('id', 'graf')
    .attr("cx", function(d, i) { return xScale(i) })
    .attr("cy", function(d) { return yScale(d.y) })
    .attr("r", 2)
    .on("mouseover", function(d) {	
    div.transition()		
            .duration(200)		
            .style("opacity", .9);	
        div.html(formatDateDrugi(dat[d.element]).substring(0, 10).split("-").reverse().join(".")+": "+funkcijaDobi(d.element)	)
            .style("left", (d3.event.pageX - 20) + "px")
        .style("top", (d3.event.pageY + 6) + "px");
        })
    .on("mouseout", function(d){
      div.transition()		
              .duration(200)		
              .style("opacity", 0)	  
          div.html(formatDateDrugi(dat[d.element]).substring(0, 10).split("-").reverse().join(".")+": "+funkcijaDobi(d.element)	)
            .style("left", (d3.event.pageX - 20) + "px")
            .style("top", (d3.event.pageY + 6) + "px");
    });
    

</script>

</div>


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