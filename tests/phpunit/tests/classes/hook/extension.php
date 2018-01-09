<?php

/**
 * Test case for WordPoints_NCPFPA_Hook_Extension.
 *
 * @package WordPoints_NCPFPA
 * @since 1.0.0
 */

/**
 * Tests WordPoints_NCPFPA_Hook_Extension.
 *
 * @since 1.0.0
 *
 * @covers WordPoints_NCPFPA_Hook_Extension
 */
class WordPoints_NCPFPA_Hook_Extension_Test
	extends WordPoints_PHPUnit_TestCase_Points {

	/**
	 * Test no points are awarded when the post author leaves a comment.
	 *
	 * @since 1.0.0
	 */
	public function test_target_comment_author_post_author_comment() {

		$this->create_points_reaction(
			array(
				'event'  => 'comment_leave\\post',
				'target' => array( 'comment\\post', 'author', 'user' ),
			)
		);

		$post_author = $this->factory->user->create();

		$this->factory->comment->create(
			array(
				'user_id'         => $post_author,
				'comment_post_ID' => $this->factory->post->create(
					array(
						'post_author' => $post_author,
						'post_type'   => 'post',
					)
				),
			)
		);

		$this->assertSame( 0, wordpoints_get_points( $post_author, 'points' ) );
	}

	/**
	 * Test points are awarded when a comment is left on another user's post.
	 *
	 * @since 1.0.0
	 */
	public function test_target_comment_author_other_user_comment() {

		$this->create_points_reaction(
			array(
				'event'  => 'comment_leave\\post',
				'target' => array( 'comment\\post', 'author', 'user' ),
			)
		);

		$post_author = $this->factory->user->create();

		$this->factory->comment->create(
			array(
				'user_id'         => $post_author,
				'comment_post_ID' => $this->factory->post->create(
					array(
						'post_author' => $this->factory->user->create(),
						'post_type'   => 'post',
					)
				),
			)
		);

		$this->assertSame( 100, wordpoints_get_points( $post_author, 'points' ) );
	}

	/**
	 * Test no points are awarded when the post author leaves a comment.
	 *
	 * @since 1.0.1
	 */
	public function test_target_post_author_post_author_comment() {

		$this->create_points_reaction(
			array(
				'event'  => 'comment_leave\\post',
				'target' => array( 'comment\\post', 'post\\post', 'post\\post', 'author', 'user' ),
			)
		);

		$post_author = $this->factory->user->create();

		$this->factory->comment->create(
			array(
				'user_id'         => $post_author,
				'comment_post_ID' => $this->factory->post->create(
					array(
						'post_author' => $post_author,
						'post_type'   => 'post',
					)
				),
			)
		);

		$this->assertSame( 0, wordpoints_get_points( $post_author, 'points' ) );
	}

	/**
	 * Test points are awarded when another user leaves a comment.
	 *
	 * @since 1.0.1
	 */
	public function test_target_post_author_other_user_comment() {

		$this->create_points_reaction(
			array(
				'event'  => 'comment_leave\\post',
				'target' => array( 'comment\\post', 'post\\post', 'post\\post', 'author', 'user' ),
			)
		);

		$post_author = $this->factory->user->create();

		$this->factory->comment->create(
			array(
				'user_id'         => $this->factory->user->create(),
				'comment_post_ID' => $this->factory->post->create(
					array(
						'post_author' => $post_author,
						'post_type'   => 'post',
					)
				),
			)
		);

		$this->assertSame( 100, wordpoints_get_points( $post_author, 'points' ) );
	}
}

// EOF
