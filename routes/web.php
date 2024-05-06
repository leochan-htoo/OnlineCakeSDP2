<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DeliveryController;


////********************************Delivery ***************************************** */



Route::middleware(['auth', 'verified', 'check.usertype'])->group(function () {
    Route::get('/delivery/userpage', [DeliveryController::class, 'delivery'])->name('delivery');
});
 /////////////////view Detial ***/////delivery_success////////////////////
Route::get('/view-deliverydetail/{username}', [DeliveryController::class, 'deliverydetail'])->name('view.deliverydetail');

//////////////////////////////** Arrow back to the index page */
Route::get('/delivery', [DeliveryController::class, 'index'])->name('delivery.index');

//////////////////***** click on logo in the same page */

Route::get('/delivery', [DeliveryController::class, 'showDeliveryPage'])->name('delivery.page');

////////////////// click on view to delivery detail

//////////////click on the edit to view signature to submit



///////////////// click on the submitform and signature to view well done successful page

Route::post('/submit-form/{order_id}', [DeliveryController::class, 'deliverySuccess'])->name('delivery.success');


//////////// click on the Failed move to fail textbox to submit//////
Route::post('/failed/{order_id}', [DeliveryController::class, 'showReasonForFail'])->name('failed.page');


///////////////////////// click on the arrowback back to delivery home /////////////
Route::get('/arrowback', [DeliveryController::class, 'showDeliveryHomePage'])->name('delivery.page');


/////////////////// click on the close back to the delivery homepage /////////
// Route::get('/close', [DeliveryController::class, 'redirectToDelivery'])->name('redirect.homepage');

//////////// click on the edit move the next page of the signature submit ////
Route::get('/edit/{order_id}', [DeliveryController::class, 'edit'])->name('edit.signature');



/////////// click on the cancel back to the signature submit///////
Route::get('/signature-submit', [DeliveryController::class, 'submit1'])->name('signature_submit');

//////// click on the arrowback then back to the signature submit /////////
Route::get('/back', [DeliveryController::class, 'back'])->name('back');
////////// fail to submit form////////
Route::post('/submit-form', [DeliveryController::class, 'handleFormSubmission'])->name('submit.form');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

route::get('/', [HomeController::class,'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// add this route for view redirect admin panel dashboard in admin
route::get('/redirect', [HomeController::class,'redirect'])->middleware('auth', 'verified')->name('redirect');

// route::get('/productview', [HomeController::class,'productview']);


//**************************** Admin panel AdminController**********************************// -
// add this route for view catagory in admin
route::get('/view_catagory', [AdminController::class,'view_catagory']);

// add this route for view product in admin
route::post('/add_catagory', [AdminController::class,'add_catagory']);

// add this route for delete product in admin
route::get('/delete_category/{id}', [AdminController::class,'delete_category']);

// add this route for view product in admin
route::get('/view_product', [AdminController::class,'view_product']);


// add this route for add product in admin
route::post('/add_product', [AdminController::class,'add_product']);

// add this route for show product in admin
route::get('/show_product', [AdminController::class,'show_product']);

// add this route for delete action
route::get('/delete_product/{id}', [AdminController::class,'delete_product']);

// add this route for update action
route::get('/update_product/{id}', [AdminController::class,'update_product']);

// add this route for update to edit in database table
route::post('/update_product_confirm/{id}', [AdminController::class,'update_product_confirm']);

// add this route for show user order in admin panel
route::get('/order', [AdminController::class,'order']);

// add this route for show user delivery in admin panel
route::get('/delivered/{id}', [AdminController::class,'delivered']);

// add this route for print_pdf of user customer make order in admin panel
route::get('/print_pdf/{id}', [AdminController::class,'print_pdf']);

// add this route for search product data in admin panel
route::get('/search', [AdminController::class,'searchdata']);

// product search
route::get('/searchproduct', [AdminController::class,'searchproduct']);

route::get('/searchcategory', [AdminController::class,'searchcategory']);






//**************************** User HomeController**********************************// -


// add this route for show product details///////////////////////////////////// not defined is solve the problems
route::get('/product_details/{id}', [HomeController::class,'product_details'])->name('product_details');

// add this route for adding product to the cart
route::post('/add_cart/{id}', [HomeController::class,'add_cart']);

// add this route for show product to the cart
route::get('/show_cart', [HomeController::class,'show_cart']);

// add this route for remove after user add into the cart package
route::get('/remove_cart/{id}', [HomeController::class,'remove_cart']);

// add this route for for cash order

route::get('/cash_order', [HomeController::class,'cash_order']);

// add this route for payment stripe
route::get('/stripe/{totalprice}',[HomeController::class,'stripe']);

/*
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
Route::post('stripe/{totalprice}',[HomeController::class,'stripePost'])->name('stripe.post');

// add this route for create show order in user view page
route::get('/show_order', [HomeController::class,'show_order']);

// add this route for cancle order
route::get('/cancel_order/{id}', [HomeController::class,'cancel_order'])->name('cancel.order');


// add this route for adding comment for user
route::post('/add_comment',[HomeController::class,'add_comment']);

// add this route for reply from user comment
route::post('/add_reply',[HomeController::class,'add_reply']);

// add this route for user to search product
route::get('/product_search',[HomeController::class,'product_search']);

// add this to show user how many product
route::get('/products',[HomeController::class,'product'])->name('products');

route::get('/search_product',[HomeController::class,'search_product']);





