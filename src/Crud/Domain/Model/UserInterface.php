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

    /**
     * @return UuidInterface|null
     */
    public function getRoleId();

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return Email
     */
    public function getEmail(): Email;

    /**
     * @return string
     */
    public function getTwitterHandle(): string;

    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime;
}
