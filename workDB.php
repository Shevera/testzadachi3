<?php


function insertNewPost(array $postData){

   if(!checkPostParams(array ($postData))){
      $resData['success'] = 0;
      $resData['message'] = 'Данные не заполнены ';
   }else{




   }


}

/**
 * Проверяем или существуют переменные
 */
function checkPostParams(array $postData){


   if (
       isset ($postData[userName]) &&
       isset($postData[email]) &&
       isset($postData[captcha]) &&
       checkCaptcha(postData[captcha]) == true &&
       isset($postData[text])
      )
   {
      return true;
   }else{
      return false;
   }
}

function checkCaptcha($captcha){

   $captcha2 = "somedata";

if($captcha === $captcha2)
   return true;
   return false;
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