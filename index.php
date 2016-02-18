<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="try.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
    <title>Accio! | Grab your playlist from Spotify</title>
  </head>

  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Accio!</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <!--<li><a href="about.php">About</a></li>
            <li><a href="#Github">Github</a></li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<!-- Jumbotron -->
    <div class="jumbotron">
      <div class="container" style="text-align:center;">
        <h1><img src="Accio-logo.png" height='200px'></h1>
        <p>Grab your own playlist from Spotify without hurting through your catalog!</p>
      </div>
    </div>
	
	<!-- Container -->
    <div class="container">
      <div class="row">
        <div class="col-md">
          <h2>Describe your playlist:</h2>
		  <form name="talk" method="post" action="playlist.php">
			<textarea name="words" id="words" class="form-control" rows="5"></textarea>
			<br />
			<input type="submit" class="btn btn-lg btn-primary btn-block" value="Create your Playlist"></input>
		  </form>
		  <br />
		  <h2>Here are examples below:</h2>
		  <blockquote>
			  <p>Include The Rolling Stones, John Lennon.</p>
			  
			  <p>Play Taylor Swift.</p>
			  <p>I like Hip Hop.</p>
			  <p>Include The Rolling Stones, John Lennon and I don't like Bob Marley.</p>
			</blockquote>
			<br />
			<center><small>ACCIO will generate a playlist for you which is related to The Rolling Stones, John Lennon. You can try with any artists, songs or albums.</small></center>
			
			<br /><br />
			<center><small>Copyright 2014 @ Accio! All right reserved. API Powred by Spotify.</small></center>
        </div>
      </div>
    </div> 
	<!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/respond.js"></script>

  </body>
</html>
