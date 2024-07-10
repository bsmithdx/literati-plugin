<?php

namespace Literati\Example\Tests;

use Literati\Example\PostTypes;
use WP_Mock\Tools\TestCase as TestCase;
use WP_Mock;

final class PostTypesTest extends TestCase {
	public function test_handle_promotion_data_create() {
		WP_Mock::userFunction('get_post_meta')
		       ->once()
		       ->with(1, 'meta_key', true)
		       ->andReturn('');

		WP_Mock::userFunction('add_post_meta')
		       ->once()
		       ->with(1, 'meta_key', 'hello world', true);

		PostTypes::handle_promotion_data('meta_key', 'hello world', 1);
		TestCase::assertConditionsMet();
	}

	public function test_handle_promotion_data_update() {
		WP_Mock::userFunction('get_post_meta')
		       ->once()
		       ->with(1, 'meta_key', true)
		       ->andReturn('existing value');

		WP_Mock::userFunction('update_post_meta')
		       ->once()
		       ->with(1, 'meta_key', 'hello world');

		PostTypes::handle_promotion_data('meta_key', 'hello world', 1);
		TestCase::assertConditionsMet();
	}
	public function test_handle_promotion_data_delete() {
		WP_Mock::userFunction('get_post_meta')
		       ->once()
		       ->with(1, 'meta_key', true)
		       ->andReturn('existing value');

		WP_Mock::userFunction('delete_post_meta')
		       ->once()
		       ->with(1, 'meta_key');

		PostTypes::handle_promotion_data('meta_key', '', 1);
		TestCase::assertConditionsMet();
	}
}