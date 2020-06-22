<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'Api','middleware'=>'api'],function (){
    //不需要auth接口
    Route::post('login', 'WechatController@getOpenid');    //登录
    Route::get('home', 'IndexController@home');    //首页数据
    Route::get('ad', 'AdvertController@getAd');    //获取广告


    //api 需要auth接口
    Route::group(['middleware'=>'apiAuth'],function (){
        Route::get('getQrCode', 'WechatController@getQrCode');    //获取推荐码
        Route::get('getShare', 'WechatController@getShare');    //获取分享码
        Route::post('qrcode', 'WechatController@delQrcode');    //删除本地二维码

        Route::get('raiders', 'AdvertController@getRaiders');    //获取攻略
        Route::get('protocol', 'AdvertController@getProtocol');    //获取协议

        Route::post('member', 'MemberController@updateInfo');    //修改用户资料
        Route::get('member', 'MemberController@member');    //获取用户信息
        Route::get('myUsers', 'MemberController@myUsers');    //获取我的用户

        Route::get('isIdentity', 'IdentityController@isIdentity');    //验证提交
        Route::post('manager', 'IdentityController@addManager');    //申请成为经纪人
        Route::post('propertyowner', 'IdentityController@addPropertyOwner');    //申请成为产权方
        Route::post('owner', 'IdentityController@addOwner');    //申请成为资方
        Route::post('service', 'IdentityController@addService');    //申请成服务商
        Route::get('business', 'IdentityController@getBusiness');    //获取服务商主营业务
        Route::get('services', 'IdentityController@getServices');    //获取服务商列表
        Route::get('service', 'IdentityController@getService');    //获取服务商
        Route::get('propertyowners', 'IdentityController@getPropertyOwners');    //获取产权方列表
        Route::get('propertyowner', 'IdentityController@getPropertyOwner');    //获取产权方详情

        Route::get('categorys', 'ArticleController@categorys');    //获取项目分类选项
        Route::post('article', 'ArticleController@addArticle');    //发布项目
        Route::get('articles', 'ArticleController@articles');    //项目列表
        Route::get('recommend_articles', 'ArticleController@recommend_articles');    //首页推荐项目
        Route::get('myArticles', 'ArticleController@myArticles');    //我发布的项目列表
        Route::get('myAllArticles', 'ArticleController@myAllArticles');    //我的项目列表
        Route::get('article', 'ArticleController@article');    //项目详情
        Route::post('completeArticle', 'ArticleController@completeArticle');    //提交完成项目
        Route::get('undoneArticle', 'ArticleController@getUndoneArticle');    //获取未完成项目

        Route::post('collection', 'IndexController@addCollection');    //添加收藏
        Route::post('partner', 'PartnerController@partner');    //申请合伙人

        Route::get('newsList', 'NewsController@newsList');    //获取新闻列表
        Route::get('news', 'NewsController@news');    //获取新闻详情

        Route::get('liveList', 'LiveController@liveList');    //获取直播列表
        Route::get('liveIndex', 'LiveController@liveIndex');    //获取直播首页展示数据
        Route::get('live', 'LiveController@live');    //获取直播详情

        Route::get('mydemands', 'DemandController@myDemands');    //获取我发布的需求列表
        Route::post('demand', 'DemandController@addDemand');    //添加需求
        Route::post('updemand', 'DemandController@upDemand');    //修改再次提交需求
        Route::get('demands', 'DemandController@demands');    //获取需求列表
        Route::get('demand', 'DemandController@demand');    //获取需求

        Route::get('brands', 'BrandController@brands');    //获取品牌机构列表
        Route::get('brand', 'BrandController@brand');    //获取品牌机构详情

        Route::post('opinion', 'CustomerServiceController@opinion');    //提交反馈
        Route::get('customers', 'CustomerServiceController@getCustomers');    //获取客服列表
        Route::get('customer', 'CustomerServiceController@getCustomer');    //获取客服
    });
});

//文件资源管理
Route::group(['namespace'=>'Admin','middleware'=>['api','apiAuth']],function (){
    Route::post('uploadImg', 'AttachmentController@uploadImgs'); // 上传图片
    Route::post('uploadFile', 'AttachmentController@uploadFile'); //上传文件
    Route::post('deleteFile', 'AttachmentController@apiDeleteimg'); //删除图片和文件
});
