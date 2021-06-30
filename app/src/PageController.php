<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;

    class PageController extends ContentController
    {
        /**
         * An array of actions that can be accessed via a request. Each array element should be an action name, and the
         * permissions or conditions required to allow the user to access it.
         *
         * <code>
         * [
         *     'action', // anyone can access this action
         *     'action' => true, // same as above
         *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
         *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
         * ];
         * </code>
         *
         * @var array
         */
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();

            Requirements::css('css/bootstrap.min.css');
            Requirements::css('css/style.css');
            Requirements::css('css/mystyles.css');
            Requirements::javascript('js/common/modernizr.js');
            Requirements::javascript('js/common/jquery-1.11.1.min.js');
            Requirements::javascript('js/common/bootstrap.min.js');
            Requirements::javascript('js/common/bootstrap-datepicker.js');
            Requirements::javascript('js/common/chosen.min.js');
            Requirements::javascript('js/common/bootstrap-checkbox.js');
            Requirements::javascript('js/common/nice-scroll.js');
            Requirements::javascript('js/common/jquery-browser.js');
            Requirements::javascript('js/scripts.js');
        }
    }
}
