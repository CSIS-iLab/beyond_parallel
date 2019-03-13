console.log("This interactive was made by Immigrants");
console.log("****")
console.log("I, too by Langston Hughes");
console.log("\n");
console.log("I, too, sing America.\nI am the darker brother. \nThey send me to eat in the kitchen \nWhen company comes, \nBut I laugh, \nAnd eat well, \nAnd grow strong. \n\nTomorrow, \nI’ll be at the table \nWhen company comes. \nNobody’ll dare \nSay to me, \n“Eat in the kitchen,” \nThen. \n\nBesides, \nThey’ll see how beautiful I am \nAnd be ashamed— \n\nI, too, am America.");

$(window).load(function(){
	if(window.navigator.userAgent.indexOf("Trident")!=-1||window.navigator.userAgent.indexOf("Edge")!=-1){
		window.alert("We noticed that you may be using Microsoft Internet Explorer.\n\nTo best experience this website please consider using Google Chrome, Mozilla Firefox or Apple Safari");
	}

	if(!(window.navigator.userAgent.includes("mobi")||window.navigator.userAgent.includes("Mobi")||window.navigator.userAgent.includes("iPad"))){
	resize();
	setup();
	var q = d3.queue()
    .defer(d3.csv, "USKoreaData.csv")
    .defer(d3.csv, "Negotiations.csv")
    .defer(d3.csv, "Provocations.csv")
    .awaitAll(makeStuff);
	}
	else{
		mobileSetup();
		var q = d3.queue()
	    .defer(d3.csv, "USKoreaData.csv")
	    .defer(d3.csv, "Negotiations.csv")
	    .defer(d3.csv, "Provocations.csv")
	    .awaitAll(makeStuff);
	}
});

var calendar = d3.select("#calendar");

var makeAnnotations;
var theData;
var negoData;
var provData;

function makeStuff(error,data){

	theData = data[0];
	negoData = data[1];
	provData = data[2];

	var NegoMax = 0;
	var ProvMax = 0;
	
	for(var i=0;i<theData.length;i++){
		if(theData[i].Nego>NegoMax){
			NegoMax=theData[i].Nego;
		}
		if(theData[i].Prov>ProvMax){
			ProvMax=theData[i].Prov;
		}
	}
	
	var provColor = d3.scaleQuantize()
	.domain([0,ProvMax])
	.range(["#fee5d9","#fcae91","#fb6a4a","#cb181d"]);

	var negoColor = d3.scaleQuantize()
	.domain([0,NegoMax])
	.range(["#eff3ff", "#bdd7e7", "#6baed6","#2171b5"]);

	calendar.append("g").attr("id","rows").selectAll('g')
	.data(theData)
	.enter()
	.append("g")
	.attr("class","row")
	.attr("transform", "translate(45,30)");

	d3.selectAll(".row")
	.append("rect")
	.attr("x",function(d,i){return ((30*i)%360)})
	.attr("y",function(d,i){return (15*Math.floor(i/12))})
	.attr('width','15')
	.attr('height','15')
	.attr('Year',function(d){return d.Year;})
	.attr('Month',function(d){return d.Month;})
	.attr("fill",function(d){if(d.Nego==0){return "white"} else{d3.select(this).attr("class","nego box");return negoColor(d.Nego)}});
	

	d3.selectAll(".row")
	.append("rect")
	.attr('width','15')
	.attr('height','15')
	.attr('data',function(d){return d.Year;})
	.attr("x",function(d,i){return (15+(30*i)%360)})
	.attr("y",function(d,i){return (15*Math.floor(i/12))})
	.attr("fill",function(d){if(d.Prov==0){return "white"} else {d3.select(this).attr("class","prov box");return provColor(d.Prov)}});

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);
	var xAxis = d3.axisTop(xScale)
	.tickSizeOuter(0);
	
	var xGridScale = d3.scaleLinear().domain([0,12]).range([0, 360]);
	var xGrid = d3.axisTop(xGridScale)
	.tickSizeOuter(0)
	.tickSize(-420)
	.tickFormat("");

	calendar.append("g")
	.attr('height','25px')
	.attr("transform", "translate(45,30)")
	.attr('id','xAxis')
	.style("background","black")
	.call(xAxis)
	.selectAll("text")
	.attr("transform", "rotate(-45 0,0) translate(0,0) ")
	.style("text-anchor", "start");

	calendar.append("g")
	.attr("class","grid")
	.attr("transform", "translate(45,30)")
	.call(xGrid);

	var yGridScale = d3.scaleLinear().domain([0,12]).range([0, 420]);
	var yGrid = d3.axisLeft(yGridScale)
	.tickSizeOuter(0)
	.ticks(0)
	.tickSize(-361)
	.tickFormat("");

	var yScale =  d3.scaleTime()
	.domain([new Date(1989, 5, 1), new Date(2017, 5, 1)])
	.range([0, 420]);
	var yAxis = d3.axisLeft(yScale)
	.ticks(15)
	.tickSizeOuter(0);

	calendar.append("g")
	.attr("transform", "translate(45,30)")
	.call(yGrid);

	calendar.append("g")
	.attr('id','Axis')
	.call(yAxis)
	.attr("transform","translate(45,30)");

	

	if(!(window.navigator.userAgent.includes("mobi")||window.navigator.userAgent.includes("Mobi"))){
		window.addEventListener('resize', _.debounce(resize, 150));
		
		d3.selectAll(".nego")
			.on("mouseenter",function(d){attachNegotiationEvents.call(this,d)})
			.on("mouseleave",function(d){removeNegotiationEvents.call(this)});

		d3.selectAll(".prov")
			.on("mouseenter",function(d){attachProvocationEvents.call(this,d)})
			.on("mouseleave",function(d){removeProvocationEvents.call(this)});	
}
}

