# Alpine WP (Alpine.js for WordPress)

## Description

This is a very simple WordPress plugin that registers the amazing [Alpine.js](https://alpinejs.dev) for use in the WordPress admin panel, front-end, and login screen.

Once installed, Alpine.js can be enqueued directly or added as a dependency using the handle `alpinejs`.

## Why Use a Plugin?

The simple answer is: because Alpine.js is awesome for WordPress development and I got tired of registering it individually on the themes and plugins I develop.

Installing Alpine.js as a plugin helps me ensure that I won't need to install it as an npm dependency for separate plugins or worry that I've enqueued it multiple times using different handles.

No worrying about writing another special `script_loader_tag` function to add the defer statement to the script tag.

## Installation

This package uses *composer/installers* to install the package as a WordPress plugin.

If you do not want to use Composer, you can also download the latest version of this repository as a .zip file and install the plugin via the WordPress admin dashboard.

---

These instructions assume you are starting from a bare WordPress installation. If this is not the case, please adapt the following accordingly.

Create a `composer.json` file in your `wp-content` directory. Add the snippets below to this file to ensure Composer installs the plugin correctly:

1. Add this GitHub repository as a Composer repository.

    ~~~json
    "repositories": [
        "type": "vcs",
        "url": "https://github.com/ratPoopert/alpine-wp.git"
    ]
    ~~~

2. Ensure Composer installs the most recent version of the plugin from the *main* branch.

    ~~~json
    "require": {
        "ratpoopert/alpine-wp": "dev-main"
    }
    ~~~

3. Configure `composer/installers` to install packages with the type `wordpress-plugin` (including this one) to the correct location.

    ~~~json
    "extra": {
        "installer-paths": {
            "plugins/{$name}": [
                "type:wordpress-plugin"
            ]
        }
    }
    ~~~

4. The complete `composer.json` should look like this:

    ```json
        "repositories": [
            "type": "vcs",
            "url": "https://github.com/ratPoopert/alpine-wp.git"
        ],
        "require": {
            "ratpoopert/alpine-wp": "dev-main"
        },
        "extra": {
            "installer-paths": {
                "plugins/{$name}": [
                    "type:wordpress-plugin"
                ]
            }
        }
    ```

5. To complete the installation, navigate to the `wp-content` directory via command line and run the following command:

    ```sh
    composer install
    ```

## Usage

This plugin registers Alpine.js under the handle `alpinejs` for use in the WordPress admin panel, front-end, and the login screen.

Per the official Alpine.js [documentation](https://alpinejs.dev/start-here), the *defer* statement is added to the `<script>` tag when it is rendered to the page.

You can either enqueue the script directly...
```php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script('alpinejs');
});
```

Or add Alpine.js as a dependency to your script...
```php
add_action('wp_enqueue_scripts', function() {
    wp_register_script(
        handle: 'my-plugin-script',
        src: plugin_dir_url(__FILE__) . 'src/index.js',
        deps: ['alpinejs'],
        ver: get_file_data(__FILE__, ['Version'], 'plugin')[0],
        in_footer: true
    );
});
```

From there, use Alpine.js as you normally would. Happy coding!
