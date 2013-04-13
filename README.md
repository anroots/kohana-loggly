# Kohana 3.3 log writer for Loggly.com

Write Kohana logs to a [Loggly.com](http://loggly.com) input. You need an account at loggly.com for this to work. The basic account is free, with quota limits.

# Installation

## As a Git submodule:

```bash
git submodule add git://github.com/anroots/kohana-loggly.git modules/loggly
```
## As a [Composer dependency](http://getcomposer.org)

```javascript
{
	"require": {
		"anroots/kohana-loggly":"1.*"
	}
}
```

## Activate the module in `bootstrap.php`.

```php
<?php
Kohana::modules(array(
	...
	'loggly' => MODPATH.'kohana-loggly',
));
```

## Create a new Loggly input

Create a new input via the loggly.com control panel. The input should be a JSON-enable HTTPS input. The module sends logs to Loggly JSON-encoded; that means [you can do some really cool stuff](http://loggly.com/blog/2011/06/on-the-way-to-impressive/) with that data.

![New Loggly Input](https://raw.github.com/anroots/kohana-loggly/master/loggly-new-input.png)

## Add the log writer after module activation

```php
<?php
Kohana::$log->attach(new Log_Loggly('my-input-key'));
```

You can use the  `$levels` and `$min_level` params of `$log->attach` to set restraints on when to log to Loggly:

```php
Kohana::$log->attach(new Log_Loggly('my-input-key'), Log::INFO); // Log only messages starting from level INFO (no DEBUG)
```

# Log some data in your code

```php
<?php
Kohana::$log->add(Log::EMERGENCY,'The world will end on :time.',[':time'=>time()+60]);
```

## Results appear in the Loggly console

![Loggly Console](https://raw.github.com/anroots/kohana-loggly/master/loggly-shell.png)

# Licence

[MIT licence](https://github.com/anroots/kohana-loggly/blob/master/LICENCE.md)
