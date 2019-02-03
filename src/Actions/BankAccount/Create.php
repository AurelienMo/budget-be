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
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Create
 */
class Create extends AbstractApiAction
{
    /**
     * @Route("/bank-accounts", name="create_bank_account", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response="201",
     *     description="Successful bank account creation",
     *     ref="#/definitions/ListBankAccountOutput"
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Bad request. Check your request"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     ref="#/definitions/JWTErrorOutput"
     * )
     */
    public function create(Request $request)
    {
    }
}
