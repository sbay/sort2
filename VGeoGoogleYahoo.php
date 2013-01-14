<?php 
class VGeoGoogleYahoo
{
	
	function getZIP( $record_zip_string )
	{
		$record_zip = $this->zip_code_from_address_yahoo($record_zip_string);
		if (!$record_zip ) 
			$record_zip = $this->zip_code_from_address_google($record_zip_string);
		
		return $record_zip;
	}
	
	// YAHOO ZIP API
	function zip_code_from_address_yahoo($address) 
	{
		$ura = rawurlencode($address);
		$rurl = "http://where.yahooapis.com/geocode?q=$ura";
	
		$dom = new DOMDocument();
		$res = $dom->loadXML(file_get_contents($rurl));
		if($res) {
			$found = $dom->getElementsByTagName('Found')->item(0)->nodeValue;
			$error = $dom->getElementsByTagName('Error')->item(0)->nodeValue;
			//echo "$found - $error\n\n";
			if($found > 0 && $error == 0) {
				$result = $dom->getElementsByTagName('Result')->item(0);
				$postalcode = $result->getElementsByTagName('postal')->item(0)->nodeValue;
				return $postalcode;
			}
		}
		return false;
	}
	
	
	// GOOGLE ZIP API
	/**
	 * Uses Google Maps Geocoder (V3) to get postal code for an address.  Uses first address match.
	 * @param String Address - Make sure to include at least the street address, city and state.
	 * @return String - Zip code on success, blank if a zip code is failed to be retrieved.
	 */
	function zip_code_from_address_google($address)
	{
		$ura = rawurlencode($address);
		$rurl = "http://maps.googleapis.com/maps/api/geocode/xml?sensor=false&address=$ura";
		echo "<!-- $rurl -->\n";
		$dom = new DOMDocument();
		$res = $dom->loadXML(file_get_contents($rurl));
		if($res){
		if($status = $dom->getElementsByTagName('status')->item(0)){
		if($status->nodeValue == 'OK'){
		//If status is OK, then at least one result should be here.
			$result = $dom->getElementsByTagName('result')->item(0);
			$postalcode = '';
			foreach($result->getElementsByTagName('address_component') as $comp){
			if($comp->getElementsByTagName('type')->item(0)->nodeValue == 'postal_code'){
			$postalcode = $comp->getElementsByTagName('short_name')->item(0)->nodeValue;
			}
			}
				return $postalcode;
			}else{
			return '';
			}
			}
			}
			else
			{
			return '';
			}
	}
}

?>