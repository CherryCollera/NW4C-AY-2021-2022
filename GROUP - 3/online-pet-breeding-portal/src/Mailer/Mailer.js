


// // exports.sendMail = ((req, res) => {


// //     const mailOptions = {
// //         from: 'rolandoallanofficial@gmail.com', // Something like: Jane Doe <janedoe@gmail.com>
// //         to: 'mrahitojr123@gmail.com',
// //         subject: 'I\'M A PICKLE!!!', // email subject
// //         html: `<p style="font-size: 16px;">Pickle Riiiiiiiiiiiiiiiick!!</p>
// //                 <br />
// //                 <img src="https://images.prod.meredith.com/product/fc8754735c8a9b4aebb786278e7265a5/1538025388228/l/rick-and-morty-pickle-rick-sticker" />
// //             ` // email content in HTML
// //     };

// //     // returning result
// //     return 
// // });
// // // // var mail = nodemailer.createTransport({
// // // //     service: 'gmail',
// // // //     auth: {
// // // //         user: 'rqlazo@bpsu.edu.ph',
// // // //         pass: '12-06-1998'
// // // //     }
// // // // });

// // // // var mailOptions = {
// // // //     from: 'rqlazo@bpsu.edu.ph',
// // // //     to: 'rolandoallanofficial@gmail.com',
// // // //     subject: 'Try Email',
// // // //     html: '<p>Good day, please see attached file thank you</p>',
// // // //     // attachments: [{
// // // //     //     filename: d,
// // // //     //     content: e
// // // //     // }]
// // // // }

// // // // export const sendmail = () => {

// // // //     mail.sendMail(mailOptions, function (error, info) {
// // // //         if (error) {
// // // //             console.log(error);
// // // //         } else {
// // // //             console.log('Email sent: ' + info.response);
// // // //         }
// // // //     })
// // // // };



// // // '​use strict​'
// // // //​Dependencies​
// // // const mailer = require('nodemailer');
// // // //​Credentials​
// // // //​Mailing Function​
// // // const mailFunc = (subject, recipient, msg) => {

// // //     //​Create transport + auth​
// // //     let transporter = mailer.createTransport({
// // //         host: "​smtp.gmail.com​",
// // //         port: 587,
// // //         auth: {
// // //             user: 'rqlazo@bpsu.edu.ph',
// // //             pass: '12-06-1998'
// // //         }
// // //     });

// // //     //​Create the message object​
// // //     let message = {
// // //         from: 'rqlazo@bpsu.edu.ph',
// // //         to: recipient,
// // //         subject: subject,
// // //         text: msg,
// // //         //​ html: "<p>HTML version of the message</p>"​
// // //     };

// // //     //​Send mail​
// // //     transporter.sendMail(message)
// // //         .then(res => {
// // //             console.log(res.response);
// // //         })
// // //         .catch(err => {
// // //             console.log(err);
// // //         })
// // // }

// // // //​Export the module​
// // // module.exports = { mailFunc }
// import React, { useRef } from 'react';

// export const ContactUs = () => {
//     const form = useRef();

//     const sendEmail = (e) => {

//     };

//     return (
//         <form ref={form} onSubmit={sendEmail}>
//             {/* <label>Name</label>
//             <input type="text" name="user_name" />
//             <label>Email</label>
//             <input type="email" name="user_email" />
//             <label>Message</label>
//             <textarea name="user_email" /> */}
//             <input type="submit" value="Send" />
//         </form>
//     );
// };