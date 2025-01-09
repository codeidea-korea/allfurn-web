<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'HomeController@index');
Route::prefix('home')->group(function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/category', 'HomeController@categoryList');
    Route::get('/getSearchData', 'HomeController@getSearchData');
    Route::get('/welcome', 'HomeController@welcome');
    Route::put('/search/{keyword}', 'HomeController@putSearchKeyword');
    Route::delete('/search/{idx}', 'HomeController@deleteSearchKeyword');
    Route::get('/searchResult', 'HomeController@searchResult');
    Route::post('/getNewProduct', 'HomeController@getNewProduct');
    Route::post('/getSpeakerLoud', 'HomeController@getSpeakerLoud');
    
    Route::get('/slick-slide/items', 'HomeController@getSlickSlideItems');
});
Route::get('/signin', 'LoginController@index')->name('signIn');
Route::post('/check-user', 'LoginController@checkUser')->name('checkUser');
Route::get('/findid', 'LoginController@findid')->name('findid');
Route::get('/findpw', 'LoginController@findpw')->name('findpw');
Route::get('/signin/choose-ids', 'LoginController@chooseLoginIds')->name('chooseLoginIds');

Route::post('/tokenpass-signin', 'LoginController@signinByAccessToken')->name('signinByAccessToken');

Route::prefix('signup')->group(function() {
    Route::get('/', 'MemberController@signup')->name('signUp');
    Route::post('/sendAuthCode', 'LoginController@sendAuthCode');
    Route::post('/signinAuthCode', 'LoginController@signinAuthCode');
    
    Route::post('/confirmAuthCode', 'LoginController@confirmAuthCode');
    
    Route::post('/update-password', 'LoginController@updatePassword');

    Route::get('/success', 'LoginController@signupcomplete');
});
Route::get('/allimtalk/templates', 'LoginController@getTemplates');
Route::post('/allimtalk/send', 'LoginController@asend');

Route::get('/json/wholesaler/{wholesalerIdx}', 'CatalogController@wholesalerInfoJson');
Route::get('/catalog/{wholesalerIdx}/product/detail/{productIdx}', 'CatalogController@productDetail')->name('.wholesaler.catalogProduct');
Route::get('/catalog/{wholesalerIdx}', 'CatalogController@catalog')->name('.wholesaler.catalog');
Route::get('/wholesalerAddProduct/catalog/', 'CatalogController@wholesalerAddProduct');

Route::get('/signout', 'LoginController@signOut')->name('signOut');
Route::get('/terms', 'MemberController@terms')->name('terms');
Route::post('/saveTerms', 'MemberController@saveTerms')->name('saveTerms');
Route::get('/passwordRequest', function () {
    return view('login.password');
})->name('.passwordRequest');
Route::post('/passwordRequest', 'MemberController@passwordRequest')->name('passwordRequest');
Route::post('/authCodeCount', 'MemberController@authCodeCount');

Route::post('checkAlert', 'HomeController@checkAlert');

Route::prefix('/family')->name('family')->group(function() {
//    Route::get('/', 'HomeController@getAllFamily');
    Route::get('/{idx}', 'HomeController@getFamilyMember');
    Route::post('/like', 'HomeController@toggleCompanyLike');
});

Route::prefix('/member')->name('member')->group(function() {
    Route::post('/createUser', 'MemberController@createUser');
    Route::post('/checkUsingEmail', 'MemberController@checkUsingEmail');
    Route::post('/checkUsingBusinessNumber', 'MemberController@checkUsingBusinessNumber');
    Route::post('/getAddressBook', 'MemberController@getAddressBook');
    Route::post('/modifyAddressBook', 'MemberController@modifyAddressBook');
    Route::delete('/addressBook/{addressIdx}', 'MemberController@removeAddressBook');
});
Route::post('/member/fcm-token', 'LoginController@updateFcmToken')->name('updateFcmToken');

