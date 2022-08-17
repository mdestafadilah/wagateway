const { startCon } = require('./server/WaConnection')
const http = require('http');
const express = require('express');
const app = express();
const server = http.createServer(app);
const router = express.Router();
const { Server } = require('socket.io');
const io = new Server(server);
app.use(express.json());
app.use(express.urlencoded({ extended: true, limit: '50mb', parameterLimit: 1000000 }))
app.use(router);
require('./server/Routes')(router)

// Copyright By Ilman Sunanuddin, M pedia
// Email : Ilmansunannudin2@gmail.com / admin@m-pedia.my.id
// Whatsap : 6282298859671
// ------------------------------------------------------------------
// Dilarang share atau menjual belikan source code ini tanpa izin ya bos! biar berkah hehe

io.on('connection', (socket) => {
    socket.on('StartConnection', async (device) => {
        startCon(device, socket)
        return;
    })
    socket.on('LogoutDevice', (device) => {
        startCon(device, socket, true)
        return
    })
})
server.listen(process.env.PORT_NODE, () => {
    console.log(`Server running on port ${process.env.PORT_NODE}`);
})



