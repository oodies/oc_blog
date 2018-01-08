<?php
/**
 * This file is part of oc_blog project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/01
 */

namespace App\Domain\Model;

/**
 * Class Mail
 *
 * @package App\Domain\Model
 */
class Mail
{
    /** *******************************
     *  PROPERTIES
     */

    /** @var string */
    protected $to = null;

    /** @var mixed */
    protected $from = null;

    /** @var string */
    protected $subject = null;

    /** @var string */
    protected $body = null;

    /** *******************************
     *  METHODS
     */

    /**
     * @return string
     */
    public function getTo(): ?string
    {
        return $this->to;
    }

    /**
     * @param string $to
     *
     * @return Mail
     */
    public function setTo(string $to): Mail
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return null|string|array
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     *
     * @return Mail
     */
    public function setFrom($from): Mail
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return Mail
     */
    public function setSubject(string $subject): Mail
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $body
     *
     * @return Mail
     */
    public function setBody(string $body): Mail
    {
        $this->body = $body;
        return $this;
    }
}
