<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    
    require 'vendor/autoload.php';
    
    $host='localhost';
    $dbusername='root';
    $dbpassword='';
    $dbname='pari';
    $did = $_POST['donationid'];
    $email = $_POST['emailid'];
    $con=mysqli_connect("localhost","root","","pari");
    $query = mysqli_query($con,"SELECT * from donations where donationId = $did limit 1");
    $res = mysqli_fetch_array($query);
    
    //Mail
    $username = $res['username'];
    $useraddress = $res['useraddress'];
    $donationid = $res['donationId'];
    $phone = $res['mobileno'];
    $foodJson = $res['food'];
    $medsJson = $res['medicines'];
    $needsJson = $res['dailyneeds'];
    $to = $email;
    $subject = "Your Donation Details";
    $header = "From:as.abhi99@gmail.com \r\n";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    $foodArr = json_decode($foodJson, true);
    $message = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    <tr>
        <td align=\"center\">
            <img src='https://i.ibb.co/pQCg5St/pari.png'>
        </td>
    </tr>
</table>"."<br>";
    $message .= "Thanks for the donation. Your donation has helped many lives in need."."<br>"."Here is the details of the donation you have made."."<br><br>";
    $message .= "<b>Food</b>"."<br>";
    foreach ($foodArr as $key => $value) {
        $message .= $key." - ".$value."<br>";
    }
    
    $medsArr = json_decode($medsJson, true);
    $message .= "<br><b>Medicines</b>"."<br>";
    foreach ($medsArr as $key => $value) {
        $message .= $key." - ".$value."<br>";
    }

    $needsArr = json_decode($needsJson, true);
    $message .= "<br><b>Daily Needs</b>"."<br>";
    foreach ($needsArr as $key => $value) {
        $message .= $key." - ".$value."<br>";
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                              
        $mail->Host       = 'smtp.gmail.com';      
        $mail->SMTPAuth   = true;                               
        $mail->Username   = ''; //Add your Email               
        $mail->Password   = ''; //Mention your Password             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    
        $mail->Port       = 587;                                   

        $mail->setFrom('amilaneni2709@gmail.com', 'Mail from Pari');
        $mail->addAddress($email, 'Donor');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
        echo "Please check your mail for the details of the Donations made.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    header("refresh:5;url=index.html" );
?>
