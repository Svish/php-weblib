Introduction
===

These are classes used in some of my website projects. Basically a simple homegrown website framework and various utility classes...


Expectations/Assumptions
===

Constants used
---

```PHP
// System paths
define('ROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);
define('SRC', ROOT.'src'.DIRECTORY_SEPARATOR);

// Web paths
define('SCHEME', empty($_SERVER['HTTPS']) || $_SERVER['HTTPS']=='off' ? 'http' : 'https');
define('HOST', $_SERVER['HTTP_HOST']);
define('WEBBASE', $_SERVER['BASE']);
define('WEBROOT', SCHEME.'://'.HOST.WEBBASE);

// Environment
define('ENV', $_SERVER['ENV']);
```

Directories
---

| Class | Directory
| --- | ---
| Cache | ROOT/.cache
| Config | ROOT/config
| Controller/Javascript | SRC/_js
| Controller/Less | SRC/_less
| Log | ROOT/.logs
| View/Mustache | SRC/_views
| View/Helper/Svg | SRC/_icons



Configuration
---

**Clicky (.clicky.ini)**

```INI
[dev]
site_id = ...
site_key = ...
admin_key = ...
```

**Email (.email.ini)**

```INI
[smtp]
sender = sender@example.com
server = smtp.example.com
port = 587
username = webmaster@example.com
password = ...
```

**CSS (css.inc)**

```PHP
<?php return (object) [
	'global' => [
		'//fonts.googleapis.com/...',
		'theme/layout.css',
		],
];

```

**JS (js.inc)**

```PHP
<?php return (object) [
	'global' => [
		'//cdnjs.cloudflare.com/...',
		'js/script.js',
		],
	'bundles' => [
		'script.js' => [
			'a.js',
			'b.js',
			],
		],
];

```

**Text (text.ini)**

```INI
[ok]
saved = 🎉 Lagret!
logged-in = 🔑 Innlogget!
db-migrated = 🔧 Database migrert: v%u

[exception]
NotFound = 😕 Kunne ikke finne "%2$s" med id "%1$s".
KeyConstraint[] = 😕 Den er i bruk, så det går dessverre ikke…
KeyConstraint[] = %3$s

[validation]
Valid::between = Må være mellom %s og %s.
DB\Valid::type = Ugyldig %s.
```

Error handler
---
```PHP
error_reporting(E_ALL);
$eh = new Error\Handler();
set_exception_handler($eh);
set_error_handler([$eh, 'error']);
```
