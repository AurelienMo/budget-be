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

namespace App\Actions\OperationManual;

use App\Actions\AbstractApiAction;
use App\Domain\Operations\ListOperations\RequestResolver;
use Doctrine\ORM\NonUniqueResultException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListOperation
 */
class ListOperation extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $requestResolver;

    /**
     * ListOperation constructor.
     *
     * @param RequestResolver $requestResolver
     */
    public function __construct(
        RequestResolver $requestResolver
    ) {
        $this->requestResolver = $requestResolver;
    }

    /**
     * @Route("/bank-accounts/{id}/operations", name="list_operations_for_given_account", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NonUniqueResultException
     * @throws \ReflectionException
     *
     * @SWG\Response(
     *     response="200",
     *     description="List all operations.",
     *     ref="#/definitions/ListOperationsOutput"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login.",
     *     ref="#/definitions/JWTErrorOutput"
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Forbidden. You are not allowed to access this ressource.",
     *     ref="#/definitions/HTTPErrorOutput"
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Account not found.",
     *     ref="#/definitions/HTTPErrorOutput"
     * )
     */
    public function listOperations(Request $request)
    {
        $input = $this->requestResolver->resolve($request);
    }
}
