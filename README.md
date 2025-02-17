<h1 align="center">Notify notification package support Laravel 10</h1>

<p align="center">:eyes: This package helps you to add notifications to your Laravel projects.</p>

<p align="center"><img width="300" alt="notify" src="https://user-images.githubusercontent.com/10859693/39634578-1a9f121a-4fb3-11e8-8863-d64fad42901b.png"></p>

## Install

You can install the package using composer

```sh
$ composer require pixelcostudios/notify
```

## Usage:

Include jQuery and your notification plugin assets in your view template: 

1. Add your styles links tag or `@notify_css`
2. Add your scripts links tags or `@notify_js`
3. Add `@notify_render` to render your notification
4. use `notify()` helper function inside your controller to set a toast notification for info, success, warning or error
```php
// Display an info toast with no title
notify()->info('Are you the 6 fingered man?')
```

as an example:
```php
<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Model;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        $post = Post::create($request->only(['title', 'body']));

        if ($post instanceof Model) {
            notify()->success('Data has been saved successfully!');

            return redirect()->route('posts.index');
        }

        notify()->error('An error has occurred please try again later.');

        return back();
    }
}
```

After that add the `@notify_render` at the bottom of your view to actualy render the notify notifications.

```blade
<!doctype html>
<html>
    <head>
        <title>yoeunes/toastr</title>
        @notify_css
    </head>
    <body>
        
    </body>
    @notify_js
    @notify_render
</html>
```
### Other Options

```php
// Set a warning toast, with no title
notify()->warning('My name is Inigo Montoya. You killed my father, prepare to die!')

// Set a success toast, with a title
notify()->success('Have fun storming the castle!', 'Miracle Max Says')

// Set an error toast, with a title
notify()->error('I do not think that word means what you think it means.', 'Inconceivable!')

// Override global config options from 'config/notify.php'

notify()->success('We do have the Kapua suite available.', 'Turtle Bay Resort', ['timeOut' => 5000])

// for pnotify driver
notify()->alert('We do have the Kapua suite available.', 'Turtle Bay Resort', ['timeOut' => 5000])
```

### other api methods:
// You can also chain multiple messages together using method chaining
```php
notify()->info('Are you the 6 fingered man?')->success('Have fun storming the castle!')->warning('doritos');
```

### Service Provider Laravel version < 5.5:

In Laravel versions 5.5 and beyond, this step can be skipped if package auto-discovery is enabled

Add the service provider to `config/app.php`. .

```php
'providers' => [
    ...
    Yoeunes\Notify\NotifyServiceProvider::class
    ...
];
```

As optional if you want to modify the default configuration, you can publish the configuration file:
 
```sh
$ php artisan vendor:publish --provider='Yoeunes\Notify\NotifyServiceProvider' --tag="config"
```

### configuration:
```php
// config/notify.php
<?php

return [

    'default' => 'toastr',

    'toastr' => [

        'class' => \Yoeunes\Notify\Notifiers\Toastr::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
        ],

        'types' => [
            'error',
            'info',
            'success',
            'warning',
        ],

        'options' => [],
    ],

    'pnotify' => [

        'class' => \Yoeunes\Notify\Notifiers\Pnotify::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css',
            'https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css',
        ],

        'types' => [
            'alert',
            'error',
            'info',
            'notice',
            'success',
        ],

        'options' => [],
    ],

    'sweetalert2' => [

        'class' => \Yoeunes\Notify\Notifiers\SweetAlert2::class,

        'notify_js' => [
            'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.js',
            'https://cdn.jsdelivr.net/npm/promise-polyfill',
        ],

        'notify_css' => [
            'https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.28.1/sweetalert2.min.css',
        ],

        'types' => [
            'error',
            'info',
            'question',
            'success',
            'warning',
        ],

        'options' => [],
    ],
];
```

## Credits

- [Younes Khoubza](https://github.com/yoeunes)
- [All Contributors](../../contributors)

## License

MIT
