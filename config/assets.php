<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Assets Manifest
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default asset manifest that should be used.
    | The "theme" manifest is recommended as the default as it cedes ultimate
    | authority of your application's assets to the theme.
    |
    */

    'default'   => 'stage',

    /*
    |--------------------------------------------------------------------------
    | Assets Manifests
    |--------------------------------------------------------------------------
    |
    | Manifests contain lists of assets that are referenced by static keys that
    | point to dynamic locations, such as a cache-busted location. A manifest
    | may employ any number of strategies for determining absolute local and
    | remote paths to assets.
    |
    | Supported Strategies: "relative"
    |
    | Note: We will add first-party support for more strategies in the future.
    |
    */

    'manifests' => array(
        'stage' => array(
            'strategy' => 'relative',
            'path'     => get_parent_theme_file_path('/dist'),
            'uri'      => get_parent_theme_file_uri('/dist'),
            'manifest' => get_parent_theme_file_path('/dist/mix-manifest.json'),
        ),
    ),
);
