<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetInputPort;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\Get\ACLPolicyGetRequestModel;

/**
 * Class ACLPolicyGetController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class ACLPolicyGetController extends Controller
{
    /**
     * Input port interactor instance
     * @var ACLPolicyGetInputPort
     */
    private ACLPolicyGetInputPort $interactor;

    /**
     * ACLPolicyGetController constructor.
     * @param ACLPolicyGetInputPort $interactor
     * @return void
     */
    public function __construct(ACLPolicyGetInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param Request $request
     * @param string $policyID
     * @return Response|null
     */
    public function __invoke(Request $request, string $policyID): ?Response
    {
        $viewModel = $this->interactor->get(
            new ACLPolicyGetRequestModel($request, $policyID)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
