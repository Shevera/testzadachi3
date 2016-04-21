<?php

include_once "workDB.php";

$result = checkPostParams();
insert_post($result);

/*
var_dump($_FILES);
echo "<hr>";
echo ($_FILES['myFile']['name']);
*/