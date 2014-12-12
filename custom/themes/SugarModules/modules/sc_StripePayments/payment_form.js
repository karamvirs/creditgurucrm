var modal = (function(){
	var 
	method = {},
	$overlay,
	$modal,
	$content,
	$close;

	// Center the modal in the viewport
	method.center = function () {
		var top, left;

		top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
		left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

		$modal.css({
			top:top + $(window).scrollTop(), 
			left:left + $(window).scrollLeft()
		});
	};

	// Open the modal
	method.open = function (settings) {
		$content.empty().append(settings.content);

		$modal.css({
			width: settings.width || 'auto', 
			height: settings.height || 'auto'
		});

		method.center();
		$(window).bind('resize.modal', method.center);
		$modal.show();
		$overlay.show();
		init_form();
	};

	// Close the modal
	method.close = function () {
		$modal.hide();
		$overlay.hide();
		$content.empty();
		$(window).unbind('resize.modal');
	};

	// Generate the HTML and add it to the document
	$overlay = $('<div id="sc_overlay"></div>');
	$modal = $('<div id="sc_modal"></div>');
	$content = $('<div id="sc_content"></div>');
	$close = $('<a id="sc_close" href="#">close</a>');

	$modal.hide();
	$overlay.hide();
	$modal.append($content, $close);

	$(document).ready(function(){
		$('body').append($overlay, $modal);						
	});

	$close.click(function(e){
		e.preventDefault();
		method.close();
	});

	return method;
}());


$(document).ready(function(){
	var button = $('<li><a href="javascript:void(0)" onclick="get_payment_form()">Make Payment</a></li>")');
	$('#detail_header_action_menu').sugarActionMenu('addItem',{item:button});
});

function get_payment_form(){	
	var focus = get_focus_data();
	var module = focus[0];
	var record = focus[1];
	$.post('index.php?module=sc_StripePayments&action=payment_form&to_pdf=1', 
		{
			focus_type : module, 
			focus_id : record
		})
	.success(function(data){
		modal.open({content:data});
	});
}

function get_focus_data(){
	var uri = decodeURIComponent(window.location.href);
	var ajaxui = getSugarAJAXUrlVars(uri);
	var params = getUrlVars(uri);
	var ajaxui_action = getUrlVars(ajaxui['action']);
	var module = ajaxui_action['module'];	
	if(module == undefined){
		module = params['module'];
	}
	var record = params['record'];
	return [module, record];
}

function getUrlVars(url) {
    var vars = {};
    var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

function getSugarAJAXUrlVars(url) {
    var vars = {};
    var parts = url.replace(/[?#&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    	if(vars[key] == undefined){
         	vars[key] = value;
        }
    });
    return vars;
}

function init_form(){
	var focus = get_focus_data();
	var module = focus[0];
	var record = focus[1];
	$.post('index.php?module=sc_StripePayments&action=json_record_data&to_pdf=1', 
		{
			focus_type : module, 
			focus_id : record,
			method : 'get_data'
		}, function(){}, 'json')
	.success(function(data){
		console.log('YAY!');
		update_form_data(data);
	}).error(function(err){
		console.log('DAMN! :: ' . err);
	});
	$('#payment_form .make_payment').click(function(){
		Stripe.createToken({
		    number: $('.cc_number').val(),
		    name: $('.cc_name').val(),
		    cvc: $('.cc_cvc').val(),
		    exp_month: $('.cc_exp_month').val(),
		    exp_year: $('.cc_exp_year').val(),
		    address_line1 : $('.address_line1').val(),
		    address_city : $('.address_city').val(),
		    address_zip : $('.address_zip').val(),
		    address_state : $('.address_state').val(),
		    address_country : $('.address_country').val(),
		    description : $('.description').val()
		}, stripeResponseHandler);
	});
}

function update_form_data(data){
	console.log(data);
	$.each(data, function(i, item){
		console.log(item);
		$('.' + item.name).val(item.value);
	});
}

function stripeResponseHandler(status, response) {
	
    if (response.error) {
    	//alert(response.error.message);
        // show the errors on the form
        $("#payment_errors").text(response.error.message);
    } else {
        var form$ = $("#payment_form");
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        $('#payment_form .make_payment').attr('disabled', 'disabled');
        // and submit
        form$.get(0).submit();
    }
}


