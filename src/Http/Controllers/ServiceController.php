<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceInputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceRequestModel;

/**
 * Class ServiceController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class ServiceController extends Controller
{
    /**
     * Service input port interactor instance
     * @var ServiceInputPort
     */
    private ServiceInputPort $interactor;

    /**
     * ServiceController constructor.
     * @param ServiceInputPort $interactor
     * @return void
     */
    public function __construct(ServiceInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param Request $request
     * @param string|null $identifier
     * @return Response|null
     */
    public function __invoke(Request $request, ?string $identifier = null): ?Response
    {
        $viewModel = $this->interactor->service(
            new ServiceRequestModel($request, $identifier)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
