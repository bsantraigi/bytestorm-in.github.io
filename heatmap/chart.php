<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$con = mysql_connect("localhost","root","");
mysql_select_db("grider");

#include 'database.php';
session_start();
if(isset($_GET['cid'])){
    $_SESSION['client_id'] = $_GET['cid'];
    $clientId = $_SESSION['client_id'];

}else{
//header("Location: https://gridb.in/NewGrayWeb/adminlogin.php");


}


if(isset($_GET['lang'])){
	$lang=$_GET['lang'];
	$_SESSION['language'] = $lang;
}



if(isset($_GET['type'])){
	$chartType=$_GET['type'];
}
else{
	$chartType='state';
}



	$getStateInfo = mysql_query("select g.client_id,t.state,t.town,t.locality,t.pin,count(*) as count from grider_requests g,(select client_id,state,town,locality,pin from outlets group by state,client_id) as t where g.client_id=t.client_id and g.client_id!=1 group by t.state");
        $num_results = mysql_num_rows($getStateInfo);
        
		
?>
<head>
  <style type="text/css">
	  body
	{
		font-family: sans-serif;
		font-size: 100%;
		margin: 20px;
		color: #ED1539;
		
	}

	#ajaxloader1, #ajaxloader2, #ajaxloader3, #ajaxloader4
	{
		display: none;
		position: relative;
		top:10%;
		left: 50%;
		
		width:50px;
		height: 50px;
		margin: 0 0 0 -15px;
		border: 8px solid #3215ED;
		border-right-color: transparent;
		border-radius: 50%;
		box-shadow: 0 0 25px 2px #ED1539;
		-webkit-animation: spin 1s linear infinite;
		-moz-animation: spin 1s linear infinite;
		-ms-animation: spin 1s linear infinite;
		-o-animation: spin 1s linear infinite;
		animation: spin 1s linear infinite;
	}

	#ajaxloader2
	{
		border-right: 0 none;
	}

	#ajaxloader3
	{
		border-left-color: transparent;
	}

	#ajaxloader4
	{
		border-bottom-color: transparent;
	}

	#ajaxloader3::after, #ajaxloader4::after
	{
		display: block;
		content: " ";
		width: 9px;
		height: 9px;
		border: 6px solid #ED1539;
		margin: 4px;
		border-radius: 50%;
	}

	#ajaxloader3::after
	{
		border-left-color: transparent;
		border-right-color: transparent;
	}

	#ajaxloader4::after
	{
		width: 13px;
		height: 13px;
		margin: 1px;
		border-width: 8px;
		border-top-color: transparent;
		border-left-color: transparent;
	}

	@-webkit-keyframes spin
	{
		from { -webkit-transform: rotate(0deg); opacity: 0.4; }
		50%  { -webkit-transform: rotate(180deg); opacity: 1; }
		to   { -webkit-transform: rotate(360deg); opacity: 0.4; }
	}

	@-moz-keyframes spin
	{
		from { -moz-transform: rotate(0deg); opacity: 0.4; }
		50%  { -moz-transform: rotate(180deg); opacity: 1; }
		to   { -moz-transform: rotate(360deg); opacity: 0.4; }
	}

	@-ms-keyframes spin
	{
		from { -ms-transform: rotate(0deg); opacity: 0.4; }
		50%  { -ms-transform: rotate(180deg); opacity: 1; }
		to   { -ms-transform: rotate(360deg); opacity: 0.4; }
	}

	@-o-keyframes spin
	{
		from { -o-transform: rotate(0deg); opacity: 0.4; }
		50%  { -o-transform: rotate(180deg); opacity: 1; }
		to   { -o-transform: rotate(360deg); opacity: 0.4; }
	}

	@keyframes spin
	{
		from { transform: rotate(0deg); opacity: 0.2; }
		50%  { transform: rotate(180deg); opacity: 1; }
		to   { transform: rotate(360deg); opacity: 0.2; }
	}

	  
	         
	      * { font-family: Aril;
	            font-size:100%;
	            }
	        .csv{
	            background-image: url(images/2.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            
	           
	            width: 102px;
	            border: 0px;
	            cursor: pointer;
	        }
	        .dump{
	            background-image: url(images/2.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            margin-left: 868px;
	            margin-top: -38px;
	            position: fixed;
	            width: 102px;
	            border: 0px;
	            cursor: pointer;
	        }
	        .selectedState{
	            background-image: url(images/3.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            width: 130px;
	            border: 0px;
	            cursor: pointer;

	        }
	        .imgClass { 
	            background-image: url(images/2.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            width: 130px;
	            border: 0px;
	            cursor: pointer;
	        }
	        .imgClass:hover{  
	            background-image: url(images/3.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            width: 130px;
	            border: 0px;
	            cursor: pointer;
	        }
	        .imgClassForReset { 
	            background-image: url(images/2.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            width: 130px;
	            border: 0px;
	            cursor: pointer;
	        }
			.imgClassForReset:hover{  
	            background-image: url(images/3.png);
	            background-repeat: no-repeat;
	            background-position: left top;
	            height: 48px;
	            width: 130px;
	            border: 0px;
	            cursor: pointer;
	        }
	        
			
			
			

</style>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script type="text/javascript" src="//www.google.com/jsapi"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="jquery.blockUI.js"></script>
	
    <script type="text/javascript">
	
	
	$(document).ready(function() {
					$.blockUI({ css: { 
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: .5, 
						color: '#fff' 
					}}); 
					$.blockUI({ overlayCSS: { backgroundColor: '#ffffff' } }); 
					setTimeout($.unblockUI, 2000); 
			}); 



		
function getNameValues(dataState){
		var legendVals = new Array();
		var numb = dataState.getNumberOfRows();
		//console.log("Total count zf : "+numb);
		
		for(var i=0; i<numb; i++){
			//values[i].Name = dataState['zf'][i]['c'][0].v;
			//legendVals.push(dataState['zf'][i]['c'][0].v);
			legendVals.push(dataState.getValue(i, 0));
		}
		return legendVals;
	
	}
	
function setSelectBoxWithChartVals(dataState, identify){
			//For setting legend
			var legendVals = new Array();
			//var numb = Object.keys(dataState['zf']).length;
			var numb = dataState.getNumberOfRows();
			//console.log("***get chart vals Total count zf : "+numb);
			
			for(var i=0; i<numb; i++){
				//legendVals.push(dataState['zf'][i]['c'][0].v);
				legendVals.push(dataState.getValue(i, 0));
			}
			console.log(legendVals + "legendVals");
			
			var InvForm = document.getElementById('selectFilter');
			InvForm.options.length=0;
			 
			var optionsAsString = "";
			for(var i = 0; i < legendVals.length; i++) {
				optionsAsString += "<option value='" + legendVals[i] + "' selected"+" >" + legendVals[i] + "</option>";
			}
			$( 'select[name="selectFilter[]"]' ).append( optionsAsString );


			var iden = document.getElementById('identify');
			iden.value = identify;
			return 1;
		}
		
		
function getLegend(dataState){
		
		//For setting legend
		var legendVals = new Array();
		//var numb = Object.keys(dataState['zf']).length;
		var numb = dataState.getNumberOfRows();
		//console.log("Total count zf : "+numb);
		
		var values = new Array();
		for(var i=0; i<numb; i++){
		  values[i] = new Object();
		}
		
		// for(var i=0; i<numb; i++){
			// values[i].auto_credit = Object(dataState['zf'][i]['c'][1].v);
			// values[i].Name = dataState['zf'][i]['c'][0].v;
			// legendVals.push(dataState['zf'][i]['c'][0].v);
		// }

		for (var i = 0; i < dataState.getNumberOfRows(); i++) {
			values[i].auto_credit = dataState.getValue(i, 1);
			values[i].Name = dataState.getValue(i, 0);
			legendVals.push(dataState.getValue(i, 0));
		}


		legendVals = legendVals.reverse();
			//alert("Legends : "+legendVals);
			 // set the columns to use in the chart's view (columns object is used in the view)
			var stateColumns = [0];
			for (var i = 0; i < legendVals.length; i++) {
				stateColumns.push({
					type: 'number',
					label: legendVals[i],
					calc: (function (x) {
						return function (dt, row) {
						   //return (row == legendVals[x]) ? dt.getValue(row, 1) : null;
							return (dt.getValue(row, 0) == legendVals[x]) ? dt.getValue(row, 1) : null;
						}
					})(i)
				});
			}
			var view = {columns: stateColumns};
			return view;
			//alert(view.toSource());
		}
	/********************************************END Funtions*************************/
	
      google.load("visualization", "1", {packages:["corechart"]});
		var viewChart;
		var currentChartView=0;
		var getfilteredValue;
		//var data;
		//var chart;
	var chart;
	var options = {
			//title: 'Performance Analytics',
			backgroundColor: { fill:'transparent' },
			isStacked: true,
			//height: 300,
            width: '100%',
			bar: {groupWidth: '90%'} ,
			animation: {
            duration: 1000,
            easing: 'out'
          }
        };


        function start_chart(){

        	var data = google.visualization.arrayToDataTable([
            ['state' , 'count'],
            <?php
                $getStates = Array();
                while( $row = mysql_fetch_assoc($getStateInfo)){
                	if(trim($row['state']) == ''){
                		continue;
                	}
                    $state = $row['state'];
                    $salesCovered = $row['count'];
                    echo "['{$state}', {$salesCovered}],";
                }
            ?>
        ]);
		
		chart = new google.visualization.ChartWrapper({
			'chartType': 'ColumnChart',
			'containerId': 'chart_div'
		});	
        
        drawChartState(data,chart);

        }
		
      google.setOnLoadCallback(function(){

      	start_chart();
			
      });

      /**************************************************************** STATE ***********************************************************************/
	var delayMsec	= 1250;
function drawChartState(data,chart){
		//getfilteredValue = document.getElementById('filterYaxis').value;

		console.log("drawChartState called");
		
		currentChartView=1;
        google.visualization.events.removeAllListeners(chart);
		var dataState;
		 
		if(data != 1){
			console.log("Button not clicked : loading.. state");
			 dataState = data;
			 //console.log(dataState.toSource());
		}else{


			console.log("Button clicked which I need to modify");

			var selectedValueString = "";
             $('#selectFilter :selected').each(function(i, selected){ 
             		selectedValueString += "'"+$(selected).val()+"',";
                });

             selectedValueString = selectedValueString.slice(0,-1);
             var identify_pass = document.getElementById("identify").value;

			var state = 'States';
			var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				data: { "level1" : state,"ranges":selectedValueString,"identity":identify_pass},
				dataType: "json",
				async: false
			}).responseText;
		
			var obj = jQuery.parseJSON(jsonData);   		//alert(""+obj.toSource());
			dataState = google.visualization.arrayToDataTable(obj);
		}
		
		
		var legendVals = getNameValues(dataState)
		console.log(dataState + "is datastate");
		
		dataState.setColumnProperty(1, 'role', 'tooltip');
		setSelectBoxWithChartVals(dataState,1);
		
		var view = getLegend(dataState);
		var info = analyseDataTwoCols(dataState);
        //console.log("analytics info : ");
        //console.log(info);
		googleTranslate(info);
		
		
		
		
		var totalCount = totalRecords(dataState,chart);
		//alert(totalCount);		
		
		chart.setDataTable(dataState);
		chart.setOptions(options)
		chart.setView(view);
		chart.draw();		
		setTimeout(function() {hideLoader();},delayMsec);
		
		var stateListener = google.visualization.events.addListener(chart, 'select', selectHandler);
        function selectHandler() {
            
			var sel = chart.getChart().getSelection();  //alert("state sel : "+sel.toSource());
			if (sel) {
				var state = dataState.getValue(sel[0].row, 0);   //alert("state : "+state);
				google.visualization.events.removeListener(stateListener);
				drawTownChart(state,chart);
			}
        }
}
	
      /************************************************************** TOWN **************************************************************************/
function drawTownChart(state,chart){
	  currentChartView=2;
	  google.visualization.events.removeAllListeners(chart);
	  console.log("drawTownChart called");
	  //getfilteredValue = document.getElementById('filterYaxis').value;
        if(state != 2){

        	console.log("modify test_getdata nil ");
			//alert("Button not clicked : getMainChart town");
            //var dataTown = new google.visualization.DataView(data);
			displayLoader();
			var town = 'Towns';
            var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				//data: { "state" : state,"level1" : state},
				data: { "level2" : town,"ranges": "'"+state+"'","identity":1},
			   dataType: "json",
				async: false
			}).responseText;
			
			var obj = jQuery.parseJSON(jsonData);   //    alert(""+obj.toSource());
			
			var dataTown = google.visualization.arrayToDataTable(obj);
			console.log(dataTown);
			setclassForCurrentView('town');
			
        } else {
			//when town 
			
			console.log("Button clicked which I need to modify");

			var selectedValueString = "";
             $('#selectFilter :selected').each(function(i, selected){ 
             		selectedValueString += "'"+$(selected).val()+"',";
                });

             selectedValueString = selectedValueString.slice(0,-1);
             var identify_pass = document.getElementById("identify").value;
             console.log("passing in ajax ");
            var town = 'Towns';
			displayLoader();
			var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				data: { "level2" : town,"ranges":selectedValueString,"identity":identify_pass},
				dataType: "json",
				async: false
			}).responseText;
		
			var obj = jQuery.parseJSON(jsonData);   		//alert(""+obj.toSource());
			console.log(obj);
			dataTown = google.visualization.arrayToDataTable(obj);
        }
		
		
		
		var legendVals = getNameValues(dataTown)
		

	
		
		setSelectBoxWithChartVals(dataTown,2);
		var view = getLegend(dataTown);
		
		var info = analyseDataTwoCols(dataTown);
        //console.log("analytics info : ");
       // console.log(info);
		googleTranslate(info);
		
		var totalCount = totalRecords(dataTown,chart);
		//alert(totalCount);		
		
		chart.setDataTable(dataTown);
		chart.setOptions(options)
		chart.setView(view);
		chart.draw(); 	
		setTimeout(function() {hideLoader();},delayMsec);
		var townListener = google.visualization.events.addListener(chart, 'select', selectHandler); 
		function selectHandler() {
		  var sel = chart.getChart().getSelection();  //alert("town sel : "+sel.toSource());
			if (sel) {
				var town = dataTown.getValue(sel[0].row, 0);   //alert("town : "+town);
				google.visualization.events.removeListener(townListener);
				drawChartArea(town,chart);
			  }
        }
}

      /*********************** START DRAW AREA CHART FUNCTION **********************************************/

