<?php

namespace Crud\Domain\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Interface for Role class
 *
 * @package Crud\Domain\Model
 */
interface RoleInterface
{
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getPasswordPolicy(): string;

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime;
}