function setup(){

	rightImageDown(d3.select("#dun1"),'dun1',document.getElementById('para5'));
	rightImageUp(d3.select("#dun1"),'dun1',document.getElementById('hwend'));
	rightImageDown(d3.select("#dun2"),'dun2',document.getElementById('para6'));
	rightImageUp(d3.select("#dun2"),'dun2',document.getElementById('clintonend'));
	rightImageDown(d3.select("#dun3"),'dun3',document.getElementById('para8'));
	rightImageUp(d3.select("#dun3"),'dun3',document.getElementById('bushend'));
	rightImageDown(d3.select("#dun4"),'dun4',document.getElementById('para9'));
	rightImageUp(d3.select("#dun4"),'dun4',document.getElementById('obamaend'));
	rightImageDown(d3.select("#dun5"),'dun5',document.getElementById('para11'));
	rightImageUp(d3.select("#dun5"),'dun5',document.getElementById('bothend'));

	leftImageDown(d3.select("#dum1"),'dum1',document.getElementById('para5'));
	leftImageUp(d3.select("#dum1"),'dum1',document.getElementById('regime1end'));
	leftImageDown(d3.select("#dum2"),'dum2',document.getElementById('para7'));
	leftImageUp(d3.select("#dum2"),'dum2',document.getElementById('regime2end'));
	leftImageDown(d3.select("#dum3"),'dum3',document.getElementById('para10'));
	leftImageUp(d3.select("#dum3"),'dum3',document.getElementById('bothend'));

	if(window.innerWidth>=1024){
		opacityWaypoint(window.innerHeight*0.5);
		introParaWaypoint(window.innerHeight*0.5);
		makeWaypoint1(window.innerHeight*0.5);
		makeWaypoint2(window.innerHeight*0.5);
		makeWaypoint3(window.innerHeight*0.5);
		makeWaypoint4(window.innerHeight*0.5);
		makeWaypoint5(window.innerHeight*0.5);
		makeWaypoint6(window.innerHeight*0.5);
		makeWaypoint7(window.innerHeight*0.5);
		makeWaypoint8(window.innerHeight*0.5);
		makeWaypoint9(window.innerHeight*0.5);
		makeWaypoint10(window.innerHeight*0.5);
		makeWaypoint11(window.innerHeight*0.5);
		makeWaypoint12(window.innerHeight*0.5);
	}
	else{
		opacityWaypoint(window.innerHeight*0.9);
		introParaWaypoint(window.innerHeight*0.9);
		makeWaypoint1(window.innerHeight*0.9);
		makeWaypoint2(window.innerHeight*0.9);
		makeWaypoint3(window.innerHeight*0.9);
		makeWaypoint4(window.innerHeight*0.9);
		makeWaypoint5(window.innerHeight*0.9);
		makeWaypoint6(window.innerHeight*0.9);
		makeWaypoint7(window.innerHeight*0.9);
		makeWaypoint8(window.innerHeight*0.9);
		makeWaypoint9(window.innerHeight*0.9);
		makeWaypoint10(window.innerHeight*0.9);
		makeWaypoint11(window.innerHeight*0.9);
		makeWaypoint12(window.innerHeight*0.9);
	}
	calendarStop();
}

