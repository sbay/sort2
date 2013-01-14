<?php
define('CRIME_DUI', 				0x0000001 );
define('CRIME_OTHER', 				0x0000002 );
define('CRIME_ALL', 				CRIME_DUI | CRIME_OTHER );

define('ZIP_LIST_LA', 				0x0000010 );
define('ZIP_LIST_LAP', 				0x0000020 );
define('ZIP_LIST_LAX', 				0x0000040 );
define('ZIP_LIST_ONT', 				0x0000080 );
define('ZIP_LIST_OR', 				0x0000100 );
define('ZIP_LIST_OX', 				0x0000200 );
define('ZIP_LIST_PC', 				0x0000400 );
define('ZIP_LIST_SFS', 				0x0000800 );
define('ZIP_LIST_WC', 				0x0001000 );
define('ZIP_LIST_SKIP', 			0x0002000 );
define('ZIP_LIST_ALL', 				ZIP_LIST_LA|ZIP_LIST_LAP|ZIP_LIST_LAX|ZIP_LIST_ONT|ZIP_LIST_OR|ZIP_LIST_OX|ZIP_LIST_PC|ZIP_LIST_SFS|ZIP_LIST_WC);

define('AGENCY_LAPD', 				0x0010000 );
define('AGENCY_VCSD', 				0x0020000 );
define('AGENCY_SBSD', 				0x0040000 );
define('AGENCY_LASD', 				0x0080000 );
define('AGENCY_OCSD', 				0x0100000 );

define('OTHER_RESULT_ONLY', 		0x1000000 ); // matched records short info
define('OTHER_FULL_RESULT', 		0x2000000 ); // all records full info
define('OTHER_SHORT_RESULT',		0x4000000 ); // all records short info
define('OTHER_MATCHED_FULL_RESULT',	0x0000004 ); // matched records full info

require_once 'VBitFlags.php';

class CrimeListFlag extends VBitFlags
{
	/**
	 * crime lists by type. For type 'all'  concatenate   lists
	 *
	 */
	const crime_list_dui 		= '23152, 23152(A), 23152A, 23152(B), 23152B, 23153, 23153(A), 23153A, 23153(B), 23153B';
	
	const crime_list_other 		= '14601.2, 14601.2A, 14601.2(A), 273.5, 273.5(A), 273.5A, 647(B), 647B, 666, 243E, 243(E), 243(E)(1), 243E1';
	
	/**
	 * selected crime lists
	 *
	 */
	protected $crime_list_cur 	= null;
	
	
	/**
	 * zip code lists by type.
	 *
	 */
	const zip_list_wc 					= '90606, 91010, 91016, 91018, 91702, 91706, 91711, 91722, 91723, 91724, 91731, 91732, 91733, 91740, 91741, 91744, 91745, 91746, 91748, 91750, 91765, 91766, 91767, 91768, 91773, 91789, 91790, 91791, 91792, 92821, 92823';
	
	const zip_list_la 					= '90004, 90005, 90010, 90019, 90020, 90024, 90025, 90027, 90028, 90029, 90034, 90035, 90036, 90038, 90046, 90048, 90049, 90064, 90067, 90068, 90069, 90073, 90077, 90210, 90211, 90212, 90272, 90401, 90402, 90403, 90404, 90405';
	
	const zip_list_sfs 					= '90040, 90201, 90202, 90241, 90240, 90242, 90262, 90270, 90280, 90502, 90601, 90602, 90603, 90638, 90639, 90640, 90650, 90660, 90670, 90701, 90703, 90706, 90715, 90716, 90723, 90712, 90713, 90731, 90732, 90744, 90745, 90746, 90747, 90801, 90802, 90803, 90804, 90805, 90806, 90813, 90814, 90822, 90831, 90840';
	
	const zip_list_laP 					= '93534, 93535, 93536, 93550, 93551, 93552, 93591';
	
