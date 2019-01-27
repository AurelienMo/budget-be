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
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ErrorResponder
 */
class ErrorResponder
{
    /** @var SerializerInterface */
    private $serializer;
    /**
     * ErrorResponder constructor.
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }
    /**
     * @param array $datas
     * @param int   $statusCode
     *
     * @return Response
     */
    public function response($datas, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return new Response(
            $this->serializer->serialize($datas, 'json'),
            $statusCode,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
