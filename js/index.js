
/*
* Функція відправки даних на сервер в форматі json.
*
* Бібліотеки на основі яких працює: jQuery, plugin jquery-json;
* Алгоритм роботи:
* 1. Формуємо об*єкт JavaScript з даними, які потрібно відправити;
* 2. Конвертуємо об*єкт в формат json, за допомогою функції toJSON();
* 3. Відправляємо запит, в одному із параметрів передаємо стрічку json;
* 4. На стороні сервера читаємо дані в масиві POST;
*
* Інструкції:
* 1. Призначаємо обробник події submit для форми, в даному випадку він повертає
* false, цим самим попереджує відправку форми звичайним способом.
* 2.Дані відправляються ajax запитом, url - скрипт php, type - спосіб передачі
* даних, data - ім*я параметра в якому будуть відправлені дані.
* 3. Приведення до формату JSON, проводиться вище згаданою функцією, перевірити наявність файла - jquery.json.min.js.
* 4. В параметрі success - повинна бути функція яка обробляє отримані дані.
* 5. В результаті ми відправляємо серверу один параметр: data - ім*я параметра;
*
* Недоліки методу:
* 1. Використання сторонніх бібліотек;
* Плюси:
* 1. Зменшення кількості коду на стороні сервера та клієнта;
* 2. Додаткова гнучкість та та функціональність;
*
* Альтернативні методи:
* 1. jQuery serialize(),jQuery serializeArray();
* 2. Звичайним способом у вигляді об*єкта або масиву, через http request;
* */

$( document ).ready(function() {
   $(function(){
	$("#usersForm").submit(function(){
		
		$.ajax({
			url:"../index.php",
			type:"POST",
			dataType:'json',
			data: "jsonData =" + $.toJSON(formData),
			success:function(result){
                document.getElementById('answerServer').innerHTML  = result;
			}
		});

		return false;
	});
});
});

/*Функція забезпечує валідацію наступних полів: ім*я, емейл, повідомлення.
 * Перевірка здійснюється за допомогою регулярних виразів. */

function validateForm() {

    var name = document.forms["usersForm"]["name"].value;
    var message = document.forms["usersForm"]["message"].value;
    var email = document.forms["usersForm"]["email"].value;

    var error = "";

    var nameRegExp = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/i;

    var emailRegExp = /([a-z]+)@([a-z]+)\.([a-z]{2,})/i;

    if (name == null || name == "" || nameRegExp.test(name)==false) {

        document.getElementById('errorName').style.backgroundColor = "red";

        error = "Please enter valid name Bob32";

        document.getElementById("errorName").innerHTML = error;

        document.getElementById('nameId').onclick = function(event){

            document.getElementById("errorName").innerHTML = "";

            document.getElementById('errorName').style.backgroundColor = "#c1e2b3";

        };

        return false;

    }if(email == null || email == "" || emailRegExp.test(email) == false){

        document.getElementById('errorEmail').style.backgroundColor = "red";

        error = "Please enter valid email address";

        document.getElementById("errorEmail").innerHTML = error;

        document.getElementById('emailId').onclick = function(event){

            document.getElementById("errorEmail").innerHTML = "";

            document.getElementById('errorEmail').style.backgroundColor = "#c1e2b3";
        };
        return false;

    }else if(message == false){

        document.getElementById('errorMessage').style.backgroundColor = "red";

         error = "Please enter some text";

        document.getElementById("errorMessage").innerHTML = error;

        document.getElementById('messageId').onclick = function(event){

            document.getElementById("errorMessage").innerHTML = "";

            document.getElementById('errorMessage').style.backgroundColor = "#c1e2b3";
        };
        return false;
    }
}


/*Дана функція виконує перевірку формату, в разі не відповідності, коистувач
* отримує повідомлення, в контексті даної функції викликається функція checkSize(),
 * яка перевяряє доступні розміри файлів, які повинні завантажуватись*/

function checkFormat() {

    var regExp =/\.txt|\.jpeg|\.png|\.gif|\.jpg/ ;

    var fileUpload = document.getElementById('fileId');

    if (regExp.test(fileUpload.value) == false){

            document.getElementById('errorFile').style.backgroundColor = "red";

            var error = "Incorrect, available format (txt, jpeg, gif, png)";

            document.getElementById("errorFile").innerHTML = error;

    }else{
        checkSize(fileUpload);
    }
}