Route::get('/event/saveUserAction', 'CatalogController@saveUserAction');
Route::prefix('product')->name('product')->group(function() {
    Route::get('/best-new', 'ProductController@bestNewProduct')->name('.best-new');
    Route::get('/new', 'ProductController@newProduct')->name('.new');
    Route::get("/newAddedProduct", 'ProductController@newAddedProduct');
    Route::get('/detail/{productIdx}', 'ProductController@detail')->name('.detail');
    Route::get('/registration', 'ProductController@registration')->name('.create');
    Route::post('/getOption/{productIdx}', 'ProductController@getOption');
    Route::post('/getProductData/{productIdx}', 'ProductController@getProductData');
    Route::post('/getCategoryList/{parentIdx}', 'ProductController@getCategoryList');
    Route::post('/getCategoryListV2', 'ProductController@getCategoryListV2');
    Route::post('/getCategoryProperty', 'ProductController@getCategoryProperty');
    Route::post('/saveProduct', 'ProductController@saveProduct');
    Route::get('/modify/{productIdx}', 'ProductController@modify')->name('.modify');
    Route::post('/getMyProductList', 'ProductController@getMyProductList');
    Route::post('/productList/{userIdx}', 'ProductController@getProductList');
    Route::post('/image', 'ProductController@imageUpload');
    Route::delete('/image', 'ProductController@imageDelete');
    Route::post('/interest/{productIdx}', 'ProductController@interestToggle');
    Route::get('/category', 'ProductController@listByCategory');
    Route::get('/search', 'ProductController@listBySearch');
    Route::get('/getSearchList', 'ProductController@listBySearchAjax');
    Route::get('/searchBar', 'ProductController@listBySearch2');
    Route::get('/thisMonth', 'ProductController@thisMonth');
    Route::get('/thisMonthDetail', 'ProductController@thisMonthDetail');
    Route::get('/getCategoryBanners', 'ProductController@getCategoryBanners');
    Route::get('/getJsonThisBestWholesaler', 'ProductController@getJsonThisBestWholesaler');
    Route::get('/getJsonListByCategory', 'ProductController@getJsonListByCategory');
    Route::get('/getJsonListBySearch', 'ProductController@getJsonListBySearch');
    Route::get('/planDiscountDetail', 'ProductController@planDiscountDetail');
    Route::get('/popularList', 'ProductController@getPopularSumList');
    Route::get('/popularListTab/{categoryIdx}', 'ProductController@getPopularSumListTab');
    Route::get('/popularBrand', 'ProductController@popularBrandList');
    Route::get('/jsonPopularBrand', 'ProductController@jsonPopularBrand');
});

Route::prefix('estimate') -> name('estimate') -> group(function(){
    Route::post('/makeEstimateCode', 'EstimateController@makeEstimateCode');
    Route::post('/insertRequest', 'EstimateController@insertRequest');
    Route::post('/updateResponse', 'EstimateController@updateResponse');
    Route::put('/holdEstimate', 'EstimateController@holdEstimate');
    Route::post('/insertOrder', 'EstimateController@insertOrder');
    Route::put('/checkOrder', 'EstimateController@checkOrder');

    Route::post('/companyList', 'EstimateController@getCompanyList');
    Route::post('/updateResponseMulti', 'EstimateController@updateResponseMulti');
});

Route::prefix('order')->name('order')->group(function() {
    Route::get('/', 'OrderController@orderForm2');
    Route::get('/{cartIdx?}', 'OrderController@orderForm');
    Route::post('/addCart', 'OrderController@addCart');
    Route::post('/addCartOption', 'OrderController@addCartOption');
    Route::post('/removeCart' ,'OrderController@removeCart');
    Route::post('/updateCart', 'OrderController@updateCart');
    Route::post('/addCart', 'OrderController@addCart');
    Route::post('/addOrder', 'OrderController@addOrder');
    Route::post('/makeOrder', 'OrderController@makeOrder');
    Route::get('/success/{orderGroupCode}', 'OrderController@success')->name('success');
});
Route::get('/cart', 'OrderController@cart')->name('cart');

Route::get('/like/product', 'MypageController@likeProduct');
Route::get('/like/company', 'MypageController@likeCompany');

