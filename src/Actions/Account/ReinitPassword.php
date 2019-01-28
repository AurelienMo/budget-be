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
use App\Domain\Account\ResetPassword\Persister;
use App\Domain\Account\ResetPassword\RequestResolver;
use App\Domain\Common\Exceptions\ValidatorException;
use Doctrine\ORM\NonUniqueResultException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReinitPassword
 */
class ReinitPassword extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $resolver;

    /** @var Persister */
    protected $persister;

    /**
     * ReinitPassword constructor.
     *
     * @param RequestResolver $resolver
     * @param Persister       $persister
     */
    public function __construct(
        RequestResolver $resolver,
        Persister $persister
    ) {
        $this->persister = $persister;
        $this->resolver = $resolver;
    }

    /**
     * @Route("/accounts/define-new-password", name="define_new_password", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidatorException
     * @throws NonUniqueResultException
     *
     * @SWG\Response(
     *     response="200",
     *     description="Successful reinit password",
     *     ref="#/definitions/AuthenticationOutput"
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Bad rquest. Please check your request."
     * )
     */
    public function reinitPassword(Request $request)
    {
        $input = $this->resolver->resolve($request);
        $output = $this->persister->save($input);

        return $this->sendResponse($output);
    }
}
