function placeImages(padding){

	d3.selectAll(".leaderImages").select(function(){
		d3.select(this).style("height",0.9*padding);
		d3.select(this).style("width",0.9*padding);
	});

	d3.selectAll(".leaderSpan").select(function(){
		d3.select(this).style("width",0.9*padding);
	})

	d3.selectAll(".rightImage").select(function(){
		if(d3.select(this).style("position")!="fixed"){
			d3.select(this).style("right",0.05*padding);
		}
		else{
			d3.select(this).style("right",(0.05*parseFloat(d3.select("#textWrapper").style("padding-right")))+parseFloat(d3.select("#textWrapper").style("margin-right"))+parseFloat(d3.select("#contentWrapper").style("margin-right")))
		}	
	});

	d3.selectAll(".leftImage").select(function(){
		if(d3.select(this).style("position")!="fixed"){
			d3.select(this).style("left",0.05*padding);
		}
		else{
			d3.select(this).style("left",(0.05*parseFloat(d3.select("#textWrapper").style("padding-left")))+(parseFloat(d3.select("#textWrapper").style("margin-left")))+parseFloat(d3.select("#contentWrapper").style("margin-left")))
		}
	});
}

function displayAll(){
	d3.selectAll(".keyevents").remove();
	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.style("display",null)
		.transition(g)
		.style("fill-opacity",1);

//.filter(function(d){return d.Year>1992})
	d3.selectAll(".prov")
		.style("display",null)	
		.transition(g)
		.style("fill-opacity",1);
}
 
function attachNegotiationEvents(d){
	if(d3.select(this).style("fill")!=="rgb(255, 255, 255)"){
		d3.select(this)
		.style("stroke","#E8336D")
		.style("stroke-width","2px")
		.style("stroke-dasharray","60");
		
		this.parentNode.parentNode.appendChild(this.parentNode);
		this.parentNode.appendChild(this);

		var localNegoData = negoData.filter(function(w){return ((w.Year==d.Year)&&(w.Month==d.Month))});

		if(localNegoData.length!=0){
			var negoBox = d3.select("#tooltip")
				.append("div")
				.attr("class","tooltipNegotiation");

			negoBox
				.append("span")
				.attr("class","tooltipDate")
				.text(localNegoData[0]['Month']+" "+localNegoData[0]['Year']);
			for(var i=0;i<localNegoData.length;i++)
			{
				

				negoBox
				.append("span")
				.attr("class","tooltipType negotiationColor")
				.text((i+1)+". "+localNegoData[i]['Event Type']);
				

				negoBox
				.append("p")
				.attr("class","tooltipDescription")
				.text(localNegoData[i]['Description']);
				

				var partyBox = negoBox.append("div").attr("class","tooltipParties");

				var nationString = localNegoData[i]['Parties Involved'].split(',');
				var leaderString = localNegoData[i]['Leadership'].split(',');

				for(var j=0;j<leaderString.length;j++){
					var theParty = partyBox.append("div").attr("class","party");
					theParty.append("img").attr("class","countryFlags").attr("src","flags/"+nationString[j].trim()+".png");
					theParty.append("span").attr("class","leaderName").text(leaderString[j]);
					//partyBox.append("span").attr("class","nationName").text(nationString[j]);;
				}
			}
			d3.select("#tooltip")
			.style("display","block")
			
			if((this.getBoundingClientRect().top+20+document.getElementById('tooltip').clientHeight)>window.innerHeight){
				d3.select("#tooltip")
				.style("top",window.innerHeight-document.getElementById('tooltip').clientHeight-20)
				.style("left",this.getBoundingClientRect().left+20);
			}
			else{
				d3.select("#tooltip")
				.style("top",this.getBoundingClientRect().top+20)
				.style("left",this.getBoundingClientRect().left+20);
			}
		}
	}
}

function removeNegotiationEvents(){
	
	var firstChild = this.parentNode.parentNode.firstChild; 
    if(firstChild){ 
    	this.parentNode.parentNode.insertBefore(this.parentNode, firstChild); 
	} 
	firstChild = this.parentNode.firstChild; 
	if(firstChild){ 
    	this.parentNode.insertBefore(this, firstChild); 
	}

	d3.select(this)
	.style("stroke",null)
	.style("stroke-width",null)
	.style("stroke-dasharray"," 0,60");

	d3.select("#tooltip").style("display","none");
	d3.selectAll(".tooltipNegotiation").remove();
}

