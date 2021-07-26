<?php

namespace SilverStripe\Mynamespace;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Versioned\Versioned;

class Region extends DataObject
{
    private static $db = [
        "Title" => "Varchar",
        "Description" => "HTMLText",
    ];

    private static $has_one = [
        "Photo" => Image::class,
        "RegionsPage" => RegionsPage::class,
    ];

    private static $has_many = [
        "Articles" => ArticlePage::class,
    ];

    private static $summary_fields = [
        'Photo.CMSThumbnail' => '',
        'Title' => 'Title of region',
        'Description' => 'Short description'
    ];

    private static $owns = [
        "Photo",
    ];

    private static $extensions = [
        Versioned::class,
    ];

    private static $versioned_gridfield_extensions = true;

    public function Link()
    {
        return "{$this->RegionsPage->Link()}show/{$this->ID}";
    }

    public function ArticlesLink()
    {
        $page = ArticleHolder::get()->first();

        if ($page) {
            return $page->Link("region/" . $this->ID);
        }
    }

    public function LinkingMode()
    {
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create("Title"),
            HTMLEditorField::create("Description"),
            $uploader = UploadField::create("Photo")
        );

        $uploader->setFolderName("myyy region-photos");
        $uploader->getValidator()->setAllowedExtensions(["png", "gif", "jpeg", "jpg"]);

        return $fields;
    }
}
