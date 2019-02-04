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

namespace App\Actions\BankAccount;

use App\Actions\AbstractApiAction;
use App\Domain\BankAccount\ListAccounts\ListAccountsInput;
use App\Domain\BankAccount\ListAccounts\Loader;
use App\Domain\BankAccount\ListAccounts\RequestResolver;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListBankAccount
 */
class ListBankAccount extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $requestResolver;

    /** @var Loader */
    protected $loader;

    /**
     * ListBankAccount constructor.
     *
     * @param RequestResolver $requestResolver
     * @param Loader          $loader
     */
    public function __construct(
        RequestResolver $requestResolver,
        Loader $loader
    ) {
        $this->requestResolver = $requestResolver;
        $this->loader = $loader;
    }

    /**
     * @Route("/bank-accounts", name="list_bank_accounts", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \ReflectionException
     *
     * @SWG\Response(
     *     response="200",
     *     description="Successful list bank accounts",
     *     ref="#/definitions/ListBankAccountOutput"
     * )
     * @SWG\Response(
     *     response="204",
     *     description="No content."
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     ref="#/definitions/JWTErrorOutput"
     * )
     * @Security(name="Bearer")
     */
    public function listBankAccounts(Request $request)
    {
        /** @var ListAccountsInput $input */
        $input = $this->requestResolver->resolve($request);
        $datas = $this->loader->load($input);

        return $this->sendResponse($datas, is_null($datas) ? 204 : 200);
    }
}
