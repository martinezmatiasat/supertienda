var login = $('#loginform');
var recover = $('#recoverform');
var register = $('#registerform');
var login_recover = $('#loginform, #recoverform');
var login_register = $('#loginform, #registerform');
var recover_register = $('#recoverform, #registerform');
var loginbox = $('#loginbox');
var userbox = $('#user');
var animation_speed = 300;

$(document).ready(function(){

    var loc = window.location + '';
    var ee = loc.split('#');

    if(ee[1] == 'recoverform' && ee[1] != undefined){
        loginbox.css({'height':'183px'});
        $('#loginform, #registerform').css({'z-index':'100','opacity':'0.01'});
        $('#recoverform').css({'z-index':'200','opacity':'1','display':'block'});
    }
	$('.flip-link.to-recover').click(function(){
        switch_container(recover,login_register,183);
	});
	$('.flip-link.to-login').click(function(){
        switch_container(login,recover_register,210);
	});

    $('#loginform').submit(function(e){
        var thisForm = $(this); 
        var userinput = $('#username');
        var passinput = $('#password');
        e.preventDefault();
        if(userinput.val() == '' || passinput.val() == '') {
            highlight_error(userinput);
            highlight_error(passinput);
            loginbox.effect('shake');
            return false;
        } else {
        	$.post('ajax/log-in.php', $("#loginform").serialize(), function(resp) {
        		if (resp.success == true){
                    loginbox.animate({'top':'+=100px','opacity':'0'},250,function(){
                        $('.user_name').text(userinput.val());
                        userbox.animate({'top':"+=75px",'opacity':'1'},250,function(){
                            setTimeout(function(){
                            	window.location.href = 'index.php';
                            },600);
                        });
                    });
        		}else {
        			highlight_error(userinput);
                    highlight_error(passinput);
                    loginbox.effect('shake');
        		}
        	},'JSON');
        }       
    });
    
    $("#recoverform").submit(function(e){
    	e.preventDefault();
    	$.post('ajax/recover.php', $("#recoverform").serialize(), function(resp) {
    		$("#recoverform .alert").show();
    		setTimeout(function(){
				switch_container(login,recover_register,210);
            },5000);
    	});
    });
    
    $('#username, #password').on('keyup',function(){
        highlight_error($(this));
    }).focus(function(){
        highlight_error($(this));
    }).blur(function(){
        highlight_error($(this));
    });
});

function highlight_error(el) {
    if(el.val() == '') {
        el.parent().addClass('has-error');
    } else {
        el.parent().removeClass('has-error');
    }
}
function switch_container(to_show,to_hide,cwidth) {
    to_hide.css('z-index','100').fadeTo(animation_speed,0.01,function(){
        loginbox.animate({'height':cwidth+'px'},animation_speed,function(){
            to_show.fadeTo(animation_speed,1).css('z-index','200');
        });
    });
}