function drawChartArea(town,chart){
	  google.visualization.events.removeAllListeners(chart);
	  //getfilteredValue = document.getElementById('filterYaxis').value;
	  console.log("drawChartArea called");


	  currentChartView = 3;
	  //alert("selected town : "+town);
        if(town != 3){
			//getting the Locality Data object for the called town
			var locality = 'Loacality';
			displayLoader();
            var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				//data: { "town" : town,"level2" : town},
				data: { "level3" : locality,"ranges":"'"+town+"'","identity":2},
			   dataType: "json",
				async: false
			}).responseText;
			
			var obj = jQuery.parseJSON(jsonData);   //    alert(""+obj.toSource());
			
			var dataLocality = google.visualization.arrayToDataTable(obj);
			console.log(dataLocality);
			setclassForCurrentView('location');
        } else {
			console.log("button clicked which I need to modify");
			//get selected towns from drop down
			var locality = 'Loacality';

				var selectedValueString = "";
             $('#selectFilter :selected').each(function(i, selected){ 
             		selectedValueString += "'"+$(selected).val()+"',";
                });

             selectedValueString = selectedValueString.slice(0,-1);
             var identify_pass = document.getElementById("identify").value;
             console.log("passing in ajax ");
			//var getfilteredValue='outlet_status';
			displayLoader();
			var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				data: { "level3" : locality,"ranges":selectedValueString,"identity":identify_pass},
				dataType: "json",
				async: false
			}).responseText;
		
			var obj = jQuery.parseJSON(jsonData);   		//alert(""+obj.toSource());
			dataLocality = google.visualization.arrayToDataTable(obj);
        }
		
		

		
		
		var legendVals = getNameValues(dataLocality)
		

		
		
		setSelectBoxWithChartVals(dataLocality,3);
		var view = getLegend(dataLocality);
		
		var info = analyseDataTwoCols(dataLocality);
        //console.log("analytics info : ");
        //console.log(info);
		googleTranslate(info);
		
		//chart.setDataTable(dataLocality);
		var totalCount = totalRecords(dataLocality,chart);
		//alert(totalCount);		
		
		
		chart.setDataTable(dataLocality);
		chart.setOptions(options)
		chart.setView(view);
		chart.draw(); 
		setTimeout(function() {hideLoader();},delayMsec);
		

		var localityListener = google.visualization.events.addListener(chart, 'select', selectHandler); 
		function selectHandler() {
		  var sel = chart.getChart().getSelection();  //alert("==> Locality sel : "+sel.toSource());
			if (sel) {
				var locality = dataLocality.getValue(sel[0].row, 0);   //alert(" ==> Locality : "+locality);
				google.visualization.events.removeListener(localityListener);
				drawChartPincode(locality,chart);
			  }
        }		
	
}

    /*************************** START DRAW PIN CHART FUNCTION ************************************************/

