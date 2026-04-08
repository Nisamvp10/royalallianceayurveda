<?php
namespace Config;
$routes = Services::routes();
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
helper(['text', 'common_helper']);


//$routes->get('/', 'Home::index');
$routes->get('/','HomeController::index');
$routes->get('language/switch/(:segment)', 'LanguageSwitcher::switch/$1');
// admin
$routes->get('admin','admin\AuthController::login');


$routes->get('admin/login','admin\AuthController::login');
$routes->post('login','admin\AuthController::attemptLogin');
$routes->get('dashboard','admin\AuthController::login');

 //Expertise
    $routes->group('admin', ['namespace' => 'App\Controllers\admin','filter'=>'auth'], function($routes) { 
        $routes->get(slugify(getappdata('expertise')),'ExpertiseController::index');
        $routes->post('expertise/save','ExpertiseController::save');
        $routes->post('expertise/data','ExpertiseController::expertiseData');
        $routes->get('edit-expertise/(:any)','ExpertiseController::getExpertise/$1');
        $routes->delete('expertise/delete/(:any)','ExpertiseController::delete/$1');
        //partnership
        $routes->get(slugify(getappdata('partnership')),'PartnershipController::index');
        $routes->post('partnership/data','PartnershipController::parnershipData');
        $routes->post('partnership/save','PartnershipController::save');
        $routes->get('edit-partnership/(:any)','PartnershipController::getPartnership/$1');
        $routes->delete('partnership/delete/(:any)','PartnershipController::delete/$1');
        //feedback
        $routes->get('feedback','FeedbackController::index');
        $routes->post('feedback/data','FeedbackController::feedbackData');
        $routes->post('feedback/save','FeedbackController::save');
        $routes->get('edit-feedback/(:any)','FeedbackController::getfeedback/$1');
        $routes->delete('feedback/delete/(:any)','FeedbackController::delete/$1');
        //staff
        $routes->get('staff','StaffController::index');
        $routes->post('staff/list','StaffController::list');
        $routes->post('staff/save','StaffController::save');
        $routes->get('edit-staff/(:any)','StaffController::getinfo/$1');
        $routes->delete('staff/delete/(:any)','StaffController::delete/$1');
        //achievements
        $routes->get(slugify(getappdata('achievements')),'AchievementsController::index');
        $routes->post('achievements/data','AchievementsController::list');
        $routes->post('achievements/save','AchievementsController::save');
        $routes->get('edit-achievements/(:any)','AchievementsController::getinfo/$1');
        $routes->delete('achievements/delete/(:any)','AchievementsController::delete/$1');
        //industries
        $routes->get(slugify(getappdata('industries')),'IndustryController::index'); 
        
        $routes->post('industries/data','IndustryController::list');
        $routes->post('industries/save','IndustryController::save');
        $routes->get('edit-industries/(:any)','IndustryController::getinfo/$1');
        $routes->delete('industries/delete/(:any)','IndustryController::delete/$1');
        //inventory
        $routes->get('inventory','InventoryController::index');
        $routes->post('purachse/save','InventoryController::save');
        $routes->post('purachse/update','InventoryController::updateSave');
        $routes->post('inventory-list','InventoryController::list');
        $routes->post('purchase-info','InventoryController::list');
        $routes->get('inventory/edit/(:any)','InventoryController::edit/$1');
        $routes->post('get-product-price','InventoryController::getProductPrice');
        $routes->post('purchase/getLastPurchasePrice','InventoryController::getLastPurchasePrice');
        //supplier
        $routes->get('supplier','SupplierController::index');
        $routes->get('supplier/create','SupplierController::create');
        $routes->post('supplier/save','SupplierController::save');
        $routes->post('supplier/list','SupplierController::list');
        $routes->get('supplier/create/(:any)','SupplierController::create/$1');
        $routes->post('supplier/delete','SupplierController::delete');
        $routes->get('supplier-history/(:any)','SupplierController::history/$1');
        $routes->post('supplier/history-list','SupplierController::historyList');
        //products //Investments
        $routes->get('products','ProductsController::index');
        $routes->post('product/save','ProductsController::save');
        $routes->post('products/get-products','ProductsController::productList');
        $routes->get('product/edit/(:any)','ProductsController::create/$1');
        $routes->get('all-products','ProductsController::allProducts');
        $routes->post('products/get-allProducts','ProductsController::allProductsList');
        $routes->delete('product/delete/(:any)','ProductsController::delete/$1');

        //careers
        $routes->get('careers','CareerController::index');
        $routes->post('careers/data','CareerController::list');
        $routes->post('careers/save','CareerController::save');
        $routes->get('edit-career/(:any)','CareerController::getinfo/$1');
        $routes->delete('careers/delete/(:any)','CareerController::delete/$1');
        //news
        $routes->get('news','NewsController::index');
        $routes->post('news/data','NewsController::list');
        $routes->post('news/save','NewsController::save');
        $routes->get('edit-news/(:any)','NewsController::getinfo/$1');
        $routes->delete('news/delete/(:any)','NewsController::delete/$1');
        $routes->post('news/delete-gallery/(:any)','NewsController::glleryDelete/$1');
        //blog
        $routes->get(slugify(getappdata('blog')),'BlogController::index');
        $routes->post(slugify(getappdata('blog')).'/data','BlogController::list');
        $routes->post(slugify(getappdata('blog')).'/save','BlogController::save');
        $routes->get(slugify(getappdata('blog')).'/edit/(:any)','BlogController::getinfo/$1');
        $routes->delete(slugify(getappdata('blog')).'/delete/(:any)','BlogController::delete/$1');
        //service category
        $routes->get(slugify(getappdata('category')),'CategoryController::index');
        $routes->post(slugify(getappdata('category'))."/list",'CategoryController::categoryList');
        $routes->post(slugify(getappdata('category'))."/save",'CategoryController::save');
        $routes->get(slugify(getappdata('category'))."/edit/(:any)",'CategoryController::getinfo/$1');
        $routes->delete(slugify(getappdata('category')).'/delete/(:any)','CategoryController::delete/$1');
        $routes->post(slugify(getappdata('category')).'/categories','CategoryController::ajaxcategory');
        $routes->delete('services/delete-variant-gallery/(:any)','ServiceController::deleteVariantGallery/$1');
        $routes->post('services/subcategories/(:any)','ServiceController::subcategories/$1');

        //service
        $routes->get(slugify(getappdata('services')),'ServiceController::index');
        $routes->post(slugify(getappdata('services')).'/data','ServiceController::list');
        $routes->post(slugify(getappdata('services')).'/save','ServiceController::save');
        $routes->get(slugify(getappdata('services')).'/edit/(:any)','ServiceController::getinfo/$1');
        $routes->delete(slugify(getappdata('services')).'/delete/(:any)','ServiceController::delete/$1');
        $routes->post(slugify(getappdata('services')).'/delete-gallery/(:any)','ServiceController::glleryDelete/$1');
        //product Management 
        $routes->get(slugify(getappdata('product_management')),'productmanagementController::index');
        $routes->post(slugify(getappdata('product_management')).'/data','productmanagementController::list');
        $routes->post(slugify(getappdata('product_management')).'/save','productmanagementController::save');
        $routes->get(slugify(getappdata('product_management')).'/edit/(:any)','productmanagementController::getinfo/$1');
        $routes->delete(slugify(getappdata('product_management')).'/delete/(:any)','productmanagementController::delete/$1');
        $routes->post(slugify(getappdata('product_management')).'/delete-gallery/(:any)','productmanagementController::glleryDelete/$1');
        $routes->post(slugify(getappdata('product_management')).'/products/(:any)','productmanagementController::getProductBycategory/$1');
        $routes->post(slugify(getappdata('product_management')).'/get-products-info/(:any)','productmanagementController::productPurchaseDetail/$1');
        //users or Clients
        $routes->get(slugify(getappdata('clients')),'ClientsController::index');
        $routes->post(slugify(getappdata('clients')).'/list','ClientsController::list');
        $routes->post(slugify(getappdata('clients')).'/delete/(:any)','ClientsController::delete/$1');
        $routes->post(slugify(getappdata('clients')).'/active/(:any)','ClientsController::active/$1');
        //sales
        $routes->get('sales','SalesController::index');
        $routes->post('sales-list','SalesController::list');
        $routes->post('sale-info','SalesController::list');
        $routes->post('order-update','SalesController::orderUpdate');
        $routes->post('payment-update','SalesController::paymentUpdate');
        $routes->get('downloadInvoice/(:any)','SalesController::downloadInvoice/$1');
        $routes->post('sales/delete/(:any)','SalesController::delete/$1');
        $routes->post('sales/active/(:any)','SalesController::active/$1');
        //coupen code
        $routes->get('coupen-code','CoupenCodeController::index');
        $routes->post('coupen-code/list','CoupenCodeController::list');
        $routes->post('coupen-code/save','CoupenCodeController::save');
        $routes->get('coupen-code/edit/(:any)','CoupenCodeController::getinfo/$1');
        $routes->get('coupen-code/delete/(:any)','CoupenCodeController::delete/$1');
          
});
$routes->group('', ['filter' => 'auth'], function($routes)
{ 
    $routes->get('settings','admin\SettingsController::index');
    $routes->post('settings/save','admin\SettingsController::save');
    //$routes->post('settings/titleConfig','admin\SettingsController::titleSave');
    $routes->post('settings/titles-save','admin\SettingsController::titleSave');
    $routes->post('settings/get_titles_by_client/', 'admin\SettingsController::get_titles_by_client');
    $routes->post('settings/termssave','admin\SettingsController::terms_save');

    //banner
    $routes->get('admin/banner','admin\BannerContoller::index');
    $routes->post('admin/banner/save','admin\BannerContoller::save');
    $routes->post('admin/banner/get-banner','admin\BannerContoller::List');
    $routes->get('admin/slider/getUploadedImages','admin\BannerContoller::getUploadedImages');
    $routes->get('admin/slider/getMultiUploadedImages','admin\BannerContoller::getMutiUploadedImages');
    $routes->delete('admin/banner/delete/(:any)','admin\BannerContoller::delete/$1');
    $routes->get('admin/banner-edit/(:any)','admin\BannerContoller::getBannerData/$1');
   
    $routes->get('branches','admin\BranchesController::index');
    $routes->get('branch/create','admin\BranchesController::create');
    $routes->post('branch/save','admin\BranchesController::save');
    $routes->get('branch/search','admin\BranchesController::search');
    $routes->get('branches/view/(:any)','admin\BranchesController::create/$1');
    
    $routes->post('card-create-blog','admin\ProductInfoController::saveblog');
    $routes->get('clients/blog-list/(:any)','admin\ProductInfoCOntroller::blogList/$1');
    $routes->get('blog/search','admin\BlogCOntroller::search');
    $routes->post('blog/delete','admin\BlogCOntroller::delete');

    //services
    $routes->get('service/create/(:any)','admin\ServicesContoller::create/$1');
    $routes->post('services/service-save','admin\ServicesContoller::save');
    $routes->get('services/search','admin\ServicesContoller::search');
    $routes->post('service/delete','admin\ServicesContoller::delete');

    //permissions 
    $routes->get('permisions','admin\Permissions::checkpermission');
    $routes->get('permisions/list','admin\Permissions::list');
    $routes->get('permissions/check-admin/permission/(:any)','Permissions::checkpermission/$1');
    $routes->post('permissions/save','admin\Permissions::save');
    $routes->get('permissions/controls','admin\Permissions::controlss');

   
});

