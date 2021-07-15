<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;

class RegionsPageController extends PageController
{
    private static $allowed_actions = [
        "show",
    ];

    public function show(HTTPRequest $request)
    {
        $region = Region::get()->byID($request->param("ID"));

        if (!$region) {
            return $this->httpError(404, "Region couldn't be found!");
        }

        return [
            "Region" => $region,
            "Title" => $region->Title
        ];
    }
}
