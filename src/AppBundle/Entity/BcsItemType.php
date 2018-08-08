<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsItemType
 *
 * @ORM\Table(name="bcs_item_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsItemTypeRepository")
 */
class BcsItemType
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
     * @ORM\Column(name="ittDescription", type="string", length=255)
     */
    private $ittDescription;


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
     * Set ittDescription
     *
     * @param string $ittDescription
     *
     * @return BcsItemType
     */
    public function setIttDescription($ittDescription)
    {
        $this->ittDescription = $ittDescription;

        return $this;
    }

    /**
     * Get ittDescription
     *
     * @return string
     */
    public function getIttDescription()
    {
        return $this->ittDescription;
    }
}

