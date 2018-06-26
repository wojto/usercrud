<?php

namespace Crud\Domain\Exception;

use Ramsey\Uuid\UuidInterface;

/**
 * Class UserNotFoundException
 *
 * @package Crud\Domain\Exception
 */
class UserNotFoundException extends \RuntimeException
{
    /**
     * Throw not found exception for specified user
     *
     * @param  UuidInterface $id
     * @return UserNotFoundException
     */
    public static function forId(UuidInterface $id)
    {
        return new self(
            sprintf(
                'Użytkownik o identyfikatorze: %s nie istnieje',
                $id
            )
        );
    }
}
