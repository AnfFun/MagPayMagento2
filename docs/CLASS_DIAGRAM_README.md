# Payment Plugin UML Class Diagram

This UML Class Diagram represents the key classes and their relationships in the GingerPay Payment plugin.

## How to Open the Diagram

1. Go to [draw.io](https://app.diagrams.net/)
2. Click on "Open Existing Diagram"
3. Select "Open from Device" and choose the `CLASS_DIAGRAM.drawio` file

## Diagram Overview

The diagram illustrates the following key components:

### Inheritance Hierarchy

- **AbstractMethod** (Magento Core): The base payment method class from Magento
  - **PaymentLibrary**: Extends AbstractMethod and provides core payment functionality
    - **AbstractPayment**: Extends PaymentLibrary and adds payment-specific functionality
      - **PaymentLibraryRedefiner**: An intermediary class for extensibility
        - **Creditcard**, **Afterpay**, **KlarnaPayLater**: Concrete payment method implementations

### Service Classes

- **OrderLines** → **ServiceOrderLinesRedefiner** → **ServiceOrderLinesBuilder**: Classes for handling order line items

### API Classes

- **GingerClient** → **ModelBuilderRedefiner** → **LibraryConfigProvider**: Classes for API communication and configuration

### Key Relationships

- PaymentLibrary uses GingerClient for API communication
- PaymentLibrary uses OrderLines for handling order line items

## Class Descriptions

### Core Payment Classes

- **AbstractMethod**: Magento's base payment method class
- **PaymentLibrary**: Core payment functionality including transaction processing and refunds
- **AbstractPayment**: Adds payment-specific functionality like capturing and voiding
- **PaymentLibraryRedefiner**: Intermediary class for extensibility
- **Creditcard**, **Afterpay**, **KlarnaPayLater**: Specific payment method implementations

### Service Classes

- **OrderLines**: Service for handling order line items
- **ServiceOrderLinesRedefiner**: Intermediary class for extensibility
- **ServiceOrderLinesBuilder**: Implementation of order line handling

### API Classes

- **GingerClient**: Client for API communication
- **ModelBuilderRedefiner**: Defines API endpoint
- **LibraryConfigProvider**: Provides configuration for payment methods