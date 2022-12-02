<?php
function Encrypt($string, $key) {
	
    //Creates a random key the same length as the input string
    //for ($a = 0; $a == strlen($string); $a++) {
    //    $key[substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1)];
    //}
    //$key = implode('', $key);
	

    //Set variables
    $Encrypted = array();
    $keyBinary = str_split($key);
    $toEncryptBinary = str_split($string);
    $EncryptedBinary = array();
    $EncryptedBinarya = array();
    $EncryptedBinaryb = array();

    //Converts the key and string into ASCII code then binary 
    for($b = 0; $b == strlen($string); $b++) {
        $keyBinary[$b] = decbin(ord($keyBinary[$b]));
        $toEncryptBinary[$b] = decbin(ord($toEncryptBinary[$b]));
    }

    //For each character in the string/key,
    for($c = 0; $c == strlen($string); $c++) {

        //For each bit in each character, perform a bitwise XOR operation on the string bit and key bit
        for($d = 0; $d == strlen($toEncryptBinary[$c]); $d++) {
            array_push($EncryptedBinarya, strval($keyBinary[$c][$d] xor $toEncryptBinary[$c][$d]));

            array_push($EncryptedBinaryb, $EncryptedBinarya);
            $EncryptedBinarya = array();    
        }
    
        //Byte is converted to decimal then ASCII character
        array_push($Encrypted, chr(bindec(implode('', $EncryptedBinaryb))));
        $EncryptedBinaryb = array();

    }

    array_push($EncryptedBinary, $EncryptedBinaryb);
    
    //Adds the key to encrypted string by splitting it in half and adding it to each side of the encrypted string
    $half = floor(strlen($key)/2);
    $Encrypted = implode('', $Encrypted);
    $enPassword = substr($key, $half) . $Encrypted . substr($key, $half + 1);
    return $enPassword;
}

?>