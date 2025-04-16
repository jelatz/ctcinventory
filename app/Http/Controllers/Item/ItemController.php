<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }
    public function index()
    {
        return inertia('Item/Index');
    }
}
