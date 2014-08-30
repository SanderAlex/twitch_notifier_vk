$(document).ready(function() {
	$("#account_link").mouseover(function() {
		$("#menu").toggle(true);
	});
	$("#menu").mouseover(function() {
		$("#menu").toggle(true);
	});
	$("#account_link").mouseout(function() {
		$("#menu").toggle(false);
	});
	$("#menu").mouseout(function() {
		$("#menu").toggle(false);
	});

	VK.init(function() {		
    	//VK.callMethod("showSettingsBox", 256);
  	}, function() { 
    // API initialization failed 
    // Can reload page here 
	}, '5.23');

	function response(data) {
		alert(data); 
	}
});