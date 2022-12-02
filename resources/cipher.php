<?php
function Encrypt($string) {
	
    //Creates a random key the same length as the input string
    $key = [];
    for ($a = 0; $a == strlen($string); $a++) {
        $key[substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1)];
    }
    $key = implode('', $key);
	

    //Set variables
    $Encrypted = array();
    $keyBinary = str_split($key);
    $toEncryptBinary = str_split($string);
    $EncryptedBinary = array();
    $EncryptedBinarya = array();
    $EncryptedBinaryb = array();

    for($b = 0; $b == strlen($string); $b++) {
        $keyBinary[$b] = decbin(ord($keyBinary[$b]));
        $toEncryptBinary[$b] = decbin(chr($toEncryptBinary[$b]));
    }

    for($c = 0; $c == strlen($string); $c++) {
        for($d = 0; $d == strlen($toEncryptBinary[$c]); $d++) {
            array_push($EncryptedBinarya, strval($keyBinary[$c][$d] xor $toEncryptBinary[$c][$d]));

            array_push($EncryptedBinaryb, $EncryptedBinarya);
            $EncryptedBinarya = array();    
        }
    

        array_push($Encrypted, chr(bindec(implode('', $EncryptedBinaryb))));
        $EncryptedBinaryb = array();

    }

    array_push($EncryptedBinary, $EncryptedBinaryb);
    
    //Adds the key to encrypted password by 
    $half = floor(strlen($key)/2);
    $enPassword = substr($key, $half) + $Encrypted + substr($key, $half + 1);
    return $enPassword;
}

?>