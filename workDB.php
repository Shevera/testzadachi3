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


    //Создаем массив с значениями переменных
    $result = [
                'username'  => $userName,
                'email'     => $email,
                'text'      => $text,
                'homepage'  =>$homepage,
                'user_ip'   => $user_ip,
                'user_browser'=>$user_browser,
                'created_data'=>$created_data
              ];

    //проверяем капчу и возвращаем массив с данными
       if(checkCaptcha($captcha)){
           $result = ['message' => 'all correct in check function',
                       'error' => true ];
           return $result;
    }else{
           $result = ['message' => 'error in check function',
                        'error' => false ];
           return $result;
       }

}

//проверяем или капча введена правильно
function checkCaptcha($captcha){

    $captchaServer = "somedata";

    if($captcha === $captchaServer)
        return true;
    return false;
}

function connect_db(){
    $mysqli = new mysqli('localhost', 'root', '' , 'testzad3');

    if($mysqli->connect_error){
        die('Connect Error: '.$mysqli->connect_error);
    }
    return $mysqli;
}

function select_post(){
    $mysqli= connect_db();
    $sql = "SELECT * FROM post";
    if($res = $mysqli->query($sql)){
        if($res->num_rows > 0){
            $row = $res->fetch_all(MYSQLI_ASSOC);
        }
    }else{
        echo 'Запрос не прошел';
    }
    return $row;
}

function insert_post(array $result){

    if($result[error]){
        $userName = $result[userName];
        $email =    $result[email];
        $text =     $result[text];
        $homepage = $result[homepage];
        $user_ip =  $result[user_ip];
        $user_browser = $result[user_browser];
        $created_data = $result[created_data];

    }else{
        return false;
    }

    $mysqli= connect_db();
    $sql = "INSERT INTO post( 'id', 'userName',     'email',    'text',   'homepage',     'user_ip',  'user_browser',     'created_data')
                      VALUES (null, '{$userName}', '{$email}', '{$text}', '{$homepage}', '{$user_ip}', '{$user_browser}', '{$created_data}')";
    if ($mysqli->query($sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($mysqli);
    }

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