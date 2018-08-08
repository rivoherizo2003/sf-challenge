<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BcsSetting
 *
 * @ORM\Table(name="bcs_setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsSettingRepository")
 */
class BcsSetting
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
     * @ORM\Column(name="setCode", type="string", length=30, unique=true)
     */
    private $setCode;

    /**
     * @var string
     *
     * @ORM\Column(name="setDescription", type="string", length=255, nullable=true)
     */
    private $setDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="setValue", type="string", length=255, nullable=true)
     */
    private $setValue;


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
     * Set setCode
     *
     * @param string $setCode
     *
     * @return BcsSetting
     */
    public function setSetCode($setCode)
    {
        $this->setCode = $setCode;

        return $this;
    }

    /**
     * Get setCode
     *
     * @return string
     */
    public function getSetCode()
    {
        return $this->setCode;
    }

    /**
     * Set setDescription
     *
     * @param string $setDescription
     *
     * @return BcsSetting
     */
    public function setSetDescription($setDescription)
    {
        $this->setDescription = $setDescription;

        return $this;
    }

    /**
     * Get setDescription
     *
     * @return string
     */
    public function getSetDescription()
    {
        return $this->setDescription;
    }

    /**
     * Set setValue
     *
     * @param string $setValue
     *
     * @return BcsSetting
     */
    public function setSetValue($setValue)
    {
        $this->setValue = $setValue;

        return $this;
    }

    /**
     * Get setValue
     *
     * @return string
     */
    public function getSetValue()
    {
        return $this->setValue;
    }
}

