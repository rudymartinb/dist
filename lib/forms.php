<?php

function GenerarInput( $tit, $id, $idclass, $len, $name, $value, $mensa ){
	$txt = "";
	$txt .= '<div class="admitem">'.$tit.':</div>' ;
	$txt .= '<input class="adminput1 '.$idclass.'" type=text value="'.$value.'" id="'.$id.'" name="'.$name.'" maxlength="'.$len.'">' ;
	$txt .= '<div class="admmensa">'.$mensa.'</div>' ;
	return $txt;
}
?>