<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsTypeMovement
 *
 * @ORM\Table(name="bcs_type_movement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsTypeMovementRepository")
 */
class BcsTypeMovement
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
     * @ORM\Column(name="tpmCode", type="string", length=20, unique=true)
     */
    private $tpmCode;

    /**
     * @var string
     *
     * @ORM\Column(name="tpmDescription", type="string", length=255)
     */
    private $tpmDescription;


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
     * Set tpmCode
     *
     * @param string $tpmCode
     *
     * @return BcsTypeMovement
     */
    public function setTpmCode($tpmCode)
    {
        $this->tpmCode = $tpmCode;

        return $this;
    }

    /**
     * Get tpmCode
     *
     * @return string
     */
    public function getTpmCode()
    {
        return $this->tpmCode;
    }

    /**
     * Set tpmDescription
     *
     * @param string $tpmDescription
     *
     * @return BcsTypeMovement
     */
    public function setTpmDescription($tpmDescription)
    {
        $this->tpmDescription = $tpmDescription;

        return $this;
    }

    /**
     * Get tpmDescription
     *
     * @return string
     */
    public function getTpmDescription()
    {
        return $this->tpmDescription;
    }
}

