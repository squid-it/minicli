<p align="center">
<img src="https://minicli.dev/images/minicli_logo_term_pink.png" align="center" alt="logo" title="Minicli logo" alt="Minicli Logo" width="160">
</p>

<br>

[Minicli + PHP-DI 6](https://github.com/squid-it/minicli) is a fork of [Minicli](https://docs.minicli.dev), a minimalist, almost dependency-free framework for building CLI-centric PHP applications. It provides a structured way to organize your commands, as well as various helpers to facilitate working with command arguments, obtaining input from users, and printing colored output.

Original Quick links:

- [Documentation](https://docs.minicli.dev)
- [Demos](https://github.com/minicli/demos)
- [Contributing](CONTRIBUTING.md)

## Almost Dependency-free: What Does it Mean

What does it mean to be (almost) dependency-free? It means that you can build a working CLI PHP application without dozens of nested user-land dependencies. The basic `minicli/minicli` package has only **testing** dependencies, and a couple system requirements:

- PHP >= 7.3
- `ext-readline` for obtaining user input

It gives you a lot of room to choose your own dependencies. This fork, adds [PHP-DI 6](https://php-di.org/) support to your controllers

## Getting Started

Please see original [Documentation](https://docs.minicli.dev)

### Minimalist App with DI support usage

1. Create directory structure
2. Modify composer.json
3. Create a `minicli`:

Create a directory structure similar like the onbe below
```
.
app
└── Command
    └── Help
        ├── DefaultController.php
        └── TestController.php
├── composer.json
└── minicli

```

Each directory inside `app/Command` represents a Command Namespace.
The classes inside `app/Command/Help` represent subcommands that you can access through the main `help` command.

You can now run the boostrapped application with:

```bash
./minicli help
./minicli help test
```

To enable DI in your controllers you can use the following `./minicli` as an example
```php
#!/usr/bin/env php
<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Minicli\App;
use Minicli\Exception\CommandNotFoundException;

if (PHP_SAPI !== 'cli') {
    die('Unable to start CLI script in on CLI context');
}

require __DIR__ . '/vendor/autoload.php';

// Build PHP-DI Container instance
$containerBuilder = new ContainerBuilder();
// .. build your container
$container = $containerBuilder->build();

// Pass along the container to the App constructor
$app = new App(
    ['app_path' => __DIR__ . '/app/Command'],
    $container,
);

try {
    $app->runCommand($argv);
} catch (CommandNotFoundException $e) {
    $app->getPrinter()->error('Unknown command: '.$argv[1]);
    $app->runCommand(['', 'help']);
} catch (Throwable $e) {
    $app->getPrinter()->error('Something went wrong : '.$e->getMessage());
}
```

Example controller using DI

```php
<?php
declare(strict_types=1);

namespace Assets\Command\Test;

use Assets\RandomClass\Reply;
use Minicli\Command\CommandController;

class DiController extends CommandController
{
    private Reply $reply;

    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    public function handle(): void
    {
        $this->getPrinter()->rawOutput($this->reply->myName('my name is DI'));
    }
}
```

