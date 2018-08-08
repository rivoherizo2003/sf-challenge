<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsUnitOfMeasure
 *
 * @ORM\Table(name="bcs_unit_of_measure")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsUnitOfMeasureRepository")
 */
class BcsUnitOfMeasure
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
     * @ORM\Column(name="uomCode", type="string", length=10, unique=true)
     */
    private $uomCode;

    /**
     * @var string
     *
     * @ORM\Column(name="uomDescription", type="string", length=255, nullable=true)
     */
    private $uomDescription;


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
     * Set uomCode
     *
     * @param string $uomCode
     *
     * @return BcsUnitOfMeasure
     */
    public function setUomCode($uomCode)
    {
        $this->uomCode = $uomCode;

        return $this;
    }

    /**
     * Get uomCode
     *
     * @return string
     */
    public function getUomCode()
    {
        return $this->uomCode;
    }

    /**
     * Set uomDescription
     *
     * @param string $uomDescription
     *
     * @return BcsUnitOfMeasure
     */
    public function setUomDescription($uomDescription)
    {
        $this->uomDescription = $uomDescription;

        return $this;
    }

    /**
     * Get uomDescription
     *
     * @return string
     */
    public function getUomDescription()
    {
        return $this->uomDescription;
    }
}

