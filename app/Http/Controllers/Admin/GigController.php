<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\GigService;
use Doctrine\DBAL\Driver\Exception;
use Illuminate\Http\Request;

class GigController extends Controller
{
    public function __construct()
    {
        $this->gigService = new GigService;
    }

    public function getGigListing()
    {
        try {
            $data = [];
            $data['gigs'] = $this->gigService->getGigs(10, null, true);
            $key = $data['gigs']['result']->firstItem();
            $data['index'] = $key;
            return view('admin.gigs.index', compact('data'));
        } catch (\Exception $exception) {
            \request()->session()->flash('error',$exception->getMessage());
            return back();
        }
    }

    public function changeStatus(Request $request){
        try {
            return $this->gigService->changeGigStatus($request->all());
        }catch (\Exception $exception){
            return ['result'=>$exception->getMessage(),"code"=>$exception->getCode()];
        }
    }
}
