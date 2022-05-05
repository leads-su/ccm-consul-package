<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Http\Requests\KeyValueReadRequest;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Read\KeyValueReadRequestModel;

/**
 * Class KeyValueReadController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class KeyValueReadController extends Controller
{
    /**
     * Key Value Read input port interactor instance
     * @var KeyValueReadInputPort
     */
    private KeyValueReadInputPort $interactor;

    /**
     * ServiceController constructor.
     * @param KeyValueReadInputPort $interactor
     * @return void
     */
    public function __construct(KeyValueReadInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param KeyValueReadRequest $request
     * @return Response|null
     */
    public function __invoke(KeyValueReadRequest $request): ?Response
    {
        $viewModel = $this->interactor->read(
            new KeyValueReadRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
