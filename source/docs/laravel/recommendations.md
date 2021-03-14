---
title: Recommendations
description: Getting recommendations from Recon
extends: _layouts.documentation
section: content
---

# Getting Recommendations

## Prerequisites

Before Recon can serve recommendations it needs at least:

1. At least 1,000 Interactions
2. At least 25 Users, with 2 or more Interactions each

## Business Solutions

A Business Solution is a particular recommendation campaign you want to use within your application. There are 2 types:

##### **Personalized User Recommendations**

The Personalized User Recommendations algorithm is optimized for all personalized recommendation scenarios.
It predicts the items that a user is most likely to interact with based on Interactions, Items, and Users data. When recommending items, it uses [automatic item exploration](#automatic-item-exploration).

##### **Related Items**

The Related Items algorithm will recommend Items most similar to each other based on similar interaction data. When there is insufficient interaction data, popular items will be recommended.

> Right now, you are allowed 1 of each type per account. You can create them in the Recon [dashboard](https://reconengine.ai/dashboard).

## Recommendations

After a business solution has been created, you can now begin serving recommendations in your application.

##### **Personalized User Recommendations**

The `ReconUser` trait comes with a `recommend()` method. It will return an array in the following format:

```
[
    'recommendation_id' => '::recommendation_id::',
    'items' => [
        [
            'item_id' => "::item1::",
            'score' => 0.09,
        ],
        [
            'item_id' => "::item2::",
            'score' => 0.05,
        ],
    ],
],
```

The `score` is a good indicator for comparing different results however the absolute value is not important.

You can use the `recommendation_id` in future `InteractionBuilder` [requests](/docs/laravel/configuration#interactions) to help Recon serve better results to your users.

##### **Related Items**

The `ReconItem` trait comes with a `related()` method. It will return an array in the following format:

```
[
    'recommendation_id' => '::recommendation_id::',
    'items' => [
        [
            'item_id' => "::item1::",
            'score' => 0.09,
        ],
        [
            'item_id' => "::item2::",
            'score' => 0.05,
        ],
    ],
],
```

The `score` is a good indicator for comparing different results however the absolute value is not important.

You can use the `recommendation_id` in future `InteractionBuilder` [requests](/docs/laravel/configuration#interactions) to help Recon serve better results to your users.

## Cold Starts?

When there is very little historical interaction data about a User or Item, serving recommendations is very difficult. These are referred to as Cold Starts.

The Recon recommendation algorithms were carefully designed to serve high quality recommendations even when there is little historic information available for new items and users.

[Automatic Item Exploration](#automatic-item-exploration) is one of the best ways to minimize the cold start problem in recommendation engines. 

## Automatic Item Exploration {#automatic-item-exploration}

With recommendation engines, it can be difficult to recommend newer items successfully. Recon will automatically test out new items and learn how they are interacted with. Items with positive results
will be served to more users. Automatic Item Exploration is particularly useful when your dataset changes frequently or when newer items are more relevant.

Exploration is being handled for you.

## Filters

Filters are currently in closed beta. Feel free to [get in touch](mailto:contact@reconengine.ai) if you would like to incorporate filters into your application.
