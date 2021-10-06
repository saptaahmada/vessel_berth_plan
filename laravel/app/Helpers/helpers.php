<?php

function safeEncrypt($message, $key)
{
    return openssl_encrypt($message,"AES-128-ECB",$key);
}

function safeDecrypt($encrypted, $key)
{
    return openssl_decrypt($encrypted,"AES-128-ECB", $key);
}