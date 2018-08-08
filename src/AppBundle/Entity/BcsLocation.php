<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsLocation
 *
 * @ORM\Table(name="bcs_location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsLocationRepository")
 */
class BcsLocation
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
     * @ORM\Column(name="locCode", type="string", length=50, unique=true)
     */
    private $locCode;

    /**
     * @var string
     *
     * @ORM\Column(name="locTitle", type="string", length=255)
     */
    private $locTitle;


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
     * Set locCode
     *
     * @param string $locCode
     *
     * @return BcsLocation
     */
    public function setLocCode($locCode)
    {
        $this->locCode = $locCode;

        return $this;
    }

    /**
     * Get locCode
     *
     * @return string
     */
    public function getLocCode()
    {
        return $this->locCode;
    }

    /**
     * Set locTitle
     *
     * @param string $locTitle
     *
     * @return BcsLocation
     */
    public function setLocTitle($locTitle)
    {
        $this->locTitle = $locTitle;

        return $this;
    }

    /**
     * Get locTitle
     *
     * @return string
     */
    public function getLocTitle()
    {
        return $this->locTitle;
    }
}

