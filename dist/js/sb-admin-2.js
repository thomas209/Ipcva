/*!
 * Start Bootstrap - SB Admin 2 v3.3.7+1 (http://startbootstrap.com/template-overviews/sb-admin-2)
 * Copyright 2013-2016 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap/blob/gh-pages/LICENSE)
 */
$(function() {
    $('#side-menu').metisMenu();

	$(document).ajaxStart(function(){
		$("#wait").css("display", "block");
	});
	$(document).ajaxComplete(function(){
		$("#wait").css("display", "none");
	});

});

function replegar(param){
	if(param == 1){
		$('#table_clientes_aprobar').toggle(500);
	}
	if(param == 2){
		$('#table_ultimos_pedidos').toggle(500);
	}
	if(param == 3){
		$('#table_pedidos_para_cargar').toggle(500);
	}
	event.preventDefault();
}

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
	$('[data-toggle="tooltip"]').tooltip();
	
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }

        $('#side-menu').css('max-height', height);


    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
        return this.href == url;
    }).addClass('active').parent();

    while (true) {
        if (element.is('li')) {
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }


	setTimeout(function() {
		$('.alert').fadeOut();
	}, 5000 );

	if(localStorage.getItem("SideBar_isVisible") == ''){
		localStorage.setItem("SideBar_isVisible", "yes");
	}
	if(localStorage.getItem("SideBar_isVisible") == 'yes'){
		sideBar_show();
	}
	else{
		sideBar_hide();
	}
	if($( window ).width()<768){
		$('#page-wrapper').css('margin-left', '0');
		
	}

});
function sideBar_hide(){
	$('.sidebar-nav.navbar-collapse').hide();
	$('#page-wrapper').css('margin-left', '0');
	$('#btn_toggle_menu').show();
	localStorage.setItem("SideBar_isVisible", "no");
}
function sideBar_show(){
	$('.sidebar-nav.navbar-collapse').show();
	$('#page-wrapper').css('margin-left', '180px');
	$('#btn_toggle_menu').hide();
	localStorage.setItem("SideBar_isVisible", "yes");
}

function validar_numeros(objeto){
	if(isNaN(objeto.value)){
		objeto.focus();
		$(objeto).css("background-color", "red");
		alert('Debe ingresar solo numeros y utilizar el "." para indicar decimales');
		objeto.value='';
		$(objeto).css("background-color", "white");
		return false;
	}
	else{
		return true;
	}
}



function areYouSure(){
	var txt;
	var r = confirm('Está seguro de que quiere realizar esta acción?');
	if (r == false) {
		event.preventDefault();
	}
}

var path = window.location.pathname;
console.log(path);
var area = path.split("/");
console.log(area);
console.log(area[1]);


if(area[1] == 'configuracion' && area[2] == 'documentos.php'){
	console.log(area[2]);
	$('#side-menu #a-documentos').css('background', '#15a857').css('color', '#fff');
}
else{
	var area = area[1];
	if(area == '' || area=='index.php'){
		area = "inicio";
	}

	console.log(area);
	$('#side-menu #a-'+area).css('background', '#15a857').css('color', '#fff');
}

$(document).click(function(e) {
	if ($(e.target).not('.opciones')){
		$('.collapse').collapse('hide');	    
	}
});

function goBack() {
    window.history.back();
}