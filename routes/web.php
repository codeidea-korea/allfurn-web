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
    Route::get('/getSearchData', 'HomeController@getSearchData');
    Route::get('/welcome', 'HomeController@welcome');
    Route::put('/search/{keyword}', 'HomeController@putSearchKeyword');
    Route::delete('/search/{idx}', 'HomeController@deleteSearchKeyword');
    Route::post('/getNewProduct', 'HomeController@getNewProduct');
});
Route::get('/signin', 'LoginController@index')->name('signIn');
Route::post('/check-user', 'LoginController@checkUser')->name('checkUser');

Route::prefix('signup')->group(function() {
    Route::get('/', 'MemberController@signup')->name('signUp');
    Route::get('/sendAuthCode', 'LoginController@sendAuthCode');
    Route::post('/confirmAuthCode', 'LoginController@confirmAuthCode');
    Route::get('/success', function () {
        return view('login/success');
    })->name('signup.success');
});

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
    
    Route::post('/fcm-token', 'LoginController@updateFcmToken')->name('updateFcmToken');
});

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
    Route::get('/searchBar', 'ProductController@listBySearch2');
    Route::get('/thisMonth', 'ProductController@thisMonth');
    Route::get('/thisMonthDetail', 'ProductController@thisMonthDetail');
    Route::get('/getCategoryBanners', 'ProductController@getCategoryBanners');
});

Route::prefix('estimate') -> name('estimate') -> group(function(){
    Route::post('/makeGroupCode', 'EstimateController@makeGroupCode');
    Route::post('/insertRequest', 'EstimateController@insertRequest');
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

Route::prefix('mypage')->name('mypage')->middleware(['auth','mypage'])->group(function() {
    Route::get('/', 'MypageController@index');
    Route::get('/deal', 'MypageController@deal')->name('.deal');
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
    Route::post('/toggle/company/like', 'MypageController@toggleCompanyLike');
    Route::delete('/company/location/{idx}', 'MypageController@deleteCompanyLocation');
    Route::get('/edit/company', 'MypageController@editCompany');
    Route::post('/company/image', 'MypageController@uploadCompanyIntroduceImage');
    Route::delete('/company/image', 'MypageController@removeCompanyIntroduceImage');
    Route::get('/product', 'MypageController@product');
    Route::delete('/product/{idx}', 'MypageController@deleteProduct');
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
});


Route::prefix('alarm')->name('alarm')->middleware('auth')->group(function() {
    Route::get('/{type?}', 'AlarmController@index');
    Route::post('/send', 'AlarmController@send');
});

Route::prefix('message')->name('message')->middleware('auth')->group(function() {
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
});

Route::prefix('community')->name('community')->middleware('auth')->group(function() {
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

    Route::get('/group', function () {
        return view('community.group');
    });

    Route::prefix('my')->name('.my')->middleware('auth')->group(function() {
        Route::get('/articles', 'CommunityController@getMyArticles')->name('.articles');
        Route::get('/comments', 'CommunityController@getMyComments')->name('.comments');
        Route::get('/likes', 'CommunityController@getMyArticles')->name('.likes');
    });
});

Route::prefix('wholesaler')->name('wholesaler')->group(function() {
    Route::get('/', 'WholesalerController@index')->name('.index');
    Route::get('/detail/{wholesalerIdx}', 'WholesalerController@detail')->name('.detail');
    Route::post('/like/{wholesalerIdx}', 'WholesalerController@likeToggle')->name('.like');
    Route::get('/search', 'WholefsalerController@listBySearch');
    Route::get('/thismonth', 'WholesalerController@getThinMonthWholesaler');
});

Route::prefix('download')->name('download')->group(function() {
    Route::get('/image/name-card/{idx}', 'DownloadController@downloadNameCard');
});

Route::prefix('magazine')->name('magazine')->middleware('auth')->group(function() {
    Route::get('/', 'MagazineController@index');
    Route::get('/daily', 'MagazineController@dailyNews');
    Route::get('/daily/detail/{idx}', 'MagazineController@newsDetail');
    Route::get('/furniture', 'MagazineController@furnitureNews');
    Route::get('/furniture/detail/{idx}', 'MagazineController@newsDetail');
    Route::get('/list', 'MagazineController@magazineList');
    Route::get('/detail/{idx}', 'MagazineController@detail');
});

Route::prefix('help')->name('help')->middleware('auth')->group(function() {
    Route::get('/', 'HelpController@index');
    Route::get('/faq', 'HelpController@faq')->name('.faq');
    Route::get('/notice', 'HelpController@notice')->name('.notice');
    Route::get('/inquiry', 'HelpController@inquiry');
    Route::get('/inquiry/detail/{idx}', 'HelpController@inquiryDetail');
    Route::get('/inquiry/form/{idx?}', 'HelpController@inquiryForm');
    Route::post('/inquiry', 'HelpController@registerInquiry');
    Route::delete('/inquiry/{idx}', 'HelpController@removeInquiry');
});
