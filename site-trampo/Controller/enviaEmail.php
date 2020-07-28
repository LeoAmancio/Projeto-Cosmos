<?php
require("../Dao/daoUser.php");
$dao = new daoUser();

$email = $_POST['email'];
if($dao->verificaContaUser($email) == "user"){
    require 'PHPMailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;
    
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'comoscontato@gmail.com';           // SMTP username
    $mail->Password = 'essaehasenha';                     // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    
    $mail->setFrom('comoscontato@gmail.com');
    $mail->addAddress($email);                            // Add a recipient
    
    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Recuperação de senha | Trampo';
    $mail->Body    = 'Seu link de recuperação de senha é: http://localhost/trampo/View/PasswordRecovery/NovaSenha/index.php?email='.$email;
    $mail->AltBody = 'Para recuperar sua senha basta clickar no link e cadastar uma nova';
    
    if(!$mail->send()) {
        header("Location: ../View/PasswordRecovery/EmailWarning/Error/index.html");
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        header("Location: ../View/PasswordRecovery/EmailWarning/Success/index.html");
    }
}else{
    header("Location: ../View/Error/DadosInvalidos/index.html");
}