Route::prefix('mypage')->name('mypage')->middleware(['auth','mypage'])->group(function() {
    Route::get('/', 'MypageController@index')->name('.mypage');;
    Route::get('/deal', 'MypageController@deal')->name('.deal');
    Route::get('/deal-company', 'MypageController@dealCompany')->name('.deal-company');
    Route::get('/purchase', 'MypageController@purchase')->name('.purchase');
    Route::get('/normal', 'MypageController@normal')->name('.normal');
    Route::get('/order/detail/', 'MypageController@detail');
    Route::get('/order/cancel/', 'MypageController@orderCancel');
    Route::put('/order/status', 'MypageController@changeStatus');
    Route::get('/interest', 'MypageController@interest')->name('.interest');
    Route::get('/like', 'MypageController@like');
    Route::get('/recent', 'MypageController@recent');
    Route::get('/my-folders', 'MypageController@getMyFolders');
    Route::post('/my-folders', 'MypageController@addMyFolders');
    Route::delete('/my-folders/{idx}', 'MypageController@removeMyFolders');
    Route::delete('/interest-products', 'MypageController@removeMyInterestProducts');
    Route::post('/interest-products', 'MypageController@addMyInterestProducts');
    Route::put('/move/interest-products', 'MypageController@moveMyInterestProducts');
    Route::get('/company', 'MypageController@company');
    Route::post('/company', 'MypageController@updateCompany');
    Route::post('/business_license_file/update', 'MypageController@updateBusinessLicenseFile');
    Route::post('/toggle/company/like', 'MypageController@toggleCompanyLike');
    Route::delete('/company/location/{idx}', 'MypageController@deleteCompanyLocation');
    Route::get('/edit/company', 'MypageController@editCompany');
    Route::post('/company/image', 'MypageController@uploadCompanyIntroduceImage');
    Route::delete('/company/image', 'MypageController@removeCompanyIntroduceImage');
    Route::get('/product', 'MypageController@product');
    Route::delete('/product/{idx}', 'MypageController@deleteProduct');
    Route::delete('/product-temp/{idx}', 'MypageController@deleteProductTemp');
    Route::put('/product/state', 'MypageController@changeProductState');
    Route::get('/account', 'MypageController@account');
    Route::post('/account/authentic', 'MypageController@compareAuthCode');
    Route::post('/account/send/auth/email', 'MypageController@sendAuthEmail');
    Route::post('/account/send/auth/phone', 'MypageController@sendAuthPhone');
    Route::get('/company-account', 'MypageController@companyAccount');
    Route::put('/company-account', 'MypageController@updateCompanyAccount');
    Route::put('/company-account/password', 'MypageController@changePassword');
    Route::delete('/company-account/{idx}', 'MypageController@deleteCompanyMember');
    Route::get('/company-member/{idx?}', 'MypageController@getCompanyMember');
    Route::post('/company-member', 'MypageController@createCompanyMember');
    Route::put('/company-member', 'MypageController@updateCompanyMember');
    Route::get('/withdrawal', 'MypageController@withdrawal');
    Route::post('/withdrawal', 'MypageController@doWithdrawal');
    Route::get('/normal-account', 'MypageController@normalAccount');
    Route::put('/normal-account', 'MypageController@updateNormalAccount');
    Route::get('/request/regular', 'MypageController@requestRegular');
    Route::post('/request/regular', 'MypageController@requestRegularForm');
    Route::delete('/logo/image', 'MypageController@deleteLogoImage');
    Route::put('/represent/product/{idx}', 'MypageController@toggleRepresentProduct');
    Route::get('/check/new/badge', 'MypageController@getCheckNewBadge');
    
    Route::get('/estimateInfo', 'MypageController@getEstimateInfo');
    Route::get('/requestEstimate', 'MypageController@getRequestEstimate');
    Route::post('/requestEstimateDetail', 'MypageController@getRequestEstimateDetail');
    Route::get('/responseEstimate', 'MypageController@getResponseEstimate');
    Route::post('/responseEstimateDetail', 'MypageController@getResponseEstimateDetail');
    Route::post('/requestOrderDetail', 'MypageController@getRequestOrderDetail');
    Route::post('/responseOrderDetail', 'MypageController@getResponseOrderDetail');
    Route::get('/responseEstimateMulti', 'MypageController@getResponseEstimateMulti');

    Route::get('/sendRequestEstimate/{idx}', 'MypageController@getSendRequestEstimate');
    Route::get('/sendResponseEstimate/{idx}', 'MypageController@getSendResponseEstimate');
    Route::get('/checkRuquestEstimate/{idx}', 'MypageController@getCheckRequestEstimate');
    Route::get('/sendResponseOrder/{code}', 'MypageController@getSendResponseOrder');
    Route::get('/checkResponseEstimate/{idx}', 'MypageController@getCheckResponseEstimate');
    Route::get('/checkOrder/{idx}', 'MypageController@getCheckOrder');

    Route::post('/products-orders/represents', 'MypageController@saveProductOrderRepresents');
    Route::post('/products-orders/normal', 'MypageController@saveProductOrderNormal');
    
    Route::post('/requestEstimateDevDetail', 'MypageController@getRequestEstimateDevDetail');
    Route::post('/responseEstimateDevDetail', 'MypageController@getResponseEstimateDevDetail');
    Route::post('/estimate/temp/order/detail', 'MypageController@getTempOrderDetail');
    Route::post('/estimate/order/detail', 'MypageController@getOrderDetail');
});