	const zip_list_or 					= '90620, 90621, 90622, 90623, 90624, 90630, 90631, 90720, 90740, 92603, 92604, 92606, 92612, 92614, 92620, 92626, 92627, 92646, 92647, 92648, 92649, 92657, 92660, 92683, 92684, 92685, 92701, 92702, 92703, 92704, 92705, 92706, 92707, 92708, 92711, 92712, 92725, 92735, 92780, 92799, 92801, 92802, 92803, 92804, 92805, 92806, 92807, 92808, 92809, 92810, 92812, 92814, 92815, 92816, 92817, 92821, 92823, 92825, 92831, 92832, 92833, 92834, 92835, 92836, 92837, 92838, 92840, 92841, 92842, 92843, 92844, 92845, 92846, 92850, 92860, 92861, 92865, 92868, 92869, 92886, 92887, 92899';
	
	const zip_list_ox 					= '90313, 90323, 91320, 91360, 91361, 91362, 93001, 93003, 93004, 93010, 93012, 93013, 93015, 93021, 93022, 93023, 93030, 93033, 93035, 93040, 93041, 93042, 93043, 93044, 93060, 93063, 93064, 93065, 93066';
	
	const zip_list_pc 					= '90022, 90032, 90041, 90042, 90063, 90065, 90264, 90384, 91001, 91006, 91007, 91011, 91020, 91024, 91030, 91101, 91102, 91103, 91104, 91105, 91106, 91107, 91108, 91125, 91126, 91201, 91202, 91203, 91204, 91205, 91206, 91207, 91208, 91214, 91501, 91502, 91503, 91504, 91505, 91506, 91523, 91754, 91755, 91770, 91775, 91776, 91780, 91801, 91803, 90263, 90265, 90290, 91040, 91301, 91302, 91303, 91304, 91305, 91306, 91307, 91311, 91316, 91321, 91324, 91325, 91326, 91330, 91331, 91335, 91340, 91342, 91343, 91344, 91345, 91350, 91351, 91352, 91354, 91355, 91356, 91364, 91367, 91381, 91382, 91384, 91401, 91402, 91403, 91405, 91406, 91411, 91423, 91436, 91601, 91602, 91604, 91605, 91606, 91607, 91608';
	
	const zip_list_ont 					= '91701, 91730, 91737, 91739, 91743, 91752, 91761, 91764, 91784, 91786, 92313, 92316, 92318, 92324, 92335, 92336, 92337, 92354, 92376, 92377, 92401, 92405, 92410, 92411';
	
	const zip_list_lax 					= '90043, 90045, 90056, 90066, 90230, 90232, 90245, 90247, 90249, 90250, 90254, 90261, 90266, 90277, 90278, 90291, 90292, 90293, 90301, 90302, 90303, 90304, 90305, 90501, 90503, 90504, 90505, 90506, 90717';
	
	/**
	 * selected zip code lists
	 *
	 */
	protected $zip_list_cur 			= null;
	
	
	/**
	 * full , filtered records ( matched records )
	 *
	 */
	protected $full_matched_records		= null;
	
	
	const	record_not_matched		= 0x0000000;
	const	record_matched_zip		= 0x0000001;
	const	record_matched_crime	= 0x0000002;
	
	
	function __construct()
	{
		parent::__construct();
	}
	
	function isMatched( $record )
	{
		return $this->isFlagSet( $record['matched'] , (self::record_matched_zip|self::record_matched_crime) );
	}
	
	
	public function setCrimeListCurrent( $crime_list_current )
	{
		$this->crime_list_cur = array_unique(explode(', ', strtolower($crime_list_current)));
	}
	public function getCrimeListCurrent()
	{
		return $this->crime_list_cur;
	}
	
	
	public function setZipListCurrent( $zip_list_current )
	{
		$this->zip_list_cur = array_unique(explode(', ', $zip_list_current ));
	}
	public function getZipListCurrent()
	{
		return $this->zip_list_cur;
	}
	
	
	public function setFullMatchedRecords( $array_matched_records )
	{
		$this->full_matched_records = $array_matched_records;
	}
	public function getFullMatchedRecords()
	{
		return $this->full_matched_records;
	}
	