//frondent Card demos 
$routes->get('index','HomeController::index');

$routes->get('logout','admin\AuthController::logout');
$routes->get('about-us','AboutController::index');
$routes->get('industries','IndustryController::index');
$routes->get('contact','ContactController::index');
//career
$routes->get('career','CareerController::index');
$routes->get('career/(:segment)','CareerController::details/$1');
//news media
$routes->get('news','NewsController::index');
$routes->get('news-details/(:segment)', 'NewsController::details/$1');
$routes->get('services','ServiceController::index');
$routes->get('service/(:segment)','ServiceController::details/$1');
//case studies
$routes->get('case-studies','CasestudiesController::index');
$routes->get('case-study/(:segment)','CasestudiesController::details/$1');
//contact

//services
$routes->get('services/(:segment)','ServiceController::details/$1');
$routes->get('service-details/(:segment)','ServiceController::singleDetails/$1');
$routes->get('profile','ProfileController::index');
$routes->get('purpose-and-values','ProfileController::purposeAndValues');
$routes->get('our-clinics','AboutController::clinics');
$routes->get('research','ResearchController::index');
$routes->get('what-not-to-do','ResearchController::whtnottodo');
$routes->get('gallery','GalleryController::index');
// products 
$routes->get('products','ProductController::index');
$routes->get('productlist','ProductController::details');
$routes->get('product-details/(:segment)','ProductController::singleDetails/$1');
//cart
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/getCart', 'CartController::getCartItems');
$routes->post('cart/remove', 'CartController::remove');
$routes->get('cart','CartController::index');
$routes->post('cart/update', 'CartController::update');
$routes->post('cart/getMyCartItems', 'CartController::getMyCartItems');
//checkout 
$routes->get('checkout','CheckoutController::index');
$routes->post('cart/checkout-items', 'CartController::getMyCheckoutItems');
$routes->get('terms-conditions','CommonController::terms');
$routes->get('refund-and-cancellation','CommonController::refundcancellation');
$routes->get('privacy-policy','CommonController::privacyPolicy');
$routes->get('shipping-policy','CommonController::shippingPolicy');
//offers
$routes->get('offers','OfferController::index');