function drawChartPincode(locality,chart){
	google.visualization.events.removeAllListeners(chart);
	//getfilteredValue = document.getElementById('filterYaxis').value;
	console.log("inside drawChartPincode");
	currentChartView = 4;
		//alert("===>>> "+locality);
		if(locality != 4){
			//var dataTown = new google.visualization.DataView(data);
			displayLoader();
			var pin = 'Pincode';
            var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				//data: { "locality" : locality,"level3" : locality},
				data: { "level4" : pin,"ranges":"'"+ locality+"'","identity":3},
			   dataType: "json",
				async: false
			}).responseText;
			
			var obj = jQuery.parseJSON(jsonData);   //    alert(""+obj.toSource());
			
			var dataPin = google.visualization.arrayToDataTable(obj);
			console.log(dataPin);
			setclassForCurrentView('pin');
		} else {
			console.log("button clicked which I need to modify");
			//get selected towns from drop down
			var pin = 'Pincode';
				var selectedValueString = "";
             $('#selectFilter :selected').each(function(i, selected){ 
             		selectedValueString += "'"+$(selected).val()+"',";
                });

             selectedValueString = selectedValueString.slice(0,-1);
             var identify_pass = document.getElementById("identify").value;
             console.log("passing in ajax ");


			displayLoader();
			var jsonData = $.ajax({
				url: "test_getdata_mod.php",
				data: { "level4" : pin,"ranges":selectedValueString,"identity":identify_pass},
				dataType: "json",
				async: false
			}).responseText;
		
			var obj = jQuery.parseJSON(jsonData);   		//alert(""+obj.toSource());
			dataPin = google.visualization.arrayToDataTable(obj);


			
		}
		
		

		
		
		var legendVals = getNameValues(dataPin)
		
		
		setSelectBoxWithChartVals(dataPin,4);
		var view = getLegend(dataPin);
		
		var info = analyseDataTwoCols(dataPin);
        //console.log("analytics info : ");
        //console.log(info);
		googleTranslate(info);
		
		var totalCount = totalRecords(dataPin,chart);
		//alert(totalCount);		
		
		
		chart.setDataTable(dataPin);
		
		//End lengend
        //Chart setting
		console.log(dataPin);
		chart.setDataTable(dataPin);
		chart.setOptions(options)
		chart.setView(view);
		chart.draw(); 
		setTimeout(function() {hideLoader();},delayMsec);
  }


	/**************************************************************************/	
		function totalRecords(dataState,chart){
		var total=0;
			for (var i = 0; i < dataState.getNumberOfRows(); i++) {
				var count = dataState.getValue(i, 1);
				total += count;
			}
			chart.setOption('title', "");	
			return total;
		}
		
		function setStateChart(){
			//alert(currentChartView);
			displayLoader();
			$.ajax({
                type: "POST",
                url: "setStateView.php",
                data: $("#my_form").serialize(),
                success: function () {
					drawChartState(1,chart);
				}
			});
			return 1;
		}
		
		
		function setTownChart(){
			//alert(currentChartView);
			displayLoader();
			$.ajax({
                type: "POST",
                url: "setTownView.php",
                data: $("#my_form").serialize(),
                success: function () {
				//alert("ok");
					drawTownChart(2,chart);
				}
			});
			return 1;
		}
		
		function setLocalityChart(){
			//alert(currentChartView);
			displayLoader();
			$.ajax({
                type: "POST",
                url: "setLocalityView.php",
                data: $("#my_form").serialize(),
                success: function () {
				//alert("ok");
					drawChartArea(3,chart);
				}
			});
			return 1;
		}
		
	function setPinChart(){
			//alert(currentChartView);
			displayLoader();
			$.ajax({
                type: "POST",
                url: "setPinView.php",
                data: $("#my_form").serialize(),
                success: function () {
				//alert("ok pin");
					drawChartPincode(4,chart);
				}
			});
			return 1;
		
		
		}
		
	function resetCharts(){
			//location.reload();
			console.log("reset");
			displayLoader();
			start_chart();
			return 1;
		
		}


		$(window).resize(function(){
			  resetCharts();
			});

		
	function googleTranslate(infoData){
			//alert("Ok");
			var dataString = 'text='+infoData;				
					$.ajax({
					type: "POST",
					url: "translate.php",
					data: dataString,
					cache: false,
					success: function (html) {
					$("#chartInfo").html(html);
					//alert("reset All");
						//drawChartState(1,chart);
					}
				});
		}
		
