Payments and sales API for Elgg
===============================
![Elgg 3.0](https://img.shields.io/badge/Elgg-3.0-orange.svg?style=flat-square)

## Features

 * Standardized API for handling payments and product sales
 * Interface for logging and refunding payments


## Usage

### New payment

```php

namespace hypeJunction\Payments;

// First, we create an itemized order/invoice
$order = new Order();
$order->setCurrency('EUR');

// Add a new product
$order->add($product, 2);

// Add additional fees and charges
$shipping = Amount::fromString('25.25', 'EUR');
$charges[] = new ShippingFee('shipping', 0, $shipping);

$charges[] = new ProcessingFee('paypal_fee', 3.9);

$order->setCharges($charges);

$address = new Address();
$address->street_address = 'Some street 25';
// add other address parts
$address->country_code = 'CZ';

$order->setShippingAddress($address);

// Now create a transaction
$transaction = new Transaction();
$transaction->setOrder($order);
$transaction->setPaymentMethod('paypal');

// Be sure to correctly set the owner and container and access id
// to ensure that both the merchant and the customer have access
// to the transaction entity
$transaction->owner_guid = $payer->guid;
$transaction->container_guid = $payee->guid;

// You can use access_grant to give access to the merchant,
// or create a new acccess collection that contains both the payer and the payee
$transaction->access_id = ACCESS_PRIVATE;

$transaction->save();

// Instantiate a gateway of choice
$gateway = new \hypeJunction\PayPal\API\Adapter();

// What you do with response may depend on where you are executing
// this code. From an action file, you can just return the $response.
$response = $adapter->pay($transaction);

```

