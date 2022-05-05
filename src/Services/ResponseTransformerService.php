<?php

namespace ConsulConfigManager\Consul\Services;

use Illuminate\Support\Str;

/**
 * Class ResponseTransformerService
 *
 * @package ConsulConfigManager\Consul\Services
 */
class ResponseTransformerService
{
    /**
     * Array which contains raw response from the Consul API
     * @var array
     */
    private array $rawResponse;

    /**
     * Array which contains formatted response
     * @var array
     */
    private array $formattedResponse = [];

    /**
     * Map for keys to be transformed
     * @var array
     */
    private array $keysMap = [];

    /**
     * Map for keys which start with given substring to be transformed
     * @var array
     */
    private array $startsWithMap = [];

    /**
     * Map for keys which end with given substring to be transformed
     * @var array
     */
    private array $endsWithMap = [];

    /**
     * Map for keys which contain given substring
     * @var array
     */
    private array $containsMap = [];

    /**
     * ResponseTransformerService Constructor.
     *
     * @param array $response
     *
     * @return void
     */
    public function __construct(array $response)
    {
        $this->rawResponse = $response;
    }

    /**
     * Tell service to load keys mappings
     * @param array $keysMap
     *
     * @return $this
     */
    public function mapKeys(array $keysMap): self
    {
        $this->keysMap = $keysMap;
        return $this;
    }

    /**
     * Tell service to load map for keys starting with given substring
     * @param array $keysMap
     *
     * @return $this
     */
    public function mapKeysStartingWith(array $keysMap): self
    {
        $this->startsWithMap = $keysMap;
        return $this;
    }

    /**
     * Tell service to load map for keys ending with given substring
     * @param array $keysMap
     *
     * @return $this
     */
    public function mapKeysEndingWith(array $keysMap): self
    {
        $this->endsWithMap = $keysMap;
        return $this;
    }

    /**
     * Tell service to load map for keys containing given substring
     * @param array $keysMap
     *
     * @return $this
     */
    public function mapContains(array $keysMap): self
    {
        $this->containsMap = $keysMap;
        return $this;
    }

    /**
     * Get raw response array
     * @return array
     * @codeCoverageIgnore
     */
    public function getRawResponse(): array
    {
        return $this->rawResponse;
    }

    /**
     * Get formatted response array
     * @return array
     */
    public function getFormattedResponse(): array
    {
        return $this->runTransformer()->formattedResponse;
    }

    /**
     * Run transformer
     * @return $this
     */
    protected function runTransformer(): self
    {
        $this->formattedResponse = $this->performKeysMapping($this->rawResponse);
        return $this;
    }

    /**
     * Perform mapping of keys
     * @param array $sourceData
     *
     * @return array
     */
    private function performKeysMapping(array $sourceData): array
    {
        $result = [];
        foreach ($sourceData as $key => $value) {
            $originalKey = $key;
            if (array_key_exists($key, $this->keysMap) || isset($this->keysMap[$key])) {
                $key = $this->keysMap[$key];
            }

            foreach ($this->endsWithMap as $substring => $replace) {
                if (Str::endsWith($key, $substring)) {
                    $key = mb_substr($key, 0, (-1 * abs(mb_strlen($substring)))) . $replace;
                    break;
                }
            }

            foreach ($this->startsWithMap as $substring => $replace) {
                if (Str::startsWith($key, $substring)) {
                    $key = $replace . mb_substr($key, mb_strlen($substring));
                    break;
                }
            }

            foreach ($this->containsMap as $substring => $replace) {
                if (str_contains($key, $substring)) {
                    $key = str_replace($substring, $replace, $key);
                }
            }

            $key = Str::snake($key);

            if (is_array($value)) {
                $result[$key] = $this->performKeysMapping($value);
            } else {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
