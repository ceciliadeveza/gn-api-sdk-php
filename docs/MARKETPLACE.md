## Marketplace ##

If you want use marketplace, use as follow:

```php
$repass = new RepassGerencianet();
$repass->payeeCode('payee_code_to_repass')
       ->percentage(7000);

$mkp = new MarketplaceGerencianet();
$mkp->addRepass($repass);

$item = new ItemGerencianet();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->marketplace($mkp);
```

### Shipping repass ###

If you want send the shipping value to another Gerencianet account, you need the account payee code e must send so:
```php
$shipping->payeeCode('payee_code_to_repass')
         ->name('Shipping')
         ->value(2000);
```