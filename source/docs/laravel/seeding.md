---
title: Seeding
description: Populate existing user, item, and interaction data into your Recon recommendation database.
extends: _layouts.documentation
section: content
---

# Seeding

When you add Recon to an already existing database of Users and Items, then you can seed Recon with that data.

## Users & Items {#users-and-items}

To automatically seed Recon with all records from your User and Item model, use the `recon` command and select the `Seed` option:

```bash
php artisan recon
```

## Interactions {#interactions}

Interactions cannot automatically be seeded. However, if you have the data available, you can import this data by creating a Laravel command.
Just send the interaction data like normal using the fluent `InteractionBuilder`:

```php
$likes = Likes::all();

foreach ($likes as $like) {
    InteractionBuilder::make('like')
        ->setClientId($like->id)
        ->setItemId($like->post_id)
        ->setUserId($like->user_id)
        ->setTimestamp($like->created_at)
        ->send();
}
```

> When importing interaction data, it is important to specify the `->setTimestamp()` method. By default, the current timestamp is used. When importing historic data, you should use the time that the event occurred.

To speed up your import process, you can batch up to 250 InteractionsBuilder instances at a time and send them at once using `InteractionBuilder::sendBatch($interactions);`

> If possible, use `->setClientId()` to set an identifier for each interaction. This allows you to re-import interactions without needing to worry about duplicates.
