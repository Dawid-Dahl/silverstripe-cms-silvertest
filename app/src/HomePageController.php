<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Dev\Debug;

class HomePageController extends PageController
{
    protected function init()
    {
        parent::init();
    }

    public function LatestArticles($count = 3)
    {
        return ArticlePage::get()
            ->sort("Created", "DESC")
            ->limit($count);
    }

    public function GetProperties()
    {
        return Property::get()
            ->filter([
                'FeaturedOnHomepage' => true
            ])
            ->limit(6);
    }
}
