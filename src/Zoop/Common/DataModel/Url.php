<?php

namespace Zoop\Common\DataModel;

//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class Url
{
    /**
     * @ODM\String
     */
    protected $relative;

    /**
     *
     * @ODM\String
     */
    protected $absolute;

    public function __construct($relative = null, $absolute = null)
    {
        $this->relative = $relative;
        $this->absolute = $absolute;
    }

    /**
     *
     * @return string
     */
    public function getRelative()
    {
        return $this->relative;
    }

    /**
     *
     * @param string $relative
     */
    public function setRelative($relative)
    {
        $this->relative = (string) $relative;
    }

    /**
     *
     * @return string
     */
    public function getAbsolute()
    {
        return $this->absolute;
    }

    /**
     *
     * @param string $absolute
     */
    public function setAbsolute($absolute)
    {
        $this->absolute = (string) $absolute;
    }
}
