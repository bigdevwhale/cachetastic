# Cachetastic - Supercharge Your Laravel Caching!

## Table of Contents
- [Introduction](#introduction)
- [Key Features](#key-features)
- [Getting Started](#getting-started)
- [Examples](#examples)
- [Use Cases](#use-cases)
- [Contributing](#contributing)
- [License](#license)

## Introduction
Welcome to Cachetastic, your secret weapon for optimizing caching in Laravel applications. This package supercharges your Laravel caching capabilities, making it a breeze to cache method results and improve your application's performance. Say goodbye to redundant API calls and database queries, and hello to lightning-fast responses!

## Key Features
- **Method-Level Caching**: Cache the results of any method, not just APIs, with ease.
- **Flexible Cache Management**: Force-refresh and update cache with new values on-demand.
- **Error Handling**: Errors from external sources don't get cached; original exceptions are preserved.
- **Automatic Cache Key Generation**: Cache keys are generated based on method name and parameters.
- **Laravel Integration**: Seamlessly integrates with Laravel's caching system.
- **Clean and Elegant Code**: Well-structured and efficient codebase for easy use and contribution.
- **PHPUnit and Mockery Read**y: Unit testing with PHPUnit and Mockery support included.

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
    use Cachetastic\CacheService;

    // Create an instance of CacheService
    $cacheService = new CacheService();

    // Cache the result of a method
    $result = $cacheService->retrieveOrCache($yourService, 'yourMethod', $yourParams, $cacheDuration);
   ```
4. Customize caching, force refresh, and error handling according to your needs.

That's it! Cachetastic seamlessly enhances your caching capabilities with minimal effort.

## Examples

Here's an example of caching the result of a method in a Laravel application:

```php
use Cachetastic\CacheService;
use YourApiService;

// Create an instance of CacheService
$cacheService = new CacheService();

// Cache the result of your API call
$result = $cacheService->retrieveOrCache(new YourApiService(), 'fetchData', [1, 2], 60);
```

## Use Cases
Cachetastic is the perfect addition to your Laravel project for various use cases:

- **API Responses**: Cache responses from external APIs to reduce latency and minimize rate limits.
- **Database Queries**: Cache complex database queries and boost query performance.
- **Expensive Computation**: Cache the results of computationally intensive methods for faster execution.
- **Dynamic Content**: Cache dynamic content to reduce server load and improve user experience.
- **Rate-Limited APIs**: Avoid exceeding rate limits by caching API responses and serving cached data.

Cachetastic is your go-to tool for optimizing your Laravel application's performance in a snap!

## Contributing
We welcome contributions from the open-source community. Feel free to submit bug reports, feature requests, or pull requests on our GitHub repository.

## License
Cachetastic is open-source software licensed under the MIT License.

---
Supercharge your Laravel application with Cachetastic and turbocharge your caching game! Give it a try and experience the benefits for yourself. Happy caching!