function displayLoader(){
			var n = document.getElementById('ajaxloader1');
			n.style.display = "block";
			/*
			$.blockUI({ css: { 
						border: 'none', 
						padding: '15px', 
						backgroundColor: '#000', 
						'-webkit-border-radius': '10px', 
						'-moz-border-radius': '10px', 
						opacity: .5, 
						color: '#fff' 
					}}); 
					$.blockUI({ overlayCSS: { backgroundColor: '#ffffff' } }); 
					setTimeout($.unblockUI, 2000); 
			*/		
			
		};
		
		function hideLoader(){
			var n = document.getElementById('ajaxloader1');
			n.style.display = "none";
		};
function setclassForCurrentView(currentView){
		if(currentView == 'state'){
			document.getElementById("reset").className = "imgClass";
			document.getElementById("state").className = "selectedState";
			document.getElementById("town").className = "imgClass";
			document.getElementById("location").className = "imgClass";
			document.getElementById("pin").className = "imgClass";
		}
		
		
		if(currentView == 'town'){
			document.getElementById("reset").className = "imgClass";
			document.getElementById("state").className = "imgClass";
			document.getElementById("town").className = "selectedState";
			document.getElementById("location").className = "imgClass";
			document.getElementById("pin").className = "imgClass";
		}
					
		if(currentView == 'location'){
			document.getElementById("reset").className = "imgClass";
			document.getElementById("state").className = "imgClass";
			document.getElementById("town").className = "imgClass";
			document.getElementById("location").className = "selectedState";
			document.getElementById("pin").className = "imgClass";
		
		}
		
		if(currentView == 'pin'){
			document.getElementById("reset").className = "imgClass";
			document.getElementById("state").className = "imgClass";
			document.getElementById("town").className = "imgClass";
			document.getElementById("location").className = "imgClass";
			document.getElementById("pin").className = "selectedState";
		}
		
		if(currentView == 'reset'){
			document.getElementById("reset").className = "selectedState";
			document.getElementById("state").className = "imgClass";
			document.getElementById("town").className = "imgClass";
			document.getElementById("location").className = "imgClass";
			document.getElementById("pin").className = "imgClass";
		}
		}
			//triger when click the button
