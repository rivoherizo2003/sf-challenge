<?php

namespace AppBundle\Entity;

use AppBundle\Validator\Constraints as CustomConstraints;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping as ORM;

/**
 * BcsMovementDetail
 *
 * @CustomConstraints\IsQuantityExitMovementCorrect()
 * @ORM\Table(name="bcs_movement_detail")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsMovementDetailRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BcsMovementDetail
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
     *
     * @var float
     *
     * @ORM\Column(name="mvdQuantity", type="float")
     */
    private $mvdQuantity;

    /**
     * @var float
     *
     */
    private $mvdStockQuantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mvdAddedDate", type="datetime")
     */
    private $mvdAddedDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsMovement", cascade={"persist","remove"}, inversedBy="mvtMovementDetailLists")
     */
    protected $mvdMovement;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsItem", cascade={"persist"})
     */
    protected $mvdItem;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsUnitOfMeasure", cascade={"persist"})
     */
    protected $mvdUnitOfMeasure;

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
     * Set mvdQuantity
     *
     * @param float $mvdQuantity
     *
     * @return BcsMovementDetail
     */
    public function setMvdQuantity($mvdQuantity)
    {
        $this->mvdQuantity = $mvdQuantity;

        return $this;
    }

    /**
     * Get mvdQuantity
     *
     * @return float
     */
    public function getMvdQuantity()
    {
        return $this->mvdQuantity;
    }

    /**
     * Set mvdAddedDate
     *
     * @param \DateTime $mvdAddedDate
     *
     * @return BcsMovementDetail
     */
    public function setMvdAddedDate($mvdAddedDate)
    {
        $this->mvdAddedDate = $mvdAddedDate;

        return $this;
    }

    /**
     * Get mvdAddedDate
     *
     * @return \DateTime
     */
    public function getMvdAddedDate()
    {
        return $this->mvdAddedDate;
    }

    /**
     * @return mixed
     */
    public function getMvdMovement()
    {
        return $this->mvdMovement;
    }

    /**
     * @param mixed $mvdMovement
     */
    public function setMvdMovement($mvdMovement)
    {
        $this->mvdMovement = $mvdMovement;
    }

    /**
     * @return mixed
     */
    public function getMvdItem()
    {
        return $this->mvdItem;
    }

    /**
     * @param mixed $mvdItem
     */
    public function setMvdItem($mvdItem)
    {
        $this->mvdItem = $mvdItem;
    }

    /**
     * @ORM\PrePersist()
     */
    public function addCreatedDate(){
        $l_dtDateNow = new \DateTime();
        $this->setMvdAddedDate($l_dtDateNow);
    }

    /**
     * @return float
     */
    public function getMvdStockQuantity()
    {
        return $this->mvdStockQuantity;
    }

    /**
     * @param float $mvdStockQuantity
     */
    public function setMvdStockQuantity($mvdStockQuantity)
    {
        $this->mvdStockQuantity = $mvdStockQuantity;
    }

    /**
     * @return mixed
     */
    public function getMvdUnitOfMeasure()
    {
        return $this->mvdUnitOfMeasure;
    }

    /**
     * @param mixed $mvdUnitOfMeasure
     */
    public function setMvdUnitOfMeasure($mvdUnitOfMeasure)
    {
        $this->mvdUnitOfMeasure = $mvdUnitOfMeasure;
    }
}