function attachProvocationEvents(d){
	if(d3.select(this).style("fill")!=="rgb(255, 255, 255)"){
				d3.select(this)
				.style("stroke","#E8336D")
				.style("stroke-width","2px")
				.style("stroke-dasharray","60");
				
				this.parentNode.parentNode.appendChild(this.parentNode);
				this.parentNode.appendChild(this);

				var localProvData = provData.filter(function(w){return ((w.Year==d.Year)&&(w.Month==d.Month))});

				if(localProvData.length!=0){
					var provBox = d3.select("#tooltip")
						.append("div")
						.attr("class","tooltipNegotiation");

					provBox
						.append("span")
						.attr("class","tooltipDate")
						.text(localProvData[0]['Month']+" "+localProvData[0]['Year']);
					for(var i=0;i<localProvData.length;i++)
					{
						provBox
						.append("span")
						.attr("class","tooltipType provocationColor")
						.text((i+1)+". "+localProvData[i]['Event']);

						provBox
						.append("p")
						.attr("class","tooltipDescription")
						.text(localProvData[i]['Description']);
					}

					d3.select("#tooltip")
					.style("display","block");



					if((this.getBoundingClientRect().top+20+document.getElementById('tooltip').clientHeight)>window.innerHeight){
						d3.select("#tooltip")
						.style("top",window.innerHeight-document.getElementById('tooltip').clientHeight-20)
						.style("left",this.getBoundingClientRect().left+20);
					}
					else{
						d3.select("#tooltip")
						.style("top",this.getBoundingClientRect().top+20)
						.style("left",this.getBoundingClientRect().left+20);
					}
				}
			}
}

function removeProvocationEvents(){
	var firstChild = this.parentNode.parentNode.firstChild; 
	        if(firstChild){ 
	        	this.parentNode.parentNode.insertBefore(this.parentNode, firstChild); 
			} 
			firstChild = this.parentNode.firstChild; 
			if(firstChild){ 
	        	this.parentNode.insertBefore(this, firstChild); 
			} 
			d3.select(this)
			.style("stroke",null)
			.style("stroke-width",null)
			.style("stroke-dasharray"," 0,60");

			d3.select("#tooltip").style("display","none");
			d3.selectAll(".tooltipNegotiation").remove();
}
function action1on(){
	const type = d3.annotationCalloutRect;
	const annotations = [{
		x: 45,
		y: 30,
		subject: {
		width: 30,
		height: 15
		}
	}]
	makeAnnotations = d3.annotation().type(type).annotations(annotations);

	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);
  	var i=0;


    d3.select("#calendar")
  		.append("g")
  		.attr("class", "annotation-group")
  		.call(makeAnnotations);

  	d3.selectAll(".annotation.callout.rect")
    	.transition(g)
    	.delay(1000)
    	.on("start",repeat);
    				
    function repeat() {
    	i+=1;
    	if(i>=317){
    		i=0;
    	}
    	xPos = ((30*i)%360)+45;
    	yPos = (15*Math.floor(i/12))+30;
        d3.active(this)
            .attr("transform","translate("+xPos+","+yPos+")")
            .transition(g)
            .delay(1000)
            .on("start", repeat);
	}
}

function action1off(){
	d3.selectAll(".annotation.callout.rect").transition();
	d3.select(".annotation-group").remove();

}

function action2on(){
	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".prov")
		.transition(g)
		.style("fill-opacity",0);

	d3.selectAll(".nego")
		.style("display",null)
		.transition(g)
		.style("fill-opacity",1);

}

function action2off(){
	d3.selectAll(".prov")
		.transition()
		.duration(500)
		.style("fill-opacity",1);
}

function action3on(){
	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".prov")
		.style("display",null)
		.transition(g)
		.style("fill-opacity",1);	

	d3.selectAll(".nego")
		.transition()
		.duration(500)
		.style("fill-opacity",0)
		.on("end", function(){d3.select(this).style("display","none")});
}



function action3off(){
	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);
	//		.filter(function(d){return d.Year>=1990&&d.Year<=1992})
	d3.selectAll(".nego")
		.style("display",null)
		.transition(g)
		.style("fill-opacity",1);

//.filter(function(d){return d.Year>1992})
	d3.selectAll(".prov")	
		.transition(g)
		.style("fill-opacity",1);
}

