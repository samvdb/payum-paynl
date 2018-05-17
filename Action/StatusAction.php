<?php

namespace Payum\Paynl\Action;

use Payum\Core\Action\ActionInterface;
use Payum\Core\GatewayAwareInterface;
use Payum\Core\GatewayAwareTrait;
use Payum\Core\Request\GetStatusInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Paynl\Request\Api\GetStatus;

class StatusAction implements ActionInterface, GatewayAwareInterface
{
    use GatewayAwareTrait;

    /**
     * {@inheritDoc}
     *
     * @param GetStatusInterface $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $model = ArrayObject::ensureArrayObject($request->getModel());

        $this->gateway->execute($status = new GetStatus($model));

        $details = $status->getModel();

        if (!$details['transaction']) {
            $request->markNew();

            return;
        }

        $transaction = new \Paynl\Result\Transaction\Transaction($details['transaction']);

        if ($transaction->isPaid()) {
            $request->markCaptured();

            return;
        }

        if ($transaction->isCanceled()) {
            $request->markCanceled();

            return;
        }

        if ($transaction->isRefunded()) {
            $request->markRefunded();

            return;
        }

        if (!$transaction->getId()) {
            $request->markNew();

            return;
        }

        if ($transaction->isAuthorized()) {
            $request->markAuthorized();

            return;
        }

        if ($transaction->isPending()) {
            $request->markPending();

            return;
        }

        if ($transaction->isBeingVerified()) {
            $request->markFailed();

            return;
        }
        $request->markUnknown();
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof GetStatusInterface &&
            $request->getModel() instanceof \ArrayAccess;
    }
}
