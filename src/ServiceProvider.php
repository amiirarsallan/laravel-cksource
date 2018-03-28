<?php

namespace AmirArsalan\LaravelCKSource;

use Auth;
use Storage;
use Blade;
use Cookie;

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
            __DIR__. '\files' => storage_path('app/public/files'),
        ],
        'laravel-cksource');

        // Main Job
        Blade::directive('ckeditor', function( $expression ) {

            $args = explode(', ', $expression);
            $name = $args[0];
            $id = $args[1];
            $options = !empty ($args[2]) ? $args[2] : '';

            // Set authentication options of CKFinder config.php
            if (Auth::check()) {
                Cookie::queue(Cookie::make('allowCkfinder', true));
                //Return with CKFinder installed
                $script = "
                    echo '<script type=\"text/javascript\" src=\"/vendor/amiirarsallan/laravel-cksource/src/assets/ckfinder/ckfinder.js\"></script>'; ";
                
                if (!empty($options)) {
                    $script .= "
                        echo '<script>
                                    CKFinder.setupCKEditor();
                                    CKEDITOR.replace(\'' . e({$id}) . '\', {' . {$options} . '});
                              </script>';
                    ";
                }
                else {
                    $script .= "
                        echo '<script>
                                    CKFinder.setupCKEditor();
                                    CKEDITOR.replace(\'' . e({$id}) . '\');
                              </script>';
                    ";
                }
            }
            else {
                if( Cookie::get('allowCkfinder') !== false) {
                    cookie('allowCkfinder', false);
                }
                else {
                    Cookie::queue(Cookie::make('allowCkfinder', false));
                }
                //Return without CKFinder
                if (!empty($options)) {
                    $script = "echo '<script>CKEDITOR.replace(\'' . e({$id}) . '\', {' . {$options} . '});</script>';";
                }
                else {
                    $script = "echo '<script>CKEDITOR.replace(\'' . e({$id}) . '\');</script>';";    
                }
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
