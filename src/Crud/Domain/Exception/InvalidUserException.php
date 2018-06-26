<?php

namespace Crud\Domain\Exception;

use Ramsey\Uuid\UuidInterface;

/**
 * Class InvalidUserException
 *
 * @package Crud\Domain\Exception
 */
class InvalidUserException extends \DomainException
{
    /**
     * Throw exception for specified user
     *
     * @param UuidInterface $id
     * @return InvalidUserException
     */
    public static function forId(UuidInterface $id, array $errors = [])
    {
        return new self(
            sprintf(
                'Niepoprawny użytkownik o identyfikatorze: %s',
                $id
            ) . ($errors ? "\n" . implode("\n", $errors) : '')
        );
    }
}
