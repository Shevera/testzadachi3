<?php

function checkPostParams(array $postData){

    //Создаем массив с результирующими значениями
    $result = [];

    //инициализация переменных
    $userName       = isset($postData[userName])    ? $postData[userName]     : null;
    $email          = isset($postData[email])       ? $postData[email]        : null;
    $text           = isset($postData[text])        ? $postData[text]         : null;
    $captcha        = isset($postData[captcha])     ? $postData[captcha]      : null;
    $homepage       = isset($postData[homepage])    ? $postData[homepage]     : null;
    $user_ip        = isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR'] : null;
    $user_browser   = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null ;
    $created_data   = date('Y:m:d H:m:s');

    //Защита от плохишей
    //обрезаем пробелы,перекодируем в html, экранируем спец символы
    $userName= trim(htmlspecialchars(mysql_real_escape_string($userName)));
    $email= trim(htmlspecialchars(mysql_real_escape_string($email)));
    $text= trim(htmlspecialchars(mysql_real_escape_string($text)));
    $homepage= trim(htmlspecialchars(mysql_real_escape_string($homepage)));

    //проверяем капчу
       if(checkCaptcha($captcha)){
           insertNewPost($userName, $email, $text, $homepage, $user_ip, $user_browser, $created_data);
    }


}

//проверяем или капча введена правильно
function checkCaptcha($captcha){

    $captchaServer = "somedata";

    if($captcha === $captchaServer)
        return true;
    return false;
}

function insertNewPost($userName, $email, $text, $homepage, $user_ip, $user_browser, $created_data){

    include_once 'database/insertNewPost.php';

   }



function getPostFromDb(){

}

//Гостевая книга предоставляет возможность пользователям сайта оставлять сообщения на сайте.
// Все данные введенные пользователем сохраняются в БД MySQL,
// так же в базе данных сохраняются данные о IP пользователя и его браузере.
//Форма добавления записи в гостевую книгу должна иметь следующие поля:

//User Name (цифры и буквы латинского алфавита) – обязательное поле
//E-mail (формат email) – обязательное поле
//Homepage (формат url) – необязательное поле
//CAPTCHA (цифры и буквы латинского алфавита) – изображение и обязательное
// поле (http://ru.wikipedia.org/wiki/CAPTCHA)
//Text (непосредственно сам текст сообщения, HTML тэги недопустимы) – обязательное поле

$json = '{"userName":"Andre",
            "email":"screppi@gmail.com",
            "homepage":"http://workhard.com",
            "captcha":true,
            "text":";lsdkc;lk;dlkf;sldkfs;ld213413414:"}';