	public function isCrimeInCrimeList( $record_charges )
	{
		$cur_crime = null;
		foreach ( $this->crime_list_cur as $crime)
		{
			if (is_integer(strpos(strtolower($record_charges), $crime)))
			{
				$cur_crime	=	$crime;
				break;
			}
		}		 
		return ($cur_crime === null )? "" : $cur_crime;
	}
	
	public function  isSetDUI()
	{
		return $this->isFlagSetInAllFlags(CRIME_DUI);
	}

	public function  isSetOTHERCrimes()
	{
		return $this->isFlagSetInAllFlags(CRIME_OTHER);
	}

	public function  isSetALLCrimes()
	{
		return $this->isFlagSetInAllFlags(CRIMECRIME_ALL);
	}

	public function  isSetSkipZip()
	{
		return $this->isFlagSetInAllFlags(ZIP_LIST_SKIP);
	}
	
	public function  isMatchedFullFlagSet()
	{
		return $this->isFlagSetInAllFlags(OTHER_MATCHED_FULL_RESULT);
	}
	
	public function  isMatchedShortFlagSet()
	{
		return $this->isFlagSetInAllFlags(OTHER_RESULT_ONLY);
	}
	public function  isFullFlagSet()
	{
		return $this->isFlagSetInAllFlags(OTHER_FULL_RESULT);
	}
	
	public function  isShortFlagSet()
	{
		return $this->isFlagSetInAllFlags(OTHER_SHORT_RESULT);
	}
	public function  isMatchAnyFlagSet()
	{
		return ( $this->isFlagSetInAllFlags(OTHER_RESULT_ONLY) || $this->isFlagSetInAllFlags(OTHER_MATCHED_FULL_RESULT) ) ;
	}
	
