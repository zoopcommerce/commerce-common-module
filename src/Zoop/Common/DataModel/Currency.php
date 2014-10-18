<?php

namespace Zoop\Common\DataModel;

use Zoop\Common\DataModel\CurrencyInterface;
//Annotation imports
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Zoop\Shard\Annotation\Annotations as Shard;

/**
 * @ODM\EmbeddedDocument
 * @Shard\AccessControl({
 *     @Shard\Permission\Basic(roles="*", allow="*")
 * })
 */
class Currency implements CurrencyInterface
{
    /**
     *
     * @ODM\String
     */
    protected $code;

    /**
     * @ODM\String
     */
    protected $symbol;

    /**
     * @ODM\String
     */
    protected $name;

    /**
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     *
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
