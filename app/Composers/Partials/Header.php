<?php

namespace Stage\Composers\Partials;

use Roots\Acorn\View\Composer;

use function Stage\stage_get_fallback;

class Header extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        'layouts.header',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'logo'         => get_custom_logo(),
            'classes'      => $this->getHeaderClasses(),
            'site_name'    => get_bloginfo('name'),
            'site_tagline' => get_bloginfo('description'),
            'show_tagline' => stage_get_fallback('header.branding.show_tagline'),
            'home_url'     => esc_url(home_url('/')),
            'desktop'      => array(
                'layout'    => stage_get_fallback('header.desktop.layout', false, true),
                'position'  => stage_get_fallback('header.desktop.position'), // fixed, sticky, relative, ...
                'align'     => stage_get_fallback('header.desktop.align'), // fixed, sticky, relative, ...
                'fullwidth' => stage_get_fallback('header.desktop.fullwidth') ? 'fullwidth' : 'boxed',
                'padding-x' => 'sm:px-' . stage_get_fallback('header.desktop.padding-x'),
                'padding-y' => 'sm:py-' . stage_get_fallback('header.desktop.padding-y'),
            ),
            'mobile'       => array(
                'layout'   => stage_get_fallback('header.mobile.layout', false, true), // fixed, sticky, relative, ...
                'position' => stage_get_fallback('header.mobile.position'),
            ),
            'search'       => array(
                'layout' => stage_get_fallback('header.search.layout', false, true),
            ),
        );
    }

    /**
     * Array of classes for <header>
     *
     * @return string
     */
    public function getHeaderClasses()
    {
        $classes = array(
            'main-header',
            'container',
            'top-0',
            'w-full',
            'banner',
            'bg-body',
            'font-copy',
            'border-accent',
	        'z-30'
        );

        return implode(' ', apply_filters('stage_header_classes', $classes));
    }
}
