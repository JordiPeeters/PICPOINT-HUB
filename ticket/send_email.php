<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);

try {
    // SMTP settings (You may need to adjust these based on your email provider)
    $mail->SMTPDebug = 0; // Set to 2 for debugging purposes
    $mail->isSMTP();
    $mail->Host       = 'dh29268.eatserver.nl'; // Your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'noreply@motionexperience.nl'; // Your SMTP username
    $mail->Password   = 'Multi@123123MM'; // Your SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Sender and recipient
    $recipientEmail = $_POST['recipient_email'];
    $mail->setFrom('noreply@motionexperience.nl', 'Motion Experience');
    $mail->addAddress($recipientEmail);
    $mail->addBcc('noreply@motionexperience.nl');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Motion Experience - Photo';
    $mail->Body    =  '<html>
    <head>
        <style>
            body {
                font-family: "Montserrat", sans-serif;
                background-image: url("background.jpeg");
                background-size: cover;
                background-position: center;
                text-align: center;
                color: #fff;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 900px;
                padding-top: 50px;
                margin: 0 auto;
                padding: 20px;
                background-color: rgba(0, 0, 0, 0.7);
                border-radius: 10px;
            }
            h1 {
                color: #37DFE8;
                font-size: 40px;
            }
            p {
                font-size: 25px;
                line-height: 1.5;
                color: white;
            }
            .social-icons {
                text-align: center;
                margin-top: 20px;
            }
            .social-icon {
                display: inline-block;
                margin: 0 15px;
                text-decoration: none;
            }
            .social-icon img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                transition: transform 0.3s ease-in-out;
            }
            .social-icon:hover img {
                transform: scale(1.2);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Bedankt voor uw bezoek aan Motion Experience!</h1>
            <p>In de bijlagen vind u de mooie fotos van uw bezoek aan Motion Experience.</p>
            <p>Vergeet niet om ons te taggen op onze social media accounts:<p>
            <div class="social-icons">
            <a style="color: #AE66FD;" href="https://www.tiktok.com/@motionexperience" target="_blank" class="social-icon">
               TikTok
            </a>

            <a style="color: #AE66FD;" href="https://www.instagram.com/_motionexperience_/" target="_blank" class="social-icon">
                Instagram
            </a>

            <a style="color: #AE66FD;" href="https://www.facebook.com/motionexperience1/" target="_blank" class="social-icon">
                Facebook
            </a>
            </div>
            <p>We hopen dat u een geweldige tijd heeft gehad en wensen u het beste,</p>
            <p style="color: #AE66FD;">Team Motion Experience</p>
        </div>
            <br><br>
        <div class="container">
            <h1>Thank you for your visit to Motion Experience!</h1>
            <p>In the attachments you will find the amazing pictures from your visit to Motion Experience.</p>
            <p>Dont forget to tag us on our social media accounts:<p>
            <div class="social-icons">
            <a style="color: #AE66FD;" href="https://www.tiktok.com/@motionexperience" target="_blank" class="social-icon">
               TikTok
            </a>

            <a style="color: #AE66FD;" href="https://www.instagram.com/_motionexperience_/" target="_blank" class="social-icon">
                Instagram
            </a>

            <a style="color: #AE66FD;" href="https://www.facebook.com/motionexperience1/" target="_blank" class="social-icon">
                Facebook
            </a>
            </div>
            <p>We hope you had a wonderfull time and wish you all the best,</p>
            <p style="color: #AE66FD;">Team Motion Experience</p>
        </div>
    </body>
</html>';
    // Attach multiple uploaded photos
    if (isset($_FILES['photos']) && is_array($_FILES['photos']['tmp_name'])) {
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
                $photoName = $_FILES['photos']['name'][$key];
                $compressedImg = compress($tmpName, '../tmpCompress/'.$photoName, 80);
                $mail->addAttachment($compressedImg, $photoName);
            }
        }
    }

    // Send the email
    $mail->send();
    echo 'Email is verstuurd naar: ' . $recipientEmail;
    header( "refresh:5;url=mail.html" );
} catch (Exception $e) {
    echo "Error: Email kon niet worden verstuurd: {$mail->ErrorInfo}";
}

function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

?>