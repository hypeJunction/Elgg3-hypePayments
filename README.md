Payments and sales API for Elgg
===============================
![Elgg 2.3](https://img.shields.io/badge/Elgg-2.3-orange.svg?style=flat-square)

## Features

 * API for handling payments and product sales
 * Transaction history

## Notes

 * Transactions are stored as JSON files on the filestore. The idea is to have all the
data on file even after merchant, product or other entities are deleted from the system.
For this reason, use of metadata is limited to `transaction_id` and `status`,
and `merchant` and `customer` info are stored as relationships. Product info, subtotals and totals
should be stored within the transaction file to avoid incomplete representation of the
transaction in history.

