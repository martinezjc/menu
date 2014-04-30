<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Home

// New navigation
//Route::get('/', 'HomeController@index');

// Old navigation
Route::get('/', array('uses' => 'ProductsController@get_ShowProductsViews'));

// Plan routes
Route::get('home2', 'PlanController@index');
Route::get('plans/home', 'PlanController@index');
Route::any('disclosure2', 'PlanController@disclosure');
//Route::get('plans/contract', 'ProductsController@CreatePDFForms');

// Contract Routes
Route::get('contract2', 'ContractController@index');

// Dealer routes

Route::get('dealers', 'DealerController@index');
Route::get('dealers/add', 'DealerController@add');
Route::get('dealers/save', 'DealerController@save');
Route::get('dealers/{id}/edit', 'DealerController@view');
Route::get('dealers/{id}/delete', 'DealerController@delete');


// Route::get('dealers/{id}/getUserData', array('uses' => 'DealerController@getUserData'));
// Route::get('dealers/{id}/updateUser', array('uses' => 'DealerController@update_userInfo'));
// Route::get('dealers/{id}/insertUser', array('uses' => 'DealerController@insert_userInfo'));
// Route::get('dealers/{id}/deleteUser', array('uses' => 'DealerController@delete_userInfo'));

Route::get('dealers/{id}/users', 'AccountController@show');
Route::get('dealers/{id}/getUserData', array('uses' => 'AccountController@retrieve'));
Route::get('dealers/{id}/updateUser', array('uses' => 'AccountController@update'));
Route::get('dealers/{id}/insertUser', array('uses' => 'AccountController@create'));
Route::get('dealers/{id}/deleteUser', array('uses' => 'AccountController@delete'));

Route::get('dealers/{id}/products', 'ProductController@index');
Route::get('dealers/{id}/products/add', 'ProductController@add');
Route::get('dealers/{id}/products/{productId}/edit', 'ProductController@view');

// Product routes
//Route::get('products/{id}/edit', 'ProductController@view');

// Account routes

// Route::get('accounts/create', 'AccountController@create');
// Route::get('accounts/update', 'AccountController@update');
// Route::get('accounts/retrieve', 'AccountController@retrieve');
// Route::get('accounts/delete', 'AccountController@delete');

// Company routes
Route::get('companies', 'CompanyController@index');
Route::get('companies/create', 'CompanyController@create');
Route::get('companies/update', 'CompanyController@update');
Route::get('companies/retrieve', 'CompanyController@retrieve');
Route::get('companies/delete', 'CompanyController@delete');



// Config
Route::get('home', array('uses' => 'ProductsController@get_ShowProductsViews'));

// Route::get('/', function()
// {
//     $html = '<html><body>'
//             . '<p>Put your html here, or generate it with your favourite '
//             . 'templating system.</p>'
//             . '</body></html>';
//     return PDF::load($html, 'A4', 'portrait')->show();
// });

Route::get('settings-page', array('uses' => 'ProductsController@show_settingsPage'));

Route::resource('products', 'ProductsController');

Route::get('productList', array('uses' => 'ProductsController@get_ShowProducts'));

Route::get('infoProduct', array('uses' => 'ProductsController@get_infoProduct'));

Route::get('addProduct', array('uses' => 'ProductsController@insert_productInfo'));

Route::get('getTable', array('uses' => 'ProductsController@get_TableData'));

Route::get('updateProduct', array('uses' => 'ProductsController@update_productInfo'));

Route::get('saveRangePricing', array('uses' => 'ProductsController@insertRangePricing'));

Route::get('createCompany', array('uses' => 'ProductsController@createCompany'));

Route::get('loadCompanyInfo', array('uses' => 'GeneralController@get_CompanyInfo'));

Route::get('updateCompanyInfo', array('uses' => 'GeneralController@updateCompanyInfo'));

Route::get('deleteCompany', array('uses' => 'GeneralController@removeCompanyInfo'));

Route::get('populateCompanyList', array('uses' => 'ProductsController@populateCompanyList'));

Route::get('getSortableTable', array('uses' => 'ProductsController@get_SortableTableData'));

