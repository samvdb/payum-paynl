<?php

namespace Payum\Paynl;

use Paynl\Error\Error;
use Paynl\Result\Transaction\Start;

class Api
{
    /**
     * @var array
     */
    protected $options = [];
    /**
     * @var string
     */
    public $serviceId;
    /**
     * @var string
     */
    public $apiToken;
    /**
     * @var boolean
     */
    public $sandbox;

    /**
     * @param array               $options
     *
     * @throws \Payum\Core\Exception\InvalidArgumentException if an option is invalid
     */
    public function __construct(array $options)
    {
        $this->options        = $options;
    }

    /**
     * @param array $fields
     *
     * @return Start
     * @throws Error
     */
    public function doRequest(array $fields)
    {
        $this->addAuthorizeFields();
        $fields = array_merge($fields, ['testmode' => $this->sandbox]);
        $result = \Paynl\Transaction::start($fields);

        return $result;
    }

    /**
     * @return \Paynl\Result\Transaction\Transaction
     */
    public function getReturnTransaction()
    {
        $this->addAuthorizeFields();

        return \Paynl\Transaction::getForReturn();
    }

    protected function addAuthorizeFields()
    {
        \Paynl\Config::setApiToken($this->options['token']);
        \Paynl\Config::setServiceId($this->options['service_id']);
    }

    public function getTransactionById($id)
    {
        $this->addAuthorizeFields();

        return \Paynl\Transaction::get($id);
    }
}
