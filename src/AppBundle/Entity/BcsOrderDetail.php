<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as CustomConstraints;
use Doctrine\ORM\Mapping as ORM;

/**
 * BcsOrderDetail
 * @CustomConstraints\IsQuantityOrderDetailCorrect()
 * @ORM\Table(name="bcs_order_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsOrderDetailRepository")
 */
class BcsOrderDetail
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
     * @var float
     *
     * @ORM\Column(name="oddQuantity", type="float")
     */
    private $oddQuantity;

    /**
     * @var float
     *
     */
    private $oddStockQuantity;

    /**
     * @var float
     *
     * @ORM\Column(name="oddPrice", type="float")
     */
    private $oddPrice;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsOrder", cascade={"persist","remove"}, inversedBy="mvtMovementDetailLists")
     */
    protected $oddOrder;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsItem", cascade={"persist"})
     */
    protected $oddItem;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsUnitOfMeasure", cascade={"persist"})
     */
    protected $oddUnitOfMeasure;


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
     * Set oddQuantity
     *
     * @param float $oddQuantity
     *
     * @return BcsOrderDetail
     */
    public function setOddQuantity($oddQuantity)
    {
        $this->oddQuantity = $oddQuantity;

        return $this;
    }

    /**
     * Get oddQuantity
     *
     * @return float
     */
    public function getOddQuantity()
    {
        return $this->oddQuantity;
    }

    /**
     * Set oddPrice
     *
     * @param float $oddPrice
     *
     * @return BcsOrderDetail
     */
    public function setOddPrice($oddPrice)
    {
        $this->oddPrice = $oddPrice;

        return $this;
    }

    /**
     * Get oddPrice
     *
     * @return float
     */
    public function getOddPrice()
    {
        return $this->oddPrice;
    }

    /**
     * @return mixed
     */
    public function getOddOrder()
    {
        return $this->oddOrder;
    }

    /**
     * @param mixed $oddOrder
     */
    public function setOddOrder($oddOrder)
    {
        $this->oddOrder = $oddOrder;
    }

    /**
     * @return mixed
     */
    public function getOddItem()
    {
        return $this->oddItem;
    }

    /**
     * @param mixed $oddItem
     */
    public function setOddItem($oddItem)
    {
        $this->oddItem = $oddItem;
    }

    /**
     * @return mixed
     */
    public function getOddUnitOfMeasure()
    {
        return $this->oddUnitOfMeasure;
    }

    /**
     * @param mixed $oddUnitOfMeasure
     */
    public function setOddUnitOfMeasure($oddUnitOfMeasure)
    {
        $this->oddUnitOfMeasure = $oddUnitOfMeasure;
    }

    /**
     * @return float
     */
    public function getOddStockQuantity()
    {
        return $this->oddStockQuantity;
    }

    /**
     * @param float $oddStockQuantity
     */
    public function setOddStockQuantity($oddStockQuantity)
    {
        $this->oddStockQuantity = $oddStockQuantity;
    }


}

