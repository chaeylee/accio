<?php

class ImageHelper {
	public function findLargestImage($imagesArr) {
		foreach($imagesArr as $index => $image) {
			if($index == 0) {
				$largest = $image;
				continue;
			}

			if( $image['height'] > $largest['height'])
				$largest = $image;

			return $largest;
		}
	}

	public function readGenresFile() {
		$readFile = fopen("genres.txt", "r") or die("Unable to open file");
		$writeFile = fopen("GENRES.TXT", "w") or die("Unable to open file");
		//$genres = fread($file, filesize("genres.txt"));
		while( ($line = fgets($readFile)) !== false )
			fwrite($writeFile, $line . ',');
		fclose($readFile);
		fclose($writeFile);

		return $genres;
	}


}

?>