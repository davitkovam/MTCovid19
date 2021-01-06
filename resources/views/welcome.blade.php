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
            $tabelaSvet=SvetController::getTable();?>
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
            var doDataSlucai={};
            <?php
            foreach($dati as $d):
              ?>doDataSlucai["<?php echo $d;?>"]={};<?php
              foreach($regioni as $r):
                ?>
                doDataSlucai["<?php echo $d;?>"]["<?php echo (strtoupper($r));?>"]=<?php echo (NijzArrayController::getCasesUntilDateInRegion($niza, $d, $r)); ?>;
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

            var svet={}

            <?php
            foreach($tabelaSvet as $niza):?>
              if(!("<?php echo ($niza[1]); ?>" in svet))
              {
                svet["<?php echo ($niza[1]); ?>"]={};
              }
              svet["<?php echo ($niza[1]); ?>"] ["<?php echo ($niza[0]); ?>"] = <?php echo ($niza[2]); ?>;<?php
            endforeach;
            ?>

              function funkcijaDobi(d) { 
                  var v = d*5;
                  var dd = dat[v];
                  var datt = doDataSlucai[dd]["VKUPNO"];
                  return (datt)/500;  
              }
            




              var co_values={};
              var minis=-1;
              var maxis=-1;

              var slucai={};
              var printi={};
              var maxi=-1;
              var mini=-1;
              var reg_values={};


            function setupSvet()
            {
              var minis=-1;
              var maxis=-1;
              for (iso in svet[currData])
              {
                if(iso !="AND" && iso !="SMR" && iso !="VAT" && iso !="BHR" )
                {
                  if(maxis<svet[currData][iso] )
                  {
                    console.log(iso)
                    maxis=svet[currData][iso];
                  }
                  if(minis==-1 || minis>svet[currData][iso])
                  {
                    minis=svet[currData][iso];
                  }
                }
               
              }
            var razlikas=(maxis-minis)/5.0;
            console.log(maxis, minis, razlikas);
            for (var i=0; i<zem.length; i++)
              {
               if(parseFloat(svet[currData][zem[i].toUpperCase()])<=(parseFloat(minis)+0.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="green";//"#6EBD45";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+1.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="yellow";//#E7D93B ";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+2.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="orange";//#F2A013";
                }
                else if (svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+3.5*parseFloat(razlikas)))
                {
                  co_values[zem[i].toUpperCase()]="red";//#C53030";
                }
                else if(svet[currData][zem[i].toUpperCase()]<=(parseFloat(minis)+5*parseFloat(razlikas)))
                {
                   co_values[zem[i].toUpperCase()]="black";
                }
                else  
                {
                  co_values[zem[i].toUpperCase()]="green";//"#1B262C";
                }
              }
              
            }  



            function setupSlo(){
              maxi=-1;
              mini=-1;
        
              <?php
              foreach($regioni as $r ):
              if($r!="Tujina" and $r!="Vkupno"):
              ?> 
                slucai["<?php echo(strtoupper($r)); ?>"]=doDataSlucai[currData]["<?php echo (strtoupper($r));?>"]/"<?php echo PopulationController::regija($r);?>";
                printi["<?php echo(strtoupper($r)); ?>"]=doDataSlucai[currData]["<?php echo (strtoupper($r));?>"];
                
                if(maxi<slucai["<?php echo(strtoupper($r)); ?>"])
                {
                  maxi=slucai["<?php echo(strtoupper($r)); ?>"];
                }
                if(mini==-1 || mini>slucai["<?php echo(strtoupper($r)); ?>"])
                {
                  mini=slucai["<?php echo(strtoupper($r)); ?>"];
                }
                
                
              <?php
              endif;
              endforeach;
              ?>
            
              var razlika=(maxi-mini)/5.0;
              console.log(maxi, mini, razlika);
            
            
              for (var i=0; i<reg.length; i++)
              {
                  if(slucai[reg[i].toUpperCase()]<=(parseFloat(mini)+parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#6EBD45";
                  }
                  else if (slucai[reg[i].toUpperCase()]<=(parseFloat(mini)+2*parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#E7D93B ";
                  }
                  else if (slucai[reg[i].toUpperCase()]<=(parseFloat(mini)+3*parseFloat(razlika)))
                  {
                    reg_values[reg[i].toUpperCase()]="#F2A013 ";
                  }
                  else if (slucai[reg[i].toUpperCase()]<=(parseFloat(mini)+4*parseFloat(razlika)))
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
            var dd = doDataSlucai[dan]["VKUPNO"];
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
 
          </script>






<link rel="stylesheet" href="<?php echo asset('style.css')?>" type="text/css"> 
<div class="page first jumbotron text-cen ter page" style="margin-bottom:0">
  <h1>Slovenia Map</h1>
  <p>Number of cases by region</p>
  <br>
  <!--
  <div class="buttons">
		<button name="submit" class="action_btn submit" type="submit" value="Slovenia" onclick="myFunction()">Slovenia</button>
		<button name="submit" class="action_btn cancel" type="submit" value="Svet" onclick="myFunction2()">World</button>
		<p id="saved"></p>
</div>
-->
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
        setupSlo();
        setupSvet();




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

<script>
  setupSlo();


  var width = 990;
  var height = 500;
  var canvas = d3.select(".first")
          .append("svg")
            .attr("width", width)
            .attr("height", height);

  d3.json("regional.geojson", function(data) {
  
    var group = canvas.selectAll("g")
          .data(data.features)
          .enter()
          .append("g");
          
    var projection = d3.geoMercator()
              .center(d3.geoCentroid(data))
              .scale(10000)
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
        div.html((d.properties.region.replace("_", " ")+" - "+printi[d.properties.region.toUpperCase()]))
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
          div.html((d.properties.region.replace("_", " ")+" - "+printi[d.properties.region.toUpperCase()]))
            .style("left", (d3.event.pageX - 20) + "px")
            .style("top", (d3.event.pageY + 6) + "px");
      });
  });

</script>
</div>
<div class="page second jumbotron text-center page" style="margin-bottom:0">
  <h1>Restrictions Timeline</h1>
  <p>Influence of restrictions</p> 



  <script>

		
var sirina = 800;
    var visina = 400;

var x = d3.time.scale()
    .range([0, sirina]);

var y = d3.scale.linear()
    .range([0,5]);



var line = d3.svg.line()
    .x(function(d) { console.log(d.date); console.log(d.title);  return x(d.date); })
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
  x.domain(d3.extent(data, function(d) { return d.date; }));
  y.domain([0,10]);


var g = svg.selectAll()
        .data(data).enter().append("g");

	 g.append("circle")
	 .attr("r", 6)
    .attr("cx", function(d) { return x(d.date); })
		.attr("cy", (visina/2))
		.style("fill", "red")
		.style("stroke","gray")
		.style("stroke-width","0.5");
   
    g.selectAll("circle")
			.on("mouseover", function(d) {		
            div.transition()		
               .duration(200)		
               .style("opacity", .9);	
            div.html((d.sm_description))	
               .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");
            })
      .on("mouseout", function(d) {
        
          div.transition()		
              .duration(200)		
              .style("opacity", 0)	  
          
      })
      .on("click", function(d) {	
        div.transition()		
               .duration(200)		
               .style("opacity", .9);	
            div.html((d.date))	
               .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");
            });
     





svg.append("text") 
        .attr("x", (sirina/2) )
        .attr("y",  (visina-100))
        .style("text-anchor", "middle")
        .text("Events: mouse over->ukrep  click->datum  double click->št.okuženih do tega datuma");


var xScale = d3.scaleTime()
  .domain([new Date("2020-03-05"), new Date("2020-12-7")])
  .range([0, sirina-1]);

var xAxis = d3.axisBottom(xScale)
  .tickFormat(d3.timeFormat("%b"));
  
svg.append("g")
  .attr("class", "x axis")
  .attr("cy", (visina/2))
  .call(xAxis);

});


