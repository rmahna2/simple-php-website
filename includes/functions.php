<?php

/**
 * Displays site name.
 */
function site_name()
{
    echo config('name');
}

/**
 * Displays site url provided in conig.
 */
function site_url()
{
    echo config('site_url');
}

/**
 * Displays site version.
 */
function site_version()
{
    echo config('version');
}

/**
 * Extract page from URI for default page, pretty or query
 */

function get_page()
{
    $page = isset($_SERVER['REQUEST_URI']) ? str_replace(array('/','?page='), array('',''), $_SERVER['REQUEST_URI']) : 'Home';
    return empty($page) ? 'Home' : $page ;
}

/**
 * Website navigation.
 */
function nav_menu($sep = ' | ')
{
    $nav_menu = '';
    $nav_items = config('nav_menu');
    $page = get_page();
    foreach ($nav_items as $uri => $name) {
        $class = $page == $uri ? ' active' : '';
        $url = config('site_url') . '/' . (config('pretty_uri') || $uri == '' ? '' : '?page=') . $uri;
        
        $nav_menu .= '<a href="' . $url . '" title="' . $name . '" class="item ' . $class . '">' . $name . '</a>' . $sep;
    }

    echo trim($nav_menu, $sep);
}

/**
 * Displays page title. It takes the data from
 * URL, it replaces the hyphens with spaces and
 * it capitalizes the words.
 */
function page_title()
{
    $page = get_page();
    echo ucwords(str_replace('-', ' ', $page));
}

/**
 * Displays page content. It takes the data from
 * the static pages inside the pages/ directory.
 * When not found, display the 404 error page.
 */
function page_content()
{
    $page = get_page();

    $path = getcwd() . '/' . config('content_path') . '/' . $page . '.phtml';

    if (! file_exists($path)) {
        $path = getcwd() . '/' . config('content_path') . '/404.phtml';
    }

    echo file_get_contents($path);
}

/**
 * Starts everything and displays the template.
 */
function init()
{
    require config('template_path') . '/template.php';
}
