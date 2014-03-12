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
class CustomHtml
{
    /**
     * @ODM\String
     */
    protected $append;

    /**
     *
     * @ODM\String
     */
    protected $prepend;

    /**
     *
     * @return string
     */
    public function getAppend()
    {
        return $this->append;
    }

    /**
     *
     * @param string $append
     */
    public function setAppend($append)
    {
        $this->append = (string) $append;
    }

    /**
     *
     * @return string
     */
    public function getPrepend()
    {
        return $this->prepend;
    }

    /**
     *
     * @param string $prepend
     */
    public function setPrepend($prepend)
    {
        $this->prepend = (string) $prepend;
    }
}
