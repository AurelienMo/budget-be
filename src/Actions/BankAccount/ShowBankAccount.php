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
 * Class ShowBankAccount
 */
class ShowBankAccount extends AbstractApiAction
{
    /**
     * @Route("/bank-accounts/{id}", name="show_bank_accounts", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response="200",
     *     description="Successful description",
     *     ref="#/definitions/ListDetailBankOutput"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     ref="#/definitions/JWTErrorOutput"
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Forbidden. You are not allowed to access this ressource",
     *     ref="#/definitions/HTTPErrorOutput"
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Not found. Bank account not found.",
     *     ref="#/definitions/HTTPErrorOutput"
     * )
     * @Security(name="Bearer")
     */
    public function showBankAccount(Request $request)
    {
    }
}
