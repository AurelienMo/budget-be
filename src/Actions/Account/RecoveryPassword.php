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

namespace App\Actions\Account;

use App\Actions\AbstractApiAction;
use App\Domain\Account\RecoveryPassword\RequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecoveryPassword
 */
class RecoveryPassword extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $resolver;

    /**
     * RecoveryPassword constructor.
     *
     * @param RequestResolver $resolver
     */
    public function __construct(
        RequestResolver $resolver
    ) {
        $this->resolver = $resolver;
    }

    /**
     * @Route("/accounts/recovery-password", name="recovery_passwordd", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidatorException
     *
     * @SWG\Response(
     *     response="201",
     *     description="Successful recovery password request"
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Bad request. Check your request."
     * )
     */
    public function recoveryPassword(Request $request)
    {
        $input = $this->resolver->resolve($request);
    }
}
