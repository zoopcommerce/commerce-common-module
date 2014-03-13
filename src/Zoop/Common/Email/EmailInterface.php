<?php

namespace Zoop\Common\Email;

interface EmailInterface
{
    public function addTo($email, $name = null);

    public function addCc($email, $name = null);

    public function addBcc($email, $name = null);

    public function setFrom($email, $name = null);

    public function setBody($body);

    public function setSubject($subject);

    public function addAttachment($file);

    public function getFrom();

    public function getTo();

    public function getCC();

    public function getBcc();

    public function getBody();

    public function getSubject();

    public function getAttachments();

    public function send();
}
