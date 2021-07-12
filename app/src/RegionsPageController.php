<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Dev\Debug;

class RegionsPageController extends PageController
{
    private static $allowed_actions = [
        "test",
    ];

    private function cube($arr)
    {
        return array_map(fn ($x) => $x * 10, $arr);
    }

    public function test($request)
    {
        return json_encode($this->cube([1, 2, 3]));
    }
}
