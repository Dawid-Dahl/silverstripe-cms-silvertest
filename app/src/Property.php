<?php

namespace SilverStripe\Mynamespace;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Assets\Image;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\TabSet;

class Property extends DataObject
{
    private static $db = [
        "Title" => "Varchar",
        "PricePerNight" => "Currency",
        "Bedrooms" => "Int",
        "Bathrooms" => "Int",
        "FeaturedOnHomepage" => "Boolean"
    ];

    private static $has_one = [
        "Region" => Region::class,
        "PrimaryPhoto" => Image::class
    ];

    private static $summary_fields = [
        "Title" => "Title",
        "PricePerNight.Nice" => "Price",
        "FeaturedOnHomepage.Nice" => "Featured?",
        "Bathrooms" => "Bathrooms",
        "Region.Title" => "Region"
    ];

    private static $owns = [
        "PrimaryPhoto",
    ];

    private static $extensions = [
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;

    public function searchableFields()
    {
        return [
            "Title" => [
                "filter" => "PartialMatchFilter",
                "title" => "Title",
                "field" => TextField::class
            ],
            "RegionID" => [
                "filter" => "PartialMatchFilter",
                "title" => "Region",
                "field" => DropdownField::create("RegionID")->setSource(Region::get())->setEmptyString(">-- Any Region --<")
            ],
            "FeaturedOnHomepage" => [
                "filter" => "ExactMatchFilter",
                "title" => "Only featured",
            ]
        ];
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create("Root"));

        $fields->addFieldsToTab(
            "Root.Main",
            [
                TextField::create("Title"),
                CurrencyField::create("PricePerNight", "Price (per night)"),
                DropdownField::create("Bedrooms")
                    ->setSource(ArrayLib::valuekey(range(1, 10))),
                DropdownField::create("Bathrooms")
                    ->setSource(
                        ArrayLib::valuekey(range(1, 10))
                    ),
                DropdownField::create("RegionID", "Region")
                    ->setSource(Region::get()),
                CheckboxField::create("FeaturedOnHomepage", "Feature on homepage")
            ]
        );

        $fields->addFieldToTab(
            "Root.Photos",
            $upload = UploadField::create(
                "PrimaryPhoto",
                "Primary Photo"
            )
        );

        $upload->getValidator()->setAllowedExtensions(
            ['png', 'jpeg', 'jpg', 'gif']
        );

        $upload->setFolderName("property-photos");

        return $fields;
    }
}
