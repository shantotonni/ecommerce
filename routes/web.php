<?php


Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user-list', 'UserManagerController@list')->name('user.list');
Route::get('/user-create', 'UserManagerController@create')->name('user.create');
Route::post('/user-store', 'UserManagerController@store')->name('user.store');
Route::get('/user-edit/{id}', 'UserManagerController@edit')->name('user.edit');
Route::post('/user-update/{id}', 'UserManagerController@update')->name('user.update');
Route::get('/user-delete/{id}', 'UserManagerController@delete')->name('user.delete');
Route::post('/district/wise/thana', 'UserManagerController@districtWiseThana');

Route::get('/user-menu-permission/{id}', 'UserManagerController@userMenuPermission');
Route::post('/user-menu-permission/store', 'UserManagerController@userMenuPermissionStore')->name('user.permission.store');

//Route::match(['get','post'],'manage-menu-permission/{id?}', 'UserManagerController@manageMenuPermission');

//menu route
Route::resource('menu-list','MenuController');

Route::get('banner-manage/{id?}','SetupController@bannerManage');
Route::post('banner-manage','SetupController@bannerAdd');
Route::get('banner/delete/{id}','SetupController@bannerdelete')->name('banner.delete');

Route::get('category-manage/{id?}','SetupController@categoryManage')->name('category.index');
Route::post('category-manage','SetupController@categoryAdd');
Route::get('category/delete/{id}','SetupController@categoryDelete')->name('category.delete');

Route::get('subcategory-manage/{categoryId}/{subcategoryId?}','SetupController@subcategoryManage');
Route::post('subcategory-manage','SetupController@subcategoryAdd');
Route::get('sub-category/delete/{id}','SetupController@subCategoryDelete')->name('sub.category.delete');

Route::get('product-manage/{id?}','ProductController@productManage');
Route::post('product-manage','ProductController@productAdd');
Route::get('product-list','ProductController@productList')->name('product.list');
Route::get('product/multiple-image/create/{id}','ProductController@productMultipleImageCreate')->name('product.multiple.image.create');
Route::post('product/multiple-image/store/{id}','ProductController@productMultipleImageStore')->name('product.multiple.image.store');
Route::get('product/multiple-image/delete/{id}','ProductController@productMultipleImageDelete')->name('product.multiple.image.delete');
Route::post('product/product-stock-add','ProductController@productStockAdd');
Route::post('product/product-price-update','ProductController@productUpdatePrice');

Route::get('review-product','ReviewRatingController@reviewProduct')->name('review.product');
Route::get('product-review/details/{id}','ReviewRatingController@productReviewDetails')->name('product.review.details');
Route::get('product-review/approved/{id}','ReviewRatingController@productReviewApproved')->name('product.review.approved');

//order route
Route::get('order/order-list','OrderController@index')->name('order.index');
Route::get('order/list','OrderController@list')->name('order.list');
Route::get('order/order-add','OrderController@addOrder')->name('order.add');
Route::post('order/order-store','OrderController@storeOrder')->name('order.store');
Route::get('order/coupon-order','OrderController@couponOrder')->name('coupon.order');
Route::get('order/get-coupon-order','OrderController@getCouponOrder')->name('get.coupon.order');

Route::get('order/thana-wise-order','OrderController@thanaWiseOrder')->name('thana.wise.order');
Route::get('order/thana-wise-order-list','OrderController@thanaWiseOrderList')->name('thana.wise.order.list');

Route::post('order/order-list-export','OrderController@exportOrderList')->name('order.order-list-export');
Route::get('order/order-details/{id}','OrderController@orderDetails')->name('order.details');
Route::get('/order/invoice-print/{id}', 'OrderController@orderInvoicePrint')->name('order.invoice.print');
Route::post('/order/status-change/{id}', 'OrderController@orderStatusChange')->name('order.status.change');
Route::post('/order/delivery-charge/', 'OrderController@orderDeliveryChangeAdd')->name('order.delivery.charge.add');
Route::post('/order/discount-amount/', 'OrderController@orderDiscountAdd')->name('order.add.discount');
Route::get('/order/delete/{id}', 'OrderController@orderDelete')->name('order.delete');

Route::get('/order/details/edit/{invoiceNo}/{productCode}', 'OrderController@orderDetailsEdit')->name('order.details.edit');
Route::post('/order/details/update', 'OrderController@orderDetailsUpdate')->name('order.details.update');
Route::get('/order/details/delete/{invoiceNo}/{productCode}', 'OrderController@orderDetailsDelete')->name('order.details.delete');
Route::get('/order/add-additional-product/{invoiceNo}', 'OrderController@addAdditionalProduct')->name('existing.order.add.product');
Route::post('/order/store-additional-product', 'OrderController@storeAdditionalProduct')->name('existing.order.store.product');

//customer route
Route::get('customer/customer-list','CustomerController@index')->name('customer.index');
Route::get('customer/list','CustomerController@list')->name('customer.list');
Route::post('customer/details','CustomerController@details')->name('customer.details');

//Guest customer route
Route::get('customer/guest-customer-list','GuestCustomerController@index')->name('guest.customer.index');
Route::get('customer/guest-list','GuestCustomerController@list')->name('guest.customer.list');
Route::post('customer/guest-details','GuestCustomerController@details')->name('guest.customer.details');

//change password
Route::get('change/password','CustomerController@changePassword')->name('change.password');
Route::post('change/password','CustomerController@changePasswordStore')->name('change.password');

//coupon route
Route::get('coupon','CouponController@index')->name('coupon.index');
Route::get('coupon/create','CouponController@create')->name('coupon.create');
Route::post('coupon/store','CouponController@store')->name('coupon.store');
Route::get('coupon/edit/{id}','CouponController@edit')->name('coupon.edit');
Route::post('coupon/update/{id}','CouponController@update')->name('coupon.update');
Route::get('coupon/delete/{id}','CouponController@delete')->name('coupon.delete');
Route::get('coupon/active-inactive/{id}','CouponController@couponActiveInactive')->name('coupon.active_inactive');

//delivery st add route
Route::get('delivery','DeliveryController@index')->name('delivery.index');
Route::get('delivery/create','DeliveryController@deliveryCreate')->name('delivery.create');
Route::post('delivery/store','DeliveryController@deliveryStore')->name('delivery.store');
Route::get('delivery/edit/{id}','DeliveryController@deliveryEdit')->name('delivery.edit');
Route::post('delivery/update/{id}','DeliveryController@deliveryUpdate')->name('delivery.update');

//discount route
Route::get('discount/create','DiscountController@discountCreate')->name('discount.create');
Route::post('discount/store','DiscountController@discountStore')->name('discount.store');

//settings route
Route::get('/settings', 'SettingController@index')->name('admin.settings');
Route::post('/settings', 'SettingController@update')->name('admin.settings.update');
Route::get('/searches', 'SettingController@searches')->name('admin.settings.searches');

//report route
Route::get('/order-report', 'ReportController@orderReport')->name('order.report');

//offer_image
Route::get('offer/offer-category/{id?}','OfferController@offerCategory');
Route::post('offer/offer-category-submit','OfferController@offerCategorySubmit');
Route::get('offer-list','OfferController@offerList')->name('offer.list');
Route::get('offer-edit/{id?}','OfferController@offerEdit')->name('offer.edit');
Route::post('offer-update/{id?}','OfferController@offerUpdate')->name('offer.update');
