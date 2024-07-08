<?php

// เคลียร์แคช
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});

// ลงทะเบียนแอดมิน
Route::get('/register','Auth\RegisterController@ShowRegisterForm');
Route::post('/register','Auth\RegisterController@register');

// ลงทะเบียนสมาชิก
// Route::get('/register-customer/{store_id}','AuthCustomer\RegisterController@ShowRegisterFormCustomer');
// Route::post('/register-customer','AuthCustomer\RegisterController@registerCustomer');

// เว็บไซต์ EDO DELIVERY
Route::group(['prefix' => '/'], function(){
    // หน้าเว็บไซต์หลัก
    Route::get('/', 'Frontend\EdoController@indexPage');
    // ลูกค้าติดต่อสอบถาม
    Route::get('/contact-us', 'Frontend\EdoController@contactUs');
    Route::post('/contact-us','Frontend\EdoController@contactUsPost');
    // เมนูอาหาร
    Route::get('/menu', 'Frontend\EdoController@menu');
    Route::get('/category-menu', 'Frontend\EdoController@categoryMenu')->name('menu.list');
    Route::get('/category/{menu_type}', 'Frontend\EdoController@categoryMenuType');
    Route::get('/special-menu', 'Frontend\EdoController@specialMenu');
    // Gallery
    Route::get('/gallery', 'Frontend\EdoController@gallery');
    // Blog
    Route::get('/blog', 'Frontend\EdoController@blog');
    // Review
    Route::get('/review', 'Frontend\EdoController@review');

    // ให้ลูกค้าแสดงความคิดเห็น
    Route::get('/customer-review/{branch_name}','Frontend\EdoController@customerReview');
    Route::post('/customer-review','Frontend\EdoController@customerReviewPost');
    Route::get('/customer-review-success','Frontend\EdoController@customerReviewSuccess');

    Route::get('/customer-feedback','Frontend\EdoController@customerFeedback');
    Route::get('/customer-feedback-detail/{branch_name}','Frontend\EdoController@customerFeedbackDetail');

    // รับสมัครงาน
    Route::get('/apply-work/{branch_name}','Frontend\EdoController@applyWork');
    Route::post('/apply-work','Frontend\EdoController@applyWorkPost');

    // voucher-card
    Route::get('/voucher-card', 'Frontend\EdoController@voucherCard');
});

// ลูกค้า
Route::group(['prefix' => 'customer'], function(){
    // เข้าสู่ระบบลูกค้า
    Route::get('/login','AuthCustomer\LoginController@ShowLoginForm')->name('customer.login');
    Route::post('/login','AuthCustomer\LoginController@login')->name('customer.login.submit');
    Route::post('/logout', 'AuthCustomer\LoginController@logout')->name('customer.logout');

    // เปลี่ยนรหัสผ่าน
    Route::get('/change-password', 'AuthCustomer\ChangePasswordController@index')->name('password.change');
    Route::post('/change-password', 'AuthCustomer\ChangePasswordController@changePassword')->name('password.update');

    // ลืมรหัสผ่าน
    Route::get('/ForgetPassword', 'AuthCustomer\ForgetPasswordController@index')->name('password.forget');
    Route::post('/ForgetPasswordForm', 'AuthCustomer\ForgetPasswordController@forgetForm');
    Route::post('/ForgetPassword', 'AuthCustomer\ForgetPasswordController@UpdatePassword')->name('password.updateForget');

    // ตะกร้าสินค้า
    // Route::get('/addToCart/{id}/{qty}','Frontend\CartController@getAddToCart');  
    // Route::get('/shopping-cart/{store_id}','Frontend\CartController@getCart')->name('cart.index');
    // Route::get('/remove/{id}/{store_id}','Frontend\CartController@getRemoveItem')->name('remove');
    // Route::get('/checkout/{store_id}','Frontend\CartController@getCheckout')->name('checkout');

    // Route::post('/coupon','Frontend\CouponsController@store')->name('coupon.store');
    // Route::get('/coupon-destroy/{store_id}','Frontend\CouponsController@destroy')->name('coupon.destroy');

    // การชำระเงิน
    // Route::post('/payment-checkout','Frontend\\CartController@paymentCheckout');

    // โปรไฟล์ลูกค้า
    // Route::get('/profile', 'Frontend\CustomerController@profile');
    // Route::get('/edit-profile/{id}', 'Frontend\CustomerController@editProfile');
    // Route::post('/update-profile', 'Frontend\CustomerController@updateProfile');

    // ประวัติการสั่งซื้อสินค้า
    // Route::get('/order-history/{store_id}', 'Frontend\CustomerController@orderHistory');
    // Route::get('/order-history-detail/{id}/{store_id}', 'Frontend\CustomerController@orderHistoryDetail');

    // ประวัติการติดต่อสอบถาม
    // Route::get('/message-history/{store_id}', 'Frontend\CustomerController@messageHistory');

    // ajax shipping cost
    // Route::get('/shipping-cost','Frontend\CartController@getShipping');
});

