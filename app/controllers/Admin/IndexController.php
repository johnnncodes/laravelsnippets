<?php namespace Admin;

class IndexController extends \BaseController
{
    public function getIndex()
    {
        return \View::make('admin.index');
    }
}