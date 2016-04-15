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

   			alert('Somethink goes wrong!');
   			
   		});

   		
   		request.send(JSON.stringify(formData));

 	}

 		//Доступ до елементів форми

 		var form = document.getElementById("myForm");

 		form.addEventListener("submit", function (event) {

    		event.preventDefault();

    			sendData();
  	
  	});

 });

//Валідація імені, пошти

 function validateForm() {
    var name = document.forms["contact_form"]["name"].value;

    var email = document.forms["contact_form"]["email"].value;

    var message = document.forms["contact_form"]["message"].value;

    var nameRegExp = /^[a-zA-Z0-9]*[a-zA-Z]+[a-zA-Z0-9]*$/i;

    var emailRegExp = /([a-z]+)@([a-z]+)\.([a-z]{2,})/i;

    if (name == null || name == "" || nameRegExp.test(name)==false) {

        alert("Name must be filled out");

        return false;
    }else if(email == null || email == "" || emailRegExp.test(email) == false){

    	alert("Email must be filled out");

        return false;
    }else if(message == null || message == ""){

    	alert("Message must be filled out");

        return false;
    }
}

	// Перевірка допустимих розширень

function checkFormat(fileinput) {

fileinput = document.getElementById("myFile").accept = ".jpeg, .jpg, .gif, .png, .txt" ;

    if (fileinput) 

      alert('Available attachment .jpeg, .jpg, .gif, .png, .txt');
}

//Витягуємо розмір файлів

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


