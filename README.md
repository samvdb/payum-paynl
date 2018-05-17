# Payum PayNL
[![Build Status](https://travis-ci.org/samvdb/Payum-paynl.png?branch=master)](https://travis-ci.org/samvdb/Payum-paynl)
[![Total Downloads](https://poser.pugx.org/samvdb/Payum-paynl/d/total.png)](https://packagist.org/packages/samvdb/Payum-paynl)
[![Latest Stable Version](https://poser.pugx.org/samvdb/Payum-paynl/version.png)](https://packagist.org/packages/samvdb/Payum-paynl)


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
