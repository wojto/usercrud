<?php

namespace Crud\Domain\Model;

use Crud\Domain\Model\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface as UserSecurityInterface;

/**
 * User class
 */
class User implements UserInterface, UserSecurityInterface, \Serializable
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var UuidInterface|null
     */
    private $roleId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var string
     */
    private $twitterHandler;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * User constructor.
     * @param UuidInterface $id
     * @param UuidInterface $roleId
     * @param string $name
     * @param Email $email
     * @param string $twitterhandler
     * @param string $password
     */
    public function __construct(
        UuidInterface $id,
        UuidInterface $roleId,
        string $name,
        Email $email,
        string $twitterhandler,
        string $password
    )
    {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->name = $name;
        $this->email = $email;
        $this->twitterHandler = $twitterhandler;
        $this->password = $password;
    }

    /**
     * Get id
     *
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * Get role id
     *
     * @return UuidInterface
     */
    public function getRoleId(): UuidInterface
    {
        return $this->roleId;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get email
     *
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * Get Twitter handler
     *
     * @return string
     */
    public function getTwitterHandle(): string
    {
        return $this->twitterHandler;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * Get salt
     *
     * @return string|null
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Return user roles
     *
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Clear user credentials
     */
    public function eraseCredentials()
    {
    }

    /**
     * Serialize user data
     *
     * @return string
     * @see    \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(
            array(
                $this->id,
                $this->email,
                $this->password,
            )
        );
    }

    /**
     * Unserialize user data
     *
     * @param string $serialized
     * @see   \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list ($this->id, $this->email, $this->password) = unserialize($serialized);
    }
}
