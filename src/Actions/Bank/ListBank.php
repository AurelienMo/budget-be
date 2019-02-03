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

namespace App\Actions\Bank;

use App\Actions\AbstractApiAction;
use App\Domain\Bank\ListBank\ListBankInput;
use App\Domain\Bank\ListBank\Loader;
use App\Domain\Bank\ListBank\RequestResolver;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListBank
 */
class ListBank extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $resolver;

    /** @var Loader */
    protected $loader;

    /**
     * ListBank constructor.
     *
     * @param RequestResolver $resolver
     * @param Loader          $loader
     */
    public function __construct(
        RequestResolver $resolver,
        Loader $loader
    ) {
        $this->resolver = $resolver;
        $this->loader = $loader;
    }

    /**
     * @Route("/banks", name="list_bank_account", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \ReflectionException
     *
     * @SWG\Response(
     *     response="200",
     *     description="Successfull list bank according given parameters",
     *     ref="#/definitions/ListBankOutput"
     * )
     * @SWG\Response(
     *     response="204",
     *     description="No content"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     ref="#/definitions/JWTErrorOutput"
     * )
     * @Security(name="Bearer")
     */
    public function listBank(Request $request)
    {
        /** @var ListBankInput $input */
        $input = $this->resolver->resolve($request);
        $output = $this->loader->load($input);

        return $this->sendResponse(
            $output,
            !is_null($output) ? Response::HTTP_OK : Response::HTTP_NO_CONTENT
        );
    }
}
