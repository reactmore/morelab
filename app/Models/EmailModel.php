<?php

namespace App\Models;

require APPPATH . "ThirdParty/swiftmailer/vendor/autoload.php";

use CodeIgniter\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MAILER_Exception;


class EmailModel extends Model
{

    protected $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = session();
    }

    //send text email
    public function send_test_email($email, $subject, $message)
    {
        if (!empty($email)) {
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $email,
                'template_path' => "email/email_newsletter",
                'subscriber' => "",
            );

            return $this->send_email($data);
        }
    }

    //send email activation
    public function send_email_activation($user_id, $sess = 'admin')
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_unique_id();
                $data = array(
                    'token' => $token
                );
                $userModel->builder()->where('id', $user->id)->update($data);
            }

            $data = array(
                'subject' => trans("confirm_your_email"),
                'to' => $user->email,
                'template_path' => "email/email_activation",
                'token' => $token
            );

            if ($sess == 'user') {
                $data['template_path'] = 'email/email_activation';
            }

            $this->send_email($data);
        }
    }

    //send email contact message
    public function send_email_contact_message($message_name, $message_email, $message_text)
    {
        $data = array(
            'subject' => trans("contact_message"),
            'to' => get_general_settings()->mail_contact,
            'template_path' => "email/email_contact_message",
            'message_name' => $message_name,
            'message_email' => $message_email,
            'message_text' => $message_text
        );
        $this->send_email($data);
    }

    //send email newsletter
    public function send_email_newsletter($subscriber, $subject, $message)
    {
        if (!empty($subscriber)) {
            if (empty($subscriber->token)) {
                $this->newsletter_model->update_subscriber_token($subscriber->email);
                $subscriber = $this->newsletter_model->get_subscriber($subscriber->email);
            }
            $data = array(
                'subject' => $subject,
                'message' => $message,
                'to' => $subscriber->email,
                'template_path' => "email/email_newsletter",
                'subscriber' => $subscriber,
            );
            return $this->send_email($data);
        }
    }

    //send email reset password
    public function send_email_reset_password($user_id)
    {
        $userModel = new UsersModel();
        $user = $userModel->get_user($user_id);
        if (!empty($user)) {
            $token = $user->token;
            //check token
            if (empty($token)) {
                $token = generate_unique_id();
                $data = array(
                    'token' => $token
                );
                $userModel->builder()->where('id', $user->id)->update($data);
            }

            $data = array(
                'subject' => trans("reset_password"),
                'to' => $user->email,
                'template_path' => "email/email_reset_password",
                'token' => $token
            );



            $this->send_email($data);
        }
    }



    // Proccess

    //send email
    public function send_email($data)
    {
        $protocol = get_general_settings()->mail_protocol;
        if ($protocol != "smtp" && $protocol != "mail") {
            $protocol = "smtp";
        }
        $encryption = get_general_settings()->mail_encryption;
        if ($encryption != "tls" && $encryption != "ssl") {
            $encryption = "tls";
        }
        if (get_general_settings()->mail_library == "swift") {
            return $this->send_email_swift($encryption, $data);
        } else {
            return $this->send_email_php_mailer($protocol, $encryption, $data);
        }
    }

    //send email with swift mailer
    public function send_email_swift($encryption, $data)
    {
        try {
            // Create the Transport
            $transport = (new \Swift_SmtpTransport(get_general_settings()->mail_host, get_general_settings()->mail_port, $encryption))
                ->setUsername(get_general_settings()->mail_username)
                ->setPassword(get_general_settings()->mail_password);

            // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message(get_general_settings()->mail_title))
                ->setFrom(array(get_general_settings()->mail_reply_to => get_general_settings()->mail_title))
                ->setTo([$data['to'] => ''])
                ->setSubject($data['subject'])
                ->setBody(view($data['template_path'], $data), 'text/html');

            //Send the message
            $result = $mailer->send($message);
            if ($result) {
                return true;
            }
        } catch (\Swift_TransportException $Ste) {
            $this->session->setFlashData('errors_form', $Ste->getMessage());
            return false;
        } catch (\Swift_RfcComplianceException $Ste) {
            $this->session->setFlashData('errors_form', $Ste->getMessage());
            return false;
        }
    }

    //send email with php mailer
    public function send_email_php_mailer($protocol, $encryption, $data)
    {
        $mail = new PHPMailer(true);
        try {
            if ($protocol == "mail") {
                $mail->isMail();
                $mail->setFrom(get_general_settings()->mail_reply_to, get_general_settings()->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            } else {
                $mail->isSMTP();
                $mail->Host = get_general_settings()->mail_host;
                $mail->SMTPAuth = true;
                $mail->Username = get_general_settings()->mail_username;
                $mail->Password = get_general_settings()->mail_password;
                $mail->SMTPSecure = $encryption;
                $mail->CharSet = 'UTF-8';
                $mail->Port = get_general_settings()->mail_port;
                $mail->setFrom(get_general_settings()->mail_reply_to, get_general_settings()->mail_title);
                $mail->addAddress($data['to']);
                $mail->isHTML(true);
                // $mail->SMTPDebug  = 1;
                $mail->Subject = $data['subject'];
                $mail->Body = view($data['template_path'], $data);
            }
            $mail->send();
            return true;
        } catch (MAILER_Exception $e) {
            if ($e) {
                $this->session->setFlashData('errors_form', $mail->ErrorInfo);
            }

            return false;
        }
        return false;
    }
}
