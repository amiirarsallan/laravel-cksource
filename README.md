# Laravel CKSource (CKEditor &amp; CKFinder) package
This package provides two products of [CKSource](https://cksource.com/), called CKEditor thats one of the world best
WYSIWYG editors and CKFinder that creates a very easy, safe file upload and management trought the CKEditor and by itself,
for [Laravel](https://laravel.com/) 5.4+ framework.

- [Installation](https://github.com/amiirarsallan/laravel-ckeditor#installation)
- [Updating](https://github.com/amiirarsallan/laravel-ckeditor#updating)
- [Usage](https://github.com/amiirarsallan/laravel-ckeditor#usage)

## Installation
### Require package via composer
```
composer require amiirarsallan/laravel-cksource
```
### Publishing assets
Run this artisan command inside your main laravel project directory
```
php artisan vendor:publish --tag=laravel-cksource
```

### Note
**By running this command you'll have a new directory named ```files``` inside your laravel project ```storage``` directory,
this directory will used for CKFinder uploads path.**

## Updating
### Update composer at first level
```
composer update amiirarsallan/laravel-cksource
```
### Publish new assets with flag --force to overwrite existing files
```
php artisan vendor:publish --tag=laravel-cksource --force
```

## Usage
Package generates new custom Laravel Blade syntax,
```
@ckeditor( [arg1](textarea name), [arg2](textarea id), [arg3]{optional}(ckfinder dirctory name)  )
```
This syntax creates a new ```<textarea>``` HTML element in your view and its ```name``` and ```id``` attributes
will populate trough first two arguments of ```@ckeditor``` syntax.

3rd argument will be the CKFinder upload directory and its default value is ```files``` that publishes via provider by installation steps

**NOTE**
CKFinder and browse server button of CKEditor will be available while ```Auth::check()``` return true result,
so it means when a user authenticated then CKFinder will be enabled.

## Configuration
### Disable CKFinder activation via Laravel Auth (not recommended)
To disable CKFinder activation via Laravel Auth, just go trough this dir in your laravel project
```
/public/vendor/amiirarsallan/laravel-cksource/src/assets/ckfinder/
```
and open config.php file inside this directory, then remove this code ```$_SESSION['ckfinder_authentication'];``` in line **30**
```
$config['authentication'] = function () {
    return $_SESSION['ckfinder_authentication'];
};
```
and just write
```
$config['authentication'] = function () {
    return true;
};
```

**This highly not recommended, but shares for those users who wants to test this package**
