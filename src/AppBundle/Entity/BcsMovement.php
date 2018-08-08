<?php

namespace AppBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BcsMovement
 *
 * @ORM\Table(name="bcs_movement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsMovementRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BcsMovement
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
     * @ORM\Column(name="mvtCode", type="string", length=50, unique=true)
     */
    private $mvtCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mvtDate", type="datetime")
     */
    private $mvtDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="mvtAddedDate", type="datetime")
     */
    private $mvtAddedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="mvtComment", type="string", length=255, nullable=true)
     */
    private $mvtComment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mvtIsDraft", type="boolean")
     */
    private $mvtIsDraft = true;

    /**
     * @Assert\Valid
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BcsMovementDetail", cascade={"persist"}, mappedBy="mvdMovement", orphanRemoval=true)
     */
    private $mvtMovementDetailLists;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsTypeMovement", cascade={"persist"})
     */
    protected $mvtMovementType;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsOrder", cascade={"persist"})
     */
    protected $mvtOrder;


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
     * Set mvtCode
     *
     * @param string $mvtCode
     *
     * @return BcsMovement
     */
    public function setMvtCode($mvtCode)
    {
        $this->mvtCode = $mvtCode;

        return $this;
    }

    /**
     * Get mvtCode
     *
     * @return string
     */
    public function getMvtCode()
    {
        return $this->mvtCode;
    }

    /**
     * Set mvtDate
     *
     * @param \DateTime $mvtDate
     *
     * @return BcsMovement
     */
    public function setMvtDate($mvtDate)
    {
        $this->mvtDate = $mvtDate;

        return $this;
    }

    /**
     * Get mvtDate
     *
     * @return \DateTime
     */
    public function getMvtDate()
    {
        return $this->mvtDate;
    }

    /**
     * Set mvtAddedDate
     *
     * @param \DateTime $mvtAddedDate
     *
     * @return BcsMovement
     */
    public function setMvtAddedDate($mvtAddedDate)
    {
        $this->mvtAddedDate = $mvtAddedDate;

        return $this;
    }

    /**
     * Get mvtAddedDate
     *
     * @return \DateTime
     */
    public function getMvtAddedDate()
    {
        return $this->mvtAddedDate;
    }

    /**
     * Set mvtComment
     *
     * @param string $mvtComment
     *
     * @return BcsMovement
     */
    public function setMvtComment($mvtComment)
    {
        $this->mvtComment = $mvtComment;

        return $this;
    }

    /**
     * Get mvtComment
     *
     * @return string
     */
    public function getMvtComment()
    {
        return $this->mvtComment;
    }

    /**
     * @ORM\PrePersist()
     */
    public function addCreatedDate(){
        $l_dtDateNow = new \DateTime();
        $this->setMvtAddedDate($l_dtDateNow);
    }

    /**
     * @return mixed
     */
    public function getMvtMovementDetailLists()
    {
        return $this->mvtMovementDetailLists;
    }



    public function __construct()
    {
        $this->mvtMovementDetailLists = new ArrayCollection();
    }

    /**
     * @param BcsMovementDetail $p_mvdMovementDetail
     * @return $this
     */
    public function addMvtMovementDetailList(BcsMovementDetail $p_mvdMovementDetail){
        if ( !$this->mvtMovementDetailLists->contains($p_mvdMovementDetail) ) {
            $this->mvtMovementDetailLists->add($p_mvdMovementDetail);
            $p_mvdMovementDetail->setMvdMovement($this);
        }

        return $this;
    }

    /**
     * @param BcsMovementDetail $p_mvdMovementDetail
     * @return $this
     */
    public function removeMvtMovementDetailList(BcsMovementDetail $p_mvdMovementDetail){
//		dump($this->mofAddressLists);die;
        if ( $this->mvtMovementDetailLists->contains($p_mvdMovementDetail) ) {
            $this->mvtMovementDetailLists->removeElement($p_mvdMovementDetail);
            $p_mvdMovementDetail->setMvdMovement(null);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMvtMovementType()
    {
        return $this->mvtMovementType;
    }

    /**
     * @param mixed $mvtMovementType
     */
    public function setMvtMovementType($mvtMovementType)
    {
        $this->mvtMovementType = $mvtMovementType;
    }

    /**
     * @return mixed
     */
    public function getMvtOrder()
    {
        return $this->mvtOrder;
    }

    /**
     * @param mixed $mvtOrder
     */
    public function setMvtOrder($mvtOrder)
    {
        $this->mvtOrder = $mvtOrder;
    }

    /**
     * @return bool
     */
    public function isMvtIsDraft()
    {
        return $this->mvtIsDraft;
    }

    /**
     * @param bool $mvtIsDraft
     */
    public function setMvtIsDraft($mvtIsDraft)
    {
        $this->mvtIsDraft = $mvtIsDraft;
    }

}