function action4on(){
	d3.selectAll(".keyevents").remove();
	const type = d3.annotationCalloutCircle

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const annotations = [
	{
	data:{
		month: "Dec", year: 1995, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Dec", year: 1997, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Aug", year: 1999, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	}
	,
	{
	data:{
		month: "Oct", year: 2002, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Aug", year: 2003, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Sep", year: 2005, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Nov", year: 2005, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Feb", year: 2007, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Dec", year: 2008, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Feb", year: 2012, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Jan", year: 1992, type:"Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "May", year: 2009, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Apr", year: 2012, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Feb", year: 2013, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Jan", year: 2016, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Sep", year: 2016, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Jul", year: 2017, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	},
	{
	data:{
		month: "Sep", year: 2017, type:"Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 0,
	 }
	}
	]

	const makeNegoAnnotations = d3.annotation()
	  .editMode(false)
	  .disable(["connector","note"])
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  })
	  .annotations(annotations.filter(function(d){return d.data.type=="Nego";}))

	const makeMiscAnnotations = d3.annotation()
	  .editMode(false)
	  .disable(["connector","note"])
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+60.5,
    y: d => yScale(d.year)+37.5
  })
	  .annotations(annotations.filter(function(d){return d.data.type=="Misc";}))

	const makeProvAnnotations = d3.annotation()
	  .editMode(false)
	  .disable(["connector","note"])
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+68.5,
    y: d => yScale(d.year)+37.5
  })
	  .annotations(annotations.filter(function(d){return d.data.type=="Prov";}))

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeNegoAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeMiscAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeProvAnnotations)

}

function action4off(){
	d3.selectAll(".keyevents").remove();
}

function action5on(){
	d3.selectAll(".keyevents").remove();
	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. North Korea signs Joint Declaration of Denuclearization of Korean Peninsula"
  },
  dx:15,
  dy:50,
	data:{
		month: "Jan", year: 1992
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}]


	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(2).textWrap(168).annotations(annotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	
	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<1990||d.Year>1993||(d.Year==1993&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<1990||d.Year>1993||(d.Year==1993&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});
}

function action6on(){
	d3.selectAll(".keyevents").remove();
	
	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. North Korea declares intent to withdraw from NPT"
  },
  dx:15,
  dy:120,
	data:{
		month: "Mar", year: 1993
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "2. Former U.S. President Carter visits North Korea"
  },
  dx:15,
  dy:50,
	data:{
		month: "Jun", year: 1994
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}]


	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(2).textWrap(168).annotations(annotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if((d.Year==1993&&d.Month=="Jan")||d.Year<1993||d.Year>1994||(d.Year==1994&&(d.Month=="Jul"||d.Month=="Aug"||d.Month=="Sep"||d.Month=="Oct"||d.Month=="Nov"||d.Month=="Dec"))){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if((d.Year==1993&&d.Month=="Jan")||d.Year<1993||d.Year>1994||(d.Year==1994&&(d.Month=="Jul"||d.Month=="Aug"||d.Month=="Sep"||d.Month=="Oct"||d.Month=="Nov"||d.Month=="Dec"))){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});
}

function action7on(){
	d3.selectAll(".keyevents").remove();

	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. Geneva Agreed Framework signed"
  },
  dx:-115,
  dy:-13,
	data:{
		month: "Oct", year: 1994
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "2. KEDO Light Water Reactor Agreement signed"
  },
  dx:-15,
  dy:-38,
	data:{
		month: "Dec", year: 1995
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}]

	const annotations2 = [{
	note: {
    title: "4. Four Party Talks collapse"
  },
  dx:-50,
  dy:100,
	data:{
		month: "Aug", year: 1999
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "3. Four Party Talks begin"
  },
  dx:-15,
  dy:90,
	data:{
		month: "Dec", year: 1997
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}]

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-4).textWrap(168).annotations(annotations)

const makeAnnotations2 = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(4).textWrap(168).annotations(annotations2)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations2)


	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<1994||d.Year>2001||(d.Year==2001&&d.Month!=="Jan")||(d.Year==1994&&(d.Month=="Jan"||d.Month=="Feb"||d.Month=="Mar"||d.Month=="Apr"||d.Month=="May"||d.Month=="Jun"))){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<1994||d.Year>2001||(d.Year==2001&&d.Month!=="Jan")||(d.Year==1994&&(d.Month=="Jan"||d.Month=="Feb"||d.Month=="Mar"||d.Month=="Apr"||d.Month=="May"||d.Month=="Jun"))){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});
}

function action8on(){
	d3.selectAll(".keyevents").remove();

	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. North Korea admits HEU program"
  },
  dx:-15,
  dy:-100,
	data:{
		month: "Oct", year: 2002
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "4. Six Party Talks begin"
  },
  dx:-15,
  dy:-50,
	data:{
		month: "Aug", year: 2003
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "2. KEDO heavy fuel oil shipments suspended"
  },
  dx:-15,
  dy:-140,
	data:{
		month: "Nov", year: 2002
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "3. North Korea announces withdrawal from NPT"
  },
  dx:15,
  dy:-75,
	data:{
		month: "Jan", year: 2003
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}];

	const annotations2 = [{
	note: {
    title: "7. Six Party Talks Joint Statement Implementation"
  },
  nx:15,
  ny:95,
	data:{
		month: "Feb", year: 2007
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "8. Six Party Talks collapse"
  },
  nx:-1,
  ny:110,
	data:{
		month: "Dec", year: 2008
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "5. Six Party Talks Joint Statement"
  },
  dx:-15,
  dy:62,
	data:{
		month: "Sep", year: 2005
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},
	{
	note: {
    title: "6. KEDO Project terminated"
  },
  dx:-1,
  dy:100,
	data:{
		month: "Nov", year: 2005
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}];

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-2).textWrap(168).annotations(annotations)

	const makeAnnotations2 = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(2).textWrap(168).annotations(annotations2)

/*
const makeAnnotations2 = d3.annotation()
	  .editMode(false)
	  .type(type2)
	   .accessors({
    x: d => xScale(d.month)+60,
    y: d => yScale(d.year)+47.5
  }).notePadding(4).textWrap(168).annotations(annotations2)*/

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations2)


	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<2001||d.Year>2009||(d.Year==2009&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<2001||d.Year>2009||(d.Year==2009&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});
}

