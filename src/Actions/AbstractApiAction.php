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

namespace App\Actions;

use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiAction
 */
abstract class AbstractApiAction
{
    /**
     * @param null|string  $datas
     * @param int   $statusCode
     * @param bool  $cacheable
     * @param array $headers
     *
     * @return Response
     */
    public function sendResponse(
        $datas,
        int $statusCode = Response::HTTP_OK,
        bool $cacheable = false,
        array $headers = []
    ) {
        return JsonResponder::response($datas, $statusCode, $headers, $cacheable);
    }
}
