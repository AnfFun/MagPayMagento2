# Database Architecture Integration - GingerPay Payment Module

This document explains the database architecture and integration of the GingerPay Payment module with the Magento 2 database.

## Overview

The GingerPay Payment module integrates with Magento's database in two main ways:

1. **Extension of Existing Tables**: Adds custom fields to Magento's core tables
2. **Custom Tables**: Creates its own tables for module-specific data

A diagram illustrating this architecture is available in the `DATABASE_ARCHITECTURE.drawio` file, which can be opened using [Draw.io](https://app.diagrams.net/).

## Magento Core Database Tables

The module interacts with the following Magento core tables:

- **sales_order**: Stores order information
- **sales_order_payment**: Stores payment information for orders
- **sales_order_grid**: Used for displaying orders in the admin grid
- **quote_payment**: Stores payment information for quotes (shopping carts)

## GingerPay Database Extensions

### Custom Fields Added to Magento Tables

The module adds the following custom fields to Magento's core tables:

- **sales_order.gingerpay_transaction_id**: Stores the GingerPay transaction ID for each order
  - This field is added in `SetupBuilder.php` using the `addTansactionId` method
  - An index is also created on this field using the `addIndex` method

This transaction ID is used to link Magento orders with GingerPay transactions, allowing the module to retrieve transaction status updates and process refunds.

## Custom Tables

The module creates the following custom table:

### gingerpay_product

This table stores product information specific to the GingerPay module.

**Table Structure:**
- **entity_id**: Primary key
- **name**: Product name
- **price**: Product price
- **description**: Product description
- **created_at**: Timestamp when the record was created
- **updated_at**: Timestamp when the record was last updated

This table is created in `InstallSchema.php` and accessed through the `GingerPay\Payment\Model\ResourceModel\Product` resource model.

## Database Interaction Flow

1. **Order Creation**:
   - When an order is placed using a GingerPay payment method, the module creates a transaction in the GingerPay API
   - The transaction ID is stored in the `sales_order.gingerpay_transaction_id` field

2. **Transaction Processing**:
   - The module retrieves orders using the transaction ID stored in `sales_order.gingerpay_transaction_id`
   - It then processes transaction updates from the GingerPay API

3. **Refunds**:
   - When a refund is requested, the module retrieves the transaction ID from the order
   - It then creates a refund in the GingerPay API using this transaction ID

## Integration with Magento's ORM

The module uses Magento's Object-Relational Mapping (ORM) system to interact with the database:

- **Models**: Represent data entities and business logic
- **Resource Models**: Handle database operations
- **Collections**: Retrieve multiple model instances

For example, the `GingerPay\Payment\Model\Product` model uses the `GingerPay\Payment\Model\ResourceModel\Product` resource model to interact with the `gingerpay_product` table.

## Conclusion

The GingerPay Payment module integrates with Magento's database by extending existing tables and creating custom tables. This integration allows the module to store and retrieve payment-related data while maintaining compatibility with Magento's core functionality.