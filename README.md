<p align="center"><img src="cachetastic.png" alt="frankenstein" height="300px"></p>

# Cachetastic - Supercharge Your Laravel Caching!

## Table of Contents
- [Introduction](#introduction)
- [Key Features](#key-features)
- [Use Cases](#use-cases)
- [Getting Started](#getting-started)
- [Examples](#examples)
- [Overwriting Cache Keys](#overwriting-cache-keys)
- [Contributing](#contributing)
- [License](#license)

## Introduction
Welcome to Cachetastic, your secret weapon for optimizing caching in Laravel applications. This package supercharges your Laravel caching capabilities, making it a breeze to cache method results and improve your application's performance. Say goodbye to redundant API calls and database queries, and hello to lightning-fast responses!

## Key Features
- **Method-Level Caching**: Cache the results of any method, whether regular or static, with ease.
- **Flexible Cache Management**: Force-refresh and update cache with new values on-demand.
- **Automatic Cache Key Generation**: Cache keys are generated based on method name and parameters.
- **Custom Parameter Keys**: Users can specify parameter keys for cache key generation.
- **Laravel Integration**: Seamlessly integrates with Laravel's caching system.
- **Clean and Elegant Code**: Well-structured and efficient codebase for easy use and contribution.
- **PHPUnit and Mockery Read**y: Unit testing with PHPUnit and Mockery support included.

## Use Cases
Cachetastic is the perfect addition to your Laravel project for various use cases:

- **API Responses**: Cache responses from external APIs to reduce latency and minimize rate limits.
- **Database Queries**: Cache complex database queries and boost query performance.
- **Expensive Computation**: Cache the results of computationally intensive methods for faster execution.
- **Dynamic Content**: Cache dynamic content to reduce server load and improve user experience.
- **Rate-Limited APIs**: Avoid exceeding rate limits by caching API responses and serving cached data.

Cachetastic is your go-to tool for optimizing your Laravel application's performance in a snap!

## Getting Started
Getting started with Cachetastic is a piece of cake. Follow these simple steps to integrate it into your Laravel project:

1. Install Cachetastic using Composer:

    ```bash
    composer require bigdevwhale/cachetastic
   ```

2. Configure the default [cache driver](https://laravel.com/docs/10.x/cache) in your Laravel application
3. Start caching method results with the CacheService class.

   ```php
    // Import the CacheService class
    use Cachetastic\Cachetastic;

    // Create an instance of CacheService
    $cacheService = new Cachetastic(
        new YourApiService(), // The service or object to call the method on.
        'fetchData',          // The name of the method to call on the service.
        [1, 2]               // An array of parameters to pass to the method.
    );

    // Customize the cache duration (optional)
    $cacheService->setCacheDuration(60);

    // Cache the result of your API call
    $result = $cacheService->retrieveOrCache();
   
     // Force a clear of the cached data if needed
    $cacheService->forceClear();
   
    // You can also use the optional $regenerate parameter to control if data should be regenerated
    $result = $cacheService->forceRefresh(false)
    ```
4. Customize caching, force refresh, and error handling according to your needs.

That's it! Cachetastic seamlessly enhances your caching capabilities with minimal effort.

## Constructor Parameters

The CacheService constructor requires the following parameters:

- **service**: The service or object to call the method on.
- **method**: The name of the method to call on the service.
- **params**: An array of parameters to pass to the method.

## Cache Customization Methods

Cachetastic provides the following methods for customizing caching:

- **setCacheDuration(int $cacheDuration)**: Set the cache duration in minutes.
- **setCacheKeyParams(array $cacheKeyParams)**: Set parameter keys to use for cache key generation.
- **setCustomCacheKey(string $customCacheKey)**: Set a custom cache key to be used instead of generating one.

By default, the cache duration is set to 60 minutes.

You can use these methods to further customize your caching experience.

## Example
Here's an example of caching the result of a method in a Laravel application, whether it's a regular or static method:
```php
use Cachetastic\Cachetastic;
use YourApiService;

// Create an instance of Cachetastic to cache the result of a regular method
$cacheService = new Cachetastic(
    new YourApiService(), // The service or object to call the method on.
    'fetchData',          // The name of the method to call on the service.
    [1, 2]               // An array of parameters to pass to the method.
);

// Customize the cache duration (optional)
$cacheService->setCacheDuration(60);

// Cache the result of your API call, whether it's a regular method
$result = $cacheService->retrieveOrCache();

// Create an instance of Cachetastic to cache the result of a static method
$cacheServiceStatic = new Cachetastic(
    YourApiService::class, // The class with the static method.
    'fetchDataStatic',    // The name of the static method to call.
    [1, 2]                // An array of parameters to pass to the static method.
);

// Cache the result of your API call, whether it's a static method
$resultStatic = $cacheServiceStatic->retrieveOrCache();
```


## Overwriting Cache Keys
Please note that if two methods are executed in the same class with only array parameters, they will overwrite each 
other's cache value since only scalar parameters are used for cache key generation. In this case, consider using the 
**setCustomCacheKey** method described above.

## Contributing
We welcome contributions from the open-source community. Feel free to submit bug reports, feature requests, or pull requests on our GitHub repository.

## License
Cachetastic is open-source software licensed under the MIT License.

---
Supercharge your Laravel application with Cachetastic and turbocharge your caching game! Give it a try and experience the benefits for yourself. Happy caching!



