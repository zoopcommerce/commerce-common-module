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
class Address
{
    /**
     *
     * @ODM\String
     */
    protected $line1;

    /**
     *
     * @ODM\String
     */
    protected $line2;

    /**
     *
     * @ODM\String
     */
    protected $city;

    /**
     *
     * @ODM\String
     */
    protected $state;

    /**
     *
     * @ODM\String
     */
    protected $postcode;

    /**
     *
     * @ODM\String
     */
    protected $country;

    /**
     *
     * @return string
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     *
     * @param string $line1
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
    }

    /**
     *
     * @return string
     */
    public function getLine2()
    {
        return $this->line2;
    }

    /**
     *
     * @param string $line2
     */
    public function setLine2($line2)
    {
        $this->line2 = $line2;
    }

    /**
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     *
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     *
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     *
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
