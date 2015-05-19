## Marketplace ##

If you want use marketplace, use as follow:

```php
$repass = new Repass();
$repass->payeeCode('payee_code_to_repass')
       ->percentage(7000);

$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepass($repass);
```

You have two options to add repasses in the item:

* Add one repass at a time:
```php
$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepass($repass);
```

* Add many repasses:
```php
$item = new Item();
$item->name('Item')
     ->value(500)
     ->amount(2)
     ->addRepasses([$repass1, $repass2]);
```

### Shipping repass ###

If you want send the shipping value to another Gerencianet account, you need the account payee code e must send so:
```php
$shipping->payeeCode('payee_code_to_repass')
         ->name('Shipping')
         ->value(2000);
```