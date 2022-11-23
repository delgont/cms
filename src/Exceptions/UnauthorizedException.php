<?php

namespace Delgont\Cms\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    public static function notLoggedIn(): self
    {
        return new static(403, 'User is not logged in.', null, []);
    }

    public static function userHasNoPermission($permission_key) : self
    {
        return $exception = new static(403);
    }

}
