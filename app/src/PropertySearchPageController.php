<?php

namespace SilverStripe\Mynamespace;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\Debug;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FormAction;
use SilverStripe\ORM\ArrayLib;

class PropertySearchPageController extends PageController
{
    private static $allowed_actions = [];

    public function index(HTTPRequest $request)
    {
        $properties = Property::get()->limit(6);

        if ($search = $request->getVar('Keywords')) {
            $properties = $properties->filter(array(
                'Title:PartialMatch' => $search
            ));
        }

        if ($arrival = $request->getVar('ArrivalDate')) {
            $arrivalStamp = strtotime($arrival);
            $nightAdder = '+' . $request->getVar('Nights') . ' days';
            $startDate = date('Y-m-d', $arrivalStamp);
            $endDate = date('Y-m-d', strtotime($nightAdder, $arrivalStamp));

            $properties = $properties->filter([
                'AvailableStart:GreaterThanOrEqual' => $startDate,
                'AvailableEnd:LessThanOrEqual' => $endDate
            ]);
        }

        if ($bedrooms = $request->getVar('Bedrooms')) {
            $properties = $properties->filter([
                'Bedrooms:GreaterThanOrEqual' => $bedrooms
            ]);
        }

        if ($bathrooms = $request->getVar('Bathrooms')) {
            $properties = $properties->filter([
                'Bathrooms:GreaterThanOrEqual' => $bathrooms
            ]);
        }

        if ($minPrice = $request->getVar('MinPrice')) {
            $properties = $properties->filter([
                'PricePerNight:GreaterThanOrEqual' => $minPrice
            ]);
        }

        if ($maxPrice = $request->getVar('MaxPrice')) {
            $properties = $properties->filter([
                'PricePerNight:LessThanOrEqual' => $maxPrice
            ]);
        }


        return [
            "Results" => $properties
        ];
    }

    public function PropertySearchForm()
    {
        $nights = [];
        foreach (range(1, 14) as $i) {
            $nights[$i] = "$i night" . (($i > 1) ? 's' : '');
        }
        $prices = [];
        foreach (range(100, 1000, 50) as $i) {
            $prices[$i] = '$' . $i;
        }

        $form = Form::create(
            $this,
            'PropertySearchForm',
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'City, State, Country, etc...')
                    ->addExtraClass('form-control'),
                TextField::create('ArrivalDate', 'Arrive on...')
                    ->setAttribute('data-datepicker', true)
                    ->setAttribute('data-date-format', 'DD-MM-YYYY')
                    ->addExtraClass('form-control'),
                DropdownField::create('Nights', 'Stay for...')
                    ->setSource($nights)
                    ->addExtraClass('form-control'),
                DropdownField::create('Bedrooms')
                    ->setSource(ArrayLib::valuekey(range(1, 5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('Bathrooms')
                    ->setSource(ArrayLib::valuekey(range(1, 5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('MinPrice', 'Min. price')
                    ->setEmptyString('-- any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control'),
                DropdownField::create('MaxPrice', 'Max. price')
                    ->setEmptyString('-- any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control')
            ),
            FieldList::create(
                FormAction::create('doPropertySearch', 'Search')
                    ->addExtraClass('btn-lg btn-fullcolor')
            )
        );

        $form
            ->setFormMethod("GET")
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVars());

        return $form;
    }
}