//isLogin
$routes->get('isLogin','CheckoutController::isLogin');
//shipping address
$routes->post('user/add-shipping-address','ShippingAddressController::save');
$routes->post('shipping-address','ShippingAddressController::getShippingAddress');
$routes->post('set-default-address','ShippingAddressController::setDefaultAddress');
$routes->post('user/check-user-address','ShippingAddressController::getShippingAddress');
//place order
$routes->post('place-order','CheckoutController::placeOrder');
$routes->post('apply-coupon','CheckoutController::applyCoupon');
$routes->post('verify-payment','CheckoutController::verifyPayment');
// razarpay
$routes->get('razorpay/create-order/(:any)','frond\RazorpayController::createOrder/$1');
//order success
$routes->get('order-success/(:any)','frond\PaymentSuccessController::index/$1');
$routes->post('cancel-order','CheckoutController::cancelOrder');
//my account
//set only login user to access my account
$routes->group('', ['filter' => 'userauth'], function($routes)
{
    $routes->get('my-account','frond\MyAccountController::index');
    $routes->post('account-update','frond\MyAccountController::myDataupdate');
    $routes->post('change-password','frond\MyAccountController::changePassword');
    $routes->get('invoice/(:any)','frond\MyAccountController::invoice/$1');
    $routes->post('account/edit-address','frond\MyAccountController::getShippingAddress');
});
//Register
$routes->get('login','AuthController::userLogin');
$routes->post('register','AuthController::register');
$routes->post('user-login','AuthController::login');
$routes->get('user-logout','AuthController::logout');
$routes->get('register','AuthController::createAccount');
$routes->get('forgot-password','AuthController::forgotPassword');
$routes->post('emailverify','AuthController::emielVerify');
$routes->get('otp-verification','AuthController::otppage');
$routes->post('verifyotp','AuthController::verifyOtp');
$routes->post('resendotp','AuthController::resendOtp');
$routes->get('reset-password/(:any)','AuthController::resetPasswordRequest/$1');
$routes->post('reset-password','AuthController::resetpassword');
//product Tracking
$routes->get('product-tracking','frond\ProductTrackingController::index');
$routes->post('track-order','frond\ProductTrackingController::trackOrder');
$routes->get('faq','CommonController::faq');
$routes->get('promo','CommonController::promo');