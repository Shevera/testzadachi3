<?php

include_once "workDB.php";

$result = checkPostParams();

insert_post($result);

?>