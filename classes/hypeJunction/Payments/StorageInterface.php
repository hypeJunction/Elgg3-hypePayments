<?php

namespace hypeJunction\Payments;

/**
 * Storage interface
 */
interface StorageInterface {

	/**
	 * Returns a stored order by its id
	 *
	 * @param mixed $id ID
	 * @return array
	 */
	public function get($id);

	/**
	 * Save order
	 *
	 * @param mixed $id ID
	 * @param mixed $data Data
	 * @return void
	 */
	public function put($id, $data);

	/**
	 * Flushes stored order by its id
	 *
	 * @param mixed $id ID
	 * @return void
	 */
	public function invalidate($id);
}
