---
title: Configuration
description: Configure the Recon Engine to best suite your needs.
extends: _layouts.documentation
section: content
---

# Configuration
 
The Recon Recommendation Engine needs to know about 3 pieces of your application to function:

1. **Users**
1. **Items**
1. **Interactions** between Users and Items 

## Users & Items  {#users-and-items}

After installing Recon, add the `ReconUser` trait to your Users class and add the `ReconItem`
trait to the models you want to recommend.

Then implement the abstract method:

```php
define(SchemaDefinition $definition)
```

You can use this method to define columns on your models that will help serve better recommendations.

Users can have up to 5 columns defined. Items can have up to 50 columns defined.

**You do not need to define all your columns. You should carefully choose the ones you think have the strongest correlation to serve better recommendations.**

> For `ReconItem`, the `created_at` is automatically defined for you. This is **required** for Recon to be able to serve better recommendations. If your items don't have a `created_at`, please add one.

### Datatypes

| Datatype      | Example | Notes |
| ----------- | ----------- | ----------- |
| int      | `$definition->int('age');` |        |
| double   | `$definition->doube('salary');` |        |
| float   | `$definition->float('average_rating');` |        |
| long   | `$definition->long('retired_at');` | Use for dates and times. |
| boolean   | `$definition->boolean('is_admin');` |  |
| string   | `$definition->string('bio');` | Ex: bio, title |
| category   | `$definition->category('gender');` | Ex: gender, color, occupation, city |

##### **Nullable properties?**

Each datatype can also be `null` by chaining on the `->nullable()` method.

##### **What about dates and times?**

Carbon instances are automatically casted to their timestamp. Therefore, you should use the `long` datatype when you want to record datetimes.
Remember to add those columns to your Eloquent `$cast` property to automatically convert the property to oCarbon instances.

##### **What about dates and times?**

Carbon instances are automatically casted to their timestamp. Therefore, you should use the `long` datatype when you want to record datetimes.
Remember to add those columns to your Eloquent `$cast` property to automatically convert the property to oCarbon instances.

### Creating your database

After your models and properties have been configured, we can now create the database. To do so, simple run:

```bash
php artisan recon
```

You will be prompted to create your first database.

> You can override the database name by setting `RECON_DATABASE` in your .env file. This is useful for when you want [multiple databases](#multiple-databases).

Selecting yes will read your ReconUser configuration and your ReconItem configuration and setup your database structure in Recon. This can take a couple of minutes.

If you need to populate already existing user, item, and interaction data, then see [Seeding](/docs/laravel/seeding).

### Training

Once you have added the `ReconUser` and `ReconItem` trait, all you need to do is `save` or `create` a model instance and it will automatically be added to your recommendation engine.
If you have configured Recon to [use queues](/docs/laravel/installation#queues), then this operation will be performed in the background by your queue worker.

```php
use App\Models\Movie;

$movie = new Movie;

// ...

$movie->save();
```

#### Adding records via Query

If you would like to add a collection of models to Recon via an Eloquent query, you main chain the `trainable` method onto the Eloquent query.
The trainable method will chunk the results of the query and store them in Recon. Again, if you have configured Recon to use queues, all of the chunks will be imported in the background by your queue workers:

```php
use App\Models\Movie;

Movie::where('views', '>', 100)->trainable();
```

If you already have a collection of Eloquent models in memory, you may call the `trainable` method on the collection instance to add the model instances to their corresponding records:

```php
$movies->trainable();
```

#### Hiding records

You can hide certain Users and Items from Recon by implementing the `isTrainable` method in your model classes.

```php
public function isTrainable() {
    return $this->views > 100;
}
```

## Interactions {#interactions}

The `InteractionBuilder` class provides a fluent API to record interactions between your users and items. Use this anywhere in your application
code where interactions are taking place:

```php
use Recon\Helpers\InteractionBuilder;

pubic function like(User $user, Post $post)
{
    InteractionBuilder::make('like')
            ->setItemId($post->id)
            ->setUserId($user->id)
            ->send();
    
    // ... the rest of your logic
}
```

| Properties | Default | Required? | Notes |
| :---------- | :------- | :--------- | ----- |
| Action | `null` | Yes | The name of the event. The Recon Engine automatically learns the importance. |
| ItemId | `null` | Yes | |
| UserId | `null` | No | The session id will automatically be used to associate interactions for users before they have signed-in or created an account. |
| SessionId | `session()->getId()` | Yes | |
| Timestamp | `now()->timestamp` | Yes | |
| Value | `null` | No | Use to associate a value with the event. For example % watched of a movie or total $ spent. The Recon Engine automatically learns how to factor in the `Value` |
| Impressions | `null` | No | An optional array of ItemIds that were displayed to the user at the time of this interaction. This helps Recon serve better recommendations to your users. |
| RecommendationId | `null` | No | The `recommendation_id` of the GET Recommendation response. This helps Recon serve better recommendations to your users. |
| Metadata | `null` | No | (coming soon) Need more customization? Use the Metadata field that aligns with your Interaction Schema definition. |

## Multiple Database? {#multiple-databases}

When you have more than 1 single Item you want to recommend, you will need a Recon database for each.

Multiple Databases are currently in closed beta. Feel free to [get in touch](mailto:contact@reconengine.ai) if you would like to use multiple databases in your application.

