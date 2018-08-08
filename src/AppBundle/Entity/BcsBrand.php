<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsBrand
 *
 * @ORM\Table(name="bcs_brand")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsBrandRepository")
 */
class BcsBrand
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
     * @ORM\Column(name="brdName", type="string", length=100, unique=true)
     */
    private $brdName;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BcsSupplier", cascade={"persist","remove"}, inversedBy="splBrandLists")
     */
    protected $brdSupplier;


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
     * Set brdName
     *
     * @param string $brdName
     *
     * @return BcsBrand
     */
    public function setBrdName($brdName)
    {
        $this->brdName = $brdName;

        return $this;
    }

    /**
     * Get brdName
     *
     * @return string
     */
    public function getBrdName()
    {
        return $this->brdName;
    }

    /**
     * @return mixed
     */
    public function getBrdSupplier()
    {
        return $this->brdSupplier;
    }

    /**
     * @param mixed $brdSupplier
     */
    public function setBrdSupplier($brdSupplier)
    {
        $this->brdSupplier = $brdSupplier;
    }


}

