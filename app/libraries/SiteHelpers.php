<?php

class SiteHelpers
{
    /**
     * Returns body id made up by URI segments
     *
     * @return string
     */
    public static function bodyId()
    {
        $body_id = preg_replace(['/\d-/', '/-\d/'], '', implode('-', Request::segments()));
        return !empty($body_id) && $body_id != '-' ? $body_id : "homepage";
    }

    /**
     * Returns body classes made up by URI segments
     *
     * @return string
     */
    public static function bodyClass()
    {
        $body_classes = [];
        $class = "";

        if (Request::segment(1) === 'snippets' && !empty(Request::segment(2))) {
            return "single-snippet";
        }

        foreach (Request::segments() as $segment) {
            if (is_numeric($segment) || empty($segment)) {
                continue;
            }

            $class .= !empty($class) ? "-" . $segment : $segment;

            array_push($body_classes, $class);
        }

        if (Auth::check()) {
            array_push($body_classes, 'user-' . Auth::user()->type);
        }

        return !empty($body_classes) ? implode(' ', $body_classes) : NULL;
    }

    /**
     * Returns breadcrumbs made up by URI segments
     *
     * @return string
     */
    public static function breadcrumbs()
    {
        $breadcrumbs = [];
        $crumbs = Request::segments();

        if (count($crumbs) < 2) {
            return;
        }

        $url = "";

        end($crumbs);
        $last_key = key($crumbs);

        foreach ($crumbs as $key => $crumb) {
            $url .= '/' . $crumb;
            $crumb = ucwords($crumb);

            if ($key != $last_key) {
                $crumb = '<span typeof="v:Breadcrumb">' .
                    link_to($url, $crumb, ['rel' => 'v:url', 'property' => 'v:title']) .
                    '</span>';
            } else if (Request::segment(1) === 'snippets') {
                $crumb = "";
            } else {
                $crumb = '<span class="current">' . $crumb . '</span>';
            }

            array_push($breadcrumbs, $crumb);
        }

        $return = '<div class="clearfix">';
        $return .= '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
        $return .= '<div class="container">';
        $return .= implode('<i class="fa fa-chevron-right"></i>', $breadcrumbs);
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';

        return $return;
    }

    /**
     * Returns li wrapped link with active class
     *
     * @param string $url
     * @param string $title
     * @param bool $has_sub_menu
     * @param array $attributes
     * @param bool $secure
     * @return string
     */
    public static function navLinkTo($url, $title, $has_sub_menu = false, $attributes = [], $secure = null)
    {
        $purl = parse_url($url);
        $uri = ltrim($purl['path'], '/');

        $link = '<li class="';
        $link .= Request::is($uri) ? 'active ' : '';
        $link .= strtolower($title);
        $link .= '">';
        $link .= link_to($url, $title, $attributes, $secure);

        if (!$has_sub_menu) {
            $link .= '</li>';
        }

        return $link;
    }

    /**
     * Returns URL with prepended protocol
     *
     * @param string $url
     * @param bool $https optional
     * @return string
     */
    public static function url($url, $https = false)
    {
        $http = $https ? 'https://' : 'http://';
        return $http . str_replace(['http://', 'https://'], '', $url);
    }
}