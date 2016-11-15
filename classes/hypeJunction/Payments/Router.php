<?php

namespace hypeJunction\Payments;

class Router {

	/**
	 * Payments page handler
	 *
	 * @param array $segments URL segments
	 * @return bool
	 */
	public static function controller($segments) {

		$page = array_shift($segments);

		switch ($page) {

			case 'history' :
				$guid = array_shift($segments) ? : elgg_get_logged_in_user_guid();
				echo elgg_view('resources/payments/history', [
					'guid' => $guid,
				]);
				return true;

			case 'transaction' :
				$id = array_shift($segments);
				$filter_context = array_shift($segments) ? : 'view';
				echo elgg_view('resources/payments/transaction', [
					'id' => $id,
					'filter_context' => $filter_context,
				]);
				return true;
		}

		return false;
	}

	/**
	 * Transaction URL handler
	 *
	 * @param string $hook   "entity:url"
	 * @param string $type   "object"
	 * @param string $return URL
	 * @param array  $params Hook params
	 * @return string
	 */
	public static function urlHandler($hook, $type, $return, $params) {

		$entity = elgg_extract('entity', $params);

		if ($entity instanceof Transaction) {
			return elgg_normalize_url("/payments/transaction/$entity->transaction_id");
		}
	}

}
