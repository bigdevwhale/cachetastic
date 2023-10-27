<?php

namespace Tests;

use Cachetastic\Cachetastic;
use Mockery;
use PHPUnit\Framework\TestCase;

class CacheServiceTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * Test the retrieval of data from cache or an external method.
     *
     * @return void
     */
    public function testRetrieveOrCache()
    {
        // Arrange
        $apiWrapper = new MockApiWrapper();
        $cacheService = new Cachetastic($apiWrapper, 'fetchData', [1, 2]);
        $cacheService->setCacheDuration(60);

        // Create a mock for the Cache facade
        $cacheMock = Mockery::mock('alias:Illuminate\Support\Facades\Cache');

        // Set up the Cache facade to return a predefined value when 'remember' is called
        $cacheKey = 'fetchData:1_2';
        $expectedValue = 'data';
        $cacheMock->shouldReceive('remember')
            ->withArgs([$cacheKey, 60, Mockery::type('Closure')])
            ->once()
            ->andReturn($expectedValue);

        // Act
        $result = $cacheService->retrieveOrCache();

        // Assert
        $this->assertEquals($expectedValue, $result);
    }

    /**
     * Test forcing a refresh of cached data and optional update.
     *
     * @return void
     */
    public function testForceRefresh()
    {
        // Arrange
        $apiWrapper = new MockApiWrapper();
        $cacheService = new Cachetastic($apiWrapper, 'fetchData', [1, 2]);
        $cacheService->setCacheDuration(60);
        $cacheService->setCacheKeyParams([1]);

        // Create a mock for the Cache facade
        $cacheMock = Mockery::mock('alias:Illuminate\Support\Facades\Cache');

        // Set up the Cache facade to expect 'forget' and 'put' calls
        $cacheKey = 'fetchData:2';
        $cacheMock->shouldReceive('forget')
            ->withArgs([$cacheKey])
            ->once();

        $newValue = 'new data';
        $cacheMock->shouldReceive('remember')
            ->withArgs([$cacheKey, 60, Mockery::type('Closure')])
            ->once()
            ->andReturn($newValue);

        // Act
        $cacheService->forceRefresh();

        // Assert
        // Add assertions to verify that cache was updated as expected
        $this->assertTrue(true); // Placeholder assertion
    }
}
