<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsItem
 *
 * @ORM\Table(name="bcs_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BcsItem
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
     * @ORM\Column(name="itmCode", type="string", length=30, unique=true)
     */
    private $itmCode;

    /**
     * @var string
     *
     * @ORM\Column(name="itmTitle", type="string", length=255)
     */
    private $itmTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="itmDescription", type="string", length=255, nullable=true)
     */
    private $itmDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="itmItemCodeSupplier", type="string", length=50, nullable=true)
     */
    private $itmItemCodeSupplier;

    /**
     * @var float
     *
     * @ORM\Column(name="itmStockQuantity", type="float", nullable=true)
     */
    private $itmStockQuantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="mvdQuantity", type="float")
     */
    private $itmReservedQuantity = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="itmPriceWithDuty", type="float", nullable=true)
     */
    private $itmPriceWithDuty = 0;

    /**
     * @var \DateTime
     * @ORM\Column(name="itmAddedDate", type="datetime")
     */
    private $itmAddedDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsUnitOfMeasure", cascade={"persist"})
     */
    protected $itmUnitOfMeasure;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsItemType", cascade={"persist"})
     */
    protected $itmItemType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsItemCategory", cascade={"persist"})
     */
    protected $itmItemCategory;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsBrand", cascade={"persist"})
     */
    protected $itmItemBrand;


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
     * Set itmCode
     *
     * @param string $itmCode
     *
     * @return BcsItem
     */
    public function setItmCode($itmCode)
    {
        $this->itmCode = $itmCode;

        return $this;
    }

    /**
     * Get itmCode
     *
     * @return string
     */
    public function getItmCode()
    {
        return $this->itmCode;
    }

    /**
     * Set itmTitle
     *
     * @param string $itmTitle
     *
     * @return BcsItem
     */
    public function setItmTitle($itmTitle)
    {
        $this->itmTitle = $itmTitle;

        return $this;
    }

    /**
     * Get itmTitle
     *
     * @return string
     */
    public function getItmTitle()
    {
        return $this->itmTitle;
    }

    /**
     * Set itmDescription
     *
     * @param string $itmDescription
     *
     * @return BcsItem
     */
    public function setItmDescription($itmDescription)
    {
        $this->itmDescription = $itmDescription;

        return $this;
    }

    /**
     * Get itmDescription
     *
     * @return string
     */
    public function getItmDescription()
    {
        return $this->itmDescription;
    }

    /**
     * Set itmStockQuantity
     *
     * @param float $itmStockQuantity
     *
     * @return BcsItem
     */
    public function setItmStockQuantity($itmStockQuantity)
    {
        $this->itmStockQuantity = $itmStockQuantity;

        return $this;
    }

    /**
     * Get itmStockQuantity
     *
     * @return float
     */
    public function getItmStockQuantity()
    {
        return $this->itmStockQuantity;
    }

    /**
     * Set itmPriceWithDuty
     *
     * @param float $itmPriceWithDuty
     *
     * @return BcsItem
     */
    public function setItmPriceWithDuty($itmPriceWithDuty)
    {
        $this->itmPriceWithDuty = $itmPriceWithDuty;

        return $this;
    }

    /**
     * Get itmPriceWithDuty
     *
     * @return float
     */
    public function getItmPriceWithDuty()
    {
        return $this->itmPriceWithDuty;
    }

    /**
     * Set itmUnitOfMeasure
     *
     * @param \AppBundle\Entity\BcsUnitOfMeasure $itmUnitOfMeasure
     *
     * @return BcsItem
     */
    public function setItmUnitOfMeasure(\AppBundle\Entity\BcsUnitOfMeasure $itmUnitOfMeasure = null)
    {
        $this->itmUnitOfMeasure = $itmUnitOfMeasure;

        return $this;
    }

    /**
     * Get itmUnitOfMeasure
     *
     * @return \AppBundle\Entity\BcsUnitOfMeasure
     */
    public function getItmUnitOfMeasure()
    {
        return $this->itmUnitOfMeasure;
    }

    /**
     * Set itmItemType
     *
     * @param \AppBundle\Entity\BcsItemType $itmItemType
     *
     * @return BcsItem
     */
    public function setItmItemType(\AppBundle\Entity\BcsItemType $itmItemType = null)
    {
        $this->itmItemType = $itmItemType;

        return $this;
    }

    /**
     * Get itmItemType
     *
     * @return \AppBundle\Entity\BcsItemType
     */
    public function getItmItemType()
    {
        return $this->itmItemType;
    }

    /**
     * Set itmItemCategory
     *
     * @param \AppBundle\Entity\BcsItemCategory $itmItemCategory
     *
     * @return BcsItem
     */
    public function setItmItemCategory(\AppBundle\Entity\BcsItemCategory $itmItemCategory = null)
    {
        $this->itmItemCategory = $itmItemCategory;

        return $this;
    }

    /**
     * Get itmItemCategory
     *
     * @return \AppBundle\Entity\BcsItemCategory
     */
    public function getItmItemCategory()
    {
        return $this->itmItemCategory;
    }

    /**
     * @return string
     */
    public function getItmItemCodeSupplier()
    {
        return $this->itmItemCodeSupplier;
    }

    /**
     * @param string $itmItemCodeSupplier
     */
    public function setItmItemCodeSupplier($itmItemCodeSupplier)
    {
        $this->itmItemCodeSupplier = $itmItemCodeSupplier;
    }

    /**
     * @return mixed
     */
    public function getItmItemBrand()
    {
        return $this->itmItemBrand;
    }

    /**
     * @param mixed $itmItemBrand
     */
    public function setItmItemBrand($itmItemBrand)
    {
        $this->itmItemBrand = $itmItemBrand;
    }

    /**
     * @return \DateTime
     */
    public function getItmAddedDate()
    {
        return $this->itmAddedDate;
    }

    /**
     * @param \DateTime $itmAddedDate
     */
    public function setItmAddedDate($itmAddedDate)
    {
        $this->itmAddedDate = $itmAddedDate;
    }

    /**
     * @ORM\PrePersist()
     */
    public function addCreatedDate(){
        $l_dtDateNow = new \DateTime();
        $this->setItmAddedDate($l_dtDateNow);
    }

    /**
     * @return float
     */
    public function getItmReservedQuantity()
    {
        return $this->itmReservedQuantity;
    }

    /**
     * @param float $itmReservedQuantity
     */
    public function setItmReservedQuantity($itmReservedQuantity)
    {
        $this->itmReservedQuantity = $itmReservedQuantity;
    }

}
