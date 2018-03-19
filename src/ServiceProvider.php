<?php

namespace AmirArsalan\LaravelCKSource;

use Auth;
use Session;
use Storage;
use Blade;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish
        $this->publishes([
            __DIR__. '\assets\ckeditor' => public_path('vendor/amiirarsallan/laravel-cksource/src/assets/ckeditor'),
            __DIR__. '\assets\ckfinder' => public_path('vendor/amiirarsallan/laravel-cksource/src/assets/ckfinder'),
            __DIR__. '\files' => storage_path('files'),
        ],
        'cksource');

        // Main Job
        Blade::directive('ckeditor', function( $expression ) {

            list($name, $id, $dir) = explode(', ', $expression);

            // Set baseURL options of CKFinder config.php
            $dir = empty($dir) ? url("storage/files") : url("storage/files/".$dir);
            Session::put('ckfinder_baseUrl', $dir);

            // Set authentication options of CKFinder config.php
            if (Auth::check()) {
                Session::put('ckfinder_authentication', true);
                //Return with CKFinder installed
                $script = "
                    echo '<script type=\"text/javascript\" src=\"/vendor/amiirarsallan/laravel-cksource/src/assets/ckfinder/ckfinder.js\"></script>';
                    echo '<script>CKFinder.setupCKEditor();CKEDITOR.replace(\'' . e({$id}) . '\')</script>';
                ";
            }
            else {
                Session::put('ckfinder_authentication', false);
                //Return without CKFinder
                $script = "echo '<script>CKEDITOR.replace(\'' . e({$id}) . '\');</script>';";
            }

            return "<?php 
            echo '<textarea name=\"' . e({$name}) . '\" id=\"' . e({$id}) . '\"></textarea>';
            echo '<script type=\"text/javascript\" src=\"/vendor/amiirarsallan/laravel-cksource/src/assets/ckeditor/ckeditor.js\"></script>';
            ". $script ."
            ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
