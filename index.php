<?php

include_once "workDB.php";

    $json = '{"userName":"Andre",
            "email":"screppi@gmail.com",
            "homepage":"http://workhard.com",
            "captcha":true,
            "text":";lsdkc;lk;dlkf;sldkfs;ld213413414:"}';

$json_decode = json_decode($json);

//get_number_rows();
var_dump(get_content('email','ASC'));

//echo $json_decode->userName;


//print_r($json_decode);

//User Name (цифры и буквы латинского алфавита) – обязательное поле
//E-mail (формат email) – обязательное поле
//Homepage (формат url) – необязательное поле
//CAPTCHA (цифры и буквы латинского алфавита) – изображение и обязательное поле (http://ru.wikipedia.org/wiki/CAPTCHA)
//Text (непосредственно сам текст сообщения, HTML тэги недопустимы) – обязательное поле