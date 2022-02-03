<?php

function hash_password($pass, $salt)
{
    return hash("sha512", "$pass$salt");
}

function create_salt(int $length = 32)
{
    return bin2hex(random_bytes($length));
}

?>
