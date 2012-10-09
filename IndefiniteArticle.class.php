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

		if(preg_match("/^(".self::$A_y_cons.")/i", $word))		return "an $word";

		# OTHERWISE, GUESS "a"
		return "a $word";
	}
}
