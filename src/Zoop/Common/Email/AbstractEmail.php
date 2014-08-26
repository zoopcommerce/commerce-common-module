<?php

namespace Zoop\Common\Email;

abstract class AbstractEmail
{
    private $to = [];
    private $cc = [];
    private $bcc = [];
    private $attachments = [];
    private $body = null;
    private $subject = null;
    private $from = [];
    private $substitution = [];
    private $template;

    public function addTo($email, $name = null)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->to[] = array(
                'email' => $email,
                'name' => $name
            );
        }
        return $this;
    }

    public function addCc($email, $name = null)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->cc[] = array(
                'email' => $email,
                'name' => $name
            );
        }
        return $this;
    }

    public function addBcc($email, $name = null)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->bcc[] = array(
                'email' => $email,
                'name' => $name
            );
        }
        return $this;
    }

    public function setFrom($email, $name = null)
    {
        $email = trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->from = array(
                'email' => $email,
                'name' => $name
            );
        }
        return $this;
    }

    public function setBody($body)
    {
        if (!empty($body)) {
            $this->body = $body;
        }
        return $this;
    }

    public function setSubject($subject)
    {
        if (!empty($subject)) {
            $this->subject = $subject;
        }
        return $this;
    }

    public function addAttachment($file)
    {
        if (is_file($file)) {
            $this->attachments[] = $file;
        }
        return $this;
    }

    public function addSubstitution($key, $value)
    {
        $this->substitution[$key][] = $value;
        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getCC()
    {
        return $this->cc;
    }

    public function getBcc()
    {
        return $this->bcc;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getSubstitution()
    {
        return $this->substitution;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function setTemplate($template)
    {
        if (!empty($template)) {
            $this->template = $template;
        }
        return $this;
    }
}
