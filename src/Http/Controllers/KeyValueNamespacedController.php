<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\Namespaced\KeyValueNamespacedRequestModel;

/**
 * Class KeyValueNamespacedController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class KeyValueNamespacedController extends Controller
{
    /**
     * Key Value Namespaced input interactor instance
     * @var KeyValueNamespacedInputPort
     */
    private KeyValueNamespacedInputPort $interactor;

    /**
     * KeyValueNamespacedController constructor.
     * @param KeyValueNamespacedInputPort $interactor
     * @return void
     */
    public function __construct(KeyValueNamespacedInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    public function __invoke(Request $request): ?Response
    {
        $viewModel = $this->interactor->namespaced(
            new KeyValueNamespacedRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
