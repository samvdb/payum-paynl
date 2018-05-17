<?php

namespace Payum\Paynl\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Reply\HttpPostRedirect;
use Payum\Core\Request\Capture;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Paynl\Request\Api\CreateCharge;

class CaptureAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritDoc}
     *
     * @param Capture $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $afterUrl = $request->getToken()->getAfterUrl();

        $model['returnUrl'] = $afterUrl;

        $this->gateway->execute(new CreateCharge($model));

        if (isset($model['transaction']['paymentURL'])) {
            $url = $model['transaction']['paymentURL'];
            throw new HttpPostRedirect(
                $url
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Capture &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
