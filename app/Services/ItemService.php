<?php

namespace App\Services;

use App\Repositories\ItemRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ItemService
{
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }
}
