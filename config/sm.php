<?php
require '../../vendors/autoload.php';
// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.titan.email', 465, 'ssl'))
  ->setUsername("admin@hiousapp.com")
  ->setPassword("Hiousapp2022.");

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendRegEmail($userEmail,$fname,$lname)
{
  $subject='Welcome to El-Chari';
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Welcome to El-Chari</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background:#000080;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
      <div style="width:80%;">
      <img src="" style="height:20%;width:80%;">
   </div>
        
        <p>Dear  '.$fname.' '.$lname.' ,</p>
       <p> Welcome to the family. You’re all set!</p>
        <p>Now you can sit back and watch your money grow once you invest with us and learn to make money and generate your trading signals by yourself when you signup to our academy.</p>
        <p>We’ll keep you updated with investment tips, news, and special offers.</p>
        <h3>ANNOUNCEMENT</h3>
        <p>
        Please note, El-Chari Limited does not have any official whatsapp group. All company news and information will be communicated via our email and website.
      </p>
        <p>Best Regards,</p>
        <p>EL-Chari Management</p>
        <p>
        <a href="http://elchariltd.com/login.php">Log In</a>
        </p>
        
      </div>
    </body>
    </html>';


    // Create a message
    $message = (new Swift_Message($subject))
        ->setFrom('admin@hiousapp.com')
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
      return true;
  } else {
      return false;
  }
}

function sendResetEmail($userEmail,$encrypted)
{
  $subject='Password Reset Code ';
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Password Reset Code</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background:#000080;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <div style="width:80%;">
           <img src="" style="height:20%;width:80%;">
        </div>
        <p>Please use the code  below to reset your password</p>
        <p>please if you did not request for this code kindly ignore </p>
        <h2>'.$encrypted.'</h2>
      </div>
    </body>

    </html>';


    // Create a message
    $message = (new Swift_Message($subject))
        ->setFrom('admin@hiousapp.com')
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
      return true;
  } else {
      return false;
  }
}

function sendVerificationEmail($userEmail, $token)
{
    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Verification Link </title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background:#000080;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
      <div style="width:80%;">
      <img src="" style="height:20%;width:80%;">
   </div>
        <p>Thank you for signing up on our site. Please this is your verification code</p>
        <h3>' . $token . '<h3>
      </div>
    </body>

    </html>';

    // Create a message
    $message = (new Swift_Message('Verify your email'))
        ->setFrom("admin@hiousapp.com")
        ->setTo($userEmail)
        ->setBody($body, 'text/html');

    // Send the message
    $result = $mailer->send($message);

    if ($result > 0) {
        return true;
    } else {
        return false;
    }
}
















