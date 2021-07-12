<?php

namespace SilverStripe\Mynamespace;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextAreaField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Versioned\Versioned;

class Region extends DataObject
{
    private static $db = [
        "Title" => "Varchar",
        "Description" => "Text",
    ];

    private static $has_one = [
        "Photo" => Image::class,
        "RegionsPage" => RegionsPage::class,
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
        return "{$this->RegionsPage->Link}show/{$this->ID}";
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create("Title"),
            TextAreaField::create("Description"),
            $uploader = UploadField::create("Photo")
        );

        $uploader->setFolderName("myyy region-photos");
        $uploader->getValidator()->setAllowedExtensions(["png", "gif", "jpeg", "jpg"]);

        return $fields;
    }
}
