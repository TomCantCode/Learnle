<?php
FUNCTION Encrypt(password):
	
    key ← ''
    FOR t ← 0 TO len(password):
   key.APPEND(RANDOM(CHAR))
    ENDFOR	


    Encrypted ← []
    keyBinary ← list(key)
    toEncryptBinary ← list(password)
    EncryptedBinary ← []
    EncryptedBinarya ← []
    EncryptedBinaryb ← []

    FOR k ← 0 TO len(password):
        keyBinary[k] ← BINARY(ASCII(keyBinary[k]))
        toEncryptBinary[k] ← BINARY(ASCII(toEncryptBinary[k]))
    ENDFOR	

    FOR i ← 0 TO len(password):
        FOR j ← 0 TO len(toEncryptBinary[i]):
            EncryptedBinarya.APPEND(
            str(keyBinary[i][j] ^ toEncryptBinary[i][j]))

            EncryptedBinaryb.APPEND(EncryptedBinarya)
            EncryptedBinarya ← []

	  ENDFOR

        Encrypted.APPEND(ASCII(DENARY(''.JOIN(EncryptedBinaryb))))
        EncryptedBinaryb ← []

    ENDFOR

    EncryptedBinary.APPEND(EncryptedBinaryb)
    

    half ← ROUND(len(key)/2)
    enPassword ← key[:half] + Encrypted + key[half + 1:]
    RETURN enPassword

?>