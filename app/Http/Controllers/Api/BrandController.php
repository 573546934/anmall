<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    //品牌机构
    /*品牌机构列表*/
    public function brands(Request $request)
    {
        $data = Brand::orderBy('sort','desc');
        if($request->has('company_name')){
            $data = $data -> where('company_name' , 'like', '%'.$request->get('company_name').'%');
        }
        $data = $data ->with('img','bgms')
            ->orderBy('id','desc')
            ->paginate($request->get('limit',10));
        return apiResult($data,'获取',$data);
    }
    /*品牌机构详情*/
    public function brand(Request $request)
    {
        $id = $request->get('id');
        $data = Brand::where('id',$id)
            ->with('img','bgms','articles')
            ->first();
        return apiResult($data,'获取',$data);
    }
}
