jQuery.extend(jQuery.validator.messages, {
	  required: "Este campo es obligatorio.",
	  remote: "Por favor, rellena este campo.",
	  email: "Por favor, escribe una dirección de correo válida",
	  url: "Por favor, escribe una URL válida.",
	  date: "Por favor, escribe una fecha válida.",
	  dateISO: "Por favor, escribe una fecha (ISO) válida.",
	  number: "Por favor, escribe un número entero válido.",
	  digits: "Por favor, escribe sólo dígitos.",
	  creditcard: "Por favor, escribe un número de tarjeta válido.",
	  equalTo: "Por favor, escribe el mismo valor de nuevo.",
	  accept: "Por favor, escribe un valor con una extensión aceptada.",
	  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
	  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
	  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
	  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
	  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
	  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
});

$(document).ready(function() {
	var sPath = window.location.pathname;
	var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
	var link = $("a[href='"+sPage+"']");
	link.closest('li').addClass('active');
	if (link.closest('.submenu').length == 1) link.closest('.submenu').addClass('active open');
	
	$(".validate-form").validate({
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-success').addClass('has-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.form-group').removeClass('has-error').addClass('has-success');
		}
	});
	
	$("input[js-action='colorpicker']").colorpicker().on('changeColor', function(ev, s){
		$(ev.target).css('background-color', ev.color.toHex()).val(ev.color.toHex());
	});
	$("input[js-action='datepicker']").datepicker({format : 'yyyy-mm-dd'});
    $('.spinner').spinner();
    $('.select2, .select-multiple').select2();
    
    tinymce.init({
    	selector: ".tinymyce",
	    theme: "modern",
	    plugins: [
	        "advlist autolink lists link image charmap preview hr anchor pagebreak",
	        "searchreplace wordcount visualblocks visualchars code fullscreen lineheight",
	        "insertdatetime media nonbreaking save table contextmenu directionality",
	        "emoticons template paste textcolor"
	    ],
	    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	    toolbar2: "preview media | forecolor backcolor lineheightselect fontsizeselect emoticons",
	    lineheight_formats: "8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 22pt 24pt 26pt 36pt",
	    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
	    font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n',
	    image_advtab: true,
	    paste_data_images: true,
	    relative_urls : false,
	    remove_script_host : false,
	    convert_urls : true,
	    images_upload_url: 'ajax/upload-image.php',
	    file_picker_callback: function(callback, value, meta) {
	    	if (meta.filetype == 'image') {
	    		$('#upload').trigger('click');
	    		$('#upload').on('change', function() {
	    			var file = this.files[0];
	    			var reader = new FileReader();
	    			reader.onload = function(e) {
	    				callback(e.target.result, {alt: ''});
	    			};
	    			reader.readAsDataURL(file);
	    		});
	    	}
	    }
	});
    
	$('.data-table').dataTable({
		"bJQueryUI": true,
    	"sPaginationType": "full_numbers",
    	"sDom": '<""l>t<"P"fp>',
    	"language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
        }
    });
	
    $(document).bind("ajaxSend", function(){$("#loading").show();}).bind("ajaxComplete", function(){$("#loading").hide();});
    
    ////DELETE MODAL
    $(".delete").click(function(e){
    	e.preventDefault();
    	$(".delete-modal .modal-body").empty().append($(this).data("txt"));
    	$(".delete-modal .delete-btn").attr("href", $(this).data("href"));
    	$(".delete-modal").modal("show");
    });
    
    ////DELETE SELECTED
    $(".delete-selected").click(function(e){
    	e.preventDefault();
    	var selected = [];
    	$("input[name='ids[]']:checked").each(function(){selected.push($(this).val());});
    	$(".delete-modal .modal-body").empty().append($(this).data("txt"));
    	$(".delete-modal .delete-btn").attr("href", $(this).data("href") + '&ids=' + selected.join(","));
    	$(".delete-modal").modal("show");
    });
    
    ////SELECT ALL
    $("#select-all").click(function(){
    	if ($(this).is(":checked")) $("input[name='ids[]']").prop("checked", true);
    	else $("input[name='ids[]']").prop("checked", false);
    });
});

function sortableTable(ajaxUrl){
	$( ".sortable-table tbody" ).sortable({
		update : function(e, ui){
			var ids = [];
			var n = 1;
			$( ".sortable-table tbody .fa-bars").each(function(){
				////CAMBIO LAS URL PARA ORDENAR
				var parts = $(this).closest('tr').find('.set-down').attr('href').split('=');
				parts[parts.length - 1] = n;
				$(this).closest('tr').find('.set-down').attr('href', parts.join('='));
				
				var parts = $(this).closest('tr').find('.set-up').attr('href').split('=');
				parts[parts.length - 1] = n;
				$(this).closest('tr').find('.set-up').attr('href', parts.join('='));
				
				ids.push($(this).data('id'));
				n++;
			});
			$.post(ajaxUrl, {ids : ids});
		}
	});
    $( ".sortable-table" ).disableSelection();	
}

function rowsPerPage(){
	$(".rowsPerPage").change(function(){
		var url = document.URL;
		if (url.indexOf("?") == -1) url = url + "?rows="+$(this).val();
		else url = url + "&rows="+$(this).val();
		window.location.href = url;
	});
}