Route::prefix('alarm')->name('alarm')
		      ->middleware('auth')
		      ->group(function() {
    Route::get('/{type?}', 'AlarmController@index');
    Route::post('/send', 'AlarmController@send');
});

Route::prefix('message')->name('message')
			->middleware('auth')
			->group(function() {
    Route::get('/', 'MessageController@index');
    Route::get('/room/detail', 'MessageController@index');
    Route::get('/room', 'MessageController@room');
    Route::get('/chatting', 'MessageController@getChatting');
    Route::delete('/keyword/{idx}', 'MessageController@deleteKeyword');
    Route::post('/company/push', 'MessageController@toggleCompanyPush');
    Route::post('/send', 'MessageController@sendMessage');
    Route::get('/rooms/count', 'MessageController@getRoomsCount');
    Route::post('/report', 'MessageController@report');
    Route::post('/send/message', 'MessageController@sendRoomMessage');
    Route::get('/rooms', 'MessageController@getRooms');
    // Route::get('/unread','MessageController@sendToUnreadRecipients');
    Route::get('/read','MessageController@readRoomAlarmCount');
});

Route::prefix('community')->name('community')
			  ->middleware('auth')
			  ->group(function() {
    Route::get('/', 'CommunityController@index')->name('.index');
    Route::delete('/remove/{idx}', 'CommunityController@removeArticle');
    Route::get('/articles', 'CommunityController@getArticleList');
    Route::get('/recent/search-keyword', 'CommunityController@getSearchKeywordList');
    Route::get('/detail/{idx}', 'CommunityController@detail')->name('.detail');
    Route::post('/reply', 'CommunityController@writeReply');
    Route::get('/write/{idx?}','CommunityController@write');
    Route::post('/write','CommunityController@create');
    Route::put('/write','CommunityController@modify');
    Route::post('/image', 'CommunityController@uploadImage');
    Route::delete('/image', 'CommunityController@deleteImage');
    Route::post('/like-article', 'CommunityController@toggleArticleLike');
    Route::post('/subscribe/board', 'CommunityController@subscribeBoard');
    Route::delete('/search-keyword/{idx}', 'CommunityController@deleteSearchKeyword');
    Route::delete('/comment/{idx}', 'CommunityController@removeComment');
    Route::post('/reporting', 'CommunityController@reporting');
    Route::get('/write-dispatch/{orderGroupCode}', 'CommunityController@writeDispatch');

    Route::get('/club', 'CommunityController@clubList');
    Route::post('/club/register', 'CommunityController@clubRegister');
    Route::post('/club/withdrawal', 'CommunityController@clubWithdrawal');
    Route::get('/club/{idx}', 'CommunityController@clubDetail');
    Route::get('/club/article/{idx}', 'CommunityController@clubArticle');
    Route::post('/club/reply', 'CommunityController@clubReply');
    Route::delete('/club/reply/{idx}', 'CommunityController@removeClubReply');
    Route::post('/club/like-article', 'CommunityController@toggleClubArticleLike');
    Route::get('/club/{clubIdx}/write/{idx?}','CommunityController@clubArticleForm');
    Route::post('/club/{clubIdx}/write','CommunityController@createClubArticle');
    Route::put('/club/{clubIdx}/write','CommunityController@modifyClubArticle');
    Route::delete('/club/{clubIdx}/write/{idx}', 'CommunityController@removeClubArticle');

    Route::prefix('my')->name('.my')->middleware('auth')->group(function() {
        Route::get('/articles', 'CommunityController@getMyArticles')->name('.articles');
        Route::get('/comments', 'CommunityController@getMyComments')->name('.comments');
        Route::get('/likes', 'CommunityController@getMyArticles')->name('.likes');
    });
});

