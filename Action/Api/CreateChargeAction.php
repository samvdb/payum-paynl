<?php

namespace Payum\Paynl\Action\Api;

use Paynl\Error\Error;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Paynl\Request\Api\CreateCharge;

class CreateChargeAction extends BaseApiAwareAction
{
    /**
     * @param mixed $request
     *
     * @throws \Payum\Core\Exception\RequestNotSupportedException if the action dose not support the request.
     */
    public function execute($request)
    {
        /** @var $request CreateCharge */
        RequestNotSupportedException::assertSupports($this, $request);
        $model = ArrayObject::ensureArrayObject($request->getModel());

        try {
            $result = $this->api->doRequest($model->toUnsafeArray());
            $model->replace($result->getData());
        } catch (Error $e) {
            $model->replace(['error' => $e->getMessage(), 'error_id' => $e->getCode()]);
        }
    }

    /**
     * @param mixed $request
     *
     * @return boolean
     */
    public function supports($request)
    {
        return
            $request instanceof CreateCharge &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