// แอดมิน
Route::group(['prefix' => 'admin'], function(){
    // เข้าสู่ระบบแอดมิน
    Route::get('/login','Auth\LoginController@ShowLoginForm')->name('admin.login');
    Route::post('/login','Auth\LoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');

    // เปลี่ยนรหัสผ่าน
    Route::get('/change-password', 'Auth\ChangePasswordController@index')->name('admin.password.change');
    Route::post('/change-password', 'Auth\ChangePasswordController@changePassword')->name('admin.password.update');

    // ตัวจัดการข้อมูลลูกค้า
    Route::get('/data-customer', 'Backend\AdminController@dataCustomer')->name('admin.home');
    Route::post('/update-customer', 'Backend\AdminController@updateCustomer');
    Route::get('/delete-customer/{id}', 'Backend\AdminController@deleteCustomer');

    // ตัวจัดการข้อมูลพนักงานขาย
    Route::get('/data-seller', 'Backend\AdminController@dataSeller');
    Route::post('/create-seller', 'Backend\AdminController@createSeller');
    Route::post('/update-seller', 'Backend\AdminController@updateSeller');
    Route::get('/delete-seller/{id}', 'Backend\AdminController@deleteSeller');

    // ตัวจัดการร้านค้า
    Route::get('/create-store', 'Backend\AdminController@createStore');
    Route::post('/create-store', 'Backend\AdminController@createStorePost');
    Route::get('/data-store', 'Backend\AdminController@dataStore');
    Route::get('/delete-store/{id}', 'Backend\AdminController@deleteStore');
    Route::post('/update-store', 'Backend\AdminController@updateStore');

    // ตัวจัดการประเภทเมนูอาหาร
    Route::get('/manage-menu-type', 'Backend\AdminController@manageMenuType');
    Route::post('/create-menu-type', 'Backend\AdminController@createMenuTypePost');
    Route::get('/delete-menu-type/{id}', 'Backend\AdminController@deleteMenuType');
    Route::post('/update-menu-type', 'Backend\AdminController@updateMenuType');

    // ตัวจัดการรายการเมนูอาหาร
    Route::get('/create-menu', 'Backend\AdminController@createMenu');
    Route::post('/create-menu', 'Backend\AdminController@createMenuPost');
    Route::get('/list-menu/{store_name}-{branch}', 'Backend\AdminController@listMenu');
    Route::get('/delete-food-menu/{id}', 'Backend\AdminController@deleteFoodMenu');
    Route::post('/update-food-menu', 'Backend\AdminController@updateFoodMenu');

    // ตัวจัดการเมนูพิเศษ
    Route::get('/create-special-menu', 'Backend\AdminController@createSpecialMenu');
    Route::post('/create-special-menu', 'Backend\AdminController@createSpecialMenuPost');
    Route::get('/special-menu/{store_name}', 'Backend\AdminController@specialMenu');
    Route::get('/delete-special-menu/{id}', 'Backend\AdminController@deleteSpecialMenu');
    Route::post('/update-special-menu', 'Backend\AdminController@updateSpecialMenu');

    // ตัวจัดการราคา
    Route::get('/list-menu-price/{store_name}-{branch}', 'Backend\AdminController@listMenuPrice');
    Route::post('/update-menu-price', 'Backend\AdminController@updateMenuPrice');   
    Route::get('/menu-price-detail/{id}', 'Backend\AdminController@menuPriceDetail');
    Route::get('/delete-menu-price/{id}', 'Backend\AdminController@deleteMenuPrice');

    // ตัวจัดการราคาโปรโมชั่น
    Route::get('/list-menu-price-promotion/{store_name}-{branch}', 'Backend\AdminController@listMenuPricePromotion');
    Route::post('/update-menu-price-promotion', 'Backend\AdminController@updateMenuPricePromotion');
    Route::get('/menu-price-promotion-detail/{id}', 'Backend\AdminController@menuPricePromotionDetail');
    Route::get('/delete-menu-price-promotion/{id}', 'Backend\AdminController@deleteMenuPricePromotion');

    // ตัวจัดการเว็บไซต์

    // จัดการโลโก้เว็บไซต์
    Route::get('/manage-logo-website', 'Backend\AdminController@manageLogoWebsite');
    Route::post('/create-logo-website', 'Backend\AdminController@createLogoWebsite');
    Route::get('/delete-logo-website/{id}', 'Backend\AdminController@deleteLogoWebsite');
    Route::post('/update-logo-website', 'Backend\AdminController@updateLogoWebsite');

    // จัดการรูปภาพเว็บไซต์
    Route::get('/manage-image-slide', 'Backend\AdminController@manageImageSlide');
    Route::post('/create-image-slide', 'Backend\AdminController@createImageSlide');
    Route::get('/delete-image-slide/{id}', 'Backend\AdminController@deleteImageSlide');
    Route::post('/update-image-slide', 'Backend\AdminController@updateImageSlide');

    // จัดการรูปภาพแกลอรี่
    Route::get('/manage-image-gallery', 'Backend\AdminController@manageImageGallery');
    Route::post('/create-image-gallery', 'Backend\AdminController@createImageGallery');
    Route::get('/delete-image-gallery/{id}', 'Backend\AdminController@deleteImageGallery');
    Route::post('/update-image-gallery', 'Backend\AdminController@updateImageGallery');

    // จัดการ Blog
    Route::get('/manage-blog', 'Backend\AdminController@manageBlog');
    Route::post('/create-blog', 'Backend\AdminController@createBlog');
    Route::get('/delete-blog/{id}', 'Backend\AdminController@deleteBlog');
    Route::post('/update-blog', 'Backend\AdminController@updateBlog');

    // จัดการคำสั่งซื้อ
    Route::get('/order/{store_name}-{branch}', 'Backend\AdminController@order');
    Route::get('/order-detail/{id}', 'Backend\AdminController@orderDetail');
    Route::post('/update-order-status', 'Backend\AdminController@updateOrdertatus');
    Route::get('/delete-order/{id}', 'Backend\AdminController@deleteOrder');
    Route::post('/update-shipment', 'Backend\AdminController@updateShipment');
    
    // การติดต่อสอบถาม
    Route::get('/message/{store_name}-{branch}', 'Backend\AdminController@message');
    Route::post('/answer-message', 'Backend\AdminController@answerMessage');

    // ค้นหาข้อมูล
    Route::post('/search-data-customer', 'Backend\AdminSearchController@searchDataCustomer');
    Route::post('/search-order', 'Backend\AdminSearchController@searchOrder');
    Route::post('/search-menu', 'Backend\AdminSearchController@searchMenu');
    Route::post('/search-menu-price', 'Backend\AdminSearchController@searchMenuPrice');
    Route::post('/search-menu-price-promotion', 'Backend\AdminSearchController@searchMenuPricePromotion');

    // คูปองส่วนลด
    Route::get('/create-coupon', 'Backend\AdminController@createCoupon');
    Route::post('/create-coupon', 'Backend\AdminController@uploadCoupon');

    // คูปองเงินสด
    Route::get('/create-voucher', 'Backend\AdminController@createVoucher');
    Route::post('/create-voucher', 'Backend\AdminController@uploadVoucher');
    Route::get('/delete-voucher/{id}', 'Backend\AdminController@deleteVoucher');
    Route::post('/update-voucher', 'Backend\AdminController@updateVoucher');
    Route::post('/search-voucher', 'Backend\AdminSearchController@searchVoucher');

    // ระบบสมัครงาน
    Route::get('/apply-work/{url_name}','Backend\AdminController@applyWork');
    Route::get('/open-pdfResume/{id}','Backend\AdminController@openPdfResume');
    Route::get('/url-apply-work','Backend\AdminController@urlApplyWork');
    Route::post('/url-apply-work','Backend\AdminController@urlApplyWorkPost');

});

