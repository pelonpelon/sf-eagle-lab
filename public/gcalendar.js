function r(f){/in/.test(document.readyState)?setTimeout('r('+f+')',9):f()}


fs = [];
function findEvents(el, text){
//console.log(el + ":" + text);
	//f = window.document.getElementById('calendarFrame')
	//console.log(f);
//	frm = window.frames['calendarFrame'].contentDocument;
	els = frm.getElementsByClassName(el);
//	for (i in window.frames.document){console.log(i,window.frames.document[i])}
//	console.log(window.frames['calendarFrame']);
//	var els = window.frames.frames.document.getElementsByClassName('te-s');
	var events = [];
	for (var i=0; i<els.length; i++) {
		if (els[i].innerText.indexOf(text) !== -1) {
			events.push(els[i]);
		}
	}
//	console.log(events);
	return events;
}

function tagEvents(ps){
    for (var x in ps){ 
		p = ps[x];
	    var f = function(p){
		    events = findEvents.call(this, p.cls, p.txt);
		    for (var e in events) {
			    events[e].style.backgroundColor = p.clr;
	 	    }
	    }
	    fs.push(f(p));
    }
	return function(fs){
		for (var f in fs){
		    fs[f].call(this);
		}
	};

}

function main(){
frm = window.frames['calendarFrame'].contentDocument;
params = [
	{cls:"te-s",txt:"BB",clr:"orange"},
	{cls:"te-s",txt:"day",clr:"yellow"},
	{cls:"event-title",txt:"BB",clr:"orange"}
]
frm.body.addEventListener('click', function(e) {
	e.preventDefault();
	console.log('clicked');
	tagEvents(params);
	return e;
});
tagEvents(params);
//	window.frames['calendarFrame'].contentWindow.location.origin = "http://google.com";
//	window.frames['calendarFrame'].contentWindow.location.host = "http://google.com";
//	window.frames['calendarFrame'].contentWindow.location.origin = "http://google.com";
//	window.frames['calendarFrame'].contentWindow.location.hostname = "google.com";
	window.frames['calendarFrame'].contentWindow.location.ancestorOrigins[0] = "http://google.com";

}
//r(tagEvents(params));

