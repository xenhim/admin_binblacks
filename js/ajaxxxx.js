function showloading()
{
	//$("#loading2").show()
	$.blockUI({ message: '<h1><img src="../images/load.gif" /><p>Just a moment..</h1>',showOverlay: true, css: { backgroundColor: '#FFFFFF'}});
	//$.blockUI({ message: '',showOverlay: true, css: { backgroundColor: '#FFFFFF'}});
}

function hideloading()
{
	//$("#loading2").hide()
	$.unblockUI({fadeOut: 500});
}
function logout()
{
	if (confirm("Do you really want to logout?"))
	{
		$.ajax({
		type: "GET",
		url: "./login.php?act=logout",
		beforeSend: showloading(),
		success: function(msg){
		window.location.reload();
		},
		error: function(msg){
		alert("Ajax loading error, please try again.");
		},
		complete: function(){
		hideloading();
		}
		});
	}
}

function showpage(link)
{
	$.ajax({
	type: "GET",
	url: link,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading(),balance();
	},
	error: function(msg){
	$("#main").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function showresult(link)
{
	$.ajax({
	type: "GET",
	url: link,
	beforeSend: showloading(),
	success: function(msg){
	$("#result").after(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#result").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function getCard(cardId)
{
	$.ajax({
	type: "GET",
	url: "./card.php?act=get&cardid=" + cardId,
	beforeSend: showloading(),
	success: function(msg){
	$("#cardResult"+cardId).hide();
	$("#cardResult"+cardId).html(msg).show("slow");
	hideloading(),balance();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function getDump(cardId)
{
	$.ajax({
	type: "GET",
	url: "./dumps.php?act=get&cardid=" + cardId,
	beforeSend: showloading(),
	success: function(msg){
	$("#cardResult"+cardId).hide();
	$("#cardResult"+cardId).html(msg).show("slow");
	hideloading(),balance();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function checki(cardId)
{
	$.ajax({
	type: "GET",
	url: "./card.php?act=checki&cardid=" + cardId,
	beforeSend: showloading(),
	success: function(msg){
	$("#cardResult"+cardId).hide();
	$("#cardResult"+cardId).html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function packchecki(cardId)
{
	$.ajax({
	type: "GET",
	url: "./packs.php?act=checki&cardid=" + cardId,
	beforeSend: showloading(),
	success: function(msg){
	$("#cardResult"+cardId).hide();
	$("#cardResult"+cardId).html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function dumpchecki(cardId)
{
	$.ajax({
	type: "GET",
	url: "./dumps.php?act=checki&cardid=" + cardId,
	beforeSend: showloading(),
	success: function(msg){
	$("#cardResult"+cardId).hide();
	$("#cardResult"+cardId).html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function bincheck()
{
    var listcc = $('#listcc').val()
	$.ajax({
	type: "POST",
	url: "checkbin.php",
    data: "listcc="+listcc,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#main").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
/*
function checkcc(){
					var cclist = $('#cclist').val();
					var dup = $('#dup').is(':checked');
					var date = $('#date').is(':checked');
					var typec = $('#type').is(':checked');
					var bin_info = $('#bin_info').is(':checked');
	$.ajax({
	type: "POST",
	url: "ccexp.php",
    data: "cclist="+cclist+"&dup="+dup+"&date="+date+"&type="+typec+"&bin_info="+bin_info,
    async: false,
	//beforeSend: showloading(),
	success: function(msg){
	$("#checkresult").hide();
	$("#checkresult").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#checkresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	//console(linha);
			});
	}
*/

function checkcc (arr_cc, cur_cc) {
        if (cur_cc >= arr_cc.length) {
$('#progress_title').html("Complete"); 

            $('#start').css("display","none");
            $('#pause').css("display","none");
			$('#newcheck').css("display","inline");
      
            return;
        }
         //xu ly encrypt cc
		 var ccnum=info(arr_cc[cur_cc]);
		 
		 		 		 if(!ccnum)
		 {
			                         $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|'+'<b style="color:black">Line error</b>' + '|' + arr_cc[cur_cc] + '<br>');
                        $('#numberok_LineErorr').html(parseInt($('#numberok_LineErorr').html()) + 1);
									$('#textarea_LineErorr').val($('#textarea_LineErorr').val() + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_LineErorr').css("display","block");
									                    // Update số cc da check
                    $('#cc_checked').html(parseInt($('#cc_checked').html()) + 1);

                    // Calculate percent
                    var temp = (parseInt($('#cc_checked').html()) * 100) / parseInt($('#tong_cc').html());
                    var percent = temp.toFixed(0) + '%'; 

                    // Update process bar
                    $('#progress_bar').css('width', percent);
                    $('.percent').html(percent); 

                    // Update title
                    document.title = 'Checked :' + percent;            

                    // Update box cc
                    update_box_cc (arr_cc[cur_cc]);
					                        $('#numberok_remain').html(parseInt($('#numberok_remain').html()) - 1);
					            $('#textarea_remain').val($('#listcc').val());
                    // continue check other cc
                    checkcc (arr_cc, cur_cc + 1);
                    return;
									
			 }
		 var result=getEncryptionValue(ccnum["num"]);
var cryptCard=result[0];
var cryptCvv=result[1];

    //var listcc = $('#listcc').val();
    var dup = $('#dup').is(':checked');
    var date = $('#date').is(':checked');
    var typec = $('#type').is(':checked');
    var bin_info = $('#bin_info').is(':checked');



		 //end xu ly encrytcc
        ajaxCall = jQuery.ajax({
            url: "ccexp.php",
            type: 'POST',
            //dataType: 'json',
            data: "cclist="+arr_cc[cur_cc]+"&dup="+dup+"&date="+date+"&type="+typec+"&bin_info="+bin_info,
            //async: false,
            //beforeSend: showloading(),
            //data: "lista="+arr_cc[cur_cc],
            //complete: function(xhr, textStatus) {
                //called when complete
             //   var credits=balance()
           // },
            
	success: function(msg){
	$("#checkresult").hide();
	$("#checkresult").html(msg).show("slow");
	//hideloading();
	},
	error: function(msg){
	$("#checkresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	//hideloading();
	}
	/*
            success: function(responseText, textStatus, xhr) {

                    if (responseText.match("#acc_live")) 
                    {

                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:Green">Live' + '|' + arr_cc[cur_cc] + '</b><br><br>');
                        $('#numberok_live').html(parseInt($('#numberok_live').html()) + 1);
									$('#textarea_live').val($('#textarea_live').val() + "[hqcheck.ru]|Live|"+arr_cc[cur_cc].trim() + "\n"); 
									$('#area_live').css("display","block");

                    } 
                    else if(responseText.match("#acc_die"))
                    {

                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:Red">Die' + '|' + arr_cc[cur_cc] + '</b><br><br>');
                        $('#numberok_die').html(parseInt($('#numberok_die').html()) + 1);
									$('#textarea_die').val($('#textarea_die').val() + arr_cc[cur_cc].trim() + "\n"); 
 $('#area_die').css("display","block");
                    }
                    else if(responseText.match("#acc_wrong"))
                    {
                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:black">CCInvaid</b>' + '|' + arr_cc[cur_cc] + '<br><br>');
                        $('#numberok_CCInvaid').html(parseInt($('#numberok_CCInvaid').html()) + 1);
									$('#textarea_CCInvaid').val($('#textarea_CCInvaid').val() + arr_cc[cur_cc].trim() + "\n");
									$('#area_CCInvaid').css("display","block"); 
                    }
                    else if(responseText.match("Cant Check"))
                    {
                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:black">Cant check</b>' + '|' + arr_cc[cur_cc] + '<br><br>');
                        $('#numberok_CanCheck').html(parseInt($('#numberok_CanCheck').html()) + 1);
									$('#textarea_CanCheck').val($('#textarea_CanCheck').val() + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_CanCheck').css("display","block"); 
                    }                                                            
                    else if(responseText.match("LINE ERROR"))
                    {
                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:black">Line error</b>' + '|' + arr_cc[cur_cc] + '<br><br>');
                        $('#numberok_LineErorr').html(parseInt($('#numberok_LineErorr').html()) + 1);
									$('#textarea_LineErorr').val($('#textarea_LineErorr').val() + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_LineErorr').css("display","block"); 
                    }                              
                    else if(responseText.match("UnKnow"))
                    {
	                    checkcc (arr_cc, cur_cc);
                    return;                 
                    }
                    else if(responseText.match("outcredit"))
                    {
                        $('#div_print_line').append('<b style="color:black">Your credit is not enought</b>'+'<br>');
return;                    
                    }
			
                    // Update số cc da check
                    $('#cc_checked').html(parseInt($('#cc_checked').html()) + 1);

                    // Calculate percent
                    var temp = (parseInt($('#cc_checked').html()) * 100) / parseInt($('#tong_cc').html());
                    var percent = temp.toFixed(0) + '%'; 

                    // Update process bar
                    $('#progress_bar').css('width', percent);
                    $('.percent').html(percent); 

                    // Update title
                    document.title = 'Checked :' + percent;            

                    // Update box cc
                    update_box_cc (arr_cc[cur_cc]);
					                        $('#numberok_remain').html(parseInt($('#numberok_remain').html()) - 1);
					            $('#textarea_remain').val($('#listcc').val());
                    // continue check other cc
                    checkcc (arr_cc, cur_cc + 1);
                    return; 
                

            },
           */ 
           /*
            error: function(xhr, textStatus, errorThrown) {
				if(textStatus!='abort'){
	                    checkcc (arr_cc, cur_cc);
                    return;
}console(responseText)
            }*/
        });
    }

/*
$(document).ready(function() {
    var ap = 0;
    var rp = 0;
    var testadas = 0;
    var card_check = 0;
    $('#start').click(function() {
        var line = $('#list').val().split('\n');
        var total = line.length;
        $('#TOTal_CCS').html(total);
        start();
    })
*/
/*
    function start() {
        var lista = document.getElementById("list").value;
        var array = lista.split("\n");
        var split = array[0].split("|");
        var cc = split[0];
        var mes = split[1];
        var ano = split[2];
        var cvv = split[3];
        if(cvv == "") {
            cvv = "123";
        }
        document.getElementById("list").readOnly = true;

        if(array.length == "1" && array[0] == "" && card_check == 0) {
            document.getElementById("list").readOnly = false;
            Checking_Success();
            return;
        }
        if(array.length == "1" && array[0] == "" && card_check == 1) {
            document.getElementById("list").readOnly = false;
            Zero_Credits();
            return;
        }
        startchk(cc, mes, ano, cvv, split);
        return;
    }

    function startchk(cc, mes, ano, cvv) {
        $.ajax({
        url: "https://object.sbs/166.php",
        method: "POST",
        data: 'ccline=' + cc + "|" + mes + "|" + ano + "|" + cvv + "|",
       // $.ajax({
         //   url: "../../status.php?cc=" + cc + "|" + mes + "|" + ano + "|" + cvv + "",
        //    method: "GET",
            success: function(reponse) {
				 if (reponse != "") {
                var reponseJSON = JSON.parse(reponse);
				 if (reponseJSON.status == '#live') {
                    document.getElementById("cLive").innerHTML += reponseJSON.card  + "|" + reponseJSON.message + "\n";
                    ap = ap + 1;
                    $('#TOTal_live').html(ap);
                    testadas = testadas + 1;
					card_check = 0;
                    $('#TOTal_Checked').html(testadas);
                    removelinha();
                } else if (reponseJSON.status == '#die') {
                    document.getElementById("cDie").innerHTML += reponseJSON.card + "|" + reponseJSON.message + "\n";
                    rp = rp + 1;
					card_check = 0;
                    $('#TOTal_Die').html(rp);
                    testadas = testadas + 1;
                    $('#TOTal_Checked').html(testadas);
                    removelinha();
				 } else if (reponseJSON.status == '#UnKnow') {
                    document.getElementById("UnKnow").innerHTML += reponseJSON.card + "|" + reponseJSON.message + "\n";
                    rp = rp + 1;
					card_check = 0;
                    $('#TOTal_Die').html(rp);
                    testadas = testadas + 1;
                    $('#TOTal_Checked').html(testadas);
                    removelinha();
                }
            }
                start();
            },
            error: function() {
                start();
            }
        });
    }

    function removelinha() {
        var lines = $("#list").val().split('\n');
        lines.splice(0, 1);
        $("#list").val(lines.join("\n"));
    }
})
*/
function depositpm()
{
    var userid = $('#userId').val()
    var value = $('#value').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=pm",
    data: "userId="+userid+"&value="+value,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function depositbtc()
{
    var useridbtc = $('#userIdbtc').val()
    var valuebtc = $('#valuebtc').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=btc",
    data: "userIdbtc="+useridbtc+"&valuebtc="+valuebtc,
	beforeSend: showloading(),
	success: function(msg){
	$("#buyresult").hide();
	$("#buyresult").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}

function depositupm()
{
    var userid = $('#userIdupm').val()
    var value = $('#valuepm').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=upm",
    data: "userId="+userid+"&value="+value,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	////, complete: hideloading()
	});
}
function deposituwmz()
{
    var userid = $('#userIdwmz').val()
    var value = $('#valuewmz').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=uwmz",
    data: "userId="+userid+"&value="+value,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	////, complete: hideloading()
	});
}

function depositupaymer()
{
    var userid = $('#userIdpaymer').val()
    var value = $('#valuepaymer').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=upaymer",
    data: "userId="+userid+"&value="+value,
	beforeSend: showloading(),
	success: function(msg){
	$("#main").hide();
	$("#main").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}

function depositbtcspeed()
{
    var useridspeed = $('#userIdspeed').val()
    var userIdspeedsum = $('#userIdspeedsum').val()
	$.ajax({
	type: "POST",
	url: "payprocess.php?act=btcspeed",
    data: "userIdbtc="+useridspeed+"&userIdspeedsum="+userIdspeedsum,
	beforeSend: showloading(),
	success: function(msg){
	$("#buyresult").hide();
	$("#buyresult").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#buyresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}
function update_cart()
{
	$.ajax({
	type: "POST",
	url: "cart.php?act=update",
	beforeSend: showloading(),
	success: function(msg){
	$("#cart").hide();
	$("#cart").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#cart").html("<font color='#ff0000'>Ajax error</font>").show("slow");
	hideloading();
	}
	});
}
function add_to_cart(card_id)
{
	$.ajax({
	type: "POST",
	url: "cart.php?act=add",
    data: "card_id="+card_id,
	});
    success: update_cart()
}
function remove_from_cart(card_id)
{
	$.ajax({
	type: "POST",
	url: "cart.php?act=remove",
    data: "card_id="+card_id,
	});
    success: update_cart(),totalcart();
}
function all_add_to_cart(){
	$('.card').each(function(){
    if($(".allcart").is(":checked")){
    add_to_cart($(this).attr('item_id'));
    } else {
    remove_from_cart($(this).attr('item_id'));
    }
	}
    );
    success: update_cart()
}
function cart_select(card_id){
	$('#card-'+card_id).each(function(){
    if($('#card-'+card_id).is(":checked")){
    add_to_cart($(this).attr('item_id'));
    } else {
    remove_from_cart($(this).attr('item_id'));
    }
    success: update_cart()
	});
}
function buy_all_cc(){
	$('.card').each(function(){
    getCard($(this).attr('item_id'));
    success: update_cart();
	}
    );
}
function clear_all_cc(){
    if ($(".card").length > 0){
    beforeSend: showloading(),
	$('.card').each(function(){
    remove_from_cart($(this).attr('item_id'));
    success: showpage('cart.php?act=order');
	}
    );
    }
    
}
function totalcart()
{
	$.ajax({
	type: "POST",
	url: "cart.php?act=totalcart",
	beforeSend: showloading(),
	success: function(msg){
	$("#totalcart").hide();
	$("#totalcart").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#totalcart").html("<font color='#ff0000'>Ajax error</font>").show("slow");
	hideloading();
	}
	});
}
//CART DUMP

function dump_update_cart()
{
	$.ajax({
	type: "POST",
	url: "dumpcart.php?act=update",
	beforeSend: showloading(),
	success: function(msg){
	$("#dumpcart").hide();
	$("#dumpcart").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#dumpcart").html("<font color='#ff0000'>Ajax error</font>").show("slow");
	hideloading();
	}
	});
}
function dump_add_to_cart(card_id)
{
	$.ajax({
	type: "POST",
	url: "dumpcart.php?act=add",
    data: "card_id="+card_id,
	});
    success: dump_update_cart()
}
function dump_remove_from_cart(card_id)
{
	$.ajax({
	type: "POST",
	url: "dumpcart.php?act=remove",
    data: "card_id="+card_id,
	});
    success: dump_update_cart(),dumptotalcart();
}
function dump_all_add_to_cart(){
	$('.dump').each(function(){
    if($(".dumpallcart").is(":checked")){
    dump_add_to_cart($(this).attr('item_id'));
    } else {
    dump_remove_from_cart($(this).attr('item_id'));
    }
	}
    );
    success: dump_update_cart()
}
function dump_cart_select(card_id){
	$('#card-'+card_id).each(function(){
    if($('#card-'+card_id).is(":checked")){
    dump_add_to_cart($(this).attr('item_id'));
    } else {
    dump_remove_from_cart($(this).attr('item_id'));
    }
    success: dump_update_cart()
	});
}
function buy_all_dump(){
	$('.dump').each(function(){
    getDump($(this).attr('item_id'));
    success: dump_update_cart()
	}
    );
}
function clear_all_dump(){
    if ($(".dump").length > 0){
    beforeSend: showloading(),
	$('.dump').each(function(){
    dump_remove_from_cart($(this).attr('item_id'));
    success: showpage('dumpcart.php?act=order');
	}
    );
    }
}
function dumptotalcart()
{
	$.ajax({
	type: "POST",
	url: "dumpcart.php?act=totalcart",
	beforeSend: showloading(),
	success: function(msg){
	$("#totalcart").hide();
	$("#totalcart").html(msg).show("slow");
	hideloading();
	},
	error: function(msg){
	$("#totalcart").html("<font color='#ff0000'>Ajax error</font>").show("slow");
	hideloading();
	}
	});
}

//MASS CHECK
function masscheck(){
    if ($(".checkcc").length > 0){
    beforeSend: showloading(),
	$('.checkcc').each(function(){
    checki($(this).attr('item_id'));
    hideloading();
	}
    );
    }
}
function massdumpcheck(){
    if ($(".checkdump").length > 0){
    beforeSend: showloading(),
	$('.checkdump').each(function(){
    dumpchecki($(this).attr('item_id'));
    hideloading();
	}
    );
    }
    
}
function packcheck(){
    if ($(".checkdump").length > 0){
    beforeSend: showloading(),
	$('.checkdump').each(function(){
    packchecki($(this).attr('item_id'));
    hideloading();
	}
    );
    }
    
}
//BALANCE
function balance()
{
	$.ajax({
	type: "GET",
	url: "balance.php",
	success: function(msg){
	$("#balance").hide();
	$("#balance").html(msg).show("slow");
	},
	error: function(msg){
	$("#balance").html("<font color='#ff0000'>Ajax error</font>").show("slow");
	}
	});
}