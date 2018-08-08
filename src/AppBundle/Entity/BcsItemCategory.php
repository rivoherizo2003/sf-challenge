<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsItemCategory
 *
 * @ORM\Table(name="bcs_item_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsItemCategoryRepository")
 */
class BcsItemCategory
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
     * @ORM\Column(name="itcDescription", type="string", length=255)
     */
    private $itcDescription;


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
     * Set itcDescription
     *
     * @param string $itcDescription
     *
     * @return BcsItemCategory
     */
    public function setItcDescription($itcDescription)
    {
        $this->itcDescription = $itcDescription;

        return $this;
    }

    /**
     * Get itcDescription
     *
     * @return string
     */
    public function getItcDescription()
    {
        return $this->itcDescription;
    }
}

