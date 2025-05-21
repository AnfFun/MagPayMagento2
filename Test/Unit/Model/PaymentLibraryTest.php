<?php
/**
 * Unit test for PaymentLibrary
 */
declare(strict_types=1);

namespace GingerPay\Payment\Test\Unit\Model;

use GingerPay\Payment\Api\Config\RepositoryInterface as ConfigRepository;
use GingerPay\Payment\Model\Api\GingerClient;
use GingerPay\Payment\Model\PaymentLibrary;
use GingerPay\Payment\Service\Order\GetOrderByTransaction;
use GingerPay\Payment\Service\Transaction\ProcessUpdate as ProcessTransactionUpdate;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Payment;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class PaymentLibraryTest extends TestCase
{
    /**
     * @var PaymentLibrary
     */
    private $paymentLibrary;

    /**
     * @var ConfigRepository|MockObject
     */
    private $configRepositoryMock;

    /**
     * @var GingerClient|MockObject
     */
    private $gingerClientMock;

    /**
     * @var GetOrderByTransaction|MockObject
     */
    private $getOrderByTransactionMock;

    /**
     * @var ProcessTransactionUpdate|MockObject
     */
    private $processTransactionUpdateMock;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * Setup test environment
     */
    protected function setUp()
    {
        $this->objectManager = new ObjectManager($this);

        // Create mocks for dependencies
        $this->configRepositoryMock = $this->createMock(ConfigRepository::class);
        $this->gingerClientMock = $this->createMock(GingerClient::class);
        $this->getOrderByTransactionMock = $this->createMock(GetOrderByTransaction::class);
        $this->processTransactionUpdateMock = $this->createMock(ProcessTransactionUpdate::class);

        // Create partial mock for PaymentLibrary to avoid mocking all dependencies
        $this->paymentLibrary = $this->objectManager->getObject(
            PaymentLibrary::class,
            [
                'configRepository' => $this->configRepositoryMock,
                'gingerClient' => $this->gingerClientMock,
                'getOrderByTransaction' => $this->getOrderByTransactionMock,
                'processTransactionUpdate' => $this->processTransactionUpdateMock
            ]
        );
    }

    /**
     * Test loadGingerClient method
     */
    public function testLoadGingerClient()
    {
        $storeId = 1;
        $testApiKey = 'test_api_key';
        $mockClient = $this->createMock(\Ginger\ApiClient::class);

        // Configure mocks
        $this->gingerClientMock->expects($this->once())
            ->method('get')
            ->with($storeId, $testApiKey)
            ->willReturn($mockClient);

        // Call the method
        $result = $this->paymentLibrary->loadGingerClient($storeId, $testApiKey);

        // Assert result
        $this->assertSame($mockClient, $result);

        // Call again to test caching behavior
        $this->gingerClientMock->expects($this->never())
            ->method('get');

        $result = $this->paymentLibrary->loadGingerClient($storeId);
        $this->assertSame($mockClient, $result);
    }

    /**
     * Test processTransaction method with empty transaction ID
     */
    public function testProcessTransactionWithEmptyTransactionId()
    {
        // Call the method with empty transaction ID
        $result = $this->paymentLibrary->processTransaction('', 'webhook');

        // Assert result contains error
        $this->assertTrue($result['error']);
        $this->assertArrayHasKey('msg', $result);
    }

    /**
     * Test processTransaction method with valid transaction ID but order not found
     */
    public function testProcessTransactionWithOrderNotFound()
    {
        $transactionId = 'test_transaction_id';

        // Configure mocks
        $this->getOrderByTransactionMock->expects($this->once())
            ->method('execute')
            ->with($transactionId)
            ->willReturn(null);

        // Call the method
        $result = $this->paymentLibrary->processTransaction($transactionId, 'webhook');

        // Assert result contains error
        $this->assertTrue($result['error']);
        $this->assertArrayHasKey('msg', $result);
    }

    /**
     * Test processTransaction method with valid transaction ID and order
     */
    public function testProcessTransactionWithValidOrder()
    {
        $transactionId = 'test_transaction_id';
        $storeId = 1;
        $methodCode = 'ginger_methods_ideal';
        $testApiKey = 'test_api_key';

        // Create mock order and payment
        $orderMock = $this->createMock(Order::class);
        $paymentMock = $this->createMock(Payment::class);
        $paymentMethodMock = $this->createMock(\Magento\Payment\Model\MethodInterface::class);

        // Configure order mock
        $orderMock->expects($this->once())
            ->method('getStoreId')
            ->willReturn($storeId);
        $orderMock->expects($this->atLeastOnce())
            ->method('getPayment')
            ->willReturn($paymentMock);

        // Configure payment mock
        $paymentMock->expects($this->once())
            ->method('getMethodInstance')
            ->willReturn($paymentMethodMock);
        $paymentMock->expects($this->once())
            ->method('getAdditionalInformation')
            ->willReturn([]);

        // Configure payment method mock
        $paymentMethodMock->expects($this->once())
            ->method('getCode')
            ->willReturn($methodCode);

        // Configure config repository mock
        $this->configRepositoryMock->expects($this->once())
            ->method('getTestKey')
            ->with($methodCode, $storeId, '')
            ->willReturn($testApiKey);

        // Configure ginger client mock
        $mockClient = $this->createMock(\Ginger\ApiClient::class);
        $this->gingerClientMock->expects($this->once())
            ->method('get')
            ->with($storeId, $testApiKey)
            ->willReturn($mockClient);

        // Configure mock client response
        $transaction = ['id' => $transactionId, 'status' => 'completed'];
        $mockClient->expects($this->once())
            ->method('getOrder')
            ->with($transactionId)
            ->willReturn($transaction);

        // Configure get order by transaction mock
        $this->getOrderByTransactionMock->expects($this->once())
            ->method('execute')
            ->with($transactionId)
            ->willReturn($orderMock);

        // Configure process transaction update mock
        $expectedResult = ['success' => true];
        $this->processTransactionUpdateMock->expects($this->once())
            ->method('execute')
            ->with($transaction, $orderMock, 'webhook')
            ->willReturn($expectedResult);

        // Call the method
        $result = $this->paymentLibrary->processTransaction($transactionId, 'webhook');

        // Assert result
        $this->assertSame($expectedResult, $result);
    }
}
