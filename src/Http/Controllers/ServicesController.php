<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Services\ServicesInputPort;
use ConsulConfigManager\Consul\Domain\Service\UseCases\Service\ServiceRequestModel;

/**
 * Class ServicesController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class ServicesController extends Controller
{
    /**
     * Services interactor instance
     * @var ServicesInputPort
     */
    private ServicesInputPort $interactor;

    /**
     * ServicesController constructor.
     * @param ServicesInputPort $interactor
     * @return void
     */
    public function __construct(ServicesInputPort $interactor)
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
        $viewModel = $this->interactor->services(
            new ServiceRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }
        return null;
    }

    // @codeCoverageIgnoreEnd
}
