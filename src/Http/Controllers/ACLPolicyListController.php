<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListInputPort;
use ConsulConfigManager\Consul\Domain\ACL\Policy\UseCases\List\ACLPolicyListRequestModel;

/**
 * Class ACLPolicyListController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class ACLPolicyListController extends Controller
{
    /**
     * Input port interactor instance
     * @var ACLPolicyListInputPort
     */
    private ACLPolicyListInputPort $interactor;

    /**
     * ACLPolicyListController constructor.
     * @param ACLPolicyListInputPort $interactor
     * @return void
     */
    public function __construct(ACLPolicyListInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param Request $request
     * @return Response|null
     */
    public function __invoke(Request $request): ?Response
    {
        $viewModel = $this->interactor->list(
            new ACLPolicyListRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
