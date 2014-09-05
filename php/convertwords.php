<?php
	
	// Allows us to keep a number of word lists that can be shuffled
	// If we want to guarantee that some common words appear at the top of the list (for gaussian sampling) we do this by the exclude parameter 
	
	function readafile($filename){
		$set=array();

		$lines = file($filename);

		foreach ($lines as $line_num => $line) {
				$set[] = trim($line);
		}		
		return $set;
	}
	
	function writearray($list,$arrayname,$noperline,$shuffle,$shuffleexclude){
			
			if($shuffle){
					$noshuffle_list=array_slice($list, 0, $shuffleexclude);
					$shuffle_list=array_slice($list,$shuffleexclude);
					shuffle($shuffle_list);
					$list=array_merge($noshuffle_list,$shuffle_list);
			}
			
			echo "\$".$arrayname."=array(";
			$i=0;
			foreach($list as $word){
				if($i==0){
				 echo "\"".$word."\"";
				}else{
				 echo ",\"".$word."\"";
				}
				$i++;
				if($i%$noperline==0){
						echo "<br>\n";
				}
			}
			echo ");";
	}
	
	//Read verbs
	
	$verbs=readafile("verb_words.txt");
	writearray($verbs,"verb","20",1,0);
	
	echo "<br>\n";	
	echo "<br>\n";	

	$nouns=readafile("noun_words.txt");
	writearray($nouns,"noun","20",1,10);

	echo "<br>\n";	
	echo "<br>\n";	

	$adjectives=readafile("adjective_words.txt");
	writearray($adjectives,"adjective","20",1,0);

	echo "<br>\n";	
	echo "<br>\n";	

	$adverbs=readafile("adverb_words.txt");
	writearray($adverbs,"adverb","20",1,0);


?>