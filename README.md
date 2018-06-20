Simple product search
------

The mission
------
You should create a new controller with a method accepting id of product as a parameter. The method should return json representation of product data.

A basic workflow for the task:

- Request with product id comes in.
- If product is cached retrieve from cache.
- If product is not cached retrieve from ElasticSearch/MySQL and add to cache.
- Increment the number of requests for given product.
- Return product data in JSON.

The solution
------
`IProductStorage` interface was created to allow uniform access to product storage. `IRequestStatisticsStorage` was created to allow uniform access to tracking requests for each product.

`ProductController` works against these interfaces, so changing implementation can be achieved by changing config file and rebuilding DI container.

`FileRequestStatisticsStorage` is an implementation of `IRequestStatisticsStorage` which uses a single file with JSON-encoded array of request counters for each product. The implementation uses file-level locking to prevent race conditions when multiple requests as processed in quick succession. 

`ICache` interface is provided to standardize access to various caching implementation. `FilesystemCache` implementation uses filesystem, cached products are saved as plain files.

Caching of products can be enabled by using `CachedProductStorage` implementation, which is just a decorator for `IProductStorage`.

This layering allows us to configure the `ProductController` to either use direct access to product storage or plug-in a caching layer. The caching layer itself can use various implementations of `ICache`.