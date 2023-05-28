<script type="text/javascript">
$(document).ready(function () {
    $("#msg_form").submit(Send);
    $("#msg").focus();
    setInterval("Load();", 2000);
$('<audio id="chatAudio"><source src="assets/audio/notify.ogg" type="audio/ogg"><source src="assets/audio/notify.mp3" type="audio/mpeg"><source src="assets/audio/notify.wav" type="audio/wav"></audio>').appendTo('body');
});

function Send() {
$.post("ajax-support.php",
{
act: "send",
text: $("#msg").val()
},
Load );
$("#msg").val("");
$("#msg").focus();
return false;
}

var last_message_id = 0;
var load_in_process = false;

function Load() {
if(!load_in_process)
{
load_in_process = true;
$.post("ajax-support.php",
{
act: "load",
last: last_message_id,
rand: (new Date()).getTime()
},
function (result) {
$(".panel-body").scrollTop($(".panel-body").get(0).scrollHeight);
load_in_process = false;
});
}
}
</script>
<div class="page-header"><h1>Support<small> Only text</small></h1></div></div></div>
<div class="row">
<div class="col-sm-12">
<div class="panel panel-default"><div class="panel-heading"><i class="clip-bubble-4"></i>Support Chat</div>
<div class="panel-body" style="height:460px; overflow: auto;">
<ol class="discussion">
<div id="message_list" >

</div>
</ol>
										</div>
									</div>
								</div>
                                <div class="col-sm-12">
                                <form id="msg_form" action="">
									<div class="chat-form">
										<div class="input-group">
											<input id="msg" type="text" class="form-control input-mask-date" placeholder="Type a message here...">
											<span class="input-group-btn">
												<button class="btn btn-teal" type="submit">
													<i class="fa fa-check"></i>
												</button> </span>
            </form>
										</div>
									</div>
								</div>
</div>