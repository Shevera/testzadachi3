<?php

//Инициализация переменных, проверка на соответствие заданным параметрам
//возвращаем массив с значениями переменных
function checkPostParams(){
    //инициализация переменных
    $name           = isset($_POST['name'])     ? $_POST['name']     : null;
    $email          = isset($_POST['email'])    ? $_POST['email']    : null;
    $message        = isset($_POST['message'])  ? $_POST['message']  : null;
    $myFile         = isset($_FILES['myFile'])  ? $_FILES['myFile']  : null;

    $user_ip        = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    $user_browser   = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    $created_data   = date('Y:m:d H:m:s');

    //Защита от плохишей
    //обрезаем пробелы,перекодируем в html, экранируем спец символы
    $name= trim(htmlspecialchars($name));
    $email= trim(htmlspecialchars($email));
    $message= trim(htmlspecialchars($message));

    //Проверка файла и запись его в переменную
    if(checkFile($myFile)){
        $myFile = checkFile($myFile);
    }else{
        $myFile = null;
    }

    //Создаем массив с значениями переменных
    $result = [
                'name'      => $name,
                'email'     => $email,
                'message'   => $message,
                'myFile'    => $myFile,
                'user_ip'   => $user_ip,
                'user_browser' => $user_browser,
                'created_data' => $created_data


              ];

    return $result;
}

function checkFile($myFile){
    $CorrectType = ['image/gif','image/jpeg', 'image/pjpeg', 'text/html'];
    $flag = false;

    //проверка типа файл
    foreach ($CorrectType as $type){
        if($type === $myFile['myFile']['type']){
            $flag = true;
            break;
        }
    }

    //проверка размера файла не больше 0,5 Mb и корректный тип данных
    if($myFile['myFile']['size'] > 500000 && $flag !== true){
        return $myFile=null;
    }

    //Читаем содержимое файла
    $myFile=file_get_contents($_FILES['myFile']['tmp_name']);
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

function insert_post($result){
    var_dump($result);
     $name           = $result['name'];
     $email          = $result['email'];
     $message        = $result['message'];
     $myFile         = $result['myFile'];
     $user_ip        = $result['user_ip'];
     $user_browser   = $result['user_browser'];
     $created_data   = $result['created_data'];

    $mysqli= connect_db();
    $sql = "INSERT INTO `post` (`id`, `userName`, `email`, `text`,      `user_ip`, `user_browser`, `created_data`, `data`)
                        VALUES (null, '{$name}',   '{$email}', '{$message}', '{$user_ip}', '{$user_browser}', '{$created_data}' , '{$myFile}')";

    /*Debug
    $sql1=" INSERT INTO `post`(`id`, `userName`, `email`, `text`, `user_ip`, `user_browser`, `created_data`, `data`)
    VALUES (NULL,'asdasd', 'screppi@gmail.com', 'ddfhfh', '127.0.0.1', NULL, '2016:04:21 13:04:53', NULL)";

    echo $sql;
    echo "<hr>";
    echo $sql1;

*/
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
    $sql = "SELECT * FROM post
            ORDER BY {$tableColumn} {$sort}
            LIMIT {$start},{$per_page}";
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
