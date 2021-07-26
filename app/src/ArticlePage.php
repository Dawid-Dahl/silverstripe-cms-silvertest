<?php

namespace SilverStripe\Mynamespace;

use Page;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\DropdownField;

class ArticlePage extends Page
{
    private static $db = [
        "Date" => "Date",
        "Teaser" => "Text",
        "ArticleAuthor" => "Varchar",
    ];

    private static $has_one = [
        "Photo" => Image::class,
        "Brochure" => File::class,
        "Region" => Region::class
    ];

    private static $has_many = [
        "Comments" => ArticleComment::class,
    ];

    private static $many_many = [
        "Categories" => ArticleCategory::class,
    ];

    private static $owns = [
        "Photo",
        "Brochure",
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab("Root.Main", DateField::create("Date", "Date of article"), "Content");
        $fields->addFieldToTab("Root.Main", TextareaField::create("Teaser")
            ->setDescription("This is the summary that appears on the article list page."), "Content");
        $fields->addFieldToTab("Root.Main", TextField::create("ArticleAuthor", "Author of article"), "Content");

        $fields->addFieldToTab("Root.Attachments", $photo = UploadField::create("Photo"));
        $fields->addFieldToTab("Root.Attachments", $brochure = UploadField::create("Brochure", "Travel brochure, optional (PDF only)"));

        $fields->addFieldToTab("Root.Categories", CheckboxSetField::create(
            "Categories",
            "Article categories",
            $this->Parent()->Categories()->map("ID", "Title"),
        ));

        $fields->addFieldToTab("Root.Main", DropdownField::create(
            "RegionID",
            "Region",
            Region::get()->map("ID", "Title")
        )->setEmptyString("-- None --"), "Content");

        $brochure->setFolderName("travel-brochures")
            ->getValidator()->setAllowedExtensions(["pdf"]);
        $photo->setFolderName("travel-photos");

        return $fields;
    }

    private static $can_be_root = false;

    public function PrintCategoriesList()
    {
        if ($this->Categories()->exists()) {
            return implode(", ", $this->Categories()->column("Title"));
        } else {
            return null;
        }
    }
}
