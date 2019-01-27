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

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponder
 */
class JsonResponder
{
    /**
     * @param mixed $datas
     * @param int   $statusCode
     * @param array $headers
     * @param bool  $cacheable
     *
     * @return Response
     */
    public static function response(
        $datas,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        bool $cacheable = false
    ) {
        $response = new Response(
            !is_null($datas) ? $datas : null,
            $statusCode,
            array_merge(
                [
                    'Content-Type' => 'application/json',
                ],
                $headers
            )
        );

        if ($cacheable) {
            $response
                ->setPublic()
                ->setSharedMaxAge(3600)
                ->setMaxAge(3600);
        }

        return $response;
    }
}
