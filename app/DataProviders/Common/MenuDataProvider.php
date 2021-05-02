<?php

namespace App\DataProviders\Common;


use App\Menu;
use Illuminate\Support\Facades\Cache;

class MenuDataProvider
{
    private array $menus;

    public function __construct()
    {
        $this->menus = Cache::rememberForever('menus', function () {
            return Menu::orderBy('sequence_num')->get();
        });
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->menus;
    }
}
