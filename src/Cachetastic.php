<?php

namespace Cachetastic;

use Illuminate\Support\Facades\Cache;

class Cachetastic
{
    /**
     * The service or object to call the method on.
     *
     * @var mixed
     */
    private $service;

    /**
     * The name of the method to call on the service.
     *
     * @var string
     */
    private $method;

    /**
     * An array of parameters to pass to the method.
     *
     * @var array
     */
    private $params;

    /**
     * The duration (in minutes) to cache the result.
     *
     * @var int
     */
    private $cacheDuration = 60;

    /**
     * An array of parameter keys to use for cache key generation.
     *
     * @var array
     */
    private $cacheKeyParams = [];

    /**
     * A custom cache key to be used instead of generating one.
     *
     * @var string|null
     */
    private $customCacheKey = null;

    /**
     * Create a new Cachetastic instance.
     *
     * @param mixed $service The service or object to call the method on.
     * @param string $method The name of the method to call on the service.
     * @param array $params An array of parameters to pass to the method.
     */
    public function __construct($service, string $method, array $params)
    {
        $this->service = $service;
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * Set the cache duration in minutes.
     *
     * @param int $cacheDuration The duration (in minutes) to cache the result.
     * @return $this
     */
    public function setCacheDuration(int $cacheDuration): Cachetastic
    {
        $this->cacheDuration = $cacheDuration;
        return $this;
    }

    /**
     * Set parameter names to use for cache key generation.
     *
     * @param array $cacheKeyParams An array of parameter names to use for cache key generation.
     * @return $this
     */
    public function setCacheKeyParams(array $cacheKeyParams): Cachetastic
    {
        $this->cacheKeyParams = $cacheKeyParams;
        return $this;
    }

    /**
     * Set a custom cache key to be used instead of generating one.
     *
     * @param string $customCacheKey A custom cache key.
     * @return $this
     */
    public function setCustomCacheKey(string $customCacheKey): Cachetastic
    {
        $this->customCacheKey = $customCacheKey;
        return $this;
    }

    /**
     * Retrieve data from cache or an external API, caching the result if needed.
     *
     * @return mixed The cached or fetched data.
     */
    public function retrieveOrCache()
    {
        $cacheKey = $this->generateCacheKey();

        return Cache::remember($cacheKey, $this->cacheDuration, function () {
            return call_user_func_array([$this->service, $this->method], $this->params);
        });
    }

    /**
     * Force a refresh of the cached data.
     */
    public function forceRefresh($regenerate = true)
    {
        $cacheKey = $this->generateCacheKey();
        Cache::forget($cacheKey);

        return $regenerate ? $this->retrieveOrCache() : null;
    }

    /**
     * Generate a cache key based on options.
     *
     * @return string The generated cache key.
     */
    private function generateCacheKey(): string
    {
        $method = $this->method;
        $params = $this->params;
        $cacheKeyParams = $this->cacheKeyParams;
        $customCacheKey = $this->customCacheKey;
        $cacheKeyComponents = [];

        $paramsToUse = empty($cacheKeyParams) ? $params : array_intersect_key($params, array_flip($cacheKeyParams));

        if ($customCacheKey) {
            return $customCacheKey;
        }

        foreach ($paramsToUse as $value) {
            if (is_array($value)) {
                continue;
            }

            $cacheKeyComponents[] = $value;
        }

        return sprintf('%s:%s', $method, implode('_', $cacheKeyComponents));
    }
}
