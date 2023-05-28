function showpanel()
{
	$("div#panel").slideDown("slow");
	$("#toggle a").toggle();
	return false;
}

$(document).ready(function() {
	// Expand Panel
	$(".open").click(function(){showpanel()});
	$("#open").click(function(){
		$("div#panel").slideDown("slow");
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("slow");	
	});
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});
});
