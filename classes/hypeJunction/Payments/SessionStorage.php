<?php

namespace hypeJunction\Payments;

/**
 * Implements Storage Interface for storing campaign cart object in the session
 */
class SessionStorage implements StorageInterface {

	/**
	 * {@inheritdoc}
	 */
	public function get($id) {
		$data = elgg_get_session()->get("payments:$id");
		if ($data) {
			return unserialize($data);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function invalidate($id) {
		return elgg_get_session()->remove("payments:$id");
	}

	/**
	 * {@inheritdoc}
	 */
	public function put($id, $data) {
		return elgg_get_session()->set("payments:$id", serialize($data));
	}

}
