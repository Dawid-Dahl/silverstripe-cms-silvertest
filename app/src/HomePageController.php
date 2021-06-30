<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\View\Requirements;

class HomePageController extends PageController
{
    protected function init()
    {
        parent::init();
    }

    public function LatestArticles($count = 3)
    {
        return ArticlePage::get()
            ->sort('Created', 'DESC')
            ->limit($count);
    }
}
