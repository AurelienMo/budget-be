<?php

declare(strict_types=1);

/*
 * This file is part of budget-be
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Common\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ProcessorErrorsHttp
 */
class ProcessorErrorsHttp
{
    public static function throwNotFound(string $message)
    {
        throw new HttpException(
            Response::HTTP_NOT_FOUND,
            $message
        );
    }
    public static function throwAccessDenied(string $message)
    {
        throw new HttpException(
            Response::HTTP_FORBIDDEN,
            $message
        );
    }
    public static function throwInternalError(string $message)
    {
        throw new HttpException(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $message
        );
    }
}
