<?php

namespace App\Http\Controllers\WebControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CMS\TermConditionResource;
use App\Models\CMSModels\TermCondition;

class ApiTermConditionController extends Controller
{
    /********* Initialize Permission based Middlewares  ***********/
    public function __construct()
    {

    }


    public function allTermCondition(Request $request){
        $term_condition = new TermConditionResource(TermCondition::first());
        return response($term_condition);
    }
}