function checkSize(fileUpload) {

     fileUpload = document.getElementById("fileId");

     var response = "";

    var regexImages = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");

    var regexTxT = ".txt";

    if (regexImages.test(fileUpload.value.toLowerCase())) {

        if (typeof (fileUpload.files) != "undefined") {

            //Створюємо новий об*єкт зчитування

            var reader = new FileReader();

            //Читаємо контент Image файлу

            reader.readAsDataURL(fileUpload.files[0]);

            reader.onload = function (e) {

                //Створили новий об*єкт Image

                var image = new Image();

                //повертаємо результат із file reader
                image.src = e.target.result;

                //Валідація на висоту і ширину

                image.onload = function () {

                    var height = this.height;

                    var width = this.width;

                    if (height > 320 || width > 240) {

                        response = "Invalid image size, recommend 240x320!";

                        document.getElementById("errorFile").innerHTML = response;

                        document.getElementById('errorFile').style.backgroundColor = "red";

                        return false;
                    }
                    response = "Image size valid";

                    document.getElementById("errorFile").innerHTML = response;

                    document.getElementById('errorFile').style.backgroundColor = "green";

                    return true;
                };
            }
        } else {
            response = "Does not suport HTML5";

            document.getElementById("errorFile").innerHTML = response;

            return false;
        }
    } else if (fileUpload.value.slice(-4) == regexTxT) {

        var txt = "";

        if ('files' in fileUpload) {

            if (fileUpload.files.length == 0) {

                txt = "Select one or more files.";
            } else {

                for (var i = 0; i < fileUpload.files.length; i++) {

                    txt += "<br><strong>" + (i + 1) + ". file</strong><br>";

                    var file = fileUpload.files[i];

                    if ('name' in file) {

                        txt += "name:" + file.name + "<br>";
                    }
                    if ('size' in file) {

                        txt += "size: " + file.size + " bytes <br>";

                        if (file.size > 100) {

                            response = "Large size of txt, available 100kb";

                            document.getElementById("errorFile").innerHTML = response;

                            document.getElementById('errorFile').style.backgroundColor = "red";

                        }else if(file.size <= 100){

                            response = "Valid size of document txt";

                            document.getElementById('errorFile').style.backgroundColor = "green";

                            document.getElementById("errorFile").innerHTML = response;
                        }
                    }
                }
            }
        }
    }
}

/*Функції які забезпечують роботу Captcha*/

function  refreshCaptcha() {
    var a = Math.ceil(Math.random() * 9)+"";
    var b = Math.ceil(Math.random() * 9)+"";
    var c = Math.ceil(Math.random() * 9)+"";
    var d = Math.ceil(Math.random() * 9)+"";
    var e = Math.ceil(Math.random() * 9)+"";

    var numberCode = a + b + c + d + e;

    document.getElementById('inputCaptcha').value = numberCode;

    document.getElementById('inputCaptcha').style.backgroundColor = random_color();

    var str1 = document.getElementById('resolveCaptcha').value ="";
}
function Captcha(){
    var str = document.getElementById('inputCaptcha').value;

    var str1 = document.getElementById('resolveCaptcha').value;

    var response = "";

    if(str1 === ""){
            response = "Refresh captcha";

            document.getElementById('errorCaptcha').style.backgroundColor = "red";

            document.getElementById("errorCaptcha").innerHTML = response;

            document.getElementById('resolveCaptcha').onclick = function(event){

            document.getElementById("errorCaptcha").innerHTML = "";

            document.getElementById('errorCaptcha').style.backgroundColor = "#c1e2b3";

        };
    }else if(str == str1){
        response = "Valid captcha";

        document.getElementById('errorCaptcha').style.backgroundColor = "green";

        document.getElementById("errorCaptcha").innerHTML = response;

    }else{
             response = "Invalid captcha";

            document.getElementById('errorCaptcha').style.backgroundColor = "red";

            document.getElementById("errorCaptcha").innerHTML = response;

            document.getElementById('resolveCaptcha').onclick = function(event){

            document.getElementById("errorCaptcha").innerHTML = "";

            document.getElementById('errorCaptcha').style.backgroundColor = "#c1e2b3";
        };
    }
}
function random_color() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
}

/*Функція очищує поле завантаження фафлів*/
function cleaner(){
        document.getElementById("errorFile").innerHTML = "";
        document.getElementById('errorFile').style.backgroundColor = "#c1e2b3";
        document.getElementById('fileId').value = "";
}



