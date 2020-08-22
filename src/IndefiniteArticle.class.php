<?php

class IndefiniteArticle
{

	public static function AN($input, $count=1) {
		return self::A($input, $count);
	}

	public static function A($input, $count=1) {
		$matches = array();
		$matchCount = preg_match("/\A(\s*)(?:an?\s+)?(.+?)(\s*)\Z/i", $input, $matches);
		list($all, $pre, $word, $post) = $matches;
		if(!$word)
			return $input;
		$result = self::_indef_article($word, $count);	
                return $pre.$result.$post;
	}

	# THIS PATTERN MATCHES STRINGS OF CAPITALS STARTING WITH A "VOWEL-SOUND"
	# CONSONANT FOLLOWED BY ANOTHER CONSONANT, AND WHICH ARE NOT LIKELY
	# TO BE REAL WORDS (OH, ALL RIGHT THEN, IT'S JUST MAGIC!)

	private static $A_abbrev = "(?! FJO | [HLMNS]Y.  | RY[EO] | SQU
		  | ( F[LR]? | [HL] | MN? | N | RH? | S[CHKLMNPTVW]? | X(YL)?) [AEIOU])
			[FHLMNRSX][A-Z]
		";

	# THIS PATTERN CODES THE BEGINNINGS OF ALL ENGLISH WORDS BEGINING WITH A
	# 'y' FOLLOWED BY A CONSONANT. ANY OTHER Y-CONSONANT PREFIX THEREFORE
	# IMPLIES AN ABBREVIATION.

	private static $A_y_cons = 'y(b[lor]|cl[ea]|fere|gg|p[ios]|rou|tt)';

	# EXCEPTIONS TO EXCEPTIONS

	private static $A_explicit_an = "euler|hour(?!i)|heir|honest|hono";
		
	private static $A_ordinal_an = "[aefhilmnorsx]-?th";

	private static $A_ordinal_a = "[bcdgjkpqtuvwyz]-?th";

	private static function _indef_article($word, $count) {
		if($count != 1) // TODO: Check against $PL_count_one instead
			return "$count $word";

    		# HANDLE USER-DEFINED VARIANTS
		// TODO

		# HANDLE NUMBERS IN DIGIT FORM (1,2 …)
		#These need to be checked early due to the methods used in some cases below

		#any number starting with an '8' uses 'an'
		if(preg_match("/^[8](\d+)?/", $word))					return "an $word";
		
		#numbers starting with a '1' are trickier, only use 'an'
		#if there are 3, 6, 9, … digits after the 11 or 18
		
		#check if word starts with 11 or 18
		if(preg_match("/^[1][1](\d+)?/", $word) || (preg_match("/^[1][8](\d+)?/", $word))) {

			#first strip off any decimals and remove spaces or commas
			#then if the number of digits modulus 3 is 2 we have a match
			if(strlen(preg_replace(array("/\s/", "/,/", "/\.(\d+)?/"), '', $word))%3 == 2) return "an $word";
		}

		# HANDLE ORDINAL FORMS
		if(preg_match("/^(".self::$A_ordinal_a.")/i", $word)) 		return "a $word";
		if(preg_match("/^(".self::$A_ordinal_an.")/i", $word))     	return "an $word";

		# HANDLE SPECIAL CASES

		if(preg_match("/^(".self::$A_explicit_an.")/i", $word))     	return "an $word";
		if(preg_match("/^[aefhilmnorsx]$/i", $word))     	return "an $word";
		if(preg_match("/^[bcdgjkpqtuvwyz]$/i", $word))     	return "a $word";

    		# HANDLE ABBREVIATIONS

		if(preg_match("/^(".self::$A_abbrev.")/x", $word))     		return "an $word";
		if(preg_match("/^[aefhilmnorsx][.-]/i", $word))     	return "an $word";
		if(preg_match("/^[a-z][.-]/i", $word))     		return "a $word";

		# HANDLE CONSONANTS

		#KJBJM - the way this is written it will match any digit as well as non vowels
		#But is necessary for later matching of some special cases.  Need to move digit
		#recognition above this.
		#rule is: case insensitive match any string that starts with a letter not in [aeiouy] 
		if(preg_match("/^[^aeiouy]/i", $word))                  return "a $word";

    		# HANDLE SPECIAL VOWEL-FORMS

		if(preg_match("/^e[uw]/i", $word))                  	return "a $word";
		if(preg_match("/^onc?e\b/i", $word))                  	return "a $word";
		if(preg_match("/^uni([^nmd]|mo)/i", $word))		return "a $word";
		if(preg_match("/^ut[th]/i", $word))                  	return "an $word";
		if(preg_match("/^u[bcfhjkqrst][aeiou]/i", $word))	return "a $word";

    		# HANDLE SPECIAL CAPITALS

		if(preg_match("/^U[NK][AIEO]?/", $word))                return "a $word";

		# HANDLE VOWELS

		if(preg_match("/^[aeiou]/i", $word))			return "an $word";

		# HANDLE y... (BEFORE CERTAIN CONSONANTS IMPLIES (UNNATURALIZED) "i.." SOUND)

		if(preg_match("/^(".self::$A_y_cons.")/i", $word))	return "an $word";
		
		#DEFAULT CONDITION BELOW
		# OTHERWISE, GUESS "a"
		return "a $word";
	}
}
