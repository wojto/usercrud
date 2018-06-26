<?php

namespace Crud\Domain\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Role class
 */
class Role implements RoleInterface
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $passwordPolicy;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $modified;

    /**
     * @var array
     */
    private $users;

    /**
     * User constructor.
     * @param UuidInterface $id
     * @param string $name
     * @param string $passwordPolicy
     */
    public function __construct(
        UuidInterface $id,
        string $name,
        string $passwordPolicy
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->passwordPolicy = $passwordPolicy;
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
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get password policy
     *
     * @return string
     */
    public function getPasswordPolicy(): string
    {
        return $this->passwordPolicy;
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
}
