<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * BcsOrder
 *
 * @ORM\Table(name="bcs_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsOrderRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BcsOrder
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
     * @ORM\Column(name="ordCode", type="string", length=20, unique=true)
     */
    private $ordCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ordDate", type="datetime")
     */
    private $ordDate;

    /**
     * @var float
     *
     * @ORM\Column(name="ordAmount", type="float")
     */
    private $ordAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="ordStatus", type="integer", options={"comment":"0 saved, 1 in progress, 2 achieved"})
     */
    private $ordStatus = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ordIsDraft", type="boolean")
     */
    private $ordIsDraft = true;

    /**
     * @var string
     *
     * @ORM\Column(name="ordComment", type="string", length=255, nullable=true)
     */
    private $ordComment;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsUser", cascade={"persist"})
     */
    protected $ordUser;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BcsOrderDetail", cascade={"persist"}, mappedBy="oddOrder", orphanRemoval=true)
     */
    private $ordOrderDetailLists;


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
     * Set ordCode
     *
     * @param string $ordCode
     *
     * @return BcsOrder
     */
    public function setOrdCode($ordCode)
    {
        $this->ordCode = $ordCode;

        return $this;
    }

    /**
     * Get ordCode
     *
     * @return string
     */
    public function getOrdCode()
    {
        return $this->ordCode;
    }

    /**
     * Set ordDate
     *
     * @param \DateTime $ordDate
     *
     * @return BcsOrder
     */
    public function setOrdDate($ordDate)
    {
        $this->ordDate = $ordDate;

        return $this;
    }

    /**
     * Get ordDate
     *
     * @return \DateTime
     */
    public function getOrdDate()
    {
        return $this->ordDate;
    }

    /**
     * Set ordAmount
     *
     * @param float $ordAmount
     *
     * @return BcsOrder
     */
    public function setOrdAmount($ordAmount)
    {
        $this->ordAmount = $ordAmount;

        return $this;
    }

    /**
     * Get ordAmount
     *
     * @return float
     */
    public function getOrdAmount()
    {
        return $this->ordAmount;
    }

    /**
     * Set ordStatus
     *
     * @param integer $ordStatus
     *
     * @return BcsOrder
     */
    public function setOrdStatus($ordStatus)
    {
        $this->ordStatus = $ordStatus;

        return $this;
    }

    /**
     * Get ordStatus
     *
     * @return int
     */
    public function getOrdStatus()
    {
        return $this->ordStatus;
    }

    /**
     * @ORM\PrePersist()
     */
    public function addCreatedDate(){
        $l_dtDateNow = new \DateTime();
        $this->setOrdDate($l_dtDateNow);
    }

    /**
     * @return mixed
     */
    public function getOrdUser()
    {
        return $this->ordUser;
    }

    /**
     * @param mixed $ordUser
     */
    public function setOrdUser($ordUser)
    {
        $this->ordUser = $ordUser;
    }

    /**
     * @return mixed
     */
    public function getOrdOrderDetailLists()
    {
        return $this->ordOrderDetailLists;
    }

    public function __construct()
    {
        $this->ordOrderDetailLists = new ArrayCollection();
    }

    /**
     * @param BcsOrderDetail $p_oddOrderDetail
     * @return $this
     */
    public function addOrdOrderDetailList(BcsOrderDetail $p_oddOrderDetail){
        if ( !$this->ordOrderDetailLists->contains($p_oddOrderDetail) ) {
            $this->ordOrderDetailLists->add($p_oddOrderDetail);
            $p_oddOrderDetail->setOddOrder($this);
        }

        return $this;
    }

    /**
     * @param BcsOrderDetail $p_oddOrderDetail
     * @return $this
     */
    public function removeOrdOrderDetailList(BcsOrderDetail $p_oddOrderDetail){
//		dump($this->mofAddressLists);die;
        if ( $this->ordOrderDetailLists->contains($p_oddOrderDetail) ) {
            $this->ordOrderDetailLists->removeElement($p_oddOrderDetail);
            $p_oddOrderDetail->setOddOrder(null);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOrdComment()
    {
        return $this->ordComment;
    }

    /**
     * @param string $ordComment
     */
    public function setOrdComment($ordComment)
    {
        $this->ordComment = $ordComment;
    }

    /**
     * @return bool
     */
    public function isOrdIsDraft()
    {
        return $this->ordIsDraft;
    }

    /**
     * @param bool $ordIsDraft
     */
    public function setOrdIsDraft($ordIsDraft)
    {
        $this->ordIsDraft = $ordIsDraft;
    }

}

