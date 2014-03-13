<?php

namespace Zoop\Common\Email\SendGrid;

use Zoop\Common\Email\AbstractEmail;
use Zoop\Common\Email\EmailInterface;
use \SendGrid;
use \SendGrid\Mail as SendGridMail;

/**
 * Description of Email
 *
 * @author josh.stuart
 */
class Email extends AbstractEmail implements EmailInterface
{
    const HOST = 'smtp.sendgrid.net';
    const PORT = 465;

    private $mail;
    private $sendgrid;

    public function __construct($username, $password, $host = null, $port = null)
    {
        $this->sendgrid = new SendGrid($username, $password);
        $this->mail = new SendGridMail();
    }

    public function send()
    {
        $from = $this->getFrom();

        if (!empty($from) && !empty($this->mail)) {
            $this->addToAddresses()
                ->addCcAddresses()
                ->addBccAddresses()
                ->addAttatchments()
                ->addSubstitutions();

            $this->mail->setFrom($from['email']);
            $this->mail->setFromName($from['name']);
            $this->mail->setSubject($this->getSubject());
            $this->mail->setHtml($this->getBody());
            $this->mail->addHeader('Content-Type', 'text/html; charset=UTF-8');

            if (!$this->sendgrid->web->send($this->mail)) {
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
                $this->mail->addAttachment($file);
            }
        }
        return $this;
    }

    private function addToAddresses()
    {
        $emails = $this->getTo();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->addTo($email['email'], @$email['name']);
            }
        }
        return $this;
    }

    private function addCcAddresses()
    {
        $emails = $this->getCc();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->addCc($email['email']);
            }
        }
        return $this;
    }

    private function addBccAddresses()
    {
        $emails = $this->getBcc();
        if (is_array($emails)) {
            foreach ($emails as $email) {
                $this->mail->addBcc($email['email']);
            }
        }
        return $this;
    }

    private function addSubstitutions()
    {
        $subs = $this->getSubstitution();
        if (is_array($subs)) {
            foreach ($subs as $key => $vals) {
                if (is_array($vals) && !empty($vals)) {
                    $this->mail->addSubstitution($key, $vals);
                }
            }
        }
        return $this;
    }
}
