<?php namespace Website;

use View;

class PagesController extends \BaseController
{
    public function showRoadmap()
    {
        return View::make('website.pages.roadmap');
    }

}
