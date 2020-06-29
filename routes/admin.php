<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台公共路由部分
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function (){
    //登录、注销
    Route::get('login','LoginController@showLoginForm')->name('admin.loginForm');
    Route::post('login','LoginController@login')->name('admin.login');
    Route::get('logout','LoginController@logout')->name('admin.logout');

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台需要授权的路由 admins
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth'],function (){
    //后台布局
    Route::get('/','IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index','IndexController@index')->name('admin.index');
    Route::get('/index1','IndexController@index1')->name('admin.index1');
    Route::get('/index2','IndexController@index2')->name('admin.index2');
    //图标
    Route::get('icons','IndexController@icons')->name('admin.icons');
});

//系统管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','permission:system.manage']],function (){
    //数据表格接口
    Route::get('data','IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');
    //用户管理
    Route::group(['middleware'=>['permission:system.user']],function (){
        Route::get('user','UserController@index')->name('admin.user');
        //添加
        Route::get('user/create','UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit','UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::put('user/{id}/update','UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //删除
        Route::delete('user/destroy','UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role','UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole','UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
        //分配权限
        Route::get('user/{id}/permission','UserController@permission')->name('admin.user.permission')->middleware('permission:system.user.permission');
        Route::put('user/{id}/assignPermission','UserController@assignPermission')->name('admin.user.assignPermission')->middleware('permission:system.user.permission');
    });
    //角色管理
    Route::group(['middleware'=>'permission:system.role'],function (){
        Route::get('role','RoleController@index')->name('admin.role');
        //添加
        Route::get('role/create','RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store','RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit','RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update','RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy','RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission','RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission','RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware'=>'permission:system.permission'],function (){
        Route::get('permission','PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create','PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store','PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit','PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update','PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
        Route::delete('permission/destroy','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
    });
    //菜单管理
    Route::group(['middleware'=>'permission:system.menu'],function (){
        Route::get('menu','MenuController@index')->name('admin.menu');
        Route::get('menu/data','MenuController@data')->name('admin.menu.data');
        //添加
        Route::get('menu/create','MenuController@create')->name('admin.menu.create')->middleware('permission:system.menu.create');
        Route::post('menu/store','MenuController@store')->name('admin.menu.store')->middleware('permission:system.menu.create');
        //编辑
        Route::get('menu/{id}/edit','MenuController@edit')->name('admin.menu.edit')->middleware('permission:system.menu.edit');
        Route::put('menu/{id}/update','MenuController@update')->name('admin.menu.update')->middleware('permission:system.menu.edit');
        //删除
        Route::delete('menu/destroy','MenuController@destroy')->name('admin.menu.destroy')->middleware('permission:system.menu.destroy');
    });
});


//资讯管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:zixun.manage']], function () {
    //分类管理
    Route::group(['middleware' => 'permission:zixun.category'], function () {
        Route::get('category/data', 'CategoryController@data')->name('admin.category.data');
        Route::get('category', 'CategoryController@index')->name('admin.category');
        //添加分类
        Route::get('category/create', 'CategoryController@create')->name('admin.category.create')->middleware('permission:zixun.category.create');
        Route::post('category/store', 'CategoryController@store')->name('admin.category.store')->middleware('permission:zixun.category.create');
        //编辑分类
        Route::get('category/{id}/edit', 'CategoryController@edit')->name('admin.category.edit')->middleware('permission:zixun.category.edit');
        Route::put('category/{id}/update', 'CategoryController@update')->name('admin.category.update')->middleware('permission:zixun.category.edit');
        //删除分类
        Route::delete('category/destroy', 'CategoryController@destroy')->name('admin.category.destroy')->middleware('permission:zixun.category.destroy');
    });
    //项目管理
    Route::group(['middleware' => 'permission:zixun.article'], function () {
        Route::get('article/data', 'ArticleController@data')->name('admin.article.data');
        Route::get('article', 'ArticleController@index')->name('admin.article');
        //添加
        Route::get('article/create', 'ArticleController@create')->name('admin.article.create')->middleware('permission:zixun.article.create');
        Route::post('article/store', 'ArticleController@store')->name('admin.article.store')->middleware('permission:zixun.article.create');
        //编辑
        Route::get('article/{id}/edit', 'ArticleController@edit')->name('admin.article.edit')->middleware('permission:zixun.article.edit');
        Route::put('article/{id}/update', 'ArticleController@update')->name('admin.article.update')->middleware('permission:zixun.article.edit');
        Route::put('article/by', 'ArticleController@by')->name('admin.article.by');
        Route::put('article/bys', 'ArticleController@byStatus')->name('admin.article.bys');
        Route::put('article/refuse', 'ArticleController@refuse')->name('admin.article.refuse');
        Route::put('article/refuses', 'ArticleController@refuseStatus')->name('admin.article.refuses');
        //删除
        Route::delete('article/destroy', 'ArticleController@destroy')->name('admin.article.destroy')->middleware('permission:zixun.article.destroy');
    });
    //标签管理
    Route::group(['middleware' => 'permission:zixun.tag'], function () {
        Route::get('tag/data', 'TagController@data')->name('admin.tag.data');
        Route::get('tag', 'TagController@index')->name('admin.tag');
        //添加
        Route::get('tag/create', 'TagController@create')->name('admin.tag.create')->middleware('permission:zixun.tag.create');
        Route::post('tag/store', 'TagController@store')->name('admin.tag.store')->middleware('permission:zixun.tag.create');
        //编辑
        Route::get('tag/{id}/edit', 'TagController@edit')->name('admin.tag.edit')->middleware('permission:zixun.tag.edit');
        Route::put('tag/{id}/update', 'TagController@update')->name('admin.tag.update')->middleware('permission:zixun.tag.edit');
        //删除
        Route::delete('tag/destroy', 'TagController@destroy')->name('admin.tag.destroy')->middleware('permission:zixun.tag.destroy');
    });
    //品牌机构
    Route::group(['middleware' => 'permission:zixun.brand'], function () {
        Route::get('brand/data', 'BrandController@data')->name('admin.brand.data');
        Route::get('brand', 'BrandController@index')->name('admin.brand');
        //添加
        Route::get('brand/create', 'BrandController@create')->name('admin.brand.create');
        Route::post('brand/store', 'BrandController@store')->name('admin.brand.store');
        //编辑
        Route::get('brand/{id}/edit', 'BrandController@edit')->name('admin.brand.edit');
        Route::put('brand/{id}/update', 'BrandController@update')->name('admin.brand.update');
        //删除
        Route::delete('brand/destroy', 'BrandController@destroy')->name('admin.brand.destroy');
    });
    //分享记录
    Route::group(['middleware' => 'permission:zixun.article_likes'], function () {
        Route::get('article_likes/data', 'ArticleLikesController@data')->name('admin.article_likes.data');
        Route::get('article_likes', 'ArticleLikesController@index')->name('admin.article_likes');
        //删除
        Route::delete('article_likes/destroy', 'ArticleLikesController@destroy')->name('admin.article_likes.destroy');
    });
});
//头条新闻
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:news.manage']], function () {
    //头条管理
    Route::group(['middleware' => 'permission:zixun.news'], function () {
        Route::get('news/data', 'NewsController@data')->name('admin.news.data');
        Route::get('news', 'NewsController@index')->name('admin.news');
        //添加
        Route::get('news/create', 'NewsController@create')->name('admin.news.create');
        Route::post('news/store', 'NewsController@store')->name('admin.news.store');
        //编辑
        Route::get('news/{id}/edit', 'NewsController@edit')->name('admin.news.edit');
        Route::put('news/{id}/update', 'NewsController@update')->name('admin.news.update');
        //删除
        Route::delete('news/destroy', 'NewsController@destroy')->name('admin.news.destroy');
    });
    //头条分类管理
    Route::group(['middleware' => 'permission:zixun.news_category'], function () {
        Route::get('news_category/data', 'NewsCategoryController@data')->name('admin.news_category.data');
        Route::get('news_category', 'NewsCategoryController@index')->name('admin.news_category');
        //添加分类
        Route::get('news_category/create', 'NewsCategoryController@create')->name('admin.news_category.create');
        Route::post('news_category/store', 'NewsCategoryController@store')->name('admin.news_category.store');
        //编辑分类
        Route::get('news_category/{id}/edit', 'NewsCategoryController@edit')->name('admin.news_category.edit');
        Route::put('news_category/{id}/update', 'NewsCategoryController@update')->name('admin.news_category.update');
        //删除分类
        Route::delete('news_category/destroy', 'NewsCategoryController@destroy')->name('admin.news_category.destroy');
    });
});
//需求管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:demand.manage']], function () {
    //需求管理
    Route::group(['middleware' => 'permission:demand.demand'], function () {
        Route::get('demand/data', 'DemandController@data')->name('admin.demand.data');
        Route::get('demand', 'DemandController@index')->name('admin.demand');
        //编辑
        Route::put('demand/{id}/update', 'DemandController@update')->name('admin.demand.update');
        Route::put('demand/by', 'DemandController@by')->name('admin.demand.by');
        Route::put('demand/refuse', 'DemandController@refuse')->name('admin.demand.refuse');
        //删除
        Route::delete('demand/destroy', 'DemandController@destroy')->name('admin.demand.destroy');
    });
});
//直播管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:live.manage']], function () {
    //直播间管理
    Route::group(['middleware' => 'permission:live.room'], function () {
        Route::get('live/data', 'LiveController@data')->name('admin.live.data');
        Route::get('live', 'LiveController@index')->name('admin.live');
        //添加
        Route::get('live/create', 'LiveController@create')->name('admin.live.create');
        Route::post('live/store', 'LiveController@store')->name('admin.live.store');
        //编辑
        Route::get('live/{id}/edit', 'LiveController@edit')->name('admin.live.edit');
        Route::put('live/{id}/update', 'LiveController@update')->name('admin.live.update');
        //删除
        Route::delete('live/destroy', 'LiveController@destroy')->name('admin.live.destroy');
    });
    //直播分类管理
    Route::group(['middleware' => 'permission:live.live_category'], function () {
        Route::get('live_category/data', 'LiveCategoryController@data')->name('admin.live_category.data');
        Route::get('live_category', 'LiveCategoryController@index')->name('admin.live_category');
        //添加分类
        Route::get('live_category/create', 'LiveCategoryController@create')->name('admin.live_category.create');
        Route::post('live_category/store', 'LiveCategoryController@store')->name('admin.live_category.store');
        //编辑分类
        Route::get('live_category/{id}/edit', 'LiveCategoryController@edit')->name('admin.live_category.edit');
        Route::put('live_category/{id}/update', 'LiveCategoryController@update')->name('admin.live_category.update');
        //删除分类
        Route::delete('live_category/destroy', 'LiveCategoryController@destroy')->name('admin.live_category.destroy');
    });
});
//配置管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:config.manage']], function () {
    //站点配置
    Route::group(['middleware' => 'permission:config.site'], function () {
        Route::get('site', 'SiteController@index')->name('admin.site');
        Route::put('site', 'SiteController@update')->name('admin.site.update')->middleware('permission:config.site.update');
    });
    //广告位
    Route::group(['middleware' => 'permission:config.position'], function () {
        Route::get('position/data', 'PositionController@data')->name('admin.position.data');
        Route::get('position', 'PositionController@index')->name('admin.position');
        //添加
        Route::get('position/create', 'PositionController@create')->name('admin.position.create')->middleware('permission:config.position.create');
        Route::post('position/store', 'PositionController@store')->name('admin.position.store')->middleware('permission:config.position.create');
        //编辑
        Route::get('position/{id}/edit', 'PositionController@edit')->name('admin.position.edit')->middleware('permission:config.position.edit');
        Route::put('position/{id}/update', 'PositionController@update')->name('admin.position.update')->middleware('permission:config.position.edit');
        //删除
        Route::delete('position/destroy', 'PositionController@destroy')->name('admin.position.destroy')->middleware('permission:config.position.destroy');
    });
    //广告信息
    Route::group(['middleware' => 'permission:config.advert'], function () {
        Route::get('advert/data', 'AdvertController@data')->name('admin.advert.data');
        Route::get('advert', 'AdvertController@index')->name('admin.advert');
        //添加
        Route::get('advert/create', 'AdvertController@create')->name('admin.advert.create')->middleware('permission:config.advert.create');
        Route::post('advert/store', 'AdvertController@store')->name('admin.advert.store')->middleware('permission:config.advert.create');
        //编辑
        Route::get('advert/{id}/edit', 'AdvertController@edit')->name('admin.advert.edit')->middleware('permission:config.advert.edit');
        Route::put('advert/{id}/update', 'AdvertController@update')->name('admin.advert.update')->middleware('permission:config.advert.edit');
        //删除
        Route::delete('advert/destroy', 'AdvertController@destroy')->name('admin.advert.destroy')->middleware('permission:config.advert.destroy');
    });
    //字典管理
    Route::group(['middleware' => 'permission:config.dictionary'], function () {
        Route::get('dictionary/data', 'DictionaryController@data')->name('admin.dictionary.data');
        Route::get('dictionary', 'DictionaryController@index')->name('admin.dictionary');
        //添加字典
        Route::get('dictionary/create', 'DictionaryController@create')->name('admin.dictionary.create');
        Route::post('dictionary/store', 'DictionaryController@store')->name('admin.dictionary.store');
        //编辑字典
        Route::get('dictionary/{id}/edit', 'DictionaryController@edit')->name('admin.dictionary.edit');
        Route::put('dictionary/{id}/update', 'DictionaryController@update')->name('admin.dictionary.update');
        //删除字典
        Route::delete('dictionary/destroy', 'DictionaryController@destroy')->name('admin.dictionary.destroy');
    });
});
//会员管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:member.manage']], function () {
    //账号管理
    Route::group(['middleware' => 'permission:member.member'], function () {
        Route::get('member/data', 'MemberController@data')->name('admin.member.data');
        Route::get('member', 'MemberController@index')->name('admin.member');
        //添加
        Route::get('member/create', 'MemberController@create')->name('admin.member.create')->middleware('permission:member.member.create');
        Route::post('member/store', 'MemberController@store')->name('admin.member.store')->middleware('permission:member.member.create');
        //编辑
        Route::get('member/{id}/edit', 'MemberController@edit')->name('admin.member.edit')->middleware('permission:member.member.edit');
        Route::put('member/{id}/update', 'MemberController@update')->name('admin.member.update')->middleware('permission:member.member.edit');
        //删除
        Route::delete('member/destroy', 'MemberController@destroy')->name('admin.member.destroy')->middleware('permission:member.member.destroy');
    });
    //合伙人
    Route::group(['middleware' => 'permission:member.partner'], function () {
        Route::get('partner/data', 'PartnerController@data')->name('admin.partner.data');
        Route::get('partner', 'PartnerController@index')->name('admin.partner');
        //编辑
        Route::put('partner/{id}/update', 'PartnerController@update')->name('admin.partner.update');
        Route::put('partner/by', 'PartnerController@by')->name('admin.partner.by');
        Route::put('partner/refuse', 'PartnerController@refuse')->name('admin.partner.refuse');
        //删除
        Route::delete('partner/destroy', 'PartnerController@destroy')->name('admin.partner.destroy');
    });
    //服务商
    Route::group(['middleware' => 'permission:member.service'], function () {
        Route::get('service/data', 'ServiceController@data')->name('admin.service.data');
        Route::get('service', 'ServiceController@index')->name('admin.service');
        //添加
        Route::get('service/create', 'ServiceController@create')->name('admin.service.create');
        Route::post('service/store', 'ServiceController@store')->name('admin.service.store');
        //编辑
        Route::get('service/{id}/edit', 'ServiceController@edit')->name('admin.service.update');
        Route::put('service/{id}/update', 'ServiceController@update')->name('admin.service.update');
        Route::put('service/by', 'ServiceController@by')->name('admin.service.by');
        Route::put('service/refuse', 'ServiceController@refuse')->name('admin.service.refuse');
        //删除
        Route::delete('service/destroy', 'ServiceController@destroy')->name('admin.service.destroy');
    });
    //资方
    Route::group(['middleware' => 'permission:member.owner'], function () {
        Route::get('owner/data', 'OwnerController@data')->name('admin.owner.data');
        Route::get('owner', 'OwnerController@index')->name('admin.owner');
         //添加
         Route::get('owner/create', 'OwnerController@create')->name('admin.owner.create');
         Route::post('owner/store', 'OwnerController@store')->name('admin.owner.store');
         //编辑
         Route::get('owner/{id}/edit', 'OwnerController@edit')->name('admin.owner.update');
         Route::put('owner/{id}/update', 'OwnerController@update')->name('admin.owner.update');
        //编辑
        Route::put('owner/{id}/update', 'OwnerController@update')->name('admin.owner.update');
        Route::put('owner/by', 'OwnerController@by')->name('admin.owner.by');
        Route::put('owner/refuse', 'OwnerController@refuse')->name('admin.owner.refuse');
        //删除
        Route::delete('owner/destroy', 'OwnerController@destroy')->name('admin.owner.destroy');
    });
    //产权方
    Route::group(['middleware' => 'permission:member.property'], function () {
        Route::get('property/data', 'PropertyOwnerController@data')->name('admin.property.data');
        Route::get('property', 'PropertyOwnerController@index')->name('admin.property');
         //添加
         Route::get('property/create', 'PropertyOwnerController@create')->name('admin.property.create');
         Route::post('property/store', 'PropertyOwnerController@store')->name('admin.property.store');
         //编辑
         Route::get('property/{id}/edit', 'PropertyOwnerController@edit')->name('admin.property.update');
         Route::put('property/{id}/update', 'PropertyOwnerController@update')->name('admin.property.update');
        //编辑
        Route::put('property/{id}/update', 'PropertyOwnerController@update')->name('admin.property.update');
        Route::put('property/by', 'PropertyOwnerController@by')->name('admin.property.by');
        Route::put('property/refuse', 'PropertyOwnerController@refuse')->name('admin.property.refuse');
        //删除
//        Route::delete('property/destroy', 'PropertyOwnerController@destroy')->name('admin.property.destroy');
        Route::delete('pro/destroy', 'PropertyOwnerController@destroy')->name('admin.pro.destroy');

    });
    //经纪人
    Route::group(['middleware' => 'permission:member.manager'], function () {
        Route::get('manager/data', 'ManagerController@data')->name('admin.manager.data');
        Route::get('manager', 'ManagerController@index')->name('admin.manager');
        //编辑
        Route::put('manager/{id}/update', 'ManagerController@update')->name('admin.manager.update');
        Route::put('manager/by', 'ManagerController@by')->name('admin.manager.by');
        Route::put('manager/refuse', 'ManagerController@refuse')->name('admin.manager.refuse');
        //删除
        Route::delete('property/destroy', 'ManagerController@destroy')->name('admin.manager.destroy');
    });
});
//消息管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:message.manage']], function () {
    //消息管理
    Route::group(['middleware' => 'permission:message.message'], function () {
        Route::get('message/data', 'MessageController@data')->name('admin.message.data');
        Route::get('message/getUser', 'MessageController@getUser')->name('admin.message.getUser');
        Route::get('message', 'MessageController@index')->name('admin.message');
        //添加
        Route::get('message/create', 'MessageController@create')->name('admin.message.create')->middleware('permission:message.message.create');
        Route::post('message/store', 'MessageController@store')->name('admin.message.store')->middleware('permission:message.message.create');
        //删除
        Route::delete('message/destroy', 'MessageController@destroy')->name('admin.message.destroy')->middleware('permission:message.message.destroy');
        //我的消息
        Route::get('mine/message', 'MessageController@mine')->name('admin.message.mine')->middleware('permission:message.message.mine');
        Route::post('message/{id}/read', 'MessageController@read')->name('admin.message.read')->middleware('permission:message.message.mine');

        Route::get('message/count', 'MessageController@getMessageCount')->name('admin.message.get_count');
    });

});
//客服服务
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:customer.manage']], function () {
    //客服
    Route::group(['middleware' => 'permission:customer.service'], function () {
        Route::get('customer/data', 'CustomerServiceController@data')->name('admin.customer.data');
        Route::get('customer', 'CustomerServiceController@index')->name('admin.customer');
        //添加
        Route::get('customer/create', 'CustomerServiceController@create')->name('admin.customer.create');
        Route::post('customer/store', 'CustomerServiceController@store')->name('admin.customer.store');
        //编辑
        Route::get('customer/{id}/edit', 'CustomerServiceController@edit')->name('admin.customer.edit');
        Route::put('customer/{id}/update', 'CustomerServiceController@update')->name('admin.customer.update');
        //删除
        Route::delete('customer/destroy', 'CustomerServiceController@destroy')->name('admin.customer.destroy');
    });
    //意见反馈
    Route::group(['middleware' => 'permission:customer.opinion'], function () {
        Route::get('opinion/data', 'OpinionController@data')->name('admin.opinion.data');
        Route::get('opinion', 'OpinionController@index')->name('admin.opinion');
        //删除
        Route::delete('opinion/destroy', 'OpinionController@destroy')->name('admin.opinion.destroy');
    });

});
//文件资源管理
Route::group(['namespace'=>'Admin','middleware'=>'auth'],function (){
    Route::post('uploadImg', 'AttachmentController@uploadImg')->name('uploadImg');
    Route::post('uploadImgs', 'AttachmentController@uploadImgs')->name('uploadImgs');
    Route::post('uploadVideo', 'AttachmentController@uploadVideo')->name('uploadVideo');
    Route::get('deleteimg/{id}', 'AttachmentController@deleteimg')->name('deleteimg'); //删除图片
});
