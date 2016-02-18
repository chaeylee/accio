<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="try.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/jumbotron.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
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
        <div class="col-md-6">
          <h2>Here is your playlist!</h2>
      <?
        require_once('parse.php');

				$keyword = $_POST['words']; 
				//echo $keyword . '<br />';
        $searchStr = ParseClass::parseWords($keyword);
        //echo 'searchStr: ' . $searchStr;

				$urlText = "https://api.spotify.com/v1/search?type=track&q=" . $searchStr;
				$string = file_get_contents($urlText);
				$json = json_decode($string, true);
				//echo '<pre>' . print_r($json, true) . '</pre><br />';;
        $parsedJson = ParseClass::parseResponse($json);
				//echo '<pre>' . print_r($parsedJson, true) . '</pre><br />';

        $URIs = '';
//        $URIs = ParseClass::filterSongsByArtist($json, $parsedJson, $urlText);
        //echo $URIs;

        foreach($parsedJson as $index => $song) {
           if ( $index == (count($parsedJson) - 1) )
            $URIs = $URIs . $song['uri'];          
           else 
            $URIs = $URIs . $song['uri'] . ',';

           echo ' 	<div style=><div class="col-md-3"><img src=' . $song['album']['cover']['url'] . ' width=90px height=90px></div><div class="col-md-9" style="padding-bottom:15px;"> <h3>' . $song['name'] .'</h3><h5>' . $song['album']['name'] .' by <b>' . $song['artist'] .'</b></h5></div></div>'; 
				
        }

        $file = fopen('uris.txt', 'w') or die('Unable to open file');
        fwrite($file, $URIs);
        fclose($file);

			?>
        </div>
		<div class="col-md-6">
          <h2>Do you like this playlist?</h2>
          <a class="btn btn-lg btn-primary btn-block" onclick="login()">Click here to Accio!</a>
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
