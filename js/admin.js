function showloading()
{
	//$("#loading2").show()
	$.blockUI({ message: '<h1><img src="../images/load.gif" /><p>Just a moment..</h1>',showOverlay: true, css: { backgroundColor: '#FFFFFF'}});
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
function editcard(editcard){
    $.fn.modalmanager.defaults.resize = true;
        $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
            '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
            '<div class="progress progress-striped active">' +
            '<div class="progress-bar" style="width: 100%;"></div>' +
            '</div>' +
            '</div>';
    var $modal = $('#ajax-modal');
  // create the backdrop and wait for next modal to be triggered
  $('body').modalmanager('loading');

  setTimeout(function(){
     $modal.load('./'+editcard, '', function(){
      $modal.modal();
    });
  }, 1000);
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
	hideloading();
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
	hideloading();
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
	hideloading();
	},
	error: function(msg){
	$("#cardResult"+cardId).html("<font color='#ff0000'>Ajax loading error, please try again.</font>").show("slow");
	hideloading();
	}
	//, complete: hideloading()
	});
}