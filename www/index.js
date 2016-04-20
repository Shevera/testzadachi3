/* 
Фунція фідправки даних
window.addEventListener - обробник загрузки сторінки
var request = new XMLHttpRequest() - створюємо новий об*єкт, відправка 
даних на сервер без перегрузки сторінки, відправляти можна будь який 
формат не лише XML;	
var FD = new FormData(form)- об*єкт для форми, в якості параметра форма, 
кодує дані для сервера.
function(event){ - функція приймає параметр - об*єкт події
*/

 window.addEventListener("load", function(){ 
 	
 	function sendData(){

   		var request = new XMLHttpRequest(); 
   		var formData = new FormData(form);  

   		request.open("POST", "http://ucommbieber.unl.edu/CORS/cors.php", true);
   		request.setRequestHeader('Content-type', 'application/json; charset=utf-8');
   		
   		//Визначаємо, що відповість сервер в разі успішної загрузки даних

   		request.addEventListener("load", function(event){ 

   			alert(event.target.responseText);

   		});

   		//Визначаємо, що відповість сервер в разі  проблем із загрузкою
   		
   		request.addEventListener("error", function(event){

            var output = event.target.statusText+"Error";   //потім забрати текст

            document.getElementById("forOutput").innerHTML = output;

        });

        var obj = {
            name:formData.get('name'),
            email:formData.get('email'),
            message:formData.get('message'),
            file:formData.get('file')
        };
   		request.send(JSON.stringify(formData));

 	}

 		//Доступ до елементів форми

 		var form = document.getElementById("myForm");

 		form.addEventListener("submit", function (event) {

    		event.preventDefault();

    			sendData();
  	});

 });

//Валідація імені, пошти розкоментовувати не потрібно
/*
 function validateForm() {

     var name = document.forms["contact_form"]["name"].value;

     var email = document.forms["contact_form"]["email"].value;

     var message = document.forms["contact_form"]["message"].value;

     var submit = true;

     var error = "";

     var nameRegExp = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/i;

     var emailRegExp = /([a-z]+)@([a-z]+)\.([a-z]{2,})/i;

    if (name == null || name == "" || nameRegExp.test(name)==false) {

        error = "Please enter right name";

        document.getElementById("errorName").innerHTML = error;

        return false;

    }else if(email == null || email == "" || emailRegExp.test(email) == false){

        error = "Email must be filled out";

        document.getElementById("errorEmail").innerHTML = error;

        return false;

    }else if(message == null || message == ""){


        error = "Message must be filled out";

        document.getElementById("errorMessage").innerHTML = error;

        return false;
    }
}
*/
	// Перевірка допустимих розширень

function checkFormat(formPatern) {

formPatern = document.getElementById("myFile").accept = ".jpeg, .jpg, .gif, .png, .txt" ;

}

//Витягуємо розмір файлів розкоментовувати не потрібно
/*
function checkSize(filesize){

  filesize = document.getElementById("myFile");
 
  var txt = "";

if ('files' in filesize) {

    if (filesize.files.length == 0) {

        txt = "Select one or more files.";
    } else {

         for (var i = 0; i < filesize.files.length; i++) {

            txt += "<br><strong>" + (i+1) + ". file</strong><br>";

            var file = filesize.files[i];

           if ('name' in file) {
                
                  txt +="name:"+file.name+"<br>";

            }if ('size' in file) {
                
                  txt += "size: " + file.size + " bytes <br>";
 
            }
        }
    }
}
document.getElementById ("sizeId").innerHTML = txt;

}
*/

/*
Функція checkSize() - перевіряє доступні розширення картинок та текстових фалів.
Потрібно продумати видалення файлів без перегрузки, та відправку.
*/
function checkSize() {

	//Доступ по ідентифікатору до файлу який загружається

	var fileUpload = document.getElementById("myFile");
	var output = "";
	//Валідація на відповідність

	var regexImages = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");

	var regexTxT = ".txt";

	if (regexImages.test(fileUpload.value.toLowerCase())) {

		//Перевірка на підтримку HTML5

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

						 output = "Invalid image, recomend size 240x320!";

						document.getElementById("forOutputfile").innerHTML = output;

						return false;
					}
					output = "Image is valid!";

					document.getElementById("forOutputfileSucces").innerHTML = output;


					return true;
				};
			}
		} else {
			output = "Does not suport HTML5";

			document.getElementById("forOutputfile").innerHTML = output;

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

							//txt += "size: " + file.size + " bytes <br>";

							//if (file.size > 100) {

								 output = "Large size of txt, recomend != 100kb";

								document.getElementById("forOutputfile").innerHTML = output;

								txt = "";
							//}
						}else if(file.size <= 100){

							output = "Document txt is valid!";

							document.getElementById("forOutputfileSucces").innerHTML = output;
						}
					}
				}
			}
			document.getElementById("sizeId").innerHTML = txt;
		} else {

			output = "Invalid format of file";

			document.getElementById("forOutputfile").innerHTML = output;

			return false;
		}
	}
}