(function() {
    var dropzone = document.getElementById("dropzone");
    dropzone.ondrop = function(e) {
		e.preventDefault();
		upload(e.dataTransfer.files);
    };
    var upload = function(files) {
		var formData = new FormData(),
		xhr = new XMLHttpRequest(),
		x;
		for(x = 0; x < files.length; x++) {
			formData.append('file[]', files[x]);
		}

		xhr.open('post', 'upload.php');
		xhr.send(formData);
		document.getElementById("body").style = "border: 0px #00ff00 solid; transition: 350ms;";
		xhr.onload = xhr.onerror = function() {
			if (this.status == 200) {
				document.location.href = "https://disk.cnsls.ru";
			} else {
				log("error " + this.status);
			}
		};
			
		
    };
    dropzone.ondragover = function() {
		document.getElementById("body").style = "border: 10px #00ff00 solid; transition: 350ms;";	
		return false;
    };
    dropzone.ondragleave = function() {
		document.getElementById("body").style = "border: 0px #00ff00 solid; transition: 350ms;";
		return false;
    };
   }());