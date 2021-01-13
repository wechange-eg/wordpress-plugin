jQuery( document ).ready( function( $ ) {

	// Register getURLVar for jQuery
	$.extend({
		getUrlVars: function(){
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
		},
		getUrlVar: function(name){
		return $.getUrlVars()[name];
		}
	});

	/*
	Get WECHANGE status
	1. Replaces menu item with css class "login" with avatar image
	2. Updates body class (wechange-logged-in/wechange-logged-out) accordingly to show/hide elements based upon CSS definitions
	like e.g.
	body.wechange-logged-in .hide-logged-in,
	body.wechange-logged-out .hide-logged-out {
		display: none;
	}
	*/
	$.ajax({
		url: wechangeCollection.baseUrl + 'api/v1/user/me/',
		type: 'GET',
		success: function (data) {
			if (data.id) {
				if ((location.pathname == "/" || location.pathname == "/cms/") && $.getUrlVar("noredir") != '1') {
					window.location.href = "/dashboard/";
				} else {
					// Update navigation links
					$('nav .login a').html('<img src="' + data.avatar_url + '" alt="' + data.first_name + ' ' + data.last_name + '" />');
					// Update body class
					$('body').addClass('wechange-logged-in');
				}
			} else {
				$('body').addClass('wechange-logged-out');
			}
		},
		cache: false,
		crossDomain: true,
		xhrFields: {
		withCredentials: true
		},
	}); 

});