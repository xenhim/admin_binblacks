<div class="page-header"><h1>INFO <small> store info</small></h1></div></div></div>
<div class="col-sm-4">
<h4>User Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="clip-users"></i>User Stats</div>
<table class="table table-bordered table-striped">
<tr><td><span class="label label-danger">Administrator</span></td><td><span class="badge badge-danger">{{adminUser}}</span></td></tr>
<tr><td><span class="label label-info">Seller</span></td><td><span class="badge badge-info">{{sellerUser}}</span></td></tr>
<tr><td><span class="label label-success">Users</span></td><td><span class="badge badge-success">{{userUser}}</span></td></tr>
<tr><td><span class="label label-inverse">Total</span></td><td><span class="badge badge-inverse">{{totalUser}}</span></td></tr>
</table>
</div>
</div>
</div>

<div class="col-sm-4">
<h4>Card Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Card Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Category</strong></span></td><td><strong>{{cardcategory}}</strong></td></tr>
<tr><td><strong>Total cards</strong></span></td><td><strong>{{totalcard}}</strong></td></tr>
<tr><td><strong>Unused cards</strong></span></td><td><strong>{{unusedcard}}</strong></td></tr>
<tr><td><strong>Used cards</strong></span></td><td><strong>{{usedcard}}</strong></td></tr>
</table>
</div>
</div>
</div>

<div class="col-sm-4">
<h4>CC Checker Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>CC Checker Stats</div>
<table class="table table-bordered table-striped">
<tr><td><span class="label label-success">Live</span></td><td><strong>{{livecards}}</strong></td></tr>
<tr><td><span class="label label-danger">Die</span></td><td><strong>{{diecards}}</strong></td></tr>
<tr><td><span class="label label-warning">Error</span></td><td><strong>{{errorcards}}</strong></td></tr>
<tr><td><span class="label label-primary">Unknown</span></td><td><strong>{{unknowncards}}</strong></td></tr>
<tr><td><span class="label label-info">Time off</span></td><td><strong>{{timeoffcards}}</strong></td></tr>
</table>
</div>
</div>
</div>

<div class="col-sm-8">
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Cards Checker</div>
<div><center>
{{cardschart | raw}}
</center>
</div>
</div>
</div>
</div>

<div class="col-sm-4">
<h4>TOP 7 USER</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>With Balance</div>
<table class="table table-bordered table-striped">
{% for user in listuser %}
<tr><td><strong>{{user.username}}</strong></span></td><td><strong>{{user.credit}} $</strong></td></tr>
{% endfor %}
</table>
</div>
</div>
</div>

<hr>

<div class="col-sm-8">
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>Dumps Checker</div>
<div><center>
{{dumpschart | raw}}
</center>
</div>
</div>
</div>
</div>

<div class="col-sm-4">
<h4>Dumps Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>Credit Card Stats</div>
<table class="table table-bordered table-striped">
<tr><td><strong>Category</strong></span></td><td><strong>{{dumpcategory}}</strong></td></tr>
<tr><td><strong>Total dumps</strong></span></td><td><strong>{{totaldumps}}</strong></td></tr>
<tr><td><strong>Unused dumps</strong></span></td><td><strong>{{unuseddumps}}</strong></td></tr>
<tr><td><strong>Used dumps</strong></span></td><td><strong>{{useddumps}}</strong></td></tr>
</table>
</div>
</div>
</div>

<div class="col-sm-4">
<h4>Dump Stats</h4>
<div class="well">
<div class="panel panel-default">
<div class="panel-heading"><i class="fa fa-credit-card"></i>Dump Checker Stats</div>
<table class="table table-bordered table-striped">
<tr><td><span class="label label-success">Live</span></td><td><strong>{{livedumps}}</strong></td></tr>
<tr><td><span class="label label-danger">Die</span></td><td><strong>{{diedumps}}</strong></td></tr>
<tr><td><span class="label label-warning">Error</span></td><td><strong>{{errordumps}}</strong></td></tr>
<tr><td><span class="label label-primary">Unknown</span></td><td><strong>{{unknowndumps}}</strong></td></tr>
<tr><td><span class="label label-info">Time off</span></td><td><strong>{{timeoffdumps}}</strong></td></tr>
</table>
</div>
</div>
</div>