Route::get('updateOrderProducts', array('uses' => 'ProductsController@get_UpdateOrderProducts'));

Route::get('deleteProduct', array('uses' => 'ProductsController@get_deleteTable'));

Route::get('insertProduct', array('uses' => 'ProductsController@get_InsertTable'));

Route::get('removeProduct', array('uses' => 'ProductsController@deleteProduct'));

Route::get('disclosure', array('uses' => 'ProductsController@post_disclosureMenu'));

Route::get('response', array('uses' => 'ProductsController@get_response'));

Route::get('general-settings', array('uses' => 'GeneralController@show_generalPage'));

Route::get('deleteDealer', array('uses' => 'GeneralController@delete_deal'));

Route::get('saveSettings', array('uses' => 'GeneralController@insert_settingInfo'));

Route::get('readService', array('uses' => 'GeneralController@get_WebService'));

Route::get('updateDisplayedFields', array('uses' => 'GeneralController@update_DisplayedFields'));

Route::get('test', array('uses' => 'ProductsController@TestService'));

Route::get('company-settings', array('uses' => 'GeneralController@show_companyPage'));

Route::get('loadCompanyProducts', array('uses' => 'ProductsController@loadCompanyProducts'));

Route::get('login', array('uses' => 'LoginController@get_LoginPage'));

Route::get('authenticate', array('uses' => 'LoginController@post_authenticate'));

Route::get('close-session', array('uses' => 'LoginController@post_closeSession'));

Route::get('WS', array('uses' => 'ProductsController@TestService'));

Route::get('uploadBrochure', array('uses' => 'ProductsController@post_uploadBrochure'));

Route::get('export', array('uses' => 'ProductsController@exportPDF'));

Route::get('new-product', array('uses' => 'ProductsController@load_newProduct'));

Route::get('edit-product', array('uses' => 'ProductsController@load_editProduct'));

Route::get('users', array('uses' => 'DealerController@show_newUserForm'));

Route::get('insertUser', array('uses' => 'DealerController@insert_userInfo'));

Route::get('infoUser', array('uses' => 'DealerController@get_userInfo'));

Route::get('TestDealerCode', array('uses' => 'DealerController@get_TestDealerCode'));

Route::get('updateUser', array('uses' => 'DealerController@update_userInfo'));

Route::get('deleteUser', array('uses' => 'DealerController@delete_userInfo'));

Route::get('profile', 'DealerController@get_userInfo');

Route::get('dealer-settings', array('uses' => 'GeneralController@show_dealerPage'));

Route::get('company-products', array('uses' => 'GeneralController@get_companyProducts'));

Route::get('loadCompanyProductsTable', array('uses' => 'GeneralController@show_companyProducts'));

Route::get('insertCompanyProduct', array('uses' => 'GeneralController@insert_companyProduct'));

Route::get('updateCompanyProduct', array('uses' => 'GeneralController@update_companyProduct'));

Route::get('deleteCompanyProduct', array('uses' => 'GeneralController@delete_companyProduct'));

Route::get('loadInfoCompanyProducts', array('uses' => 'GeneralController@load_companyProduct'));

Route::get('sendMailPassword', array('uses' => 'GeneralController@send_mailResetPassword'));

Route::get('password-reset', array('uses' => 'GeneralController@load_resetPassword'));

Route::get('savePassword', array('uses' => 'GeneralController@save_newPassword'));

Route::get('settings-dealercode', array('uses' => 'DealerController@get_settingsCode'));

Route::get('save-settingcode', array('uses' => 'DealerController@save_settingCode'));

Route::get('load-settingcode', array('uses' => 'DealerController@load_settingCode'));

Route::get('update-settingcode', array('uses' => 'DealerController@update_settingCode'));

Route::get('delete-settingcode', array('uses' => 'DealerController@delete_settingCode'));

Route::get('contract', array('uses' => 'ProductsController@CreatePDFForms'));

Route::get('SavetoDMS', array('uses' => 'ProductsController@SavetoDMS'));

Route::get('printmenu', array('uses' => 'ProductsController@printMenuPdf'));

