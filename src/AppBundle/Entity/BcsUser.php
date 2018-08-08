<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * BcsUser
 * @UniqueEntity(fields="usrMail", message="message.mail_already_exist")
 * @ORM\Table(name="bcs_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BcsUserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class BcsUser implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="usrCode", type="string", length=15, unique=true)
     */
    private $usrCode;

    /**
     * @ORM\Column(name="roles", type="json_array", nullable=false)
     */
    private $roles = [];

    /**
     * @var string
     *
     * @ORM\Column(name="usrLastName", type="string", length=255, nullable=false)
     */
    private $usrLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="usrFirstName", type="string", length=255, nullable=false)
     */
    private $usrFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="usrAddress", type="string", length=255, nullable=false)
     */
    private $usrAddress;

    /**
     * @var string
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid e-mail.",
     *     checkMX = false)
     *
     * @ORM\Column(name="usrMail", type="string", length=150, unique=true, nullable=false)
     */
    private $usrMail;

    /**
     * @var int
     *
     * @ORM\Column(name="usrGender", type="integer", length=2, nullable=true, options={"comment":"male 1, female 0"})
     */
    private $usrGender;

    /**
     * @var boolean
     * @ORM\Column(name="usrIsActive", type="boolean", options={"comment":"true if the user is active, false if not"})
     */
    private $usrIsActive = true;

    /**
     * @var boolean
     * @ORM\Column(name="usrIsNotLocked", type="boolean", options={"comment":"true if the user is not locked, false if not"})
     */
    private $usrIsNotLocked = true;

    /**
     * @var boolean
     * @ORM\Column(name="usrIsNonExpired", type="boolean", options={"comment":"true if the user's account is not Expired, false if not"})
     */
    private $usrIsNonExpired = true;

    /**
     * @var boolean
     * @ORM\Column(name="usrIsCredentialsNonExpired", type="boolean", options={"comment":"true if the user's account is not Expired, false if not"})
     */
    private $usrIsCredentialsNonExpired = true;

    /**
     * @var string
     *
     * @ORM\Column(name="usrPhone", type="string", length=30, nullable=false)
     */
    private $usrPhone;

    /**
     * @var string
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "message.minimum_character"
     * )
     *
     * @ORM\Column(name="password", type="text", nullable=true)
     */
    private $password;


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
     * Set usrCode
     *
     * @param string $usrCode
     *
     * @return BcsUser
     */
    public function setUsrCode($usrCode)
    {
        $this->usrCode = $usrCode;

        return $this;
    }

    /**
     * Get usrCode
     *
     * @return string
     */
    public function getUsrCode()
    {
        return $this->usrCode;
    }

    /**
     * Set usrLastName
     *
     * @param string $usrLastName
     *
     * @return BcsUser
     */
    public function setUsrLastName($usrLastName)
    {
        $this->usrLastName = $usrLastName;

        return $this;
    }

    /**
     * Get usrLastName
     *
     * @return string
     */
    public function getUsrLastName()
    {
        return $this->usrLastName;
    }

    /**
     * Set usrFirstName
     *
     * @param string $usrFirstName
     *
     * @return BcsUser
     */
    public function setUsrFirstName($usrFirstName)
    {
        $this->usrFirstName = $usrFirstName;

        return $this;
    }

    /**
     * Get usrFirstName
     *
     * @return string
     */
    public function getUsrFirstName()
    {
        return $this->usrFirstName;
    }

    /**
     * Set usrAddress
     *
     * @param string $usrAddress
     *
     * @return BcsUser
     */
    public function setUsrAddress($usrAddress)
    {
        $this->usrAddress = $usrAddress;

        return $this;
    }

    /**
     * Get usrAddress
     *
     * @return string
     */
    public function getUsrAddress()
    {
        return $this->usrAddress;
    }

    /**
     * Set usrMail
     *
     * @param string $usrMail
     *
     * @return BcsUser
     */
    public function setUsrMail($usrMail)
    {
        $this->usrMail = $usrMail;

        return $this;
    }

    /**
     * Get usrMail
     *
     * @return string
     */
    public function getUsrMail()
    {
        return $this->usrMail;
    }

    /**
     * Set usrPhone
     *
     * @param string $usrPhone
     *
     * @return BcsUser
     */
    public function setUsrPhone($usrPhone)
    {
        $this->usrPhone = $usrPhone;

        return $this;
    }

    /**
     * Get usrPhone
     *
     * @return string
     */
    public function getUsrPhone()
    {
        return $this->usrPhone;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return BcsUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return BcsUser
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set usrGender
     *
     * @param integer $usrGender
     *
     * @return BcsUser
     */
    public function setUsrGender($usrGender)
    {
        $this->usrGender = $usrGender;

        return $this;
    }

    /**
     * Get usrGender
     *
     * @return integer
     */
    public function getUsrGender()
    {
        return $this->usrGender;
    }

    /**
     * Set usrIsActive
     *
     * @param boolean $usrIsActive
     *
     * @return BcsUser
     */
    public function setUsrIsActive($usrIsActive)
    {
        $this->usrIsActive = $usrIsActive;

        return $this;
    }

    /**
     * Get usrIsActive
     *
     * @return boolean
     */
    public function getUsrIsActive()
    {
        return $this->usrIsActive;
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return $this->usrIsNonExpired;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return $this->usrIsNotLocked;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
        return $this->usrIsCredentialsNonExpired;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->usrIsActive;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->usrMail,
            $this->password,
            $this->roles,
            // see section on salt below
//			                  $this->salt,
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->usrMail,
            $this->password,
            $this->roles,
            // see section on salt below
//			 $this->salt
            ) = unserialize($serialized);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->usrMail;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return bool
     */
    public function isUsrIsNotLocked()
    {
        return $this->usrIsNotLocked;
    }

    /**
     * @param bool $usrIsNotLocked
     */
    public function setUsrIsNotLocked($usrIsNotLocked)
    {
        $this->usrIsNotLocked = $usrIsNotLocked;
    }

    /**
     * @return bool
     */
    public function isUsrIsNonExpired()
    {
        return $this->usrIsNonExpired;
    }

    /**
     * @param bool $usrIsNonExpired
     */
    public function setUsrIsNonExpired($usrIsNonExpired)
    {
        $this->usrIsNonExpired = $usrIsNonExpired;
    }

    /**
     * @return bool
     */
    public function isUsrIsCredentialsNonExpired()
    {
        return $this->usrIsCredentialsNonExpired;
    }

    /**
     * @param bool $usrIsCredentialsNonExpired
     */
    public function setUsrIsCredentialsNonExpired($usrIsCredentialsNonExpired)
    {
        $this->usrIsCredentialsNonExpired = $usrIsCredentialsNonExpired;
    }
}
