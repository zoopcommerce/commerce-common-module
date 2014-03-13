<?php

namespace Zoop\Common\Email\Ses;

use Zoop\Common\Email\AbstractEmail;
use Zoop\Common\Email\EmailInterface;
use Zoop\Common\Email\PhpMailer\PhpMailer;

/**
 * Description of Email
 *
 * @author josh.stuart
 */
class Email extends AbstractEmail implements EmailInterface
{
    const HOST = 'email-smtp.us-east-1.amazonaws.com';
    const PORT = 465;

    private $mail;

    public function __construct($username, $password, $host = null, $port = null)
    {
        $this->mail = new PhpMailer(true);
        $this->mail->IsSMTP();
        $this->mail->Mailer = 'smtp';
        $this->mail->SMTPAuth = true;
        $this->mail->Host = 'tls://' . (empty($host) ? self::HOST : $host);
        $this->mail->Port = !is_numeric($port) ? self::PORT : $port;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->CharSet = 'utf-8';
    }

    public function send()
    {
        $from = $this->getFrom();

        if (!empty($from) && is_a($this->mail, '\Email\PhpMailer\PhpMailer')) {
            $this->addToAddresses()
                ->addCcAddresses()
                ->addBccAddresses()
                ->addAttatchments();

            $this->mail->SetFrom($from['email'], $from['name']);
            $this->mail->Subject = $this->getSubject();
            $this->mail->MsgHTML($this->getBody());

            if (!$this->mail->Send()) {
                return false;
            } else {
                return true;
            }
        }
        return false;
    }

    private function addAttatchments()
    {
        $files = $this->getAttachments();
        if (is_array($files)) {
            foreach ($files as $file) {
                $this->mail->AddAttachment($file);
            }
        }
        return $this;
    }

    private function addToAddresses()
    {
        $emails = $this->getTo();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->AddAddress($email['email'], $email['name']);
            }
        }
        return $this;
    }

    private function addCcAddresses()
    {
        $emails = $this->getCc();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->AddCC($email['email'], $email['name']);
            }
        }
        return $this;
    }

    private function addBccAddresses()
    {
        $emails = $this->getBcc();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->AddBCC($email['email'], $email['name']);
            }
        }
        return $this;
    }
}
