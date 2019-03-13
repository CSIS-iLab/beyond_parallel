function opacityWaypoint(theOffset){

	var elements = document.getElementsByClassName("textpara");
	Array.prototype.filter.call(elements, function(testElement,i){
	    
		new Waypoint({
			element: testElement,
			handler: function(direction) {

				if(i!==0){
					if(direction==="down"){
						d3.select(testElement)
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.9);

						d3.select(elements[i-1])
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.1);
					}
					else{
						d3.select(testElement)
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.1);

						d3.select(elements[i-1])
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.9);
					}
				}
				else{
					if(direction==="down"){
						d3.select(testElement)
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.9);
					}
					else{
						d3.select(testElement)
						.transition()
						.duration(400)
						.ease(d3.easeQuadInOut)
						.style("opacity",0.1);
					}
				}
			},
			offset: theOffset
		});
	});
}

function introParaWaypoint(theOffset){
	introWay = new Waypoint({
		element: document.getElementById('intropara'),
		handler: function(direction){
			if(direction==="down"){
				displayAll();
			}
			else{
				action4on();
			}
		},
		offset: theOffset
	});
}

function makeWaypoint1(theOffset){
waypointAction1 = new Waypoint({
		element: document.getElementById('para1'),
		handler: function(direction) {
			if(direction==="down"){
				action1on();
			}
			else{
				action1off();
			}
		},
		offset: theOffset
	});
}

function makeWaypoint2(theOffset){
waypointAction2 = new Waypoint({
		element: document.getElementById('para2'),
		handler: function(direction) {
			if(direction==="down"){
				action1off();
				action2on();
			}
			else{
				action1on();
				action2off();
			}
		},
		offset: theOffset
	});
}

function makeWaypoint3(theOffset){
	waypointAction3 = new Waypoint({
		element: document.getElementById('para3'),
		handler: function(direction) {
			if(direction==="down"){
				action2off();
				action3on();
			}
			else{
				action3off();
				action2on();
			}
		},
		offset: theOffset
	});
}

function makeWaypoint4(theOffset){
	waypointAction4 = new Waypoint({
	    element: document.getElementById('para4'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action3off();
    			action4on();
	    	}
	    	else{
	    		action4off();
    			action3on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint5(theOffset){
	waypointAction5 = new Waypoint({
	    element: document.getElementById('para5'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action5on();
	    	}
	    	else{
	    		displayAll();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint6(theOffset){
	waypointAction6 = new Waypoint({
	    element: document.getElementById('para6'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action6on();
	    	}
	    	else{
	    		action5on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint7(theOffset){
	waypointAction7 = new Waypoint({
	    element: document.getElementById('para7'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action7on();
	    	}
	    	else{
	    		action6on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint8(theOffset){
	waypointAction8 = new Waypoint({
	    element: document.getElementById('para8'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action8on();
	    	}
	    	else{
	    		action7on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint9(){
	waypointAction9 = new Waypoint({
	    element: document.getElementById('para9'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action9on();
	    	}
	    	else{
	    		action8on();
	    	}
	    },
	    offset: window.innerHeight/2
	});
}

function makeWaypoint10(theOffset){
	waypointAction10 = new Waypoint({
	    element: document.getElementById('para10'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action10on();
	    	}
	    	else{
	    		action9on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint11(theOffset){
	waypointAction11 = new Waypoint({
	    element: document.getElementById('para11'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action11on();
	    	}
	    	else{
	    		action10on();
	    	}
	    },
	    offset: theOffset
	});
}

function makeWaypoint12(theOffset){
	waypointAction12 = new Waypoint({
	    element: document.getElementById('para12'),
	    handler: function(direction) {
	    	if(direction==="down"){
    			action4off();
    			displayAll();
	    	}
	    	else{
	    		action11on();
	    	}
	    },
	    offset: theOffset
	});
}

function rightImageDown(element,name,para){
	rightImage = new Waypoint({
	    element: para,
	    handler: function(direction) {
	    	if(direction==="down"){
    			element
    			.style("right",(0.05*parseFloat(d3.select("#textWrapper").style("padding-right")))+parseFloat(d3.select("#textWrapper").style("margin-right"))+((window.innerWidth-document.getElementById('contentWrapper').clientWidth)/2))
    			.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
    			.style("position","fixed");

	    	}
	    	else{
	    		element
	    		.style("top",null)
	    		.style("right",0.05*parseFloat(d3.select("#textWrapper").style("padding-right")))
	    		.style("position","absolute");
	    	}

	    },
	    offset: (window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2)
	});
}

function rightImageUp(element,name,para){
	strange = new Waypoint({
	    element: para,
	    handler: function(direction) {
	    	if(direction==="down"){
    			element
    			.style("right",0.05*parseFloat(d3.select("#textWrapper").style("padding-right")))
    			.style("top",para.offsetTop+para.clientHeight-document.getElementById(name).clientHeight)
    			.style("position","absolute");
	    	}
	    	else{
	    		element
	    		.style("right",(0.05*parseFloat(d3.select("#textWrapper").style("padding-right")))+parseFloat(d3.select("#textWrapper").style("margin-right"))+((window.innerWidth-document.getElementById('contentWrapper').clientWidth)/2))
	    		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))	
	    		.style("position","fixed");
	    	}
	    
	    },
	    offset: -para.clientHeight+((window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))+document.getElementById(name).clientHeight
	});
}

function leftImageDown(element,name,para){
	imageWaypoint = new Waypoint({
	    element: para,
	    handler: function(direction) {
	    	if(direction==="down"){
    			element
    			.style("left",(0.05*parseFloat(d3.select("#textWrapper").style("padding-left")))+(parseFloat(d3.select("#textWrapper").style("margin-left")))+((window.innerWidth-document.getElementById('contentWrapper').clientWidth)/2))
    			.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
    			.style("position","fixed");

	    	}
	    	else{
	    		element
	    		.style("top",null)
	    		.style("left",0.05*parseFloat(d3.select("#textWrapper").style("padding-left")))
	    		.style("position","absolute");
	    	}
	    },
	    offset: (window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2)
	});
}

function leftImageUp(element,name,para){
	//para = document.getElementById('regime1end')
	imageWaypoint = new Waypoint({
	    element: para,
	    handler: function(direction) {
	    	if(direction==="down"){
    			element
    			.style("left",0.05*parseFloat(d3.select("#textWrapper").style("padding-left")))
    			.style("top",para.offsetTop+para.clientHeight-document.getElementById(name).clientHeight)
    			.style("position","absolute");
	    	}
	    	else{
	    		element
	    		.style("left",(0.05*parseFloat(d3.select("#textWrapper").style("padding-left")))+(parseFloat(d3.select("#textWrapper").style("margin-left")))+((window.innerWidth-document.getElementById('contentWrapper').clientWidth)/2))
	    		.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
	    		.style("position","fixed");
	    	}
	    },
	    offset: -para.clientHeight+((window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))+document.getElementById(name).clientHeight
	});
}

function calendarStop(){
	theCalendarStop = new Waypoint({
		element: document.getElementById('footer'),
		handler: function(direction){
			if(direction==="down"){
				d3.select("#calendarContainer")
				.style("top",document.getElementById('footer').offsetTop-document.getElementById('calendarContainer').clientHeight-((window.innerHeight-document.getElementById('calendarContainer').clientHeight)/2))
				.style("position","absolute");
			}
			else{
				d3.select("#calendarContainer")
				.style("top",(window.innerHeight/2)-(document.getElementById('calendarContainer').clientHeight/2))
				.style("position","fixed");
			}
		},
		offset: window.innerHeight
	});
}

