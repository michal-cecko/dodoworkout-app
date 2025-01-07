<?php

namespace App\Misc;

use App\Models\Post;
use App\Models\PostTag;

class MorphMap {
    public static function make(): array {
        return [
            "post" => Post::class,
            "post_tag" => PostTag::class
        ];
    }
}
