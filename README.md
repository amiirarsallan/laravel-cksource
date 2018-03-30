# Laravel CKSource (CKEditor &amp; CKFinder) package
This package provides two products of [CKSource](https://cksource.com/), called CKEditor thats one of the world best
WYSIWYG editors and CKFinder that creates a very easy, safe file upload and management trought the CKEditor and by itself,
for [Laravel](https://laravel.com/) 5.4+ framework.

- [Installation](#installation)
- [Updating](#updating)
- [Usage](#usage)
- [Notes](#notes)

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

### Configurating CKFinder
Open CKFinder ```config.php``` file available in this path ```/public/vendor/amiirarsalan/laravel-cksource/src/assets/ckfinder/```
in line 29
Replace **YOUR_APP_KEY** with your own application key stores in .env file of project, without **base64:** flag
```
$config['authentication'] = function () {
    $APP_KEY = "YOUR_APP_KEY";
```
Then, we have the most important part for authentication,

1- **Set Cookie to authenticate user in login**

In your user login process you have to redirect user after successful login attempt, so by that way you have to
redirect with a cookie set, with command ```withCookie()``` and the cookie should be named **allowCkfinder** with **true** value,
and the code snippet should be something like this
```
//Attempt to login user
if (!auth()->attempt($credentials, request('remember'))) {
    return back()->withErrors([
        'message' => 'Please check your credentials.'
    ]);
}

//Redirect to panel
return redirect()->withCookie(cookie()->forever('allowCkfinder', true));
```
2- **Unset Cookie while user logout**

To make the process works completely, you have to remove the cookie while user logout, and the snippet should be something like this
```
//Log out the user
auth()->logout();

//Redirect to index
return redirect()->withCookie(cookie()->forget('allowCkfinder'));
```

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
@ckeditor( [arg1](textarea name), [arg2](textarea id), [arg3]{optional}(ckeditor custom configs)  )
```
This syntax creates a new ```<textarea>``` HTML element in your view and its ```name``` and ```id``` attributes
will populate trough first two arguments of ```@ckeditor``` syntax.

3rd argument will be the CKFinder custom configurations.

**NOTE**
CKFinder and browse server button of CKEditor will be available while ```Auth::check()``` return true result,
so it means when a user authenticated then CKFinder will be enabled.

## Notes
### Disable CKFinder activation via Laravel Auth (NOT RECOMMENDED)
To disable CKFinder activation via Laravel Auth, just go trough this path in your laravel project
```
/public/vendor/amiirarsallan/laravel-cksource/src/assets/ckfinder/
```
and open config.php file inside this directory, then remove the whole code ```$config['authentication']``` in line **28**
and just write
```
$config['authentication'] = function () {
    return true;
};
```

### Invalid Request | Interface 'CKSource\CKFinder\Request\Transformer\TransformerInterface' not found
This error usually occures while you hit Browse Server button from CKEditor dialog, to fix this you have to
Open CKFinder config ```/public/vendor/amiirarsalan/laravel-cksource/src/assets/ckfinder/config.php```
and comment line 13, 14
```
// Production
// error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
// ini_set('display_errors', 0);
```
and uncomment line 17, 18
```
// Development
error_reporting(E_ALL);
ini_set('display_errors', 1);
```
Save the config file and try re-open the Browse Server dialog from CKEditor,
If the error shown on screen display something like this,

**Fatal error: Interface 'CKSource\CKFinder\Request\Transformer\TransformerInterface' not found in X:\X\public\vendor\amiirarsallan\laravel-cksource\src\assets\ckfinder\core\connector\php\vendor\cksource\ckfinder\src\CKSource\CKFinder\Request\Transformer\JsonTransformer.php on line 24**

Go to the path

```X:\X\public\vendor\amiirarsallan\laravel-cksource\src\assets\ckfinder\core\connector\php\vendor\cksource\ckfinder\src\CKSource\CKFinder\Request\Transformer\JsonTransformer.php```

and open ```JsonTransformer.php``` file, on line 24, change the code like this

```
class JsonTransformer //implements TransformerInterface
{
```

This will fix the Browse Server dialog.
