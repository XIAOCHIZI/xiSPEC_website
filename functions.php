<?php

function get_link_sites($pep, $pep_index){
	$linkSitesArr = array();

	$pep_nomods = preg_replace ( '/[a-z]+/' , '' , $pep);	
	preg_match_all( "/#[0-9]?/" , $pep_nomods, $matches, PREG_OFFSET_CAPTURE);

	foreach ($matches[0] as $matchgroup) {
		//extract cl number
		$cl_index = (preg_match("/[0-9]+/", $matchgroup[0], $match) != 0) ? $match : 0;

		array_push($linkSitesArr, array('id' => $cl_index, 'peptideId' => $pep_index, 'linkSite' => $matchgroup[1]-1));
	}	

	return $linkSitesArr;
}

function pep_to_array($pep){
	$mods = array();
	$pep = preg_replace( '/#[0-9]?/' , '' , $pep);	
	$pep_nomods = str_split(preg_replace ( '/[a-z]+/' , '' , $pep));
	$pep_array = array();

	foreach ($pep_nomods as $letter) {
		array_push($pep_array, array('aminoAcid' => $letter, 'Modification' => ''));
	}

	preg_match_all('/[a-z]+/', $pep, $matches, PREG_OFFSET_CAPTURE);

	$offset = 1;
	foreach ($matches[0] as $matchgroup) {
		$pep_array[$matchgroup[1] - $offset]['Modification'] = $matchgroup[0];
		$offset += strlen($matchgroup[0]);
	}
	return array('sequence' => $pep_array);
}

?>