var n = (dat.length-1)/5;

var xScale = d3.scaleLinear()
    .domain([0, n-1]) 
    .range([0, sirina]); 

var yScale = d3.scaleLinear()
    .domain([0, (dat.length-1)/5])
    .range([visina/2.5, 0]); 

var line = d3.line()
    .x(function(d, i) { return xScale(i); }) 
    .y(function(d) { return yScale(d.y); }) 
    .curve(d3.curveMonotoneX) 

var dataset = d3.range(n).map(function(d) {  return {"y": d3.randomUniform(1)() } })
var tabela = [];
for (let i = 0; i < (dat.length-1)/5; i++) {
  tabela[i] = i; 
};

var dataseter = new Map();
var dataseter2 = [];
for (let index = 0; index < tabela.length; index++) {
  const element = tabela[index];
  dataseter.set(element, { "y": funkcijaDobi(element) });
  dataseter2[index] = { "y": funkcijaDobi(element) };
}


svg.append("path")
    .datum(dataseter2) 
    .attr("class", "line") 
    .attr("d", line);  

svg.selectAll(".dot")
    .data(dataseter2)
  .enter().append("circle") 
    .attr("class", "dot") 
    .attr("cx", function(d, i) { return xScale(i) })
    .attr("cy", function(d) { return yScale(d.y) })
    .attr("r", 2)
    .on("mouseover", function(d) {	
        div.transition()		
               .duration(200)		
               .style("opacity", .9);	
            div.html(getCases1(d.date))	
               .style("left", (d3.event.pageX - 20) + "px")
				   .style("top", (d3.event.pageY + 6) + "px");
            });;

</script>








</div>
<div class="page third jumbotron text-center page" style="margin-bottom:0">
  <h1>World Map</h1>
  <p>Number of cases per million</p>

 <script>
 
  
  setupSvet();
  var width = 990;
  var height = 500;
  var scale1 = 100;


  var canvas1 = d3.select(".third")
          .append("svg")
            .attr("width", width)
            .attr("height", height);

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

<div class="jumbotron text-center page" style="margin-bottom:0">
  <h1>Sources:</h1>
  <p>NIJZ <br>
     Covid Tracker</p>
     <h1>Made by:</h1>
  <p>Marijana Davitkova <br> Erik Maglica </p>
  <h1>Univerza v Ljubljani</h1>
  <p>Multimedijske tehnologije <br> 2020</p>
</div>
</body>
</html>