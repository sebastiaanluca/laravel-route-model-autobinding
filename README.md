# Automatically bind Eloquent models to be used as route segments

<a href="https://packagist.org/packages/sebastiaanluca/laravel-route-model-autobinding"><img src="https://poser.pugx.org/sebastiaanluca/laravel-route-model-autobinding/version" alt="Latest stable release"></img></a>
<a href="LICENSE.md"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg" alt="Software license"></img></a>
<a href="https://travis-ci.org/sebastiaanluca/laravel-route-model-autobinding"><img src="https://img.shields.io/travis/sebastiaanluca/laravel-route-model-autobinding/master.svg" alt="Build status"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca/laravel-route-model-autobinding"><img src="https://img.shields.io/packagist/dt/sebastiaanluca/laravel-route-model-autobinding.svg" alt="Total downloads"></img></a>

<a href="https://blog.sebastiaanluca.com"><img src="https://img.shields.io/badge/link-blog-lightgrey.svg" alt="Read my blog"></img></a>
<a href="https://packagist.org/packages/sebastiaanluca"><img src="https://img.shields.io/badge/link-other_packages-lightgrey.svg" alt="View my other packages and projects"></img></a>
<a href="https://twitter.com/sebastiaanluca"><img src="https://img.shields.io/twitter/follow/sebastiaanluca.svg?style=social" alt="Follow @sebastiaanluca on Twitter"></img></a>
<a href="https://twitter.com/intent/tweet?text=Automatically%20bind%20Eloquent%20models%20to%20be%20used%20as%20route%20segments.%20Via%20@sebastiaanluca%20https://github.com/sebastiaanluca/laravel-route-model-autobinding"><img src="https://img.shields.io/twitter/url/http/shields.io.svg?style=social" alt="Share this package on Twitter"></img></a>

**A Laravel package that automatically registers all your Eloquent models as route segment variables.**

TODO: full description

- Medium to large apps: lots of models
- Need to bind and alias them all separately in the route service provider
- Need to do the same (and can't forget) for each new, changed, or deleted model
- Hard to maintain, easy to forget
- This package scans all your model directories (from composer.json PSR-4 autoload section) and does the grunt work for you
- Still allows you to override certain aliases
- Cache command to read bindings from a static file and speed up app in production

## Table of contents

- [Requirements](#requirements)
- [How to install](#how-to-install)
- [How to use](#how-to-use)
- [License](#license)
- [Change log](#change-log)
- [Testing](#testing)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [About](#about)

## Requirements

- PHP 7.2 or higher
- Laravel 5.6 or higher

## How to install

Via Composer:

```bash
composer require sebastiaanluca/laravel-route-model-autobinding
```

## How to use

TODO

- Only do this once if you have a base App (domain) model that every other model extends from
- Override a method to change the name (casing unchanged)
- Change config to change casing

## License

This package operates under the MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer install
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [hello@sebastiaanluca.com][link-author-email] instead of using the issue tracker.

## Credits

- [Sebastiaan Luca][link-github-profile]
- [All Contributors][link-contributors]

## About

My name is Sebastiaan and I'm a freelance back-end developer specializing in building custom Laravel applications. Check out my [portfolio][link-portfolio] for more information, [my blog][link-blog] for the latest tips and tricks, and my other [packages][link-packages] to kick-start your next project.

Have a project that could use some guidance? Send me an e-mail at [hello@sebastiaanluca.com][link-author-email]!

[link-packagist]: https://packagist.org/packages/sebastiaanluca/laravel-route-model-autobinding
[link-travis]: https://travis-ci.org/sebastiaanluca/laravel-route-model-autobinding
[link-contributors]: ../../contributors

[link-portfolio]: https://www.sebastiaanluca.com
[link-blog]: https://blog.sebastiaanluca.com
[link-packages]: https://packagist.org/packages/sebastiaanluca
[link-github-profile]: https://github.com/sebastiaanluca
[link-author-email]: mailto:hello@sebastiaanluca.com