viewChart =  function(value){

	// this function get called when button is clicked
	console.log("viewChart called as result of button click",value);
	// I need to pass identify and select filters


                var selectedValueString = "";
             $('#selectFilter :selected').each(function(i, selected){ 

             		selectedValueString += "'"+$(selected).val()+"',";
                  //statusSelectionArray.push($(selected).val());
                });

             selectedValueString = selectedValueString.slice(0,-1);

             // get idenfy value

             var identify_pass = document.getElementById("identify").value;

             console.log(identify_pass+"  nil identify");
             

             console.log(selectedValueString);            
            switch(value){
                
                case 1:
					//alert("I n switch "+ currentChartView);
					if(currentChartView == 1){
						//setStateChart();
						drawChartState(1,chart,selectedValueString);
					}else{
						drawChartState(1,chart,selectedValueString);
					}
					setclassForCurrentView('state');
                    break;
                case 2:
					//alert("I n switch "+ currentChartView);
					if(currentChartView == 2){
						setTownChart();
					}else{
						drawTownChart(2,chart,selectedValueString);
					}
				
                    setclassForCurrentView('town');
                    break;
                case 3:
                    //drawChartArea(3,chart);
					//alert("I n switch "+ currentChartView);
					if(currentChartView == 3){
						setLocalityChart();
					}else{
					//alert("I n switch function called");
						drawChartArea(3,chart);
					}
					setclassForCurrentView('location');
                    break;
                case 4:
                    //drawChartPincode();
					//alert("I n switch "+ currentChartView);
					if(currentChartView == 4){
						setPinChart();
					}else{
						drawChartPincode(4,chart);
					}
					setclassForCurrentView('pin');
                    break;
				case 5:
                    resetCharts(5);
					setclassForCurrentView('reset');
                    break;
            }
			}
			
			//triger when chart view chages 

			
			/*******************************/