function resize(){
	if(window.innerWidth>=1024){
		d3.select("#calendar")
		.style("width",0.325*document.getElementById("contentWrapper").getBoundingClientRect().width)
		.style("height",null);

		d3.select("#calendarContainer")
		.style("width",d3.select("#calendar").style("width"))
		.style("height",null)
		.style("margin-left",0.050*document.getElementById("contentWrapper").getBoundingClientRect().width)
		.style("margin-right",0.025*document.getElementById("contentWrapper").getBoundingClientRect().width)
		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
		.style("left",document.getElementById('contentWrapper').getBoundingClientRect().left);

		d3.select("#textWrapper")
		.style("width",null)
		.style("margin-top",d3.select("#calendarContainer").style("top"))
		.style("margin-left",null)
		.style("margin-right",null)
		.style("padding-right",null)
		.style("padding-left",null);

		d3.selectAll(".textpara")
		.style("width",null)
		.style("padding",null);

		d3.select("#legend").style("display",null);

		d3.selectAll(".nego")
			.on("touchstart",function(d){attachNegotiationEvents.call(this,d)})
			.on("touchend",function(d){removeNegotiationEvents.call(this)})

		d3.selectAll(".prov")
			.on("touchstart",function(d){attachProvocationEvents.call(this,d)})
			.on("touchend",function(d){removeProvocationEvents.call(this)})
		
		placeImages(parseFloat(d3.select("#textWrapper").style("padding-right")));
	}
	else{
		d3.select("#calendar")
		.style("width",0.70*window.innerWidth)
		.style("height",null);

		d3.select("#calendarContainer")
		.style("height",null)
		.style("width",document.getElementById('calendar').clientWidth)
		.style("margin-left",0.5*(window.innerWidth-document.getElementById('calendar').clientWidth))
		.style("margin-right",0.5*(window.innerWidth-document.getElementById('calendar').clientWidth))
		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
		.style("left",0);

		d3.select("#textWrapper")
		.style("margin-top",(window.innerHeight/2)-(document.getElementById('landingSpot').clientHeight/2));

		placeImages(parseFloat(d3.select("#textWrapper").style("padding-right")));
	}
}

function mobileWindowResize(){
	d3.select("#calendarContainer")
		.transition()
		.duration(300)
		.ease(d3.easeQuadInOut)
		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2));
	window.addEventListener('resize',mobileWindowResize);
}

function mobileSetup(){
	d3.selectAll(".image").remove();
	d3.select("#legend").remove();

	d3.select("#calendar")
		.style("height",null) 
		.style("width",window.innerWidth);

	d3.select("#calendarContainer")
		.style("width",document.getElementById('calendar').clientWidth)
		.style("margin-left",0.5*(window.innerWidth-document.getElementById('calendar').clientWidth))
		.style("margin-right",0.5*(window.innerWidth-document.getElementById('calendar').clientWidth))
		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
		.style("left",0);

	d3.select("#textWrapper")
		.style("width","95%")
		.style("margin-top",(window.innerHeight/2)-(document.getElementById('landingSpot').clientHeight/2))
		.style("margin-right",0)
		.style("margin-left",0)
		.style("padding-left","2.5%")
		.style("padding-right","2.5%");

	d3.selectAll(".textpara")
		.style("width","90%")
		.style("padding","5%")
		.style("background","#16222a")
		.style("color","white")
		.style("margin-top",window.innerHeight*0.7)
		.style("margin-bottom",window.innerHeight*0.7)
		.style("opacity",0.5);

	opacityWaypoint(window.innerHeight*0.9);
	introParaWaypoint(window.innerHeight*0.9);
	makeWaypoint1(window.innerHeight*0.9);
	makeWaypoint2(window.innerHeight*0.9);
	makeWaypoint3(window.innerHeight*0.9);
	makeWaypoint4(window.innerHeight*0.9);
	makeWaypoint5(window.innerHeight*0.9);
	makeWaypoint6(window.innerHeight*0.9);
	makeWaypoint7(window.innerHeight*0.9);
	makeWaypoint8(window.innerHeight*0.9);
	makeWaypoint9(window.innerHeight*0.9);
	makeWaypoint10(window.innerHeight*0.9);
	makeWaypoint11(window.innerHeight*0.9);
	makeWaypoint12(window.innerHeight*0.9);
	calendarStop();
}
