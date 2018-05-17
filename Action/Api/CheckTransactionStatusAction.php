<?php

namespace Payum\Paynl\Action\Api;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetHumanStatus;
use Payum\Paynl\Request\Api\GetStatus;

class CheckTransactionStatusAction extends BaseApiAwareAction
{

    /**
     * @param mixed $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);
        $details = ArrayObject::ensureArrayObject($request->getModel());

        if (!isset($details['transaction']['transactionId'])) {
            return;
        }

        $transaction = $this->api->getTransactionById($details['transaction']['transactionId']);

        $details['transaction_id'] = $transaction->getId();
        $details['transaction']    = $transaction->getData();
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatus &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
