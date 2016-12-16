<?php

/**
 * @package Invoke_Helpers
 * @version 1.0
 */

/*
Plugin Name: Invoke Helpers
Plugin URI: http://wordpress.org/plugins/invoke-helpers/
Description: Theme and function helpers that make using WordPress more pleasant
Author: Invoke Media
Version: 1.0
Author URI: http://www.invokemedia.com
*/

function var_template_include($t)
{
    $GLOBALS['current_theme_template'] = basename($t, '.php');
    return $t;
}

add_filter('template_include', 'var_template_include', 1000);

if (!function_exists('exceptions_error_handler')) {
    /**
     * Convert errors into Exceptions
     * @param int $severity
     * @param string $message
     * @param string $filename
     * @param int $lineno
     * @return Exception
     */
    function exceptions_error_handler($severity, $message, $filename, $lineno)
    {
        if (error_reporting() == 0) {
            return;
        }
        if (error_reporting() & $severity) {
            throw new ErrorException($message, 0, $severity, $filename, $lineno);
        }
    }
}

set_error_handler('exceptions_error_handler');

if (!function_exists('strip_non_numeric')) {
    /**
     * Strip characters that are not numbers
     * @param string $value
     * @return string
     */
    function strip_non_numeric($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }
}

if (!function_exists('plural_count')) {
    /**
     * Returns a 's' given a number. Works well for plural and singular words
     * @param string $word
     * @param int $count
     * @return string
     */
    function plural_count($word, $count)
    {
        $added_s = $count == 1 ? '': 's';
        return $word.$added_s;
    }
}

if (!function_exists('asset')) {
    /**
     * Returns an url for an asset in the current theme
     * @param string $value
     * @return string
     */
    function asset($value)
    {
        return sprintf("%s", get_template_directory_uri() . '/' . $value);
    }
}

if (!function_exists('copyright_date')) {
    /**
     * Returns a string for copyright for the difference in year started and current year
     * @param string $year
     * @return string
     */
    function copyright_date($year = '2016')
    {
        return (date('Y') == $year) ? null: '-' . date('Y');
    }
}

if (!function_exists('str_slug')) {
    /**
     * Slugify a string with certain rules
     * @param string $string
     * @param array $replace
     * @param string $delimiter
     * @return string
     */
    function str_slug($string, $replace = array(), $delimiter = '-')
    {
        // https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
        if (!extension_loaded('iconv')) {
            throw new Exception('iconv module not loaded');
        }

        // Save the old locale and set the new locale to UTF-8
        $oldLocale = setlocale(LC_ALL, '0');
        setlocale(LC_ALL, 'en_US.UTF-8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        if (!empty($replace)) {
            $clean = str_replace((array) $replace, ' ', $clean);
        }

        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower($clean);
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
        $clean = trim($clean, $delimiter);

        // Revert back to the old locale
        setlocale(LC_ALL, $oldLocale);
        return $clean;
    }
}

if (!function_exists('auth')) {
    include 'inc/Auth.php';
    /**
     * A helper for the autenticated user
     * @return Auth
     */
    function auth()
    {
        return new Auth();
    }
}

if (!function_exists('request')) {
    include 'inc/Request.php';
    /**
     * A helper for POST and GET requests
     * @return Request
     */
    function request()
    {
        return new Request();
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limit a string to a certain amount of characters
     * @param string $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }
}

if (!function_exists('word_limit')) {
    /**
     * Limit a sentence to a specific number of words
     * @param string $text
     * @param int $limit
     * @param string $end
     * @return string
     */
    function word_limit($text, $limit = 20, $end = '...')
    {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = trim(substr($text, 0, $pos[$limit])) . $end;
        }
        return $text;
    }
}

if (!function_exists('dd')) {
    /**
     * Dump and die with nice formatting and styling
     * @param mixed $data
     * @return string
     */
    function dd($data)
    {
        ini_set("highlight.comment", "#969896; font-style: italic");
        ini_set("highlight.default", "#FFFFFF");
        ini_set("highlight.html", "#D16568");
        ini_set("highlight.keyword", "#7FA3BC; font-weight: bold");
        ini_set("highlight.string", "#F2C47E");
        $output = highlight_string("<?php\n\n" . var_export($data, true), true);
        echo "<div style=\"text-align:left; background-color: #1C1E21; padding: 1rem; word-break: break-word\">{$output}</div>";
        die();
    }
}

if (!function_exists('is_even')) {
    /**
     * Tell if an array length or integer is even
     * @param mixed $value
     * @return int
     */
    function is_even($value)
    {
        if (is_array($value)) {
            return count($value) % 2 !== 0;
        }

        return $value % 2 !== 0;
    }
}

if (!function_exists('is_odd')) {
    /**
     * Tell if an array length or integer is odd
     * @param mixed $value
     * @return int
     */
    function is_odd($value)
    {
        if (is_array($value)) {
            return count($value) % 2 == 0;
        }

        return $value % 2 == 0;
    }
}

if (!function_exists('url')) {
    /**
     * A wrapper around get_permalink and site_url
     * @param WP_Post|string $uri
     * @param string|null $protocol
     * @return string
     */
    function url($uri, $protocol = null)
    {
        // calls the correct function is the object is a post
        if (is_object($uri) && get_class($uri) == 'WP_Post') {
            return get_permalink($uri);
        }

        // just a general site URL from a URI
        return site_url($uri, $protocol);
    }
}

if (!function_exists('e')) {
    /**
     * Escape html entities
     * @param string $value
     * @return string
     */
    function e($value)
    {
        echo htmlentities($value, ENT_QUOTES, 'utf-8');
    }
}

if (!function_exists('template_is')) {
    /**
     * Figure out if a template is the current template of the page
     * @param array|string $names
     * @return bool
     */
    function template_is($names)
    {
        $names = is_array($names) ? $names: [$names];
        return count(array_filter($names, function ($uri) {
            return $GLOBALS['current_theme_template'] == $uri;
        }));
    }
}

if (!function_exists('content')) {
    /**
     * Get the content for the current page or a given post
     * @param WP_POST|null $post
     * @return string
     */
    function content($post = null)
    {
        $post = is_null($post) ? get_post(): $post;

        return apply_filters('the_content', $post->post_content);
    }
}

if (!function_exists('featured_image')) {
    /**
     * Get the featured image of the current post or a given post
     * @param WP_POST|null $post
     * @return object
     */
    function featured_image($post = null)
    {
        $post = is_null($post) ? get_post(): $post;

        $image = (object)wp_get_attachment_metadata(get_post_thumbnail_id($post));

        $image->url = sprintf("%s/wp-content/uploads/%s", defined('WP_HOME') ? WP_HOME : get_site_url() , $image->file);
        return $image;
    }
}

if (!function_exists('view')) {
    /**
     * Render a partial template with a given array of data
     * @param string $filename
     * @param array $vars
     * @return string
     */
    function view($filename, $vars = null)
    {
        try {
            if (is_array($vars) && !empty($vars)) {
                extract($vars);
            }

            ob_start();

            include(get_template_directory() . '/' . $filename);

            return ob_get_clean();
        } catch (Exception $e) {
            dd(sprintf("%s in %s:%s when using the `view` function.", $e->getMessage(), $filename, $e->getLine()));
        }
    }
}
