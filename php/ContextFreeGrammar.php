<?php

	include("wordlists.php");

	// Not Exactly Context Free Grammar Generator with Nearly Gaussian Distribution of Words V 1.5
	
	// Known bugs:
	// Does not handle plurals very well i.e. "Zero innocent beetles does observe many tests." should be DO not DOES
	// Does not s-ify nouns well e.g. "toothbrushs"
	// Does not an-ify nouns that start with e or a etc.
	// 
	
	// Notable Quotes:
	// 						"The finger does poke the eye."
	//            "Another game shamefully had breathed a couple of numbers."
	
	function randprocent(){
		return (rand(0,100)/100.0);
	}
	
	function edify($word){
		$subs=substr(trim($word),-1);
		if(strpos($subs,"e")===FALSE){
				return "ed";
		}else{
				return "d";
		}
	}
	
	function randomword($list,$distribution){
			if($distribution){
				return $list[rand(0,count($list)-1)];
			}else{
				$ret=rand(0,count($list)-1);
				$ret=rand(0,$ret);
				return $list[$ret];
			}
	}

	function replacen($search,$replace,$subject,$n){
		$foundpos=0;
		$foundcount=0;
		$cont=1;

		$beforestr="";
		$afterstr="";
		
		do{
				$foundpos=strpos($subject,$search,$foundpos);
				if($foundpos===FALSE){
						$cont=0;
				}else{
						if($n==$foundcount){
								$beforestr=substr($subject,0,$foundpos);
								$afterstr=substr($subject,$foundpos+strlen($search));								
								return $beforestr.$replace.$afterstr;
						}
						$foundcount++;
						$foundpos+=strlen($search);
				}		
		}while($cont==1);
		
		return $subject;
		
	}	
	
	function countfinds($search,$subject){
		$foundpos=0;
		$foundcount=0;
		$cont=1;
		
		do{
				$foundpos=strpos($subject,$search,$foundpos);
				if($foundpos===FALSE){
						$cont=0;
				}else{
						$foundcount++;
						$foundpos+=strlen($search);
				}		
		}while($cont==1);
		
		return $foundcount;
	}	
	
	function replacerandom($placeholder,$set,$distribution,$sentence){
			$found=countfinds($placeholder,$sentence);			
			for($i=0;$i<$found;$i++){
				$sentence=replacen($placeholder,randomword($set,$distribution),$sentence,0);					
			}
			return $sentence;
	}
	
	function generate_sentence($probnounphrase,$probverbphrase,$probdualajdectives,$probstartadj,$distributionnouns,$distributionverbs,$distributionadjectives,$distributionadverbs,$distributiondeterminers,$distributionconjunctions,$distributionmodals) {
		
			global $noun,$verb,$determiner,$adjective,$adverb,$conjunction,$modal;

			$sentence="[subject] [verbphrase] [object]";
			
			$sentence=str_replace("[subject]","[nounphrase]",$sentence);
			$sentence=str_replace("[object]","[nounphrase]",$sentence);
			
			// Replace all nounphrases with "delimiter noun" or "delimiter adjective noun"
			// Also add determiners and plural s
						
			$nonounphrases=countfinds("[nounphrase]",$sentence);			
			for($i=0;$i<$nonounphrases;$i++){
				if(randprocent()>=$probnounphrase){

						$replacestring=randomword($determiner,$distributiondeterminers);
		
						if($replacestring=="another"||$replacestring=="a"||$replacestring=="the"||$replacestring=="one"||$replacestring=="this"||$replacestring=="that"||$replacestring=="which"||$replacestring=="either"||$replacestring=="neither"||$replacestring=="each"||$replacestring=="every"||$replacestring=="any"||$replacestring=="whichever"||$replacestring=="the same"||$replacestring=="which"||$replacestring=="whatever"||$replacestring=="no"||$replacestring=="my"||$replacestring=="your"||$replacestring=="our"||$replacestring=="his"||$replacestring=="her"||$replacestring=="each"||$replacestring=="the only"||$replacestring=="the"||$replacestring=="this"||$replacestring=="that"){
								$replacestring=" ".$replacestring." [noun]";	
						}else{
								$replacestring=" ".$replacestring." [noun]s";				
						}

						$sentence=replacen("[nounphrase]",$replacestring,$sentence,0);
											
				}else{
						$replacestring=randomword($determiner,$distributiondeterminers);
		
						if($replacestring=="another"||$replacestring=="a"||$replacestring=="the"||$replacestring=="one"||$replacestring=="this"||$replacestring=="that"||$replacestring=="which"||$replacestring=="either"||$replacestring=="neither"||$replacestring=="each"||$replacestring=="every"||$replacestring=="any"||$replacestring=="whichever"||$replacestring=="the same"||$replacestring=="which"||$replacestring=="whatever"||$replacestring=="no"||$replacestring=="my"||$replacestring=="your"||$replacestring=="our"||$replacestring=="his"||$replacestring=="her"||$replacestring=="each"||$replacestring=="the only"||$replacestring=="the"||$replacestring=="this"||$replacestring=="that"){
								$replacestring=" ".$replacestring." [adjective] [noun]";	
						}else{
								$replacestring=" ".$replacestring." [adjective] [noun]s";				
						}

						$sentence=replacen("[nounphrase]",$replacestring,$sentence,0);
				}			
			}
			

			// Replace all noun determiners with a random determiner			
			$found=countfinds("[determiner] [noun]",$sentence);			
			for($i=0;$i<$found;$i++){
				echo "<div style='color:red'>FOO $sentence $found</div>";
				$replacestring=randomword($determiner,$distributiondeterminers);

				if($replacestring=="another"||$replacestring=="a"||$replacestring=="the"||$replacestring=="one"||$replacestring=="much"||$replacestring=="this"||$replacestring=="that"||$replacestring=="which"||$replacestring=="either"||$replacestring=="neither"||$replacestring=="each"||$replacestring=="every"||$replacestring=="any"||$replacestring=="whichever"||$replacestring=="the same"||$replacestring=="which"||$replacestring=="whatever"||$replacestring=="no"||$replacestring=="my"||$replacestring=="your"||$replacestring=="our"||$replacestring=="his"||$replacestring=="her"||$replacestring=="each"||$replacestring=="the only"||$replacestring=="the"||$replacestring=="this"||$replacestring=="that"){
						$replacestring=" ".$replacestring." [noun]";	
				}else{
						$replacestring=" ".$replacestring." [noun]s";				
				}
				
				$sentence=replacen("[determiner] [noun]",$replacestring,$sentence,0);				
				echo "<div style='color:green'>FOO $sentence $found</div>";
			}


			// Replace all verbphrases with "verb" or "adverb verb"			
			$nonounphrases=countfinds("[verbphrase]",$sentence);			
			for($i=0;$i<$nonounphrases;$i++){
				if(randprocent()>=$probverbphrase){
						$sentence=replacen("[verbphrase]","[verb]",$sentence,0);					
				}else{
						$sentence=replacen("[verbphrase]","[adverb] [verb]",$sentence,0);							
				}			
			}
			
			// Replace some adjectives with two adjectives
			$adjectives=countfinds("[adjective]",$sentence);			
			for($i=0;$i<$adjectives;$i++){
				if(randprocent()>=$probdualajdectives){
						$sentence=replacen("[adjective]","[dual adjective]",$sentence,0);					
				}			
			}
			
			// Replace all dual adjectives with two adjectives
			// One alternative to this is to insert an "and" between the two adjectives
			$dualadjectives=countfinds("[dual adjective]",$sentence);			
			for($i=0;$i<$dualadjectives;$i++){
				$sentence=replacen("[dual adjective]","[adjective] [conjunction] [adjective]",$sentence,0);					
			}
			
			// Replace all conjunctions with a random conjunction			
			$found=countfinds("[adjective] [conjunction] [adjective]",$sentence);			
			for($i=0;$i<$found;$i++){
				$replacestring=randomword($conjunction,$distributionconjunctions);
				if($replacestring=="or"){
					$replacestring="either [adjective] or [adjective]";
				}else if($replacestring=="nor"){
					$replacestring="neither [adjective] nor [adjective]";					
				}else if($replacestring=="both"){									
					$replacestring="both [adjective] and [adjective]";
				}else if($replacestring=="equally"){									
					$replacestring="equally [adjective] and [adjective]";
				}else{
					$replacestring="[adjective] ".$replacestring." [adjective]";
				}
				$sentence=replacen("[adjective] [conjunction] [adjective]",$replacestring,$sentence,0);				
			}

			// Replace all nouns with a random noun
			$sentence=replacerandom("[noun]",$noun,$distributionnouns,$sentence);			

			// Replace all verbs with a random verb
			// Verbs have modals
			
			$found=countfinds("[verb]",$sentence);			
			for($i=0;$i<$found;$i++){
				$replacestring=randomword($verb,$distributionverbs);
				$amodal=randomword($modal,$distributionmodals);
				
				if($amodal=="s"){
						$replacestring.="s";
				}else if($amodal=="ed"){
						$replacestring=$replacestring.edify($replacestring);	
				}else if($amodal=="had"){
						$replacestring=$amodal." ".$replacestring.edify($replacestring);					
				}else{
						// All others such as can shall will did etc
						$replacestring=$amodal." ".$replacestring;				
				}
				
				$sentence=replacen("[verb]",$replacestring,$sentence,0);				
			}

			// Replace all adverbs with a random adverb			
			$sentence=replacerandom("[adverb]",$adverb,$distributionadverbs,$sentence);			

			// Replace all adjectives with a random adjective			
			$sentence=replacerandom("[adjective]",$adjective,$distributionadjectives,$sentence);			
							
			return $sentence;
					
	}
	
	
	// Nounphrase probability
	// Verbphrase probability
	// Dual Adjective probability
	// Start adverb probability
	
	// Distribution nouns
	// Distribution verbs
	// Distribution adjectives
	// Distribution adverbs
	// Distribution determiner	
	// Distribution conjunctions	
	
	for($i=0;$i<20;$i++){
			$sentence=generate_sentence(0.5,0.5,0.5,0.5,0,0,0,0,0,0,0);
			$sentence=ucfirst(trim($sentence));
			echo $sentence.".<br>";
	}

?>



