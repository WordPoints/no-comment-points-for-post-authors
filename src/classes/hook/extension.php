<?php

/**
 * Hook extension class.
 *
 * @package WordPoints_NCPFPA
 * @since   1.0.0
 */

/**
 * Class WordPoints_NCPFPA_Hook_Extension
 *
 * @since 1.0.0
 */
class WordPoints_NCPFPA_Hook_Extension extends WordPoints_Hook_Extension {

	/**
	 * @since 1.0.0
	 */
	public function should_hit( WordPoints_Hook_Fire $fire ) {

		// We are only interested in post comments.
		if ( $fire->reaction->get_event_slug() !== 'comment_leave\\post' ) {
			return true;
		}

		// See which target the points will go to.
		$target_hierarchy = $fire->reaction->get_meta( 'target' );

		// We only are interested when the points will go to the comment author...
		if ( array( 'comment\\post', 'author', 'user' ) !== $target_hierarchy ) {
			return true;
		}

		// ...AND the comment author is also the post author.
		$comment_author = $fire->event_args->get_from_hierarchy( $target_hierarchy );
		$post_author    = $fire->event_args->get_from_hierarchy(
			array( 'comment\\post', 'post\\post', 'post\\post', 'author', 'user' )
		);

		// If we got both successfully, and they are both the same, then don't award
		// any points.
		if (
			$comment_author instanceof WordPoints_Entity
			&& $post_author instanceof WordPoints_Entity
			&& $comment_author->get_the_id() === $post_author->get_the_id()
		) {
			return false;
		}

		// Otherwise, let the points get awarded.
		return true;
	}
}

// EOF
