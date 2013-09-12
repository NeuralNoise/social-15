$(document).ready(function() {  
    if (!("WebSocket" in window) ) {  
        // $('#chatLog, input, button, #examples').fadeOut("fast");  
        // $('<p>Oh no, you need a browser that supports WebSockets. How about <a href="http://www.google.com/chrome">Google Chrome</a>?</p>').appendTo('#container');  
    } else {  
  
    //The user has WebSockets  
  
    connect();  
  
    function connect(){  
	    try{
		var socket,
			host = "ws://localhost:8000/socket/server/startDaemon.php",
			socket = new WebSocket(host);
			
        socket.onopen = function(e){
            conn.send('192837465username: bubo'); //18
        }  
  
        socket.onmessage = function(msg){
        	
        }  
  
        socket.onclose = function(){  

        }             
	  
	    } catch(e){  
	    	alert('<p>Error' + e); 
	    }  
	}

});  