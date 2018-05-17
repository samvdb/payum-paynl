# Payum PayNL

The Payum PayNL extension

1. Require extension

```bash
$ composer create-project samvdb/payum-paynl
```

```php
<?php

use Payum\Core\PayumBuilder;
use Payum\Core\GatewayFactoryInterface;

$defaultConfig = [];

$payum = (new PayumBuilder)
    ->addGatewayFactory('paynl', function(array $config, GatewayFactoryInterface $coreGatewayFactory) {
        return new \Payum\Paynl\PaynlGatewayFactory($config, $coreGatewayFactory);
    })

    ->addGateway('paynl', [
        'factory' => 'paynl',
        'sandbox' => true,
        'token' => '',
        'service_id' => ''
    ])

    ->getPayum()
;
```

5. While using the gateway implement all method where you get `Not implemented` exception:

```php
<?php

use Payum\Core\Request\Capture;

$paynl = $payum->getGateway('paynl');

$model = new \ArrayObject([
  // ...
]);

$paynl->execute(new Capture($model));
```


## License

Released under the [MIT License](LICENSE).
