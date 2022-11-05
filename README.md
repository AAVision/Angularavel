
## About ANGULARAVEL

You can now build your angular-laravel project in the same place without any problem with the development or build bundles!


## Quick start
### Step 1
```sh
git https://github.com/AAVision/Angularavel.git
cd Angularavel
composer install
cp .env.example .env
php artisan key:generate
php artisan serve 
```
and go to http://127.0.0.1:8000

### Step2
Go to frontend folder in the root directory and run : 

```sh
npm i
npm run run-dev   <-- for develoment
npm run build     <-- for production

```

## Description

### Changing our CLI build location
#### We want the Angular CLI to output code in our Laravel app’s public folder, that way we are going to avoid having to run two servers at the same time when serving our app in production.

```sh
{
  /* ... */
  "options": {
    "outputPath": "../public/build",
    "index": "",
  },
  /* ... */
}
```

#### Create a file NgBuildService.php

```sh
<?php

namespace App\Services;

use Exception;

class NgBuildService
{

    public $assets = array();

    public function __construct()
    {
        if (config('app.env') === 'production') {
            $this->extractAndCache();
        }
    }

    private function extractAndCache()
    {
        $path = public_path('build') . '/stats.json';

        try {
            $json = json_decode(file_get_contents($path), true);

            if (isset($json['assets']) && count($json['assets'])) {
                foreach ($json['assets'] as $asset) {
                    $name = $asset['name'];

                    if ($asset['chunkNames'] && count($asset['chunkNames'])) {
                        $this->assets[$asset['chunkNames'][0]] = $name;
                    } else {
                        $this->assets[$name] = $name;
                    }
                }
            }
        } catch (Exception $e) {

        }
    }
}
```

#### Making a custom Laravel provider

```sh

<?php

namespace App\Providers;

use App\Services\NgBuildService;
use Illuminate\Support\ServiceProvider;

class NgBuildServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('App\Services\NgBuildService', function ($app) {
            return new NgBuildService();
        });
    }
}

```

## Compatibility
Laravel 9 + Angular 14
