# Yii2 Tactician Command Bus

![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/dersonsena/yii2-tactician)
[![GitHub stars](https://img.shields.io/github/stars/dersonsena/yii2-tactician)](https://github.com/dersonsena/yii2-tactician/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/dersonsena/yii2-tactician)](https://github.com/dersonsena/yii2-tactician/network)
![GitHub repo size](https://img.shields.io/github/repo-size/dersonsena/yii2-tactician)
[![GitHub license](https://img.shields.io/github/license/dersonsena/yii2-tactician)](https://github.com/dersonsena/yii2-tactician/blob/master/LICENSE)

This is a Yii Framework 2 Wrapper/Adapter for [Tactician Command Bus Library](https://tactician.thephpleague.com/). It provides an easy way to use the command bus pattern in Yii2 Based apps.

## When should I use Command Bus?

> Tactician is a great fit if you’ve got a service layer. If you’re not sure what a service layer is, Martin Fowler’s PoEAA is a good starting point. Tactician’s author also did a talk on the subject.
>
> Commands really help capture user intent. They’re also a great stand-in for the models when it comes to forms or serializer libraries that expect getter/setter objects.
>
> The command bus itself is really easy to decorate with extra behaviors, like locking or database transactions so it’s very easy to extend with plugins.
>
> _By: tactician.thephpleague.com_

## When should I not use it?

> If you’ve got a very small app that doesn’t need a service layer, then Tactician won’t offer much to you.
>
> If you’re already using a tool that provides a command bus (like Broadway), you’re probably okay there too.
>
> _By: tactician.thephpleague.com_

## Installation

```bash
$ composer require dersonsena/yii2-tactician
```

## Setup

First of all, let's create a file with under `config/command-bus.php` to map our command and handlers ones, link this:

```php
return [
    YourCommandClass::class => YourHandlerClass::class,
    AnotherCommandClass::class => AnotherHandlerClass::class,
    // ...
];
```

**Heads up**: to become easily, this component will be call automatically the Handler classes, `YourHandlerClass` and `AnotherHandlerClass` in this example, from [Yii Dependency Injection Container](https://www.yiiframework.com/doc/guide/2.0/en/concept-di-container).

The last one is register component in your `config/web.php` file, as below:

```php
return [
    // ...
    'components' => [
        'commandBus' => [
            'class' => DersonSena\Yii2Tactician\Yii2TacticianCommandBus::class,
            'commandHandlerMap' => require __DIR__ . '/command-bus.php'
        ],
        // other components...
    ],
    // ...
];
```

Define a command class somewhere in your application, for example:

```php
class YourCommandClass
{
    public $someParam;
    public $someOtherParam;

    public function __construct($someParam, $someOtherParam = 'defaultValue')
    {
    	$this->someParam = $someParam;
        $this->someOtherParam = $someOtherParam;
    }
}
```

So your `Handler` class should be something like:

```php
class YourCommandClassHandler
{
    public function handle(YourCommandClass $command)
    {
    	// do command stuff hire!
        // we can use $command->someParam and $this->someOtherParam
    }
}
```

Now we can use this command in controllers (or wherever you want):

```php
public function actionDoSomething()
{
    $queryParam = Yii::$app->getRequest()->get('some_param');
    $result = Yii::$app->commandBus->handle(new YourCommandClass($queryParam));

    if ($result === true) {
    	return $this->redirect(['go/to/some/place']);
    }

    return $this->render('some-awesome-view');
}
```

That's all! =)

## Authors

-   [Kilderson Sena](https://github.com/dersonsena) - Initial work - [Yii Academy](https://www.yiiacademy.com.br)

See also the list of [contributors](https://github.com/dersonsena/yii2-tactician/contributors) who participated in this project.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Licence

This package is released under the [MIT](https://choosealicense.com/licenses/mit/) License. See the bundled [LICENSE](./LICENSE) for details.

## References

-   [thephpleague/tactician](https://github.com/thephpleague/tactician)
-   [pavelmics/YiiTactician](https://github.com/pavelmics/YiiTactician/blob/master/README.md)
