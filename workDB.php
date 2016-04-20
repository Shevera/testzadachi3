<?php

//Инициализация переменных, проверка на соответствие заданным параметрам
//возвращаем массив с значениями переменных
function checkPostParams(){
    //инициализация переменных
    $name           = isset($_POST['name'])     ? $_POST['name']     : null;
    $email          = isset($_POST['email'])    ? $_POST['email']    : null;
    $message        = isset($_POST['message'])  ? $_POST['message']  : null;
    $myFile         = isset($_FILES['myFile'])  ? $_FILES['myFile']  : null;

    //Защита от плохишей
    //обрезаем пробелы,перекодируем в html, экранируем спец символы
    $name= trim(htmlspecialchars(mysql_real_escape_string($name)));
    $email= trim(htmlspecialchars(mysql_real_escape_string($email)));
    $message= trim(htmlspecialchars(mysql_real_escape_string($message)));

    //Проверка файла и запись его в переменную
    if(checkFile($myFile)){
        $myFile = checkFile($myFile);
    }else{
        $myFile = null;
    }

    //Создаем массив с значениями переменных
    $result[] = [
                'name'      => $name,
                'email'     => $email,
                'message'   => $message,
                'myFile'    => $myFile
              ];

    return $result;
}

function checkFile($myFile){
    $CorrectType = ['image/gif','image/jpeg', 'image/pjpeg', 'text/html'];
    $flag = false;

    //проверка типа файл
    foreach ($CorrectType as $type){
        if($type === $myFile[type]){
            $flag = true;
            break;
        }
    }

    //проверка размера файла не больше 0,5 Mb и корректный тип данных
    if($myFile[size] > 500000 && $flag !== true){
        return $myFile=null;
    }
    //бинарное копирование файла в переменную
    $temp=fopen($_POST['tmp_name'],'rb'); //  открыли файл на чтение
    $myFile = fread($temp,filesize($_POST['name']));//считали файл в переменную
    fclose($temp);//закрыли файл
    //защита переменной от опасных символов
    $myFile=addslashes($myFile);

    return $myFile;
}

// Array ( [name] => testimage.jpg [type] => image/jpeg [tmp_name] => C:\OpenServer\userdata\temp\php696A.tmp [error] => 0 [size] => 41467 )

//проверяем или капча введена правильно
function checkCaptcha($captcha){

    $captchaServer = "somedata";

    if($captcha === $captchaServer)
        return true;
    return false;
}
/*
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
*/

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
        $data = $result[data];

    }else{
        return false;
    }

    $mysqli= connect_db();
    $sql = "INSERT INTO post( 'id', 'userName',     'email',    'text',   'homepage',     'user_ip',  'user_browser',     'created_data', 'data')
                      VALUES (null, '{$userName}', '{$email}', '{$text}', '{$homepage}', '{$user_ip}', '{$user_browser}', '{$created_data}' , '{$data}')";
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

    return [
        'row' => $row,
        'per_page'=> $per_page,
        'total_rows'=>$total_rows,
        'num_pages'=>$num_pages,
        'page'=>$page
        ];
}
