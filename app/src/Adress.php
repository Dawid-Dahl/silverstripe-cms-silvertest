<?php

use SilverStripe\View\ViewableData;

class Address extends ViewableData
{

    public $Street = '123 Main Street';

    public $City = 'Compton';

    public $Zip = '90210';

    public $Country = 'US';

    public function Country()
    {
        //return MyGeoLibrary::get_country_name($this->Country);
        return $this->Country;
    }

    public function getFullAddress()
    {
        return sprintf(
            '%s<br>%s %s<br>%s',
            $this->Street,
            $this->City,
            $this->Zip,
            $this->Country()
        );
    }

    public function forTemplate()
    {
        return $this->getFullAddress();
    }
}