	public function  isAllRecordsAnyFlagSet()
	{
		return ( $this->isFlagSetInAllFlags(OTHER_FULL_RESULT) || $this->isFlagSetInAllFlags(OTHER_SHORT_RESULT) ) ;
	}
	public function  mapAllFlagsAndLists( $flags_array )
	{
		// map CRIME_LIST
		switch ($flags_array['crime_list'])
		{
			case "dui":
				$this->setFlagToAllFlags(CRIME_DUI); 
				$this->setCrimeListCurrent( self::crime_list_dui );
				break;
			case "other":
				$this->setFlagToAllFlags(CRIME_OTHER); 
				$this->setCrimeListCurrent( self::crime_list_other );
				break;
			case "all":
				$this->setFlagToAllFlags(CRIME_ALL); 
				$this->setCrimeListCurrent( self::crime_list_dui . ', ' .  self::crime_list_other );
				break;
			default: ;
				break;
		}


		// map ZIP_LIST
		switch ($flags_array['zip_list'])
		{
			case "los_angeles":
				$this->setFlagToAllFlags(ZIP_LIST_LA); 
				$this->setZipListCurrent( self::zip_list_la );
				break;
			case "lap":
				$this->setFlagToAllFlags(ZIP_LIST_LAP); 
				$this->setZipListCurrent( self::zip_list_laP );
				break;
			case "lax":
				$this->setFlagToAllFlags(ZIP_LIST_LAX);
				$this->setZipListCurrent( self::zip_list_lax );
				break;
			case "ontario":
				$this->setFlagToAllFlags(ZIP_LIST_ONT);
				$this->setZipListCurrent( self::zip_list_ont );
				break;
			case "or":
				$this->setFlagToAllFlags(ZIP_LIST_OR);
				$this->setZipListCurrent( self::zip_list_or );
				break;
			case "oxnard":
				$this->setFlagToAllFlags(ZIP_LIST_OX); 
				$this->setZipListCurrent( self::zip_list_ox );
				break;
			case "pc":
				$this->setFlagToAllFlags(ZIP_LIST_PC);
				$this->setZipListCurrent( self::zip_list_pc );
				break;
			case "sfs":
				$this->setFlagToAllFlags(ZIP_LIST_SFS); 
				$this->setZipListCurrent( self::zip_list_sfs );
				break;
			case "wc":
				$this->setFlagToAllFlags(ZIP_LIST_WC); 
				$this->setZipListCurrent( self::zip_list_wc );
				break;
			case "all":
				$this->setFlagToAllFlags(ZIP_LIST_ALL); 
				$this->setZipListCurrent( self::zip_list_la . ', ' . self::zip_list_laP . ', ' . self::zip_list_lax . ', ' . self::zip_list_ont . ', ' . self::zip_list_or . ', ' . self::zip_list_ox . ', ' . self::zip_list_pc . ', ' . self::zip_list_sfs . ', ' . self::zip_list_wc );
				break;
			default:
				$this->setFlagToAllFlags(ZIP_LIST_SKIP);
		}

		// map agency
		switch ($flags_array['algorithm'])
		{
			case "lapd":
				$this->setFlagToAllFlags(AGENCY_LAPD); 
				break;
			case "vcsd":
				$this->setFlagToAllFlags(AGENCY_VCSD); 
				break;
			case "sbcsd":
				$this->setFlagToAllFlags(AGENCY_SBSD); 
				break;
			case "lasd":
				$this->setFlagToAllFlags(AGENCY_LASD); 
				break;
			case "ocsd":
				$this->setFlagToAllFlags(AGENCY_OCSD); 
				break;
			default: break;
		}

		// map other flags
		if( $flags_array['results_only']) $this->setFlagToAllFlags(OTHER_RESULT_ONLY);
		if( $flags_array['all_short']) $this->setFlagToAllFlags(OTHER_SHORT_RESULT);
		if( $flags_array['all_full']) $this->setFlagToAllFlags(OTHER_FULL_RESULT);
		if( $flags_array['matched_full']) $this->setFlagToAllFlags(OTHER_MATCHED_FULL_RESULT);
	}
}

require_once 'VGeoGoogleYahoo.php';

class CrimeList extends CrimeListFlag
{
	

	
	
	// var  $result, $record, $record_plus, $result_string, $zip_list, $crime_list, $skip_zips;
	

	private $VGeoZIP = null;
	
	
	
	function __construct()
	{
		$this->VGeoZIP = new VGeoGoogleYahoo();
		parent::__construct();
	}
	
	function findCrimeListByType()
	{
		return  $this->getCrimeListCurrent();
	}

	
	
