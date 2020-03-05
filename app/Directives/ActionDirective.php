<?php

namespace Stage\Directives;

class ActionDirective {

	/**
	 * Invoke the @action directive.
	 *
	 * @param  string $expression
	 * @return string
	 */
	public function __invoke( $expression ) {
		return sprintf( '123<?= %s(%s); ?>', '\\Stage\\stage_do_action', $expression );
	}
}
