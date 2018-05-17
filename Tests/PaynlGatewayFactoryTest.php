<?php

namespace Payum\Paynl\Tests;

use Payum\Paynl\PaynlGatewayFactory;

class PaynlGatewayFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function shouldImplementCheckoutGatewayFactoryInterface()
    {
        $rc = new \ReflectionClass('Payum\Paynl\PaynlGatewayFactory');
        $this->assertTrue($rc->implementsInterface('Payum\Core\GatewayFactoryInterface'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new PaynlGatewayFactory();
    }
}