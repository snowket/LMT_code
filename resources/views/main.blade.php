<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LMT</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
			<nav class="navbar navbar-default">
			<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="Migration">LMT</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
			<li ><a href="/migration">Migration </a></li>
			<li><a href="/model">Model</a></li>
			<li><a href="/controller">Controller</a></li>
			<li><a href="/adminconfig">Admin Config</a></li>

			</ul>


			</div><!-- /.navbar-collapse -->
			</div><!-- /.container-fluid -->
			</nav>

			@yield('button')

			@yield('content')

	<!-- Latest compiled and minified JavaScript -->


<script>
	$(function(){
    $('#migration-form-submit').on('submit', function(e){
        e.preventDefault();
        console.log($('#migration-form-submit').serialize());
        $.ajax({
            url: '/migration', //this is the submit URL
            type: 'POST', //or POST
            data: $('#migration-form-submit').serialize(),
            success: function(data){
                 alert('successfully Created ' + data)
                 location.reload();
            }
        });
    });

});
</script>
</body>
</html>
