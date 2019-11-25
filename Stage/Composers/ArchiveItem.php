<?php

namespace App\Composers;

use Roots\Acorn\View\Composer;

class ArchiveItem extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'partials.content',
		'partials.content-*'
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		return [
			'title'         => get_the_title(),
			'excerpt'       => get_the_excerpt(),
			'tags'          => $this->item_tags(),
			'classes'       => $this->item_classes(),
			'inner_classes' => $this->item_inner_classes(),
			'permalink'     => get_permalink(),
			'has_thumbnail' => has_post_thumbnail(),
			'thumbnail'     => $this->item_thumbnail(),
		];
	}

	/**
	 * Data to overwrite before rendering.
	 *
	 * @return array
	 */
	public function override() {
		return [
			'layout' => $this->layout(),
			'classes' => $this->item_classes(),
		];
	}

	/**
	 * Generates classes for archive item
	 *
	 * @return string
	 */
	public function item_classes() {
		// Classes for all items
		$classes = $this->layout() . '-item w-full grid-item w-full float-left';

		// Cards specific classes
		if ( $this->layout() === 'cards' ) {
			$classes .= ' flex flex-wrap flex-grow-0 flex-shrink md:w-1/2 lg:w-1/3';
		}

		return implode(' ', get_post_class( $classes ));
	}


	/**
	 * Generates classes for archive item
	 *
	 * @return string
	 */
	public function item_inner_classes() {
		// Classes for all items
		$classes = 'post-inner mx-4 mb-8 shadow-lg overflow-hidden rounded';

		// Cards specific classes
		if ( $this->data->get('display_thumbnail') ) {
			$classes .= '';
		}

		// Cards specific classes
		if ( $this->layout() === 'cards' ) {
			$classes .= ' flex-1';
		}

		return $classes;
	}

	/**
	 * Generate a list of post tags
	 *
	 * @return string
	 */
	public function item_tags() {
		$tags = get_the_tags( get_the_ID() );
		$out = '';

		if ( $tags ) {
			foreach ( $tags as $tag ) {
				$out .= '<a href="' . get_tag_link( $tag->term_id ) . '" title="' . $tag->name . '">';
					$out .= '<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-xs font-semibold text-gray-700 mr-2 my-1 hover:bg-primary">#' . $tag->name . '</span>';
				$out .= '</a>';
			}
		}

		return $out;
	}

	/**
	 * Post thumbnail with formatting
	 *
	 * @return string
	 */
	public function item_thumbnail() {
		$container_classes = 'image-container';
		$img_classes = 'w-full';
		$out = '';

		if( $this->layout() === 'cards' ) {
			$container_classes .= ' relative aspect-ratio-square overflow-hidden';
			$img_classes .= ' h-full absolute inset-0 object-cover';
		}

		if ( has_post_thumbnail() ) {
			$out .= '<div class="' . $container_classes . '">';
				$out .= get_the_post_thumbnail( get_the_ID(), 'large', [ 'class' => $img_classes ] );
			$out .= '</div>';
		} else {

			if( $this->layout() !== 'cards' ) {
				$container_classes .= ' aspect-ratio-3/2';
			}

			$out .= '<div class="' . $container_classes . ' bg-primary">';
				$out .= '<div class="absolute inset-0 flex flex-wrap justify-center content-center items-center bg-primary">';
					$out .= get_svg( 'image', 'absolute stroke-current text-body h-24 w-24' );
				$out .= '</div>';
			$out .= '</div>';
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
