$(document).ready(function(){

	$('.chatScreenHeader').on('click', function(){

		if ( $('.chatScreen').css('bottom') == '-366px' ) // if its offscreen animate onscreen else animate offscreen 
			screenPosition = '0';
		else
			screenPosition = '-366px';

		$('.chatScreen').animate({"bottom": screenPosition},400);
	});

	var sock = new WebSocket("ws://localhost:5001");
	var username = $('.chatName').val();

	sock.onopen = function (){
		sock.send(JSON.stringify({
			type: 'username',
			data: username
		}));
	}

	sock.onmessage = function(event){
		console.log(event);
		var json = JSON.parse(event.data);

		$('.log').append('<span class = "message">' + json.name + ': ' + json.data + '</span> <br>');
	}

	document.querySelector('.chatSubmit').onclick = function(){
		var message = $('.chatMessage').val();
		//sock.send(message);

		sock.send(JSON.stringify({
			type: 'message',
			data: message
		}));

		$('.log').append('<span class = "message">'  + username + ': ' + message + '</span> <br>').css('color', '#556DAA');
	};
});