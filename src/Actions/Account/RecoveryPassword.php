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
use App\Domain\Account\RecoveryPassword\Persister;
use App\Domain\Account\RecoveryPassword\RequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use Doctrine\ORM\NonUniqueResultException;
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

    /** @var Persister */
    protected $persister;

    /**
     * RecoveryPassword constructor.
     *
     * @param RequestResolver $resolver
     * @param Persister       $persister
     */
    public function __construct(
        RequestResolver $resolver,
        Persister $persister
    ) {
        $this->resolver = $resolver;
        $this->persister = $persister;
    }

    /**
     * @Route("/accounts/recovery-password", name="recovery_passwordd", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidatorException
     * @throws NonUniqueResultException
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
        $output = $this->persister->save($input);

        return $this->sendResponse($output, Response::HTTP_CREATED);
    }
}