function analyseDataTwoCols(dataToTest){
        /****************************** Data for MaxMinPareto ***************************/
        //var numb = Object.keys(dataToTest['zf']).length;
		var numb = dataToTest.getNumberOfRows();
        //console.log("Total count zf : "+numb);
        if(numb > 5){
            var values = new Array();
            for(var i=0; i<numb; i++){
              values[i] = new Object();
            }
            
            //console.log(dataToTest['zf'][0]['c'][0].v);
            //console.log(dataToTest['zf'][0]['c'][1].v);
            for(var i=0; i<numb; i++){
                // values[i].auto_credit = Object(dataToTest['zf'][i]['c'][1].v);
                // values[i].Name = dataToTest['zf'][i]['c'][0].v;
				values[i].auto_credit = dataToTest.getValue(i, 1);
                values[i].Name = dataToTest.getValue(i, 0);
            }

			/*****MAX*****/
            var maxValues = new Array();
            maxValues = getMax3(values);
            var max_min_string = '';
            for(var i=0; i<3; i++){
                max_min_string += (maxValues[i].Name + ', ');
            }
            //max_min_string += "are Leading group.";

            /*****MIN*****/

            //max_min_string += " while ";
            for(var i=0; i<numb; i++){
                // values[i].auto_credit = Object(dataToTest['zf'][i]['c'][1].v);
                // values[i].Name = dataToTest['zf'][i]['c'][0].v;
				
				values[i].auto_credit = dataToTest.getValue(i, 1);
                values[i].Name = dataToTest.getValue(i, 0);
				
            }

            var minValues = new Array();
            minValues = getMin3(values);

            for(var i=0; i<3; i++){
                max_min_string += (minValues[i].Name + ', ');
            }
            //max_min_string += "are Trailing.";
            //console.log("analysis : "+max_min_string);
            
            /***** Pareto *****/

            for(var i=0; i<numb; i++){
                // values[i].auto_credit = Object(dataToTest['zf'][i]['c'][1].v);
                // values[i].Name = dataToTest['zf'][i]['c'][0].v;
				
				values[i].auto_credit = dataToTest.getValue(i, 1);
                values[i].Name = dataToTest.getValue(i, 0);
				
            }

            var percent = getPareto(values);
            //console.log("The Top 20 Percent has contributed upto "+percent);
            //max_min_string += " The Top 20 Percent has contributed upto "+percent;
            return max_min_string;
        } else {
				var values = new Array();
				for(var i=0; i<numb; i++){
				  values[i] = new Object();
				}
				
				//console.log(dataToTest['zf'][0]['c'][0].v);
				//console.log(dataToTest['zf'][0]['c'][1].v);
				for(var i=0; i<numb; i++){
					values[i].auto_credit = dataToTest.getValue(i, 1);
					values[i].Name = dataToTest.getValue(i, 0);
					//console.log(values[i].Name);
					dataToTest.getValue(i, 0);
				}
				
				var maxValues = getMax(values);
				var max_min_string = maxValues[0].Name;
				
				//max_min_string += " is Leading group.";
				//console.log("This in else part");
				//console.log(max_min_string);
				/*****MIN*****/

				//max_min_string += " while ";
				for(var i=0; i<numb; i++){
					// values[i].auto_credit = Object(dataToTest['zf'][i]['c'][1].v);
					// values[i].Name = dataToTest['zf'][i]['c'][0].v;
					values[i].auto_credit = dataToTest.getValue(i, 1);
					values[i].Name = dataToTest.getValue(i, 0);
				}

				var minValues = new Array();
				minValues = getMin(values);

				
				max_min_string += (minValues[0].Name + ', ');
				
				//max_min_string += "is Trailing.";
				//console.log("analysis : "+max_min_string);
				
				
				
				/***** Pareto *****/

				for(var i=0; i<numb; i++){
					// values[i].auto_credit = Object(dataToTest['zf'][i]['c'][1].v);
					// values[i].Name = dataToTest['zf'][i]['c'][0].v;
					values[i].auto_credit = dataToTest.getValue(i, 1);
					values[i].Name = dataToTest.getValue(i, 0);
					
				}

				var percent = getPareto(values);
				//console.log("The Top 20 Percent has contributed upto "+percent);
				//max_min_string += " The Top 20 Percent has contributed upto "+percent;
				return max_min_string;
        }
        /*********************************************************/
		
		/************umanh functions ***********************/

function swap(a,b,param){
       var temp = a[param];
       a[param] = b[param];
       b[param] = temp;
      }

   function getMax3(values){
        var maxValues = new Array();
        
        for(var i=0; i<3; i++){
          maxValues[i] = new Object();
          maxValues[i].auto_credit = 0;
          maxValues[i].Name = '';
        }

        for(var i=0; i<Object.keys(values).length; i++){
          if(values[i].auto_credit > maxValues[0].auto_credit){
            swap(values[i],maxValues[0],'auto_credit');
            maxValues[0].Name = values[i].Name;
            if(maxValues[0].auto_credit > maxValues[1].auto_credit){
              swap(maxValues[0],maxValues[1],'auto_credit');
              swap(maxValues[0],maxValues[1],'Name');
            }
            if(maxValues[1].auto_credit > maxValues[2].auto_credit){
              swap(maxValues[1],maxValues[2],'auto_credit');
              swap(maxValues[1],maxValues[2],'Name');
            }
          }
        }
        return maxValues;
      }
	  
	   function getMax(values){
		//alert(values.toSource());
        var maxValues = new Array();
        
        
          maxValues[0] = new Object();
          maxValues[0].auto_credit = 0;
          maxValues[0].Name = '';
       

        for(var i=0; i<Object.keys(values).length; i++){
          if(values[i].auto_credit > maxValues[0].auto_credit){
            swap(values[i],maxValues[0],'auto_credit');
            maxValues[0].Name = values[i].Name;
            
          }
        }
        return maxValues;
      }
	  
	  function getMin(values){
        var minValues = new Array();
          minValues[0] = new Object();
          minValues[0].auto_credit = Number.MAX_VALUE;
          minValues[0].Name = '';
        

        for(var i=0; i<Object.keys(values).length; i++){
          if(values[i].auto_credit < minValues[0].auto_credit){
            swap(values[i],minValues[0],'auto_credit');
            minValues[0].Name = values[i].Name;
          }
        }
        return minValues;
      }

      function getMin3(values){
        var minValues = new Array();
        
        for(var i=0; i<3; i++){
          minValues[i] = new Object();
          minValues[i].auto_credit = Number.MAX_VALUE;
          minValues[i].Name = '';
        }

        for(var i=0; i<Object.keys(values).length; i++){
          if(values[i].auto_credit < minValues[0].auto_credit){
            swap(values[i],minValues[0],'auto_credit');
            minValues[0].Name = values[i].Name;
            if(minValues[0].auto_credit < minValues[1].auto_credit){
              swap(minValues[0],minValues[1],'auto_credit');
              swap(minValues[0],minValues[1],'Name');
            }
            if(minValues[1].auto_credit < minValues[2].auto_credit){
              swap(minValues[1],minValues[2],'auto_credit');
              swap(minValues[1],minValues[2],'Name');
            }
          }
        }
        return minValues;
      }

      function getPareto(values){
        var top20P = new Array();
        var sum = 0;
        var top20PLen = Math.floor((Object.keys(values).length*0.2));

        if(top20PLen > 0){
          for(var i=0; i<top20PLen;i++){
            top20P[i] = new Object();
            top20P[i].auto_credit = 0;
            top20P[i].Name = '';
          }

          for(var i=0; i<Object.keys(values).length; i++){
            sum += values[i].auto_credit;
            if(values[i].auto_credit > top20P[0].auto_credit){
              swap(values[i],top20P[0],'auto_credit');
              top20P[0].Name = values[i].Name;
              for(var j=0; j<top20PLen-1; j++){
                if(top20P[j].auto_credit > top20P[j+1].auto_credit){
                  swap(top20P[j],top20P[j+1],'auto_credit');
                  swap(top20P[j],top20P[j+1],'Name');
                }
              }
            }
          }

          var sumTop20 = 0;
          for(var i=0; i<top20PLen;i++){
            sumTop20 += top20P[i].auto_credit;
          }

          return ((sumTop20/sum)*100).toFixed(2)+'%';
        } else {
          return 100+'%';
        }       
      }
		/**********************************************************/
    }
			
    </script>
	
