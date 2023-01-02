<?php

/**
 * Plugin Name: Alpine.js for WordPress
 * Plugin URI: https://github.com/ratPoopert/alpine-wp
 * Description: A simple plugin that registers Alpine.js with the handle 'alpinejs' for use as a plugin/theme script dependency.
 * Version: 2023.01.01
 * Requires PHP: 8.0
 * Author: Patrick Ruppert
 * Author URI: https://github.com/ratPoopert
 * Update URI: https://github.com/ratPoopert/alpine-wp#latest
 */

/**
 * Stop further execution if the request did not come from WordPress.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Initialize Alpine.js with WordPress.
 */
add_action('init', 'alpine_wp_init');

/**
 * Registers Alpine.js for use on the WordPress front-end, admin panel, and login screen.
 */
function alpine_wp_init(): void
{
    add_action('admin_enqueue_scripts', 'alpine_wp_register_script');
    add_action('wp_enqueue_scripts', 'alpine_wp_register_script');
    add_action('login_enqueue_scripts', 'alpine_wp_register_script');
}

/**
 * Register Alpine.js and ensure the script is deferred per the Alpine.js docs.
 */
function alpine_wp_register_script(): void
{
    wp_register_script(...alpine_wp_script());
    add_action('script_loader_tag', 'alpine_wp_script_loader_tag', 10, 2);
}

/**
 * Returns an associate array representation of Alpine.js for consumption by WordPress.
 */
function alpine_wp_script(): array
{
    return [
        'handle' => 'alpinejs',
        'src' => 'https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js',
        'deps' => [],
        'ver' => false,
        'in_footer' => false
    ];
}

/**
 * Adds the 'defer' modifier to the Alpine.js script tag.
 */
function alpine_wp_script_loader_tag(string $tag, string $handle): string
{
    if ($handle === alpine_wp_script()['handle']) {
        $tag = str_replace('<script', '<script defer', $tag);
    }

    return $tag;
}
