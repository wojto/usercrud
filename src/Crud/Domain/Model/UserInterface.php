<?php

namespace Crud\Domain\Model;

use Crud\Domain\Model\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface for User class
 *
 * @package Crud\Domain\Model
 */
interface UserInterface
{
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface;

//    /**
//     * @param null|UuidInterface $roleId
//     * @return UserInterface
//     */
//    public function setRoleId(?UuidInterface $roleId): UserInterface;
//
//    /**
//     * @return UuidInterface|null
//     */
//    public function getRoleId():? UuidInterface;

    /**
     * @param RoleInterface $role
     * @return UserInterface
     */
    public function setRole(RoleInterface $role): UserInterface;

    /**
     * Get role
     *
     * @return RoleInterface
     */
    public function getRole(): RoleInterface;

    /**
     * @param string $name
     * @return UserInterface
     */
    public function setName(string $name): UserInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param Email $email
     * @return UserInterface
     */
    public function setEmail(Email $email): UserInterface;

    /**
     * @return Email
     */
    public function getEmail(): Email;

    /**
     * @param string $twitterHandle
     * @return UserInterface
     */
    public function setTwitterHandle(string $twitterHandle): UserInterface;

    /**
     * @return string
     */
    public function getTwitterHandle():? string;

    /**
     * @param string $password
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime;

    /**
     * @param \DateTime $modified
     * @return UserInterface
     */
    public function setModified(\DateTime $modified): UserInterface;

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime;
}