function action9on(){
	d3.selectAll(".keyevents").remove();

	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. North Korea's second nuclear test"
  },
  dx:15,
  dy:-30,
	data:{
		month: "May", year: 2009
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "3. Shelling of Yeonpyeong Island by North Korea"
  },
  dx:-15,
  dy:60,
	data:{
		month: "Nov", year: 2010
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "2. Sinking of ROKS Cheonan"
  },
  dx:15,
  dy:30,
	data:{
		month: "Mar", year: 2010
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}]


	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+67.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(2).textWrap(168).annotations(annotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<2009||d.Year>2011||(d.Year==2009&&d.Month=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<2009||d.Year>2011||(d.Year==2009&&d.Month=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});
}

function action10on(){
	d3.selectAll(".keyevents").remove();

	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. Leap Day Agreement"
  },
  dx:15,
  dy:-105,
	data:{
		month: "Feb", year: 2012, type: "Nego"
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "2. North Korea's third nuclear test"
  },
  dx:15,
  dy:-65,
	data:{
		month: "Feb", year: 2013, type: "Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "3. North Korea's fourth nuclear test"
  },
  dx:0,
  dy:-200,
	data:{
		month: "Jan", year: 2016, type: "Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	},{
	note: {
    title: "4. North Korea's fifth nuclear test"
  },
  dx:-10,
  dy:-85,
	data:{
		month: "Sep", year: 2016, type: "Prov"
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}];

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+52.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-2).textWrap(200).annotations(annotations.filter(function(d){return d.data.type=="Nego"}));

	const makeAnnotations2 = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+67.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-2).textWrap(200).annotations(annotations.filter(function(d){return d.data.type=="Prov"}));

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations2)


	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<2012||(d.Year==2017&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<2012||(d.Year==2017&&d.Month!=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
	});
}

function action11on(){
	d3.selectAll(".keyevents").remove();

	const type = d3.annotationCustomType(
  d3.annotationCalloutCircle, 
  {"className":"custom",
    "connector":{"type":"elbow"},
    "note":{"lineType":"horizontal"}})

	const annotations = [{
	note: {
    title: "1. North Korea successfully tests ICBM Hwasong-14 twice"
  },
  dx:15,
  dy:-90,
	data:{
		month: "Jul", year: 2017
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}];

	const annotations2= [{
	note: {
    title: "2. North Korea's sixth nuclear test"
  },
  dx:15,
  dy:-30,
	data:{
		month: "Sep", year: 2017
	},
	  subject: {
	radius: 14,
	radiusPadding: 1,
	 }
	}];

	var xScale =  d3.scaleBand()
	.domain(["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"])
	.range([0, 360]);

	var yScale =  d3.scaleLinear()
	.domain([1990,2017])
	.range([0, 405]);

	const makeAnnotations = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+67.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-5).textWrap(140).annotations(annotations)

	const makeAnnotations2 = d3.annotation()
	  .editMode(false)
	  .type(type)
	   .accessors({
    x: d => xScale(d.month)+67.5,
    y: d => yScale(d.year)+37.5
  }).notePadding(-5).textWrap(80).annotations(annotations2)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations)

	d3.select("svg")
	  .append("g")
	  .attr("class", "keyevents")
	  .call(makeAnnotations2)

	var g = d3.transition().duration(500).ease(d3.easeQuadInOut);

	d3.selectAll(".nego")
		.select(function(d){
			if(d.Year<2017||(d.Year==2017&&d.Month=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
		});

	d3.selectAll(".prov")
		.select(function(d){
			if(d.Year<2017||(d.Year==2017&&d.Month=="Jan")){
				d3.select(this)
				.transition(g)
				.style("fill-opacity",0)
				.on("end", function(){d3.select(this).style("display","none")});
			}else{
				d3.select(this)
				.style("display",null)
				.transition(g)
				.style("fill-opacity",1);
			}
	});
}

