# About
This is a php library. It will help php developer to convert any amount to Bangladeshi Currency format by Comma separated and in words in Bangladeshi way.

## Installation

Taka-Format is a php library; it's build on top of php 8^ and Pest ^2.34

In terms of local development, you can use the following requirements:

- PHP ^8
- pestphp/pest: ^2.34

If you have these requirements, you can start by run this command:

```bash
composer require arifhossen/taka-format
```

Next, use the trait on you respective `class`

```bash
use TakaFormat;

$this->takaSeperatedByComma(199990)) // ৳1,99,990
$this->takaInWords(199990)) // One lakh ninety Nine thousands Nine hundred and ninety taka

```

Enjoy 🎉
