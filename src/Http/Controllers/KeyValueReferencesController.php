<?php

namespace ConsulConfigManager\Consul\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References\KeyValueReferencesInputPort;
use ConsulConfigManager\Consul\Domain\KeyValue\UseCases\References\KeyValueReferencesRequestModel;

/**
 * Class KeyValueReferencesController
 * @package ConsulConfigManager\Consul\Http\Controllers
 */
class KeyValueReferencesController extends Controller
{
    /**
     * Key Value References input interactor instance
     * @var KeyValueReferencesInputPort
     */
    private KeyValueReferencesInputPort $interactor;

    /**
     * KeyValueReferencesController constructor.
     * @param KeyValueReferencesInputPort $interactor
     * @return void
     */
    public function __construct(KeyValueReferencesInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    public function __invoke(Request $request): ?Response
    {
        $viewModel = $this->interactor->references(
            new KeyValueReferencesRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
