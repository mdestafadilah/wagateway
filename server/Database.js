const mysql = require("mysql2");
require('dotenv').config();
const db = mysql.createConnection({
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    charset: 'utf8mb4',
    multipleStatements: true
})


db.connect((err) => {
    if (err) throw err;
    console.log('database terhubung.')
})




module.exports = { db }