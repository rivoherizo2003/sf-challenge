<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * BcsSupplier
 *
 * @ORM\Table(name="bcs_supplier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsSupplierRepository")
 */
class BcsSupplier
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
     * @ORM\Column(name="splCode", type="string", length=20, unique=true)
     */
    private $splCode;

    /**
     * @var string
     *
     * @ORM\Column(name="splName", type="string", length=255)
     */
    private $splName;

    /**
     * @var string
     *
     * @ORM\Column(name="splAddress", type="string", length=255)
     */
    private $splAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="splPhone", type="string", length=50, nullable=true)
     */
    private $splPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="splMail", type="string", length=150, nullable=true)
     */
    private $splMail;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BcsBrand", cascade={"persist"}, mappedBy="brdSupplier", orphanRemoval=true)
     */
    private $splBrandLists;


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
     * Set splCode
     *
     * @param string $splCode
     *
     * @return BcsSupplier
     */
    public function setSplCode($splCode)
    {
        $this->splCode = $splCode;

        return $this;
    }

    /**
     * Get splCode
     *
     * @return string
     */
    public function getSplCode()
    {
        return $this->splCode;
    }

    /**
     * Set splName
     *
     * @param string $splName
     *
     * @return BcsSupplier
     */
    public function setSplName($splName)
    {
        $this->splName = $splName;

        return $this;
    }

    /**
     * Get splName
     *
     * @return string
     */
    public function getSplName()
    {
        return $this->splName;
    }

    /**
     * Set splAddress
     *
     * @param string $splAddress
     *
     * @return BcsSupplier
     */
    public function setSplAddress($splAddress)
    {
        $this->splAddress = $splAddress;

        return $this;
    }

    /**
     * Get splAddress
     *
     * @return string
     */
    public function getSplAddress()
    {
        return $this->splAddress;
    }

    /**
     * Set splPhone
     *
     * @param string $splPhone
     *
     * @return BcsSupplier
     */
    public function setSplPhone($splPhone)
    {
        $this->splPhone = $splPhone;

        return $this;
    }

    /**
     * Get splPhone
     *
     * @return string
     */
    public function getSplPhone()
    {
        return $this->splPhone;
    }

    /**
     * Set splMail
     *
     * @param string $splMail
     *
     * @return BcsSupplier
     */
    public function setSplMail($splMail)
    {
        $this->splMail = $splMail;

        return $this;
    }

    /**
     * Get splMail
     *
     * @return string
     */
    public function getSplMail()
    {
        return $this->splMail;
    }

    /**
     * @return mixed
     */
    public function getSplBrandLists()
    {
        return $this->splBrandLists;
    }

    public function __construct()
    {
        $this->splBrandLists = new ArrayCollection();
    }

    /**
     * @param BcsBrand $p_brdBrand
     * @return BcsSupplier
     */
    public function addSplBrandList(BcsBrand $p_brdBrand){
        if ( !$this->splBrandLists->contains($p_brdBrand) ) {
            $this->splBrandLists->add($p_brdBrand);
            $p_brdBrand->setBrdSupplier($this);
        }

        return $this;
    }

    /**
     * @param BcsBrand $p_brdBrand
     * @return BcsSupplier
     */
    public function removeSplBrandList(BcsBrand $p_brdBrand){
//		dump($this->mofAddressLists);die;
        if ( $this->splBrandLists->contains($p_brdBrand) ) {
            $this->splBrandLists->removeElement($p_brdBrand);
            $p_brdBrand->setBrdSupplier(null);
        }

        return $this;
    }
}

