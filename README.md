# UK Postcode Helper
PHP Helper class for dealing with UK postcodes.

Used to break postcodes in to parts based on

https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Formatting

## How to use

Break in to parts
```php
<?php

$postcode = new Postcode('SR5 1NA');

$postcode->get();
$postcode->getOutward();
$postcode->getInward();
$postcode->getArea();
$postcode->getDistrict();
$postcode->getSector();
$postcode->getUnit();
```

Validate a postcode
```php
<?php

$good = Postcode::validate('SR5 1nA');
```

Format Postcodes in a consistent way
```php
<?php

$formatted = Postcode::format('Sr51NA'); // SR51NA
$formatted = Postcode::format('sR5 1NA'); // SR51NA
```

Pull a postcode from an address string
```php
<?php

$postcode = Postcode::findInString('1 Fake Street, Fake Vil, Fake Country, SR51NA');
```
