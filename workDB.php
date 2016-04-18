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
           $result =    ['message' => 'error in check function',
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

function checkFile(){
//    name=uploadfile для файл
// http://php.spb.ru/php/image.html - запись картинок и текста в базу почитать

// Каталог, в который мы будем принимать файл:
    $uploaddir = './files/';
    $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
// Массив с правильными форматами
    $mimeFormat = array('image/gif','image/jpeg', 'image/pjpeg', 'text/html');
    $flag = true;

//путь к временному файлу
    $uploadfileTemp =  $_FILES['uploadfile']['tmp_name'];

//Размер загруженого файла не больше 500 кб (0,5 мб)
    if($flag){
        $fileSize = filesize($uploadfileTemp);
        if($fileSize > 500000){
            echo 'Размер не правильный';
            $flag = false;
        }
    }


//Проверяем или формат принятого файла соответствует заданным форматам
    if($flag){

        //создаем мимо переменные
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $formatFile = finfo_file($finfo, $uploadfileTemp);
        finfo_close($finfo);

        foreach ($mimeFormat as $mime){
            if($mime === $formatFile){
                $flag = true;
                break;
            }else{
                $flag = false ;
            }
        }
    }


    // Копируем файл из каталога для временного хранения файлов:
    if ($flag && (copy($_FILES['uploadfile']['tmp_name'], $uploadfile)))
    {
        echo "<h3>Файл успешно загружен на сервер</h3>";
        return true;
    }else{
        echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>";
        return false;
    }


// Выводим информацию о загруженном файле:
    echo "<h3>Информация о загруженном на сервер файле: </h3>";
    echo "<p><b>Оригинальное имя загруженного файла: ".$_FILES['uploadfile']['name']."</b></p>";
    echo "<p><b>Mime-тип загруженного файла: ".$_FILES['uploadfile']['type']."</b></p>";
    echo "<p><b>Размер загруженного файла в байтах: ".$_FILES['uploadfile']['size']."</b></p>";
    echo "<p><b>Временное имя файла: ".$_FILES['uploadfile']['tmp_name']."</b></p>";
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

//получаем количество записей в таблице
function get_number_rows(){
    $mysqli= connect_db();
    $sql = "SELECT * FROM post";
    $res = $mysqli->query($sql)->num_rows;
    return $res;
}



//функция отдать данные сортированные по user name, e-mail, data-create
//ASC DESC
function get_content($tableColumn, $sort){
    //к-ство записей на странице
    $per_page=3;

    //получаем номер страницы
    $page = isset($_GET['page']) ? ($_GET['page']-1) : 0;
    //вичисляем первый оператор для LIMIT
    $start=abs($page*$per_page);



    $mysqli= connect_db();
    $sql = "SELECT * FROM post ORDER BY {$tableColumn} {$sort} LIMIT {$start},{$per_page}";
    $res = $mysqli->query($sql);

        //определяем количество записей в таблице всего
        $total_rows = get_number_rows();


        //рассчитаем сколько всего получается страниц
        $num_pages = ceil($total_rows/$per_page);


        if($total_rows){
            $row = $res->fetch_all(MYSQLI_ASSOC);
        }

        // дальше выводим ссылки на страницы:



       // echo 'Запрос не прошел';

    return [
        'row' => $row,
        'per_page'=> $per_page,
        'total_rows'=>$total_rows,
        'num_pages'=>$num_pages,
        'page'=>$page
        ];
}


//Сообщения должны выводится в виде таблицы,
//с возможностью сортировки по следующим
//полям: User Name, e-mail, и дата добавления


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

//--------------------------------------------------------------------------------------------------
//Про вордпрес
// паганіція форма зворотнього звязку, контактні форми

// сторінка (товар - ціна) при клікові на кожен товарі переход на сторінку з товаром.
// а адмінці додавати - фотки ціна опис
// редагування товару
// стандартними функціями добавляти можна поля, але не варто.

// раслітератор, мультиязичність, слайдери, ротатори
// бред крампс
// плагін кешированіє
// модуль - контакт фром сім

// зазвичай пишуться сайт візитка (5 сторінок) і кілька оголошень
//--------------------------------------------------------------------------------------------------