	function sortingLAPD( $content )
	{
		
		require_once 'VGeoGoogleYahoo.php';
		// Break down the input data into an array and find out the total number of entries
		$array_content 	= explode("\r\n", stripslashes(trim($content)));
		$num_lines 		= sizeof($array_content);
		
		// filters
		$zip_list 		= $this->getZipListCurrent();
		
		// Start filtering
		for ($i=0, $j=0; $i<$num_lines; $i++) 
		{
			$record_plus 					= null;
			
			$record_plus['matched']			= parent::record_not_matched;
			$record_plus['charges'] 		= preg_replace('/\s+/',' ', trim(substr($array_content[$i], 329, 558)));
			$record_plus['crime']			= $this->isCrimeInCrimeList( $record_plus['charges'] ) ;
			
			// check crime code match
			
			if( $record_plus['crime'] == "" )
			{
				if( $this->isMatchAnyFlagSet()  &&  !($this->isAllRecordsAnyFlagSet()) )continue;
			}
			else
				$record_plus['matched']			|= parent::record_matched_crime;
										
			$record_plus['street_address'] 	= ucwords(preg_replace('/\s+/',' ', trim(substr($array_content[$i], 249, 30))));
			$record_plus['city'] 			= ucwords(trim(substr($array_content[$i], 279, 16)));
			$record_plus['state'] 			= ucwords(trim(substr($array_content[$i], 295, 2)));				
			$record_plus['zip'] 			= $this->VGeoZIP->getZIP( str_replace(" ", "+", preg_replace('/\s+/',' ', trim(substr($array_content[$i], 249, 24))) . "+" .  $record_plus['city'] . "+" .  $record_plus['state']   )   ) ;			
			
			// check ZIP code match
			if ( !$this->isSetSkipZip()  &&  !in_array( substr( $record_plus['zip'], 0, 5) , $zip_list )  )
			{
				if( $this->isMatchAnyFlagSet() &&  !($this->isAllRecordsAnyFlagSet()) )continue;		
			}
			else
				$record_plus['matched']			|= parent::record_matched_zip;
			
			$record_plus['first_name']		= ucwords(trim(substr($array_content[$i], 104, 12)));
			$record_plus['last_name'] 		= ucwords(trim(substr($array_content[$i], 89, 15)));
			$record_plus['middle_name'] 	= ucwords(trim(substr($array_content[$i], 116, 13)));
			$record_plus['gender'] 			= trim(substr($array_content[$i], 169, 1));
			$record_plus['race'] 			= trim(substr($array_content[$i], 171, 1));
			$record_plus['arrest_agency'] 	= "LAPD";
			$record_plus['arrest_date'] 	= trim(substr($array_content[$i], 969, 16));

			$this->full_matched_records[$j++]= $record_plus;			
		}
	}
	
	
	
	function sortingVCSD( $content )
	{
		
		require_once 'VGeoGoogleYahoo.php';
		
		$dom = new DOMDocument();
		$res = $dom->loadXML(stripslashes(trim( $content )));
		if($res)
		{
			$bookings = $dom->getElementsByTagName('BOOKING');
			
			$zip_list 		= $this->getZipListCurrent();
			
			$j=0;
			foreach($bookings as $booking)
			{
				$record_plus 					= null;				
				$record_plus['matched']			= parent::record_not_matched;
				
				$crime_code = "";
				$full_name = $booking->getElementsByTagName('NAME')->item(0)->nodeValue;
				$full_name = explode(' ', $full_name);
					
				$charges = $booking->getElementsByTagName('CHARGE');
				foreach($charges as $charge) 
				{
					$crime_code .= $charge->getElementsByTagName('CODE')->item(0)->nodeValue . "; "  ;
				}
				 
				$record_plus['charges'] 		= substr($crime_code, 0, -2);
				$record_plus['crime']			= $this->isCrimeInCrimeList( $record_plus['charges'] ) ;
				
				// check CRIME list match
				if( $record_plus['crime'] == "" )
				{
					if( $this->isMatchAnyFlagSet()  &&  !($this->isAllRecordsAnyFlagSet()) )continue;
				}
				else
					$record_plus['matched']			|= parent::record_matched_crime;
				 
					
				// Critical Info
				$record_plus['first_name'] 		= ucwords($full_name[0]);
				$record_plus['last_name'] 		= ucwords($full_name[2]);
				$record_plus['middle_name'] 	= ucwords($full_name[1]);
				$record_plus['street_address'] 	= ucwords($booking->getElementsByTagName('STREET')->item(0)->nodeValue);
				$record_plus['city'] 			= ucwords($booking->getElementsByTagName('CITY')->item(0)->nodeValue);
				$record_plus['state'] 			= ucwords($booking->getElementsByTagName('ST')->item(0)->nodeValue);
					
				if (!$booking->getElementsByTagName('ZIP')->item(0)->nodeValue) 
				{
					$record_plus['zip'] = $this->VGeoZIP->getZIP( str_replace(" ", "+", $record_plus['street_address'] . "+" . $record_plus['city'] . "+" . $record_plus['state']) );
				} 
				else 
				{
					$record_plus['zip'] = $booking->getElementsByTagName('ZIP')->item(0)->nodeValue;
				}
					
				// check ZIP code match
				if ( !$this->isSetSkipZip()  &&  !in_array( substr( $record_plus['zip'], 0, 5) , $zip_list )  )
				{
					if( $this->isMatchAnyFlagSet() &&  !($this->isAllRecordsAnyFlagSet()) )continue;
				}
				else
					$record_plus['matched']			|= parent::record_matched_zip;
								
				
				$record_plus['gender'] 			= $booking->getElementsByTagName('GENDER')->item(0)->nodeValue;
				$record_plus['race'] 			= $booking->getElementsByTagName('RACE')->item(0)->nodeValue;
				$record_plus['arrest_agency'] 	= $booking->getElementsByTagName('AGENCY')->item(0)->nodeValue;
				$record_plus['arrest_date'] 	= $booking->getElementsByTagName('REC_DT')->item(0)->nodeValue . ' ' . $booking->getElementsByTagName('REC_TIME')->item(0)->nodeValue;
	
				$this->full_matched_records[$j++]= $record_plus;

			}
		}
	}
	

