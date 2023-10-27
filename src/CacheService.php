<?php

namespace Cachetastic;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    /**
     * Retrieve data from cache or an external API, caching the result if needed.
     *
     * @param mixed $service The service or object to call the method on.
     * @param string $method The name of the method to call on the service.
     * @param array $params An array of parameters to pass to the method.
     * @param int $cacheDuration The duration (in minutes) to cache the result.
     * @return mixed The cached or fetched data.
     */
    public function retrieveOrCache($service, string $method, array $params, int $cacheDuration = 60)
    {
        $cacheKey = $this->generateCacheKey($method, $params);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($service, $method, $params) {
            // Attempt to fetch data from an external source
            return $service->$method(...$params);
        });
    }

    /**
     * Force a refresh of the cached data and optionally update it with a new value.
     *
     * @param string $method The name of the method to refresh.
     * @param array $params An array of parameters to identify the cached data.
     * @param mixed $newValue The new value to store in the cache (optional).
     * @param int $cacheDuration The duration (in minutes) to cache the new value (optional).
     */
    public function forceRefresh(string $method, array $params, $newValue = null, int $cacheDuration = 60)
    {
        $cacheKey = $this->generateCacheKey($method, $params);

        // Delete the cached data for the specified method and parameters
        Cache::forget($cacheKey);

        if ($newValue !== null) {
            // Update the cache with a new value if provided
            Cache::put($cacheKey, $newValue, $cacheDuration);
        }
    }

    /**
     * Generate a cache key based on the method name and its parameters.
     *
     * @param string $method The name of the method.
     * @param array $params An array of parameters.
     * @return string The generated cache key.
     */
    private function generateCacheKey(string $method, array $params): string
    {
        // Create a cache key based on the method name and its parameters
        return sprintf('%s:%s', $method, implode('_', $params));
    }
}