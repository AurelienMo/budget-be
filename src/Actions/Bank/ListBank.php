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
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListBank
 */
class ListBank extends AbstractApiAction
{
    /**
     * @Route("/banks", name="list_bank_account", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
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
     */
    public function listBank(Request $request)
    {
    }
}
