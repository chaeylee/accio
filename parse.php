<?php

require_once 'alchemyapi.php';
require_once 'imageHelper.php';

class ParseClass {

	public function parseWords($text) {
		$alchemy = new AlchemyAPI();

		//$str = "I don't like the Beatles or Owl City. I like MGMT";
		//$str = "It will not include 'MGMT', 'the doors', and 'Foster The People'. I want to include 'michael jackson', 'Owl City', 'the rolling stones', and 'fastball'. ";
		//$str = "I want to hear alternative rock. Don't use Pearl Jam, Nirvana, or Soundgarden. Include Sleepyhead, John Lennon, and Hotel Yorba";

		if( strpos($text, '.') !== false) {
			$strs = explode('.', $text);
			
			foreach($strs as $index => $subStr) {
				
				if( empty($subStr) ) {
					unset($strs[$index]);
				}

				else {
					$strs[$index] = str_replace('not include', 'exclude', $subStr);
				}
			}
		}
		else {
			$strs = array($text . '.');
		}

		foreach($strs as $index => $subStr) {
			//echo $subStr . '<br />';
			$strs[$index] = $alchemy->relations('text', $subStr, array(
				'keywords' => 1));

			//to test
			if( empty($strs[$index]['relations']) ) { // if the alchemy call came back empty, there's no subject
				$strs[$index] = $alchemy->relations('text', 'It ' . $subStr, array(
				'keywords' => 1));
			}
		}
		
		$op = 'nothing yet';
		$commands = array();
		$addCommands = array('find', 'include', 'make', 'want', 'be', 'do', 'add', 'like', 'use', 'with', 'listen', 'hear', 'play');
		$removeCommands = array('exclude', 'forbid', 'without', 'filter');

		//echo '<pre>' . print_r($strs, true) . '</pre>';

		foreach($strs as $subStr) {
			foreach($subStr['relations'] as $index => $relation) {
				if( count($relation) == 1 ) {
					$relation = array($relation);
				}
				if( array_key_exists('action', $relation) ) {
					if( strpos($relation['object']['text'], "n't") !== false )
						continue;

					if(array_key_exists('negated', $relation['action']['verb']) && $relation['action']['verb']['negated'] == 1) {
						if(in_array( strtolower($relation['action']['verb']['text']), $addCommands) )
							$op = 'exclude';
						else if(in_array( strtolower($relation['action']['verb']['text']), $removeCommands))
							$op = 'include';
						else
							$op = 'error';
					}
					else /*if($relation['action']['verb']['negated'] == 0)*/ {
						if(in_array( strtolower($relation['action']['verb']['text']), $addCommands) )
							$op = 'include';
						else if(in_array( strtolower($relation['action']['text']), $removeCommands))
							$op = 'exclude';
						else 
							$op = 'error';
					}
					if( strcmp( $relation['object']['text'], 'It') == 0 )
						$realObject = 'subject';
					else 
						$realObject = 'object';
					foreach($relation[$realObject]['keywords'] as $keyword) {
						$commands[] = array('op' => $op, 'keyword' => $keyword['text']);
					}
				}
			}
		}

		// sanitize $parsedCommands

		// first remove duplicates
		foreach($commands as $index => $compare) {
			foreach($commands as $index2 => $search) {
				if( ($index != $index2) ) {
					if( strcmp($search['op'], $compare['op']) == 0 ) {
						if( strcmp($search['keyword'], $compare['keyword']) == 0 )
							unset( $commands[$index] );
					}
				}
			}
		}
		/*
		$genres = ImageHelper::readGenresFile();
		$genresArr = explode(' ', $genres);
		echo '<pre>' . print_r($genresArr, true) . '</pre>';?8
/*
		foreach($commands as $command) {
			if( $command['keyword'] )
		}*/

		// parse commands
		$searchStr = '';
		$arrKeys = array_keys($commands);

		foreach($commands as $index => $command) {
			$command['keyword'] = str_replace(' ', '+', $command['keyword']);

			if( $index == $arrKeys[0] ) {
				if( strcmp($command['op'], 'include') == 0)
					$searchStr = $searchStr . $command['keyword'];
				else 
					$searchStr = $searchStr . 'NOT+' . $command['keyword'];
				continue;
			}

			if( strcmp($command['op'], 'include') == 0)
				$searchStr = $searchStr . '+OR+' . $command['keyword'];
			else
				$searchStr = $searchStr . '+NOT+' . $command['keyword'];
		}

		//echo '<pre>' . print_r($strs, true) . '</pre>';
		//echo '<pre>' . print_r( $commands, true) . '</pre><br />';
		//echo $searchStr;
		return $searchStr;
	}

	public function parseResponse($json) {
		if( array_key_exists('error', $json) ) {
			return;// error
		}

		if( array_key_exists('tracks', $json) && !empty($json['tracks']['items']) ) {
			$playlist = array();

			foreach($json['tracks']['items'] as $index => $item) {
				/*echo $index . ' ';
				echo '<pre>' . print_r($item, true) . '</pre><br >';
				*/
				if( strcmp($item['type'], 'track') == 0 ) {
					$song['name'] = $item['name'];
					$song['uri'] = $item['uri'];

					foreach($item['artists'] as $artist)
						$song['artist'] = $artist['name'];
					$song['album']['uri'] = $item['album']['uri'];
					$song['album']['name'] = $item['album']['name'];
					$song['album']['cover'] = ImageHelper::findLargestImage($item['album']['images']);

					$playlist[] = $song;
				}
			}
		}

 		return $playlist;
	}

        public function filterSongsByArtist($json, $parsedJson, $urlText) {
        
          $done = false;
          $page = 0;
          $URIs = '';
          $artist_count = array();

          //while($json['next'] != '') {
        while($page <=10 ) {
        	foreach($parsedJson as $index => $song) {
            	if(array_key_exists($song['artist']['name'], $artist_count)) {

              		if( $artist_count[$song['artist']['name']] <= 25 ) { // now add current song
       	       
        	        	if ( $index == (count($parsedJson) - 1) ) {
        	        	   $URIs = $URIs . $song['uri'];
        	        	}
        		        else {
        		           $URIs = $URIs . $song['uri'] . ',';
        		        }
        		        $artist_count[$song['artist']['name']] += 1;
        		    }

        		    else {
             		  continue;
       	    	  	}
        		}
        	    else {
        	      $URIs = $URIs . $song['uri'] . ',';
        	      $artist_count[$song['artist']['name']] = 1;
        	    }
        	}
        	$page += 1;

        	$urlText = $urlText . '&page=' . $page;
        	$string = file_get_contents($urlText);
        	$json = json_decode($string, true);
        	$parsedJSon = ParseClass::parseResponse($json);
        }
        //	echo $URIs;
          return $URIs;
      }

}

?>