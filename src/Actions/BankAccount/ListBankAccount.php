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
    /**
     * @Route("/bank-accounts", name="list_bank_accounts", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
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
    }
}
