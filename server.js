const express = require('express');
const app = express();
const redis = require('redis');

const server = require('http').createServer(app);

const  port = 3000;

const io = require('socket.io')(server,{
    cors:{ origin : "*" }
});
io.on('connection',(socket)=>{
    const redisClient = redis.createClient();
    redisClient.subscribe('message');
    redisClient.on("message", function(channel, data) {
        data = JSON.parse(data);
        console.log(channel);
        console.log("mew message add in queue '"+ data.message + "' channel");
        socket.emit(channel, data);
    });
    socket.on('disconnect', function() {
        redisClient.quit();
    });
    // socket.on('sendMsg',(msg)=>{
    //     io.sockets.emit('sendOnClient',msg);
    // });
    // socket.on('disconnect',(socket)=>{
    //     console.log('disconnect');
    // });
})
server.listen(port, ()=>{
    console.log(`server running at http://localhost:${port}`);
});
