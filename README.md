# PHP Weather Here Developer API

This is a simple package that allows access to the Here Developer Weather API using a (mostly) fluent API.

![Packagist Downloads](https://img.shields.io/packagist/dt/medeirosdev/php-google-maps-distance-matrix)

## Information
Package create for Here Developer Weather

Documentation -
[https://developer.here.com/documentation/weather/topics/overview.html](https://developer.here.com/documentation/weather/topics/overview.html) 

## Installation

Install the package using composer:

```
$ composer require medeirosdev/weather-here-developer
```

## Frameworks

At the moment we only have framework compatibility for Laravel. However, we welcome PRs to add further framework
specific behavior as long as it doesn't prevent the package working for others

### Laravel

If you are using Laravel then you can use our service provider. If you have Laravel >5.5 then the package
will be auto discovered upon install. Else, add the following to your `config/app.php` file:

```php
'providers' => [
    ...
    \MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel\WeatherHereDeveloperServiceProvider::class,
]
```

#### Facades

If you are using Laravel >5.5 then the facade will
be automatically discovered. Else, you can add it in your `config/app.php` file.

```php
'aliases' => [
    ...
    'WeatherHereDeveloper' => \MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel\WeatherHereDeveloper::class,
]
```
#### Configuration

First, make sure you have copied the configuration file:

```
$ php artisan vendor:publish --tag=config --provider="MedeirosDev\WeatherHereDeveloper\Frameworks\Laravel\WeatherHereDeveloperServiceProvider"
```

This will make a `config/here_developer.php` file, this is where your API Key / License information is fetched from.
By default we use the `.env` configuration values to get your API key.

Use the App ID and App Code then you should add
the following to your `.env`:

```
HERE_DEVELOPER_APP_ID=MY-APP-ID
HERE_DEVELOPER_APP_CODE=MY-APP-CODE
```

Please, make sure you don't store your keys in version control!

## Usage

#### License / API Key

Before making requests you need to create your License object.
You will need is your API key, then you can create your license as follows:

```php
$license = new License($appId, $appCode);
```

Then, you can start making your request:

```php
$request = new WeatherHereDeveloper($license);

// or

$request = WeatherHereDeveloper::license($license);

// or Laravel framework license is auto generated

$request = new WeatherHereDeveloper();
```

#### Basic usage

```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLanguage(Language::PORTUGUESE_BR)
    ->setLocation(Location::byName('Campinas - SP - Brazil'))
    ->request();

// Get description of first node  
$response->nodes[0]->description

// Or get description of first node based json response
$response->observations->location[0]->observaton[0]->description
```

#### Basic usage in Laravel
##### No need to enter license object

```php
$response = (new WeatherHereDeveloper)
    ->setProduct(Product::OBSERVATION)
    ->setLanguage(Language::PORTUGUESE_BR)
    ->setLocation(Location::byName('Campinas - SP - Brazil'))
    ->request();
```


#### Supported Products
- Product::`OBSERVATION`
- Product::`FORECAST_7DAYS`
- Product::`FORECAST_7DAYS_SIMPLE`
- Product::`FORECAST_HOURLY`
- Product::`FORECAST_ASTRONOMY`
- Product::`ALERTS`
- Product::`NWS_ALERTS`


#### SUPPORTED UNITS
- Unit::`METRIC`
- Unit::`IMPERIAL`


#### Supported Locations
- Location::`byLatitudeLongitude($latitude, $longitude)`
- Location::`byName($cityOrOtherName)`
- Location::`byZipcode($zipcode)`


#### Supported Languages consult language files
```
src/Entities/Language.php
```


#### Get Observation
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLanguage(Language::PORTUGUESE_BR)
    ->setLocation(Location::byName('Campinas - SP - Brazil'))
    ->request();

$observations = $response->nodes;
```

#### Get One Observation
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLanguage(Language::PORTUGUESE_BR)
    ->setLocation(Location::byName('Campinas - SP - Brazil'))
    ->setOneObservation()
    ->request();

$observation = $response->nodes[0];
```

#### Get Forecast 7 days
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::FORECAST_7DAYS)
    ->setLanguage(Language::PORTUGUESE_BR)
    ->setLocation(Location::byName('Campinas - SP - Brazil'))
    ->setOneObservation()
    ->request();

$node = $response->nodes[0];
```

#### Use Location - Latitude and Longitude
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLocation(Location::byLatitudeLongitude('-22.907104', '-47.063240'))
    ->request();
```

#### Use Location - Zipcode
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLocation(Location::byZipcode('13000-000'))
    ->request();
```

#### Use Unit - Imperial
```php
$response = WeatherHereDeveloper::license($license)
    ->setProduct(Product::OBSERVATION)
    ->setLocation(Location::byZipcode('13000-000'))
    ->useImperial()
    ->request();
```