	function sortingLASD( $content )
	{
		require_once 'VGeoGoogleYahoo.php';

		// Break down the input data into an array and find out the total number of entries
		$raw_content 	= stripslashes(trim( $content ));
		$raw_needle 	= "\r\n\r\n  \r\n  <center>\r\n  \r\n  \r\n    \r\n	 ";
		$raw_content 	= stripslashes(trim(substr($raw_content, strpos($raw_content, $raw_needle) + 30)));
	
		$raw_needle2 	= "\r\n	  \r\n	  \r\n	\r\n  \r\n  </center>";
		$raw_content 	= stripslashes(trim(substr($raw_content, 0, strpos($raw_content, $raw_needle2))));
		//print_r($raw_content);
		$raw_needle3 	= "      \r\n\r\n      \r\n         \r\n         \r\n      ";
		$array_content 	= explode($raw_needle3, $raw_content);
		$num_lines 		= sizeof($array_content);
	
		
		$zip_list 		= $this->getZipListCurrent();
		// Start filtering
		for ($i=0, $k=0; $i<$num_lines; $i++) 
		{
			$array_content[$i] 				= ucwords(stripslashes(trim($array_content[$i])));
	
			// Break down the input data into an array and find out the total number of entries
			$array_content_inner 			= explode("\r\n", $array_content[$i]);
			
			$record_plus 					= null;
			$record_plus['matched']			= parent::record_not_matched;
			
			
			
			for ($j=0; $j<count($array_content_inner); $j++) 
			{
				// Critical Info
				if (strpos($array_content_inner[$j], "Inmate Name")) 
				{
					$record_plus['first_name'] 			= trim(substr($array_content_inner[$j], 44, 13));
					$record_plus['last_name'] 			= trim(substr($array_content_inner[$j], 27, 15));
					$record_plus['middle_name'] 		= trim(substr($array_content_inner[$j], 57, 9));
				} 
				elseif (strpos($array_content_inner[$j], "Home Address")) 
				{
					$do 								= preg_match("/<b>(.*)<\/b>/", $array_content_inner[$j], $raw_address);
					$raw_address_array 					= explode(", ", $raw_address[1]);
	
					$record_plus['city'] 				= trim($raw_address_array[count($raw_address_array)-2]);
					$record_plus['state'] 				= trim(substr($raw_address_array[count($raw_address_array)-1], 0, 2));
					$record_plus['street_address'] 		= trim(substr($raw_address[1], 0, strpos($raw_address[1], $record_plus['city'])-2));
	
					$record_plus['zip'] 				= trim(substr($raw_address[1], -5));
	
					if ( $record_plus['zip'] == "00000" || $record_plus['zip'] == "") 
					{
						$record_zip_string = $record_plus['street_address'] . "+" . $record_plus['city'] . "+" . $record_plus['state'];
						$record_plus['zip'] = $this->VGeoZIP->getZIP( $record_zip_string );
					}
					
					// check ZIP code match
					if ( !$this->isSetSkipZip()  &&  !in_array( substr( $record_plus['zip'], 0, 5) , $zip_list )  )
					{
						if( $this->isMatchAnyFlagSet() &&  !($this->isAllRecordsAnyFlagSet()) )continue 2;
					}
					else
						$record_plus['matched']			|= parent::record_matched_zip;
	
				} 
				elseif (strpos($array_content_inner[$j], "Arrest Charge")) 
				{
					$do 								= preg_match("/<b>(.*)<\/b>/", $array_content_inner[$j], $raw_charges);
					$record_plus['charges'] 			= trim($raw_charges[1]);
					$record_plus['crime']				= $this->isCrimeInCrimeList( $record_plus['charges'] ) ;
					
					// check CRIME list match
					if( $record_plus['crime'] == "" )
					{
						if( $this->isMatchAnyFlagSet()  &&  !($this->isAllRecordsAnyFlagSet()) )continue 2;
					}
					else
						$record_plus['matched']			|= parent::record_matched_crime;
						

				} 
				elseif (strpos($array_content_inner[$j], "Sex")) 
				{
					$do 								= preg_match("/<b>(.*)<\/b>/", $array_content_inner[$j], $raw_gender);
					$record_plus['gender'] 				= trim($raw_gender[1]);
				} 
				elseif (strpos($array_content_inner[$j], "Race")) 
				{
					$do 								= preg_match("/<b>(.*)<\/b>/", $array_content_inner[$j], $raw_race);
					$record_plus['race'] 				= trim($raw_race[1]);
				} 
				elseif (strpos($array_content_inner[$j], "Arrest Date")) 
				{
					$do 								= preg_match("/<b>(.*)<\/b>/", $array_content_inner[$j], $raw_arrest_date);
					$record_plus['arrest_date'] 		= trim($raw_arrest_date[1]);
				}
			}
			
			$record_plus['arrest_agency'] 			= "LASD";	
			$this->full_matched_records[$k++]		= $record_plus;
		}
	}
	
	
	
	

