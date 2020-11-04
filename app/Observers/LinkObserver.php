<?php

namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{
    public function created(Link $link)
    {
        // 在保存时清空 cache_key 对应的缓存
        Cache::forget($link->cache_key);
    }
}
