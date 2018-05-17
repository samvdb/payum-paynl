<?php

namespace Payum\Paynl;

use Payum\Paynl\Action\Api\CheckTransactionStatusAction;
use Payum\Paynl\Action\Api\CreateChargeAction;
use Payum\Paynl\Action\AuthorizeAction;
use Payum\Paynl\Action\CancelAction;
use Payum\Paynl\Action\ConvertPaymentAction;
use Payum\Paynl\Action\CaptureAction;
use Payum\Paynl\Action\NotifyAction;
use Payum\Paynl\Action\RefundAction;
use Payum\Paynl\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use Payum\Paynl\Request\Api\CreateCharge;

class PaynlGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults(
            [
                'payum.factory_name'                        => 'paynl',
                'payum.factory_title'                       => 'PayNL',
                'payum.action.capture'                      => new CaptureAction(),
                'payum.action.status'                       => new StatusAction(),
                'payum.action.api.create_charge'            => new CreateChargeAction(),
                'payum.action.api.check_transaction_status' => new CheckTransactionStatusAction(),
                'payum.action.convert_payment'              => new ConvertPaymentAction(),
            ]
        );

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'sandbox'    => false,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = [
                'token',
                'service_id',
            ];

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                $api            = new Api(
                    (array)$config
                );
                $api->apiToken  = $config['token'];
                $api->serviceId = $config['service_id'];
                $api->sandbox   = $config['sandbox'];

                return $api;
            };
        }
    }
}
