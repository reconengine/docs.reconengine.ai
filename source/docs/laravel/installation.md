---
title: Installation
description: Get up and running with the Recon Engine in your Laravel application.
extends: _layouts.documentation
section: content
---

# Prerequisites {#prerequisites}

Minimum PHP version: `7.1`

Minimum Laravel version: `7.0`

# Installation

First, install Recon via the Composer package:

```bash
composer require reconengine/laravel-recon
```

Next, we need to get an API token over at [reconengine.ai](https://reconengine.ai/user/api-tokens) and add it to our `.env` file:

```env
RECON_TOKEN={token}
```

You are now ready to start interaction with the Recon API in your application.

## Queueing {#queueing}
 
While not strictly required to use Recon, you should **strongly** consider configuring a [queue driver](https://laravel.com/docs/8.x/queues)
before using the library. Running a queue worker will allow Recon to queue all operations that sync your model information
to your recommendation engine, providing much better response times for your application's web interface.
 
Once you have configured a queue driver, set the value of the `queue` option in your `config/recon.php` configuration file to `true`:
 
```php
'queue' => true,
```

or add `RECON_QUEUE=true` to your .env file. 
