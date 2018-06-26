<?php

namespace Crud\Domain\Model;

use Crud\Domain\Model\ValueObject\Email;
use Ramsey\Uuid\Uuid;
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
    private $twitterHandle;

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
     * @var Role
     */
    private $role;

    /**
     * User constructor.
     * @param Role|null $role
     * @param string $name
     * @param Email $email
     * @param string $twitterHandle
     * @param string $password
     */
    public function __construct(
        Role $role,
        string $name,
        Email $email,
        $twitterHandle,
        $password
    )
    {
        $this->id = Uuid::uuid4();
        $this->role = $role;
        $this->name = $name;
        $this->email = $email;
        $this->twitterHandle = $twitterHandle;
        $this->password = $password;

        $this->created = new \DateTime();
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

//    /**
//     * @param null|UuidInterface $roleId
//     * @return UserInterface
//     */
//    public function setRoleId(?UuidInterface $roleId): UserInterface
//    {
//        $this->roleId = $roleId;
//
//        return $this;
//    }

//    /**
//     * Get role id
//     *
//     * @return UuidInterface
//     */
//    public function getRoleId():? UuidInterface
//    {
//        return $this->roleId;
//    }

    /**
     * @param RoleInterface $role
     * @return UserInterface
     */
    public function setRole(RoleInterface $role): UserInterface
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return RoleInterface
     */
    public function getRole(): RoleInterface
    {
        return $this->role;
    }

    /**
     * @param string $name
     * @return UserInterface
     */
    public function setName(string $name): UserInterface
    {
        $this->name = $name;

        return $this;
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
     * @param Email $email
     * @return UserInterface
     */
    public function setEmail(Email $email): UserInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return Email
     */
    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    /**
     * @param string $twitterHandle
     * @return UserInterface
     */
    public function setTwitterHandle(string $twitterHandle): UserInterface
    {
        $this->twitterHandle = $twitterHandle;

        return $this;
    }

    /**
     * Get Twitter handle
     *
     * @return string
     */
    public function getTwitterHandle():? string
    {
        return $this->twitterHandle;
    }

    /**
     * @param string $password
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface
    {
        $this->password = $password;

        return $this;
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
     * @param \DateTime $modified
     * @return UserInterface
     */
    public function setModified(\DateTime $modified): UserInterface
    {
        $this->modified = $modified;

        return $this;
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
