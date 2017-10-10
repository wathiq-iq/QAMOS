var instanse = false;
var mes;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.instanse = true;
}

function updateChat(){
	     $.ajax({
			   type: "POST",
			   url: "chat.php",
			   data: {  
			   			'function': 'update'
						},
			   dataType: "json",
			   success: function(data){
				   $(".chatcontent").empty();
				   $.each(data, function(k, v) {
					   if(v !== false){ 
							$(".chatcontent").append(v + "<br/>");
					   }
						
					});
				   document.getElementById('chatbox').scrollTop = document.getElementById('chatbox').scrollHeight;
			   }
			});
}

function sendChat(message, nickname){       
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "chat.php",
		   data: {  
		   			'function': 'send',
					'message': message,
					'nickname': nickname
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}
