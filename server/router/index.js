'use strict'

const express = require('express')
const router = express.Router()

/**
 * THIS IS MAIN ROUTER
 */
const wa = require('./model/routes')
const store = require('./model/store')
const {initialize} = require('./model/whatsapp')

const CryptoJS = require("crypto-js")
const validation = process.env.AUTH

// sendFile will from here. Delete or comment if no use anymore
router.get('/', (req, res) => {
    const path = require('path')
    res.sendFile(path.join(__dirname, '../../public/index.html'));
})


router.post('/backend-logout', wa.deleteCredentials)
router.post('/backend-generate-qr', wa.createInstance)
router.post('/backend-initialize', initialize)
router.post('/backend-send-list', wa.sendListMessage)
router.post('/backend-send-template', wa.sendTemplateMessage)
router.post('/backend-send-button', wa.sendButtonMessage)
router.post('/backend-send-media', wa.sendMedia)
router.post('/backend-send-text', wa.sendText)
router.post('/backend-getgroups', wa.fetchGroups)
router.post('/backend-blast', wa.blast)

// STORE
//router.post('/backend-store-chats', store.chats)



module.exports = router