// แอดมิน
Route::group(['prefix' => 'seller'], function(){
    // เข้าสู่ระบบแอดมิน
    Route::get('/login','AuthSeller\LoginController@ShowLoginForm')->name('seller.login');
    Route::post('/login','AuthSeller\LoginController@login')->name('seller.login.submit');
    Route::post('/logout', 'AuthSeller\LoginController@logout')->name('seller.logout');

    // เปลี่ยนรหัสผ่าน
    Route::get('/change-password', 'AuthSeller\ChangePasswordController@index')->name('seller.password.change');
    Route::post('/change-password', 'AuthSeller\ChangePasswordController@changePassword')->name('seller.password.update');

    // ตัวจัดการรายการเมนูอาหาร
    Route::get('/list-menu', 'Backend\SellerController@listMenu')->name('seller.home');
    Route::post('/update-food-menu', 'Backend\SellerController@updateFoodMenu');

    // ตัวจัดการราคา
    Route::get('/list-menu-price', 'Backend\SellerController@listMenuPrice');
    Route::post('/update-menu-price', 'Backend\SellerController@updateMenuPrice');
    Route::get('/menu-price-detail/{id}', 'Backend\SellerController@menuPriceDetail');

    // ตัวจัดการราคาโปรโมชั่น
    Route::get('/list-menu-price-promotion', 'Backend\SellerController@listMenuPricePromotion');
    Route::post('/update-menu-price-promotion', 'Backend\SellerController@updateMenuPricePromotion');
    Route::get('/menu-price-promotion-detail/{id}', 'Backend\SellerController@menuPricePromotionDetail');

    // จัดการคำสั่งซื้อ
    Route::get('/order', 'Backend\SellerController@order');
    Route::get('/order-detail/{id}', 'Backend\SellerController@orderDetail');
    Route::post('/update-order-status', 'Backend\SellerController@updateOrdertatus');
    Route::post('/update-shipment', 'Backend\SellerController@updateShipment');
    
    // การติดต่อสอบถาม
    Route::get('/message', 'Backend\SellerController@message');
    Route::post('/answer-message', 'Backend\SellerController@answerMessage');

    // ค้นหาข้อมูล
    Route::post('/search-order', 'Backend\SellerSearchController@searchOrder');
    Route::post('/search-menu', 'Backend\SellerSearchController@searchMenu');
    Route::post('/search-menu-price', 'Backend\SellerSearchController@searchMenuPrice');
    Route::post('/search-menu-price-promotion', 'Backend\SellerSearchController@searchMenuPricePromotion');

    // คูปองเงินสด
    Route::get('/voucher', 'Backend\SellerController@voucher');
    Route::post('/update-voucher', 'Backend\SellerController@updateVoucher');
    Route::post('/search-voucher', 'Backend\SellerSearchController@searchVoucher');


});

