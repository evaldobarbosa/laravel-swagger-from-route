# Swagger file from Laravel routes

Create your swagger specification from your laravel routes.

# installation

First create a repositories section in your composer.json like this:

```
//composer.json
{
...
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/evaldobarbosa/laravel-swagger-from-route",
    }
  ]
..
}

```sh
composer require evaldobarbosa/laravel-swagger-from-route --dev
```

# Usage

For while you can use this package like this:

```php
    $allRoutes = Route::getRoutes()->getRoutes();

    $x = new \SwaggerFromRoute\RouteManager;
    $x->setRoutes($allRoutes);

    $y = new \SwaggerFromRoute\FileGenerator($x);
    $y->handle();
```

# Soon

- [ ] create a artisan command to run this code block and generate all the files;
- [ ] join all files to create only on specification file;
- [ ] 