function multipleUpload(url){
	html5Upload(url);
	$("#fileToUpload").change(function(){
		$.ajaxFileUpload({
			url: url,
			secureuri:false,
			fileElementId:"fileToUpload",
			dataType: 'json',
			data:{name:'logan', id:'id'},
			success: function (data, status){location.reload();},
			error: function (data, status, e){alert(e);}
		});
    });
}

var totalUpload = 0;
var actualUploaded = 0;

function html5Upload(url){
    $("#dropable-images").on('dragover',function(e){e.preventDefault();e.stopPropagation();});
	$("#dropable-images").on('dragenter',function(e) {e.preventDefault();e.stopPropagation();});
	$("#dropable-images").on('drop',function(e){
    	if(e.originalEvent.dataTransfer){
            if(e.originalEvent.dataTransfer.files.length) {
                e.preventDefault();
                e.stopPropagation();
                var files = e.originalEvent.dataTransfer.files;
                totalUpload = files.length;
                for (var i = 0; i < files.length; i++){
                    var fd = new FormData();
                    fd.append('fileToUpload[]', files[i]);
                    sendFileToServer(fd, url);
               }
            }   
        }
    });
}

function sendFileToServer(formData,url){
    $.ajax({
        url: url,
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        dataType: 'json',
        success: function(data){
        	actualUploaded++;
        	if (actualUploaded == totalUpload) location.reload();
        },
    }); 
}

function getTitle(input, url){
	$(input).focusout(function(){
		$.post("ajax/get-title.php", {t : $(this).val()}, function(r){
			$(url).val(r);
		});
	});
}

function cropImg(){
	var x = $("#x").val();
	var y = $("#y").val();
	form = $("#save").closest("form");
	
	cropper = $("#crop-img").cropper({aspectRatio: x / y, minCropBoxWidth : x, minCropBoxHeight : y, viewMode : 1});
	$("#save").click(function(e){
		e.preventDefault();
		////CROP
		var bb = cropper.cropper('getCroppedCanvas');
		bb.toBlob(function (blob) {
			var formData = new FormData(form[0]);
			formData.append('croppedImage', blob);
			$.ajax(form.attr("action"), {
				method: "POST",
				data: formData,
				processData: false,
				dataType: "json",
				contentType: false, 
				success: function (data) {
					if (data.error == false) window.location = $("#return").val();
    				else alert(data.error);
    			},error: function (e) {
    				alert('Upload error');
    			}
    		});
		});
	});
}

/*
 * https://www.facebook.com/sharer/sharer.php?u=
 * https://plus.google.com/share?url=
 * http://pinterest.com/pin/create/button/?url=
 * https://twitter.com/home?status=
 */
function sharer(){
	$(".social").click(function(e){
		e.preventDefault();
		var url = $(this).attr('href');
		var w = 300;
		var h = 300;
		var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
		var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
		var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
		var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
		var left = ((width / 2) - (w / 2)) + dualScreenLeft;
		var top = ((height / 2) - (h / 2)) + dualScreenTop;
		var newWindow = window.open(url, 'Compartir', 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
		if (window.focus) newWindow.focus();
	});
}


/////////////////////////////////////////////////////////

//////////////INDEX
function dashboard(){
	google.load('visualization', '1.0', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
    	var length = titles.length, element = null;
    	var data = new google.visualization.DataTable();
    	data.addColumn('string', 'Topping');
    	data.addColumn('number', 'Slices'); 	
    	for (var i = 0; i < length; i++) data.addRow([titles[i], parseInt(sales[i])]);
    	var options = {is3D: true, 'backgroundColor' : '#FAFAFA'};
    	var chart = new google.visualization.PieChart(document.getElementById('all-sales'));
    	chart.draw(data, options);
    }
    google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){loadMonthSales();}});
    $(".salesYears").change(function(){loadMonthSales();});
}

function loadMonthSales(){
	$.post( "ajax/get-sales-chart.php",{year: $(".salesYears").val()}, function(resp) {
		var data = google.visualization.arrayToDataTable(resp);
		var options = {'backgroundColor' : '#FAFAFA', 'legend' : {position: 'top'}};
		var chart = new google.visualization.LineChart(document.getElementById('month-sales'));
		chart.draw(data, options);
	}, "json");
}

function dashboardMulti(){
	google.load('visualization', '1.0', {'packages':['corechart']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
    	var length = titles.length, element = null;
    	var data = new google.visualization.DataTable();
    	data.addColumn('string', 'Topping');
    	data.addColumn('number', 'Slices'); 	
    	for (var i = 0; i < length; i++) data.addRow([titles[i], parseInt(sales[i])]);
    	var options = {is3D: true, 'backgroundColor' : '#FAFAFA'};
    	var chart = new google.visualization.PieChart(document.getElementById('all-sales'));
    	chart.draw(data, options);
    }
    google.load('visualization', '1', {packages:['corechart'], 'callback' : function(){loadMonthSalesMulti();}});
    $(".salesYears").change(function(){loadMonthSalesMulti();});
}

function loadMonthSalesMulti(){
	$.post( "ajax/get-sales-chart-multi.php",{year: $(".salesYears").val()}, function(resp) {
		var data = google.visualization.arrayToDataTable(resp);
		var options = {'backgroundColor' : '#FAFAFA', 'legend' : {position: 'top'}};
		var chart = new google.visualization.LineChart(document.getElementById('month-sales'));
		chart.draw(data, options);
	}, "json");
}

