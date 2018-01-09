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

		$comment_author_hierarchy = array( 'comment\\post', 'author', 'user' );
		$post_author_hierarchy    = array(
			'comment\\post',
			'post\\post',
			'post\\post',
			'author',
			'user',
		);

		// See which target the points will go to.
		$target_hierarchy = $fire->reaction->get_meta( 'target' );

		// We only are interested when the points will go to the comment author or
		// the post author...
		if ( $comment_author_hierarchy === $target_hierarchy ) {
			$trigger_hierarchy = $post_author_hierarchy;
		} elseif ( $post_author_hierarchy === $target_hierarchy ) {
			$trigger_hierarchy = $comment_author_hierarchy;
		} else {
			return true;
		}

		// ...AND the comment author is also the post author.
		$target  = $fire->event_args->get_from_hierarchy( $target_hierarchy );
		$trigger = $fire->event_args->get_from_hierarchy( $trigger_hierarchy );

		// If we got both successfully, and they are both the same, then don't award
		// any points.
		if (
			$target instanceof WordPoints_Entity
			&& $trigger instanceof WordPoints_Entity
			&& $target->get_the_id() === $trigger->get_the_id()
		) {
			return false;
		}

		// Otherwise, let the points get awarded.
		return true;
	}
}

// EOF
