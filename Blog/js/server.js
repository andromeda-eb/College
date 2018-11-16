var server = require('ws').Server;
var s = new server({port: 5001});

s.on('connection', function(ws){ // s contains list of all connected clients

	ws.on('message', function(message){ // ws is particular to client

		message = JSON.parse(message);

		if(message.type == 'username'){
			ws.username = message.data;
			return;
		}

		console.log("Received: " + message);

		s.clients.forEach(function e(client){ // send to each client
			
			if(client != ws) // don't send message back from the client it recieved it from
				client.send(JSON.stringify({
					name: ws.username,
					data: message.data
				}));
		});

		//ws.send(message);
	});

	ws.on('close', function(){
		console.log("I lost a client");
	});

	console.log('one more client connected');
});