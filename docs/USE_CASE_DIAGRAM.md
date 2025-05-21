# GingerPay Use Case Diagram

This document provides a use case diagram that illustrates the main functionalities and interactions in the GingerPay payment plugin.

## Overview

The use case diagram shows the interactions between the following actors and the system:

- **Customer**: End-user who makes payments using the plugin
- **Merchant/Admin**: Store administrator who configures and manages the payment methods
- **Ginger API**: External API service that processes payment transactions
- **Payment Provider**: External payment service providers (like Afterpay, Klarna, etc.)

## How to View the Diagram

The use case diagram is created using draw.io (diagrams.net). To view and edit the diagram:

1. Go to [diagrams.net](https://app.diagrams.net/)
2. Click on "Open Existing Diagram"
3. Select "Open from Device" and upload the `USE_CASE_DIAGRAM.drawio` file
4. Alternatively, you can use the desktop version of draw.io

## Use Cases Description

The diagram illustrates the following main use cases:

### Customer Use Cases
1. **Select Payment Method**: Customer selects one of the available payment methods during checkout
2. **Initiate Payment**: Customer initiates the payment process
3. **Complete Payment**: Customer completes the payment on the payment provider's platform

### Merchant/Admin Use Cases
1. **Configure Payment Methods**: Merchant configures which payment methods are available and their settings
2. **Refund Payment**: Merchant processes refunds for completed transactions

### System Use Cases
1. **Create Order in API**: System creates an order in the Ginger API
2. **Send Webhook Notification**: System sends webhook notifications for payment status updates
3. **Process Webhook Callback**: System processes incoming webhook callbacks

## Relationships

The diagram shows several types of relationships:

- **Association**: Connects actors to the use cases they participate in (solid lines)
- **Include**: Indicates that one use case includes the functionality of another use case (dashed lines with <<include>> label)
- **Extend**: Indicates that one use case may be extended by another use case (dashed lines with <<extend>> label)

## Key Include Relationships
- "Initiate Payment" includes "Create Order in API"
- "Complete Payment" includes "Send Webhook Notification"
- "Send Webhook Notification" includes "Process Webhook Callback"

## Key Extend Relationships
- "Select Payment Method" extends "Initiate Payment"

## Implementation Details

The use cases in the diagram correspond to the following components in the codebase:

- **Select Payment Method**: Implemented in the checkout frontend
- **Initiate Payment**: Handled by `PaymentLibrary::prepareTransaction()`
- **Complete Payment**: Processed by the payment provider and Ginger API
- **Create Order in API**: Implemented in `PaymentLibrary::createOrder()`
- **Send Webhook Notification**: Handled by Ginger API
- **Process Webhook Callback**: Implemented in `Webhook::execute()` and `PaymentLibrary::processTransaction()`
- **Configure Payment Methods**: Managed through Magento admin configuration
- **Refund Payment**: Implemented in `AbstractPayment::refundFunctionality()`