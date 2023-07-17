<?php

require __DIR__ .'/../classes/date.php';

function convert_to_jalali(string $gDate){

    $gDate = explode('-',date('Y-n-j', strtotime($gDate)));
    
    $jDateOBJ = new SDate();
    $jDate = $jDateOBJ -> toShaDate($gDate , '-');
    $jDate = $jDateOBJ -> tr_num($jDate,'fa');
    
    
    return $jDate;
   
}


