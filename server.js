'use strict'

const fs = require('fs')
const wa = require('./server/router/model/whatsapp')

require('dotenv').config()
const lib = require('./server/lib')
global.log = lib.log

/**
 * EXPRESS FOR ROUTING
 */
const express = require('express')
const app = express()
const http = require('http')
const server = http.createServer(app)

/**
 * SOCKET.IO
 */
const {Server} = require('socket.io');
const io = new Server(server)
const port = process.env.PORT_NODE
// const io = require('socket.io')(server, {
//     cors: {
//         origin: process.env.ORIGIN
//     }
// });
// middleware
app.use((req, res, next) => {
    res.set('Cache-Control', 'no-store')
    req.io = io
    // res.set('Cache-Control', 'no-store')
    next()
})


/**
 * PARSER
 */
// body parser
const bodyParser = require('body-parser')
const { dbQuery } = require('./server/database')
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: false }))
// parse application/json
app.use(bodyParser.json())

app.use(express.static('src/public'))
app.use(require('./server/router'))


// console.log(process.argv)

io.on('connection', (socket) => {
  socket.on('StartConnection', (data) => {
        wa.connectToWhatsApp(data,io)
  })
    socket.on('LogoutDevice', (device) => {
       wa.deleteCredentials(device,io)
    })
})
server.listen(port, log.info(`Server run and listening port: ${port}`))

