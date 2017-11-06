<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * mailer class to handle contact emails
 */
class Mailer {
    public $mail;
    public $firstName;
    public $lastName;
    public $emailAddress;
    public $phoneNumber;
    public $message;

    private function _generateMail() {
        //Recipients
        $this->mail->setFrom($this->emailAddress, 'Mailer');
        $this->mail->addAddress('terrijonfowler@gmail.com', 'Terrijon Fowler');

        //Content
        $this->mail->isHTML(true);
        $this->mail->Subject = 'You got mail from terrijonFowler.com!';

        $html = '';
        $html .= '<br>First Name: ' . $this->firstName;
        $html .= '<br>Last Name: ' . $this->lastName;
        $html .= '<br>Email Address: ' . $this->emailAddress;
        $html .= '<br>Phone Number: ' . $this->phoneNumber;
        $html .= '<br>Message: ' . $this->message;

        $this->mail->Body    = $html;
        $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    }

    private function _initializeMailer() {
        require ABS_BASE_PATH . 'vendor/autoload.php';

        $this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        //Server settings
        $this->mail->SMTPDebug  = 0;                                 // Enable verbose debug output
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth   = true;                               // Enable SMTP authentication
        $this->mail->Username   = 'terrijonfowler@gmail.com';                 // SMTP username
        $this->mail->Password   = 'Trinity74108520!';                           // SMTP password
        $this->mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port       = 465;                                    // TCP port to connect to
    }

    private function _setFields() {
        $this->firstName    = Post::get('first-name');
        $this->lastName     = Post::get('last-name');
        $this->emailAddress = Post::get('email-address');
        $this->phoneNumber  = Post::get('phone-number');
        $this->message      = Post::get('message');
    }

    public function send() {
        $response = array();

        $this->_setFields();
        $this->_initializeMailer();
        $this->_generateMail();

        try {
            $this->mail->send();

            $response = array(
                'class' => 'success',
                'title' => 'Success',
                'message' => 'This is a placeholder success message'
            );

        } catch (Exception $e) {
            $response = array(
                'class' => 'success',
                'title' => 'Success',
                'message' => 'This is a error placeholder message: ' . $this->mail->ErrorInfo
            );
        }

        return $response;
    }
}