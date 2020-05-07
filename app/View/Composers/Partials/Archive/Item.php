<?php

namespace Stage\View\Composers\Partials\Archive;

use Roots\Acorn\View\Composer;
use Stage\View\Composers\Partials\Archive;

class Item extends Composer
{

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = array(
        '*item*',
        '*content-*',
    );

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return array(
            'id'            => get_the_ID(),
            'title'         => get_the_title(),
            'excerpt'       => get_the_excerpt(),
            'tags'          => $this->itemTags(),
            'classes'       => $this->itemClasses(),
            'inner_classes' => $this->itemInnerClasses(),
            'permalink'     => get_permalink(),
            'has_thumbnail' => has_post_thumbnail(),
            'thumbnail'     => $this->itemThumbnail(),
        );
    }

    /**
     * Data to overwrite before rendering.
     *
     * @return array
     */
    public function override()
    {
        return array(
            'layout'  => $this->layout(),
            'classes' => $this->itemClasses(),
        );
    }

    /**
     * Generates classes for archive item
     *
     * @return string
     */
    public function itemClasses()
    {
        // Classes for all items
        $classes = array_merge(
            get_post_class(),
            array(
                $this->layout() . '-item',
                'grid-item',
                'w-full',
                'float-left',
                'mb-4',
                'lg:mb-4',
            )
        );

        // Cards specific classes
        if ($this->layout() === 'cards') {
            $classes = array_merge(
                $classes,
                array(
                    'flex',
                    'flex-wrap',
                    'flex-grow-0',
                    'flex-shrink',
                    'md:px-2',
                    'md:w-1/2',
                    'lg:w-1/3',
                )
            );
        }

        return implode(' ', apply_filters('stage_' . get_post_type() . '_archive_item_classes', $classes));
    }

    /**
     * Generates classes for single archive item
     *
     * @return string
     */
    public function itemInnerClasses()
    {
        // Classes for all items
        $classes = array(
            'post-inner',
            'overflow-hidden',
        );

        // Cards specific classes
        if ($this->data->get('display_thumbnail')) {
            $classes[] = 'featured-image';
        }

        // Cards specific classes
        if ($this->layout() === 'cards') {
            $classes[] = 'flex-1';
        }

        return implode(' ', apply_filters('stage_' . get_post_type() . '_archive_item_inner_classes', $classes));
    }

    /**
     * Generate a list of post tags
     *
     * @return string
     */
    public function itemTags()
    {
        $tags = get_the_tags(get_the_ID());
        $out  = '';

        if ($tags) {
            foreach ($tags as $tag) {
                $out     .= '<a href="' . get_tag_link($tag->term_id) . '" title="' . $tag->name . '">';
                    $out .= '<span class="
									inline-block
									bg-gray-200
									rounded-full
									px-3
									py-1
									text-xs
									font-semibold
									text-gray-700
									mr-2
									my-1
									hover:bg-primary
									hover:text-white">#' . $tag->name . '</span>';
                $out     .= '</a>';
            }
        }

        return $out;
    }

    /**
     * Post thumbnail with formatting
     *
     * @return string
     */
    public function itemThumbnail()
    {
        $container_classes = 'image-container overflow-hidden';
        $img_classes       = 'w-full';
        $out               = '';

        if ($this->layout() === 'cards') {
            $container_classes .= ' relative aspect-ratio-square overflow-hidden';
            $img_classes       .= ' h-full absolute inset-0 object-cover';
        }

        if (has_post_thumbnail()) {
            $out     .= '<div class="' . $container_classes . '">';
                $out .= get_the_post_thumbnail(get_the_ID(), 'large', array( 'class' => $img_classes ));
            $out     .= '</div>';
        } else {
            if ($this->layout() !== 'cards') {
                $container_classes .= ' aspect-ratio-3/2';
            }

            $out         .= '<div class="' . $container_classes . ' bg-primary">';
                $out     .= '<div class="
									absolute
									inset-0
									flex
									flex-wrap
									items-center
									content-center
									justify-center
									bg-primary">';
                    $out .= get_svg('image', 'absolute stroke-current text-body h-24 w-24');
                $out     .= '</div>';
            $out         .= '</div>';
        }

        return $out;
    }

    /**
     * Returns the layout type.
     *
     * @return string
     */
    public function layout()
    {
        return $this->data->get('layout');
    }
}
