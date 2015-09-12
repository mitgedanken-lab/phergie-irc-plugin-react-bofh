# phergie/phergie-irc-plugin-react-bofh

[Phergie](http://github.com/phergie/phergie-irc-bot-react/) plugin for pulling excuses from bastard operator from hell.

[![Build Status](https://secure.travis-ci.org/phergie/phergie-irc-plugin-react-bofh.png?branch=master)](http://travis-ci.org/phergie/phergie-irc-plugin-react-bofh)

## Install

The recommended method of installation is [through composer](http://getcomposer.org).

```JSON
{
    "require": {
        "phergie/phergie-irc-plugin-react-bofh": "^1"
    }
}
```

See Phergie documentation for more information on
[installing and enabling plugins](https://github.com/phergie/phergie-irc-bot-react/wiki/Usage#plugins).

## Configuration

```php
return [
    'plugins' => [
        // configuration
        new \Phergie\Irc\Plugin\React\BOFH\Plugin([



        ])
    ]
];
```

## Tests

To run the unit test suite:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
./vendor/bin/phpunit
```

## License

Released under the BSD License. See `LICENSE`.
