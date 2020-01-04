<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;

use function Stage\stage_is_feature_active;

class ImagesServiceProvider extends ServiceProvider
{



    public $lazy;
    public $gallery;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Store feature state in variable
        $this->lazy    = stage_is_feature_active('lazy');
        $this->gallery = stage_is_feature_active('gallery');

        /**
         * Register Image Sizes
         */
        if ($this->lazy) {
            add_image_size('low-res', 64, 48, false);
        }

        /**
         * Add class 'wp-image-{$id}' to images
         * This is already set to block images by default
         */
        add_filter(
            'wp_get_attachment_image_attributes',
            function (array $attr, \WP_Post $attachment) {

                $classes   = explode(' ', $attr['class']);
                $classes[] = 'wp-image-' . $attachment->ID;

                $attr['class'] = implode(' ', $classes);

                return $attr;
            },
            10,
            2
        );

        /**
         * Filter blocks HTML
         */
        if ($this->gallery) {
            add_filter(
                'render_block',
                function ($block_content, $block) {
                    return $this->manipulateBlocksHTML($block_content, $block);
                },
                10,
                2
            );
        }

        /**
         * Filter the_content output for Gutenberg support
         */
        if ($this->lazy || $this->gallery) {
            /**
             * Manipulate images outside the_content()
             */
            add_filter(
                'post_thumbnail_html',
                function ($html) {
                    return $this->manipulateImageHTML($html);
                }
            );

            /**
             * Manipulate images inside the_content()
             */
            add_filter(
                'the_content',
                function ($html) {
                    return $this->manipulateImageHTML($html);
                }
            );
        }
    }

    /**
     * Add gallery wrappers
     *
     * @param $block_content
     * @param $block
     *
     * @return string
     */
    protected function manipulateBlocksHTML($block_content, $block)
    {
        // Fail early
        if (is_admin() || ! isset($block['blockName']) || ! $this->gallery) {
            return $block_content;
        }

        // Add a dedicated class to the gallery
        if (
            $block['blockName'] === 'core/gallery'
            && isset($block['attrs']['linkTo'])
            && $block['attrs']['linkTo'] === 'media'
        ) {
            $block_content = str_replace('wp-block-gallery', 'wp-block-gallery stage-gallery', $block_content);
        }

        // Add a dedicated class to the images
        if (
            $block['blockName'] === 'core/image'
            && isset($block['attrs']['linkDestination'])
            && $block['attrs']['linkDestination'] === 'media'
        ) {
            $block_content = str_replace('wp-block-image', 'wp-block-image stage-gallery', $block_content);
        }

        return $block_content;
    }

    /**
     * Manipulates HTML to support lozad.js and PhotoSwipe.js
     * Change src/srcset to data attributes, and replace img src with its low res version
     * https://regex101.com/r/65oTIM/1/
     *
     * @note This has effect on gutenberg blocks.
     *
     * @param string $html HTML which contains images to manipulate.
     *
     * @return string|string[]|null
     */
    protected function manipulateImageHTML($html)
    {
        $html = preg_replace_callback(
            '/<(img)(.*?)(src=)\"(.*?)\"(.*?)(srcset=)\"(.*?)\"(.*?)>/i',
            function ($m) {

                $out = '';

                // Try to get image ID from class
                preg_match('/wp-image-(\d+)/', $m[5], $image, PREG_UNMATCHED_AS_NULL);
                $image_id = isset($image[1]) ? $image[1] : null;

                if ($this->gallery) {
                    $m = $this->imagesAddGalleryMarkup($m, $image_id);
                }

                if ($this->lazy) {
                    $m = $this->imagesAddLazyMarkup($m, $image_id);
                }

                $out .= "<$m[1]$m[2]$m[3]$m[4]$m[5]$m[6]\"$m[7]\"$m[8]>";
                $out .= '<noscript>' . $m[0] . '</noscript>';

                return $out;
            },
            $html
        );

        if ($this->lazy) {
            $html = $this->addLazyClass($html);
        }

        return $html;
    }

    /**
     * Adjust image markup for lazy loading
     *
     * @param $matches
     *
     * @param null    $image_id
     *
     * @return mixed
     */
    protected function imagesAddLazyMarkup($matches, $image_id = null)
    {

        $placeholder = $this->getImage($matches[4], $image_id, 'low-res');

        if (! empty($placeholder)) {
            // Replace src attribute
            $matches[2] .= 'src="' . $placeholder[0] . '"';
            $matches[3]  = 'data-src=';

            // Replace srcset with data-srcset
            $matches[6] = 'data-srcset=';
        }

        return $matches;
    }

    /**
     * Adjust image markup for images
     *
     * @param $matches
     *
     * @param null    $image_id
     *
     * @return mixed
     */
    protected function imagesAddGalleryMarkup($matches, $image_id = null)
    {
        $image = $this->getImage($matches[4], $image_id, 'full');

        if (! empty($image) && isset($image[0]) && isset($image[1]) && isset($image[2])) {
            $matches[8] .= 'data-full="'
                           . $image[0]
                           . '" data-full-width="'
                           . $image[1]
                           . '" data-full-height="'
                           . $image[2]
                           . '"';
        }

        return $matches;
    }

    /**
     * Add lazy class to images and iframes
     *
     * @param $html
     *
     * @return string|string[]|null
     */
    protected function addLazyClass($html)
    {
        // Add .lazy class to each image that already has a class.
        $html = preg_replace('/(<img|<iframe)(.*?)class=\"(.*?)\"(.*?)>/i', '$1$2class="$3 lazy"$4>', $html);

        // Add .lazy class to each image that doesn't already have a class.
        $html = preg_replace('/(<img|<iframe)((?:(?!class=).)*?)>/i', '$1 class="lazy"$2>', $html);

        return $html;
    }

    /**
     * Gets image by id with fallback to src
     *
     * @param string   $image_url
     * @param int|null $image_id
     * @param string   $size
     *
     * @return array|false Returns an array (url, width, height, is_intermediate), or false, if no image is available.
     */
    public function getImage(string $image_url = '', int $image_id = null, string $size = 'low-res')
    {
        $image_id = $image_id ?: attachment_url_to_postid($image_url);

        return wp_get_attachment_image_src($image_id, $size);
    }
}