	function sortingOCSD( $content ) 
	{
		require_once 'VGeoGoogleYahoo.php';
		// Break down the input data into an array and find out the total number of entries
		$array_content 	= explode("\r\n", stripslashes(trim($content)));
		$num_lines 		= sizeof($array_content);
		$zip_list 		= $this->getZipListCurrent();
	
		// Start filtering
		for ($i=0, $j=0; $i<$num_lines; $i++) 
		{
			//$array_content[$i] = ucwords($array_content[$i]);
			$record_content = explode(",", $array_content[$i]);
	
			$record_plus 					= null;
			$record_plus['matched']			= parent::record_not_matched;
				
			$record_plus['charges'] 		= $record_content[13];
			$record_plus['charges_desc'] 	= $record_content[14];
			$record_plus['crime']			= $this->isCrimeInCrimeList( $record_plus['charges'] ) ;
			
			// check crime code match
			if( $record_plus['crime'] == "" )
			{
				if( $this->isMatchAnyFlagSet()  &&  !($this->isAllRecordsAnyFlagSet()) )continue;
			}
			else
				$record_plus['matched']			|= parent::record_matched_crime;
			
			$record_plus['street_address'] 	= $record_content[4];
			$record_plus['city'] 			= $record_content[5];
			$record_plus['state'] 			= $record_content[6];
			$record_plus['zip'] 			= $record_content[7];
	
			if(empty($record_plus['zip']) || ctype_space($record_plus['zip'])) 
			{
				$record_zip_string 			= str_replace(" ", "+", $record_plus['street_address'] . "+" . $record_plus['city'] . "+" . $record_plus['state']);
				$record_plus['zip'] 		= $this->VGeoZIP->getZIP( $record_zip_string );
			}
			
			// check ZIP code match
			if ( !$this->isSetSkipZip()  &&  !in_array( substr( $record_plus['zip'], 0, 5) , $zip_list )  )
			{
				if( $this->isMatchAnyFlagSet() &&  !($this->isAllRecordsAnyFlagSet()) )continue;
			}
			else
				$record_plus['matched']			|= parent::record_matched_zip;
			
			$record_plus['first_name'] 		= $record_content[2];
			$record_plus['last_name'] 		= $record_content[1];
			$record_plus['middle_name'] 	= $record_content[3];
			
			$record_plus['gender'] 			= $record_content[9];
			$record_plus['race'] 			= $record_content[8];
			$record_plus['arrest_agency'] 	= $record_content[11];
			$record_plus['arrest_date'] 	= $record_content[12];
	
			$this->full_matched_records[$k++]= $record_plus;
		}
	}
	
	
	
