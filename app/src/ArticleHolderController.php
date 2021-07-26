<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Dev\Debug;
use SilverStripe\ORM\PaginatedList;

class ArticleHolderController extends PageController
{
    private static $allowed_actions = [
        'category',
        'region',
        'date'
    ];

    protected $articleList;

    public function init()
    {
        parent::init();

        $this->articleList = ArticlePage::get()->filter(["ParentID" => $this->ID])->sort("Date", "DESC");
    }

    public function PaginatedArticles($num = 10)
    {
        return PaginatedList::create(
            $this->articleList,
            $this->getRequest()
        )->setPageLength($num);
    }
}
