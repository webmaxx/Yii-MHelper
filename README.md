Yii-MHelper
===========

1. Copy "MHelper" folder to "protected/components/"

2. In config file:

```php
...
'import' => array(
	...
	'application.components.MHelper. ',
	...
),
...
```

Use
---

```php
MHelper::get()->string->toLower('TeSt StRiNg');          // test string
MHelper::get()->string()->toUpper('TeSt StRiNg');        // TEST STRING
MHelper::get()->string('TeSt StRiNg')->ucwords();        // Test String
MHelper::get('string', 'TeSt StRiNg')->toLower();        // test string
MHelper::get(null, 'TeSt StRiNg')->string->toLower();    // test string
```

### OR

```php
$MString = new MString('TeSt StRiNg');
$MString->toLower();                                     // test string

$MString = new MString();
$MString->toLower('TeSt StRiNg');                        // test string
```

### OR

```php
// PHP 5.3+ only
MHelper::String()->toLower('TeSt StRiNg');               // test string
MHelper::String('TeSt StRiNg')->toUpper();               // TEST STRING
MString::toLower('TeSt StRiNg');                         // test string
```

Use chaining
------------

```php
MHelper::get()->string('TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
MHelper::get()->string(null, true)->toUpper('TeSt StRiNg')->lcFirst()->value;             // tEST STRING
MHelper::get()->string('TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
MHelper::get('string', 'TeSt StRiNg', true)->toUpper()->lcFirst()->value;                 // tEST STRING
MHelper::get(null, 'TeSt StRiNg', true)->string->toUpper()->lcFirst()->value;             // tEST STRING
MHelper::get(null, null, true)->string('TeSt StRiNg')->toUpper()->lcFirst()->value;       // tEST STRING
```

### OR

```php
$MString = new MString('TeSt StRiNg', true);
$MString->toLower()->ucFirst()->value;                                  // Test string

$MString = new MString();
$MString->setChain(true)->toLower('TeSt StRiNg')->ucFirst()->value;     // Test string
```

### OR

```php
// PHP 5.3+ only
MHelper::String('TeSt StRiNg', true)->toLower()->ucFirst()->value;               // Test string
MHelper::String(null, true)->toLower('TeSt StRiNg')->ucFirst()->value;           // Test string
MHelper::String('TeSt StRiNg')->setChain(true)->toLower()->ucFirst()->value;     // Test string
MHelper::String()->setChain(true)->toLower('TeSt StRiNg')->ucFirst()->value;     // Test string
MString::chain(true)->toUpper('TeSt StRiNg')->lcFirst()->value;                  // tEST STRING
```

Helpers list
------------

### String

Methods:

- toUpper
- toLower
- ucFirst
- lcFirst
- ucWords
- convertCase
- substr
- strrchr
- len
- stripos
- trimSlashes
- stripSlashes
- stripQuotes
- quotesToEntities
- reduceDoubleSlashes
- reduceMultiples
- incrementString
- alternator
- repeater
- wordwrap
- truncate
- randomString
- toTranslit
- fromTranslit
- diff

### Array

Methods:

- element
- randomElement
- elements

### Date

Methods:

- timeAgo
- daysInMonth

### Path

Methods:

- isFile
- isReadable
- createDir
- read
- write
- filenames
- filesInfo
- fileInfo
- pathInfo
- size
- sizeFormat
- send
- download
- getMimeType
- getMimeTypeByExtension
- map
- cleardir
- rmdir
