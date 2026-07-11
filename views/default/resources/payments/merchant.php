<?php
/**
 * Dispatcher for the `collection:object:transaction:merchant` route
 * (/payments/merchant/{guid}) — a merchant's own transaction collection.
 *
 * The route named a resource view, resources/payments/merchant.php, that was never
 * created, so /payments/merchant/{guid} raised ResourceNotFoundException and 404'd
 * (bd elgg-migrate-ckn0c). Its sibling resources/payments/history.php (the customer
 * route) builds its collection from $request->getRoute(), so it is route-agnostic:
 * reached through the merchant route it renders the merchant collection. Delegate to
 * it rather than duplicating the collection/permission/breadcrumb boilerplate.
 */

echo elgg_view('resources/payments/history', $vars);
