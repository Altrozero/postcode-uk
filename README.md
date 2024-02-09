[![codecov](https://codecov.io/gh/maksimovic/postcode-uk/branch/master/graph/badge.svg?token=77DATYD2HN)](https://codecov.io/gh/maksimovic/postcode-uk)

# UK Postcode Helper
PHP Helper class for dealing with UK postcodes.

Used to break postcodes in to parts based on

https://en.wikipedia.org/wiki/Postcodes_in_the_United_Kingdom#Formatting

## How to use

Break in to parts
```php
<?php

$postcode = new Postcode('SR5 1NA');

$postcode->get(); // SR51NA
$postcode->getOutward(); //SR5
$postcode->getInward(); // 1NA
$postcode->getArea(); // SR
$postcode->getDistrict(); // 5
$postcode->getSector(); // 1
$postcode->getUnit(); // NA
```

Validate a postcode
```php
<?php

$good = Postcode::validate('SR5 1nA'); // true
$bad = Postcode::validate('SR5 N1A'); // false
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