Route::prefix('wholesaler')->name('wholesaler')->group(function() {
    Route::get('/', 'WholesalerController@index')->name('.index');
    Route::get('/list', 'WholesalerController@getWholesalerList');
    Route::get('/detail/{wholesalerIdx}', 'WholesalerController@detail')->name('.detail');
    Route::post('/like/{wholesalerIdx}', 'WholesalerController@likeToggle')->name('.like');
    Route::get('/search', 'WholesalerController@listBySearch');
    Route::get('/getSearchList', 'WholesalerController@listBySearchAjax');
    Route::get('/best', 'WholesalerController@best');
    Route::get('/gather', 'WholesalerController@gather');
    Route::get('/gatherDetail', 'WholesalerController@gatherDetail');
    Route::get('/thismonth', 'WholesalerController@getThisMonthWholesaler');
    Route::get('/wholesalerAddProduct', 'WholesalerController@wholesalerAddProduct');
    Route::get('/wholesalerAddProduct2', 'WholesalerController@wholesalerAddProduct2');
    Route::get('/wholesalerProduct', 'WholesalerController@wholesalerProduct');
    Route::post('/wholesalerProduct2', 'WholesalerController@wholesalerProduct2');
});

Route::prefix('download')->name('download')->group(function() {
    Route::get('/image/name-card/{idx}', 'DownloadController@downloadNameCard');
});

Route::prefix('magazine')->name('magazine')
			 ->middleware('auth')
			 ->group(function() {
    Route::get('/', 'MagazineController@index');
    Route::get('/daily', 'MagazineController@dailyNews');
    Route::get('/daily/detail/{idx}', 'MagazineController@newsDetail');
    Route::get('/furniture', 'MagazineController@furnitureNews');
    Route::get('/furniture/detail/{idx}', 'MagazineController@newsDetail');
    Route::get('/list', 'MagazineController@magazineList');
    Route::get('/detail/{idx}', 'MagazineController@detail');
});

Route::prefix('help')->name('help')
->middleware('auth')
	->group(function() {
    Route::get('/', 'HelpController@index');
    Route::get('/faq', 'HelpController@faq')->name('.faq');
    Route::get('/notice', 'HelpController@notice')->name('.notice');
    Route::get('/notice/{idx}', 'HelpController@notice')->name('.notice');
    Route::get('/guide', 'HelpController@guide')->name('.guide');
    Route::get('/inquiry', 'HelpController@inquiry');
    Route::get('/inquiry/detail/{idx}', 'HelpController@inquiryDetail');
    Route::get('/inquiry/form/{idx?}', 'HelpController@inquiryForm');
    Route::post('/inquiry', 'HelpController@registerInquiry');
    Route::delete('/inquiry/{idx}', 'HelpController@removeInquiry');
});

Route::get('/message/unread','MessageController@sendToUnreadRecipients');
Route::get('/push-send/all', 'ExtraApiController@sendPushByStatusPending')->name('sendPushByStatusPending');
