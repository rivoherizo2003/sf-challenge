<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsObject
 *
 * @ORM\Table(name="bcs_object")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsObjectRepository")
 */
class BcsObject
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="objCode", type="string", length=50, unique=true)
     */
    private $objCode;

    /**
     * @var float
     *
     * @ORM\Column(name="objQuantity", type="float")
     */
    private $objQuantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="objAddedDate", type="datetime")
     */
    private $objAddedDate;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objCode
     *
     * @param string $objCode
     *
     * @return BcsObject
     */
    public function setObjCode($objCode)
    {
        $this->objCode = $objCode;

        return $this;
    }

    /**
     * Get objCode
     *
     * @return string
     */
    public function getObjCode()
    {
        return $this->objCode;
    }

    /**
     * Set objQuantity
     *
     * @param float $objQuantity
     *
     * @return BcsObject
     */
    public function setObjQuantity($objQuantity)
    {
        $this->objQuantity = $objQuantity;

        return $this;
    }

    /**
     * Get objQuantity
     *
     * @return float
     */
    public function getObjQuantity()
    {
        return $this->objQuantity;
    }

    /**
     * Set objAddedDate
     *
     * @param \DateTime $objAddedDate
     *
     * @return BcsObject
     */
    public function setObjAddedDate($objAddedDate)
    {
        $this->objAddedDate = $objAddedDate;

        return $this;
    }

    /**
     * Get objAddedDate
     *
     * @return \DateTime
     */
    public function getObjAddedDate()
    {
        return $this->objAddedDate;
    }
}

