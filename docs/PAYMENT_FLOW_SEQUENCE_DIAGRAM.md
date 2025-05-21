# GingerPay Payment Flow Sequence Diagram

This document provides a sequence diagram that illustrates the payment flow in the GingerPay module.

## Overview

The sequence diagram shows the interactions between the following components:

- Customer
- Checkout
- PaymentLibrary
- ServiceOrderBuilder
- ApiBuilder
- Ginger API
- Webhook
- TransactionBuilder

## How to View the Diagram

The sequence diagram is created using draw.io (diagrams.net). To view and edit the diagram:

1. Go to [diagrams.net](https://app.diagrams.net/)
2. Click on "Open Existing Diagram"
3. Select "Open from Device" and upload the `PAYMENT_FLOW_SEQUENCE_DIAGRAM.drawio` file
4. Alternatively, you can use the desktop version of draw.io

## Payment Flow Description

The diagram illustrates the following payment flow:

1. Customer selects a payment method in the checkout
2. Checkout calls the redirect method
3. PaymentLibrary prepares the transaction by calling prepareTransaction
4. ServiceOrderBuilder collects data for the order
5. PaymentLibrary loads the Ginger client
6. ApiBuilder gets the client
7. PaymentLibrary creates an order in the Ginger API
8. Ginger API returns the transaction
9. PaymentLibrary processes the request using TransactionBuilder
10. TransactionBuilder returns the redirect URL
11. Customer is redirected to the payment page
12. Customer completes the payment
13. Ginger API sends a webhook notification
14. Webhook controller processes the transaction
15. PaymentLibrary updates the transaction using TransactionBuilder

## Key Methods

The main methods involved in the payment flow are:

- `redirect()` - Initiates the payment process
- `prepareTransaction()` - Prepares the transaction data
- `collectDataForOrder()` - Collects order data for the transaction
- `loadGingerClient()` - Loads the Ginger API client
- `createOrder()` - Creates an order in the Ginger API
- `processRequest()` - Processes the transaction request
- `processTransaction()` - Processes the transaction update from the webhook
- `processUpdate()` - Updates the transaction status

## File Locations

The key files involved in the payment flow are:

- `/Payment/Model/PaymentLibrary.php` - Main payment library
- `/Payment/Model/Builders/ServiceOrderBuilder.php` - Builds order data
- `/Payment/Model/Builders/ApiBuilder.php` - Builds API client
- `/Payment/Model/Builders/TransactionBuilder.php` - Builds and processes transactions
- `/Payment/Controller/Checkout/Webhook.php` - Handles webhook callbacks
- `/Payment/Redefiners/Controller/ControllerCheckoutActionRedefiner.php` - Redefines controller actions
- `/Payment/Model/Builders/ControllerCheckoutActionBuilder.php` - Builds controller actions