</head>
  <body>

	


	<div class="container">

	<div class="row">
		<div class="col-sm-2" style="margin-top:10%">
			<form id='my_form'>
			<select  name="selectFilter[]" style='' multiple id="selectFilter" size='8'>

			</select>
			</form>
			<input type="hidden" id="identify" name="identify" value="1" >
		</div>

		<div class="col-sm-10">
			<div style="" id="chartInfo"> <marquee> <font color="red"></font></marquee></div>
    <div id="chart_div" style=""></div>
	<div style="" id="ajaxloader1"></div>
		</div>
	</div>
	<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-10">
	<form>

	<input class="imgClass"  type="button" value="Reset" id="reset" name="reset" onclick="viewChart(5)"/> 
	<input style='margin-left: 50px;' class="imgClass"  type="button" value="State" id="state" name="state" onclick="viewChart(1)"/> 
	<input class="imgClass"  type="button" value="Town" id="town" name="town" onclick="viewChart(2)"/> 
	<input class="imgClass"  type="button" value="Locality" id="location" name="location" onclick="viewChart(3)"/> 
	<input class="imgClass"  type="button" value="Pin" id="pin" name="pin" onclick="viewChart(4)"/> 
	
	
	</form>
	</div>
	</div>
		


	</div>
	
	

  </body>
</html>