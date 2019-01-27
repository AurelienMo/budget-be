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

namespace App\Domain\Common\Helpers;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestParamsExtractor
 */
class RequestParamsExtractor
{
    const PATH = 'path';
    const QUERY = 'query';

    /**
     * @param Request $request
     * @param string  $type
     * @param string  $name
     *
     * @return mixed|null
     */
    public static function extractParams(Request $request, string $type, string $name)
    {
        $value = null;
        switch ($type) {
            case self::PATH:
                $value = $request->attributes->get($name);
                break;
            case self::QUERY:
                $value = $request->query->get($name);
                break;
        }

        return $value;
    }
}
