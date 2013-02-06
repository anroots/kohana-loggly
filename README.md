# Kohana 3.3 log writer for Loggly

Write Kohana logs to [Loggly](http://loggly.com). Log messages are sent to Loggly via external HTTP requests using the
`Request::factory()`.

## Installation

### As a Git submodule:

```bash
git clone git://github.com/anroots/kohana-loggly.git modules/loggly
```
### As a [Composer dependency](http://getcomposer.org)

```javascript
{
	"require": {
		"php": ">=5.4.0",
		"composer/installers": "*",
		"anroots/loggly":"1.*"
	}
}
```

### Activate the module in `bootstrap.php`.

```php
<?php
Kohana::modules(array(
	...
	'loggly' => MODPATH.'kohana-loggly',
));
```

### Create a new Loggly input

The input should be a JSON-enable HTTPS input.

![New Loggly Input](https://github.com/anroots/kohana-loggly/raw/loggly-new-input.png)!

### Add the log writer after module activation

```php
<?php
Kohana::$log->attach(new Log_Loggly('my-input-key'));
```

You can use the  `$levels` and `$min_level` params of `$log->attach` to set restraints on when to log to Loggly:

```php
Kohana::$log->attach(new Log_Loggly('my-input-key'), Log::INFO); // Log only messages starting from level INFO (no DEBUG)
```

### Log some data in your code

```php
<?php
Kohana::$log->add(Log::EMERGENCY,'The world will end on :time.',[':time'=>time()+60]);
```

### Results appear in the Loggly console

![Loggly Console](https://github.com/anroots/kohana-loggly/raw/loggly-shell.png)!

# Licence

Licenced under the MIT licence.