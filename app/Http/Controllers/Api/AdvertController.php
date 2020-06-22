<?php

namespace App\Http\Controllers\Api;

use App\Models\Advert;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertController extends Controller
{
    public function getAd(Request $request)
    {
        $title = $request->get('title','首页导航');
        $data = Advert::getList($title);
        return response(['data'=>$data]);
    }
    //获取协议
    public function getProtocol(Request $request)
    {
        $position_id = Position::where('name','like','%'.'协议'.'%')->value('id');
        $title = $request->get('title');
        $data = Advert::getWa($title,$position_id);
        return response(['data'=>$data]);
    }
    //获取晋升攻略
    public function getRaiders(Request $request)
    {
        $position_id = Position::where('name','like','%'.'攻略'.'%')->value('id');
        $title = $request->get('title');
        $data = Advert::getWa($title,$position_id);
        return response(['data'=>$data]);
    }
}
