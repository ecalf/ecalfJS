<!DocType html>
<html>
<head>
	<title>ecalfJS</title>
	<script src="http://files.cnblogs.com/ecalf/mobiDebuggerHelper.js"></script>
</head>
<body>
<p>hello world</p>


<div id="page">

<div id="contentHolder">
<div>
<!-- camera--照相机；camcorder--摄像机；microphone--录音 -->
<input id="uploadimg" type="file" accept="image/*" capture="camera" />
</div>

<section class="left">
<h1>Camera and Video Control with HTML5</h1>
    <video id="video" autoplay ></video>
    <button id="btnStop" data-status='1'>stop</button>
    <button id="btn">Take Photo</button><br />    
    <img id="photo" />
    <script>
    document.getElementsByTagName('input')[0].addEventListener('change',function(){
    	var file=this.files[0];
    	var formatDate = function(date){
    		return date.getFullYear()
    		+'-'+(date.getMonth()+1)
    		+'-'+date.getDate()
    		+' '+date.getHours()
    		+':'+date.getMinutes()
    		+':'+date.getSeconds();
    	};
    	var s = 'now:  '+formatDate(new Date())+'<hr />';
    	for(var k in file){
    		if(file.hasOwnProperty(k)&&typeof(k)=='string'){
    			if(k=='lastModifiedDate'){
    				s+= k+':  '+formatDate(file[k])+'<br/>';
    			}else{
    				s+= k+':  '+file[k]+'<br/>';
    			}
    		}
    	
    	}
    	
    	
    	var el = document.createElement('div');
    	
    	el.innerHTML = s;
    	this.parentNode.appendChild(el);
    	
    	/*
    	 var reader = new FileReader(); 
    	 reader.onloadend = function() { 
    		 console.log('reader>>>',this);
    	 };
    	 
    	reader.readAsDataURL(file);
    	*/
    },false);
    
    
    
    
    
        window.addEventListener("DOMContentLoaded", function(){
            var width = 480;
            var photo = document.getElementById("photo");
            var video = document.getElementById("video");
            var canvas = document.createElement("canvas");
            var context = canvas.getContext("2d");                
            var mediaErr = function(error) {
                    console.log("media error: ",error); 
                };
            var mediaConf = {
                        video: true , //开始摄像头
                        audio: false //开启麦克风
                    }; 
           	window.videoStream;
           	
             //stop camera
             document.getElementById('btnStop').addEventListener('click',function(){
            	 if(this.dataset.status==1){
            		 videoStream.stop();
            		 this.dataset.status=0;
            		 this.innerHTML='play';
            	 }else{
            		 openMedia();
            		 this.dataset.status=1;
            		 this.innerHTML='stop';
            	 }
            	 
             });
             
             
             
            //event:take photo
            document.getElementById("btn").addEventListener("click", function(){                
                context.drawImage(video, 0, 0, video.width, video.height);                
                photo.setAttribute('src', canvas.toDataURL('image/png'));                        
            });        
            
            //event: resize video
            video.addEventListener('play', function(ev){
                    setTimeout(function(){                        
                        if(video.videoWidth){
                            height = video.videoHeight/(video.videoWidth/width);
                            video.setAttribute('width', width);
                            video.setAttribute('height', height);
                            canvas.setAttribute('width',width);
                            canvas.setAttribute('height',height);    
                            photo.setAttribute('width', width);
                            photo.setAttribute('height', height);                                                        
                        }else{
                            setTimeout(arguments.callee,100);
                        }
                    },100);
            }, false);
            
            
            // open media
        	function openMedia(){
        	    if(navigator.getUserMedia) { // Standard, opera
                    navigator.getUserMedia(mediaConf, function(stream) {
                    	videoStream = stream;
                        video.src = stream;
                        video.play();
                    }, mediaErr);    
                } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed, chrome
                    navigator.webkitGetUserMedia(mediaConf, function(stream){
                    	videoStream = stream;
                        video.src = window.webkitURL.createObjectURL(stream);
                        video.play();
                    }, mediaErr);
                }else if(navigator.mozGetUserMedia){ // firefox
                    navigator.mozGetUserMedia(mediaConf,function(stream){   
                    	videoStream = stream;
                        video.mozSrcObject = stream;
                        video.play();            
                    },mediaErr);
                    
                }else{
                    console.log('your browser do not support UserMedia API');
                }
            }
        	openMedia();
            
        }, false);

    </script>
        
</section>


</div>


</body>
</html>