	function sorting_sbcsd( $content ) {
		
		$pdf = Z;
		
		// Break down the input data into an array and find out the total number of entries
		$array_content = explode("\r\n\r\n", stripslashes(trim($content )));
		$num_lines = sizeof($array_content);
		print_r($array_content);
		// Start filtering
		for ($i=0; $i<$num_lines; $i++) {
			$array_content[$i] = ucwords($array_content[$i]);
	
			// Critical Info
			$record_plus['first_name'] = trim(substr($array_content[$i], 27, 10));
			$record_plus['last_name'] = trim(substr($array_content[$i], 11, 16));
			$record_plus['middle_name'] = trim(substr($array_content[$i], 37, 10));
			/*		$record[$i]['street_address'] = preg_replace('/\s+/',' ', trim(substr($array_content[$i], 249, 30)));
			 $record[$i]['city'] = trim(substr($array_content[$i], 279, 16));
			$record[$i]['state'] = trim(substr($array_content[$i], 295, 2));
	
			$record_zip_string = str_replace(" ", "+", preg_replace('/\s+/',' ', trim(substr($array_content[$i], 249, 24))) . "+" . $record[$i]['city'] . "+" . $record[$i]['state']);
			$record_zip = zip_code_from_address_yahoo($record_zip_string);
			if (!$record_zip) $record_zip = zip_code_from_address_google($record_zip_string);
			$record[$i]['zip'] = $record_zip;
	
			$record[$i]['charges'] = preg_replace('/\s+/',' ', trim(substr($array_content[$i], 329, 558)));
	
			// Additional Info
			$record_plus[$i]['first_name'] = $record[$i]['first_name'];
			$record_plus[$i]['last_name'] = $record[$i]['last_name'];
			$record_plus[$i]['middle_name'] = $record[$i]['middle_name'];
			$record_plus[$i]['street_address'] = $record[$i]['street_address'];
			$record_plus[$i]['city'] = $record[$i]['city'];
			$record_plus[$i]['state'] = $record[$i]['state'];
			$record_plus[$i]['zip'] = $record[$i]['zip'];
			$record_plus[$i]['charges'] = $record[$i]['charges'];
			$record_plus[$i]['gender'] = trim(substr($array_content[$i], 169, 1));
			$record_plus[$i]['race'] = trim(substr($array_content[$i], 171, 1));
			$record_plus[$i]['arrest_agency'] = "SBCSD";
			$record_plus[$i]['arrest_date'] = trim(substr($array_content[$i], 969, 16));
	
			$zip_code = substr($record[$i]['zip'], 0, 5);
			if ($skip_zips || is_integer(strpos($zip_list, $zip_code))) {
			foreach ($crime_list as $crime) {
			if (is_integer(strpos(strtolower($record[$i]['charges']), $crime))) {
			$result[$i] = $record[$i];
			$result_string .= $record[$i]['first_name'] . ',' . $record[$i]['last_name'] . ',' . $record[$i]['street_address'] . ',' . $record[$i]['city'] . ',' . $record[$i]['state'] . ',' . $record[$i]['zip'] . ',' . $crime . "\n";
			break;
			}
			}
			} */
		}
	}
	
	
	
	
	
	
}

?>
