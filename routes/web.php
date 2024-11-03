<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AppointmentsPagesController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\FaqsPagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OwnerAppointmentsController;
use App\Http\Controllers\OwnerAppointmentsPagesController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PackagesPagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostPagesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UsertypeController;
use App\Http\Controllers\VerifyIdController;
use App\Http\Controllers\ManagerAppointmensController;
use App\Http\Controllers\ManagerAppointmentsPagesController;
use App\Http\Controllers\ManagerChatController;
use App\Http\Controllers\CustomPackagesController;
use App\Http\Controllers\CustomPackagesPagesController;
use App\Http\Controllers\MgrCustomPackagesPagesController;
use App\Http\Controllers\MgrCustomPackagesController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/profile', [ProfileController::class, 'adminedit'])->name('adminprofile.edit');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::get('/get-messages', [ChatController::class, 'getMessages']);
Route::get('/get-users', [ChatController::class, 'getUsers']);
Route::get('/get-admin', [ChatController::class, 'getAdminAcc']);
Route::post('/send-message-to-managers', [ChatController::class, 'sendMessageToManagers']);
Route::get('/get-messages-for-managers', [ChatController::class, 'getMessagesForManagers']);
Route::get('/get-managers', [ChatController::class, 'getManagers']);
Route::post('/send-message-to-user', [ChatController::class, 'sendMessageToUser']);
Route::get('/get-messages-for-user', [ChatController::class, 'getMessagesForUser']);
Route::get('/get-unread-message-counts', [ChatController::class, 'fetchUserUnreadMessageCounts']);
Route::post('/mark-messages-as-read/{senderId}', [ChatController::class, 'markAsRead'])->name('messages.markAsRead');







//ADMIN
Route::get('/admin/chat', [AdminController::class, 'chat'])->middleware(['auth', 'verified','admin'])->name('admin.chat');
Route::get('/others', [AdminController::class, 'others'])->middleware(['auth', 'verified','admin'])->name('others');
Route::get('/admindashboard', [AdminController::class, 'admindashboard'])->middleware(['auth', 'verified','admin'])->name('admindashboard');
Route::get('/appointments', [AdminController::class, 'appointments'])->middleware(['auth', 'verified','admin'])->name('adminappointments');
Route::get('/users', [UsertypeController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('adminusers');
Route::get('/adminreviews', [AdminController::class, 'adminreviews'])->middleware(['auth', 'verified','admin'])->name('adminratings');
Route::get('/packages', [AdminController::class, 'packages'])->middleware(['auth', 'verified','admin'])->name('adminpackages');
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware(['auth', 'verified','admin'])->name('profile');

//ADMIN APPOINTMENT
Route::get('/admin/calendar/data', [AppointmentsPagesController::class, 'calendar'])->middleware(['auth', 'verified','admin'])->name('calendar');
Route::get('/admin/calendar', [AppointmentsPagesController::class, 'calendarView'])->middleware(['auth', 'verified','admin'])->name('calendarView');

Route::get('/admin/meetingCalendar', [AppointmentsPagesController::class, 'meetingCalendarView'])->middleware(['auth', 'verified','admin'])->name('meetingCalendarView');
Route::get('/admin/meetingCalendar/data', [AppointmentsPagesController::class, 'meetingCalendar'])->middleware(['auth', 'verified','admin'])->name('meetingCalendar');

Route::get('/admin/booked', [AppointmentsPagesController::class, 'booked'])->middleware(['auth', 'verified','admin'])->name('booked');
Route::get('/admin/booked/{appointment_id}/view', [AppointmentsPagesController::class, 'bookedView'])->middleware(['auth', 'verified','admin'])->name('bookedView');
Route::get('/admin/pending', [AppointmentsPagesController::class, 'pending'])->middleware(['auth', 'verified','admin'])->name('pending');
Route::get('/admin/pending/{appointment_id}/view', [AppointmentsPagesController::class, 'pendingView'])->middleware(['auth', 'verified','admin'])->name('pendingView');
Route::get('/admin/cancelled/{appointment_id}/view', [AppointmentsPagesController::class, 'cancelledView'])->middleware(['auth', 'verified','admin'])->name('cancelledView');
Route::get('/admin/done/{appointment_id}/view', [AppointmentsPagesController::class, 'doneView'])->middleware(['auth', 'verified','admin'])->name('doneView');
Route::get('/admin/approved', [AppointmentsPagesController::class, 'approved'])->middleware(['auth', 'verified','admin'])->name('approved');
Route::get('/admin/returned', [AppointmentsPagesController::class, 'returned'])->middleware(['auth', 'verified','admin'])->name('returned');
Route::get('/admin/cancelled', [AppointmentsPagesController::class, 'cancelled'])->middleware(['auth', 'verified','admin'])->name('cancelled');
Route::get('/admin/done', [AppointmentsPagesController::class, 'done'])->middleware(['auth', 'verified','admin'])->name('done');
Route::get('/admin/direct', [AppointmentsPagesController::class, 'direct'])->middleware(['auth', 'verified','admin'])->name('direct');
Route::post('/admin/direct/save', [AppointmentController::class, 'directsave'])->middleware(['auth', 'verified','admin'])->name('directsave');


//REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS 
Route::get('/admin/reviews/pending', [ReviewController::class, 'pending'])->middleware(['auth', 'verified','admin'])->name('reviewpending');
Route::get('/admin/reviews/approved', [ReviewController::class, 'approved'])->middleware(['auth', 'verified','admin'])->name('reviewapproved');
Route::put('/admin/reviews/pending/to/approved/{review_id}', [ReviewController::class, 'statusApproved'])->middleware(['auth', 'verified','admin'])->name('reviews.approve');
Route::put('/admin/reviews/approved/to/pending/{review_id}', [ReviewController::class, 'statusPending'])->middleware(['auth', 'verified','admin'])->name('reviews.pending');

//REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS 


//NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS 
Route::get('/fetch-admin-unread-count', [AppointmentController::class, 'fetchAdminUnreadCount'])->middleware(['auth', 'verified','admin'])->name('fetch.admin.unread.count');
Route::get('/admin/notifications', [AdminController::class, 'notifications'])->middleware(['auth', 'verified','admin'])->name('admin.notifications');
Route::get('/fetch-unopened-messages-count', [AppointmentController::class, 'fetchAdminUnopenedMessageCount'])->middleware(['auth', 'verified','admin'])->name('fetch.admin.unopened.message.count');

//NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS 



// CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE 

// Route::resource('newpackage', CustomPackagesController::class);
Route::get('/admin/new/custom/packages/add', [CustomPackagesPagesController::class, 'customadd'])->middleware(['auth', 'verified','admin'])->name('custom.add');
Route::post('/admin/new/custom/packages/store', [CustomPackagesController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('newcustom.package.store');
Route::get('/manager/new/custom/packages/add', [MgrCustomPackagesPagesController::class, 'customadd'])->middleware(['auth', 'verified','manager'])->name('manager.custom.add');
Route::post('/manager/new/custom/packages/store', [MgrCustomPackagesController::class, 'store'])->middleware(['auth', 'verified','manager'])->name('manager.newcustom.package.store');

//FOOD //FOOD //FOOD //FOOD //FOOD 
//FOOD-ADMIN
Route::get('/admin/custom/packages/food', [CustomPackagesPagesController::class, 'food'])->middleware(['auth', 'verified','admin'])->name('customfood');
Route::get('/admin/custom/packages/food/add', [CustomPackagesPagesController::class, 'foodAdd'])->middleware(['auth', 'verified','admin'])->name('customfoodadd');
Route::post('/admin/custom/packages/food/store', [CustomPackagesController::class, 'foodStore'])->middleware(['auth', 'verified','admin'])->name('customfood.store');
Route::get('/admin/custom/packages/food/view', [CustomPackagesPagesController::class, 'foodView'])->middleware(['auth', 'verified','admin'])->name('customfood.view');
Route::get('/admin/custom/packages/food/edit/{food_id}', [CustomPackagesPagesController::class, 'foodEdit'])->middleware(['auth', 'verified','admin'])->name('customfood.edit');
Route::put('/admin/custom/packages/food/update/{food_id}', [CustomPackagesController::class, 'foodUpdate'])->middleware(['auth', 'verified','admin'])->name('customfood.update');
Route::get('/admin/custom/packages/food/destroy/{food_id}', [CustomPackagesController::class, 'foodDestroy'])->middleware(['auth', 'verified','admin'])->name('customfood.destroy');


//FOOD-MANAGER
Route::get('/manager/custom/packages/food', [MgrCustomPackagesPagesController::class, 'food'])->middleware(['auth', 'verified','manager'])->name('manager.customfood');
Route::get('/manager/custom/packages/food/add', [MgrCustomPackagesPagesController::class, 'foodAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodadd');
Route::post('/manager/custom/packages/food/store', [MgrCustomPackagesController::class, 'foodStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.store');
Route::get('/manager/custom/packages/food/view', [MgrCustomPackagesPagesController::class, 'foodView'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.view');
Route::get('/manager/custom/packages/food/edit/{food_id}', [MgrCustomPackagesPagesController::class, 'foodEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.edit');
Route::put('/manager/custom/packages/food/update/{food_id}', [MgrCustomPackagesController::class, 'foodUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.update');
Route::get('/manager/custom/packages/food/destroy/{food_id}', [MgrCustomPackagesController::class, 'foodDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.destroy');
//FOOD //FOOD //FOOD //FOOD //FOOD 


//FOODPACK //FOODPACK //FOODPACK //FOODPACK //FOODPACK 
//FOODPACK-ADMIN
Route::get('/admin/custom/packages/foodpack', [CustomPackagesPagesController::class, 'foodpack'])->middleware(['auth', 'verified','admin'])->name('customfoodpack');
Route::get('/admin/custom/packages/foodpack/add', [CustomPackagesPagesController::class, 'foodpackAdd'])->middleware(['auth', 'verified','admin'])->name('customfoodpackadd');
Route::post('/admin/custom/packages/foodpack/store', [CustomPackagesController::class, 'foodpackStore'])->middleware(['auth', 'verified','admin'])->name('customfoodpack.store');
Route::get('/admin/custom/packages/foodpack/view', [CustomPackagesPagesController::class, 'foodpackView'])->middleware(['auth', 'verified','admin'])->name('customfoodpack.view');
Route::get('/admin/custom/packages/foodpack/edit/{foodpack_id}', [CustomPackagesPagesController::class, 'foodpackEdit'])->middleware(['auth', 'verified','admin'])->name('customfoodpack.edit');
Route::put('/admin/custom/packages/foodpack/update/{foodpack_id}', [CustomPackagesController::class, 'foodpackUpdate'])->middleware(['auth', 'verified','admin'])->name('customfoodpack.update');
Route::get('/admin/custom/packages/foodpack/destroy/{foodpack_id}', [CustomPackagesController::class, 'foodpackDestroy'])->middleware(['auth', 'verified','admin'])->name('customfoodpack.destroy');


//FOODPACK-MANAGER
Route::get('/manager/custom/packages/foodpack', [MgrCustomPackagesPagesController::class, 'foodpack'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack');
Route::get('/manager/custom/packages/foodpack/add', [MgrCustomPackagesPagesController::class, 'foodpackAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpackadd');
Route::post('/manager/custom/packages/foodpack/store', [MgrCustomPackagesController::class, 'foodpackStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack.store');
Route::get('/manager/custom/packages/foodpack/view', [MgrCustomPackagesPagesController::class, 'foodpackView'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack.view');
Route::get('/manager/custom/packages/foodpack/edit/{foodpack_id}', [MgrCustomPackagesPagesController::class, 'foodpackEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack.edit');
Route::put('/manager/custom/packages/foodpack/update/{foodpack_id}', [MgrCustomPackagesController::class, 'foodpackUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack.update');
Route::get('/manager/custom/packages/foodpack/destroy/{foodpack_id}', [MgrCustomPackagesController::class, 'foodpackDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodpack.destroy');
//FOODPACK //FOODPACK //FOODPACK //FOODPACK //FOODPACK 


//FOODCART //FOODCART //FOODCART //FOODCART //FOODCART 
//FOODPACK-ADMIN
Route::get('/admin/custom/packages/foodcart', [CustomPackagesPagesController::class, 'foodcart'])->middleware(['auth', 'verified','admin'])->name('customfoodcart');
Route::get('/admin/custom/packages/foodcart/add', [CustomPackagesPagesController::class, 'foodcartAdd'])->middleware(['auth', 'verified','admin'])->name('customfoodcartadd');
Route::post('/admin/custom/packages/foodcart/store', [CustomPackagesController::class, 'foodcartStore'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.store');
Route::get('/admin/custom/packages/foodcart/view', [CustomPackagesPagesController::class, 'foodcartView'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.view');
Route::get('/admin/custom/packages/foodcart/edit/{foodcart_id}', [CustomPackagesPagesController::class, 'foodcartEdit'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.edit');
Route::put('/admin/custom/packages/foodcart/update/{foodcart_id}', [CustomPackagesController::class, 'foodcartUpdate'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.update');
Route::get('/admin/custom/packages/foodcart/destroy/{foodcart_id}', [CustomPackagesController::class, 'foodcartDestroy'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.destroy');


//FOODPACK-MANAGER
Route::get('/manager/custom/packages/foodcart', [MgrCustomPackagesPagesController::class, 'foodcart'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart');
Route::get('/manager/custom/packages/foodcart/add', [MgrCustomPackagesPagesController::class, 'foodcartAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcartadd');
Route::post('/manager/custom/packages/foodcart/store', [MgrCustomPackagesController::class, 'foodcartStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.store');
Route::get('/manager/custom/packages/foodcart/view', [MgrCustomPackagesPagesController::class, 'foodcartView'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.view');
Route::get('/manager/custom/packages/foodcart/edit/{foodcart_id}', [MgrCustomPackagesPagesController::class, 'foodcartEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.edit');
Route::put('/manager/custom/packages/foodcart/update/{foodcart_id}', [MgrCustomPackagesController::class, 'foodcartUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.update');
Route::get('/manager/custom/packages/foodcart/destroy/{foodcart_id}', [MgrCustomPackagesController::class, 'foodcartDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.destroy');
//FOODCART //FOODCART //FOODCART //FOODCART //FOODCART 


//LECHON //LECHON //LECHON //LECHON //LECHON //LECHON 
//LECHON-ADMIN
Route::get('/admin/custom/packages/lechon', [CustomPackagesPagesController::class, 'lechon'])->middleware(['auth', 'verified','admin'])->name('customlechon');
Route::get('/admin/custom/packages/lechon/add', [CustomPackagesPagesController::class, 'lechonAdd'])->middleware(['auth', 'verified','admin'])->name('customlechonadd');
Route::post('/admin/custom/packages/lechon/store', [CustomPackagesController::class, 'lechonStore'])->middleware(['auth', 'verified','admin'])->name('customlechon.store');
Route::get('/admin/custom/packages/lechon/view', [CustomPackagesPagesController::class, 'lechonView'])->middleware(['auth', 'verified','admin'])->name('customlechon.view');
Route::get('/admin/custom/packages/lechon/edit/{lechon_id}', [CustomPackagesPagesController::class, 'lechonEdit'])->middleware(['auth', 'verified','admin'])->name('customlechon.edit');
Route::put('/admin/custom/packages/lechon/update/{lechon_id}', [CustomPackagesController::class, 'lechonUpdate'])->middleware(['auth', 'verified','admin'])->name('customlechon.update');
Route::get('/admin/custom/packages/lechon/destroy/{lechon_id}', [CustomPackagesController::class, 'lechonDestroy'])->middleware(['auth', 'verified','admin'])->name('customlechon.destroy');


//LECHON-MANAGER
Route::get('/manager/custom/packages/lechon', [MgrCustomPackagesPagesController::class, 'lechon'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon');
Route::get('/manager/custom/packages/lechon/add', [MgrCustomPackagesPagesController::class, 'lechonAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customlechonadd');
Route::post('/manager/custom/packages/lechon/store', [MgrCustomPackagesController::class, 'lechonStore'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon.store');
Route::get('/manager/custom/packages/lechon/view', [MgrCustomPackagesPagesController::class, 'lechonView'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon.view');
Route::get('/manager/custom/packages/lechon/edit/{lechon_id}', [MgrCustomPackagesPagesController::class, 'lechonEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon.edit');
Route::put('/manager/custom/packages/lechon/update/{lechon_id}', [MgrCustomPackagesController::class, 'lechonUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon.update');
Route::get('/manager/custom/packages/lechon/destroy/{lechon_id}', [MgrCustomPackagesController::class, 'lechonDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customlechon.destroy');
//LECHON //LECHON //LECHON //LECHON //LECHON //LECHON 


//CAKE //CAKE //CAKE //CAKE //CAKE //CAKE //CAKE //CAKE 
//CAKE-ADMIN
Route::get('/admin/custom/packages/cake', [CustomPackagesPagesController::class, 'cake'])->middleware(['auth', 'verified','admin'])->name('customcake');
Route::get('/admin/custom/packages/cake/add', [CustomPackagesPagesController::class, 'cakeAdd'])->middleware(['auth', 'verified','admin'])->name('customcakeadd');
Route::post('/admin/custom/packages/cake/store', [CustomPackagesController::class, 'cakeStore'])->middleware(['auth', 'verified','admin'])->name('customcake.store');
Route::get('/admin/custom/packages/cake/view', [CustomPackagesPagesController::class, 'cakeView'])->middleware(['auth', 'verified','admin'])->name('customcake.view');
Route::get('/admin/custom/packages/cake/edit/{cake_id}', [CustomPackagesPagesController::class, 'cakeEdit'])->middleware(['auth', 'verified','admin'])->name('customcake.edit');
Route::put('/admin/custom/packages/cake/update/{cake_id}', [CustomPackagesController::class, 'cakeUpdate'])->middleware(['auth', 'verified','admin'])->name('customcake.update');
Route::get('/admin/custom/packages/cake/destroy/{cake_id}', [CustomPackagesController::class, 'cakeDestroy'])->middleware(['auth', 'verified','admin'])->name('customcake.destroy');


//CAKE-MANAGER
Route::get('/manager/custom/packages/cake', [MgrCustomPackagesPagesController::class, 'cake'])->middleware(['auth', 'verified','manager'])->name('manager.customcake');
Route::get('/manager/custom/packages/cake/add', [MgrCustomPackagesPagesController::class, 'cakeAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customcakeadd');
Route::post('/manager/custom/packages/cake/store', [MgrCustomPackagesController::class, 'cakeStore'])->middleware(['auth', 'verified','manager'])->name('manager.customcake.store');
Route::get('/manager/custom/packages/cake/view', [MgrCustomPackagesPagesController::class, 'cakeView'])->middleware(['auth', 'verified','manager'])->name('manager.customcake.view');
Route::get('/manager/custom/packages/cake/edit/{cake_id}', [MgrCustomPackagesPagesController::class, 'cakeEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customcake.edit');
Route::put('/manager/custom/packages/cake/update/{cake_id}', [MgrCustomPackagesController::class, 'cakeUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customcake.update');
Route::get('/manager/custom/packages/cake/destroy/{cake_id}', [MgrCustomPackagesController::class, 'cakeDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customcake.destroy');
//CAKE //CAKE //CAKE //CAKE //CAKE //CAKE //CAKE //CAKE 


//CLOWN //CLOWN //CLOWN //CLOWN //CLOWN //CLOWN //CLOWN 
//CLOWN-ADMIN
Route::get('/admin/custom/packages/clown', [CustomPackagesPagesController::class, 'clown'])->middleware(['auth', 'verified','admin'])->name('customclown');
Route::get('/admin/custom/packages/clown/add', [CustomPackagesPagesController::class, 'clownAdd'])->middleware(['auth', 'verified','admin'])->name('customclownadd');
Route::post('/admin/custom/packages/clown/store', [CustomPackagesController::class, 'clownStore'])->middleware(['auth', 'verified','admin'])->name('customclown.store');
Route::get('/admin/custom/packages/clown/view', [CustomPackagesPagesController::class, 'clownView'])->middleware(['auth', 'verified','admin'])->name('customclown.view');
Route::get('/admin/custom/packages/clown/edit/{clown_id}', [CustomPackagesPagesController::class, 'clownEdit'])->middleware(['auth', 'verified','admin'])->name('customclown.edit');
Route::put('/admin/custom/packages/clown/update/{clown_id}', [CustomPackagesController::class, 'clownUpdate'])->middleware(['auth', 'verified','admin'])->name('customclown.update');
Route::get('/admin/custom/packages/clown/destroy/{clown_id}', [CustomPackagesController::class, 'clownDestroy'])->middleware(['auth', 'verified','admin'])->name('customclown.destroy');


//CLOWN-MANAGER
Route::get('/manager/custom/packages/clown', [MgrCustomPackagesPagesController::class, 'clown'])->middleware(['auth', 'verified','manager'])->name('manager.customclown');
Route::get('/manager/custom/packages/clown/add', [MgrCustomPackagesPagesController::class, 'clownAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customclownadd');
Route::post('/manager/custom/packages/clown/store', [MgrCustomPackagesController::class, 'clownStore'])->middleware(['auth', 'verified','manager'])->name('manager.customclown.store');
Route::get('/manager/custom/packages/clown/view', [MgrCustomPackagesPagesController::class, 'clownView'])->middleware(['auth', 'verified','manager'])->name('manager.customclown.view');
Route::get('/manager/custom/packages/clown/edit/{clown_id}', [MgrCustomPackagesPagesController::class, 'clownEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customclown.edit');
Route::put('/manager/custom/packages/clown/update/{clown_id}', [MgrCustomPackagesController::class, 'clownUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customclown.update');
Route::get('/manager/custom/packages/clown/destroy/{clown_id}', [MgrCustomPackagesController::class, 'clownDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customclown.destroy');
//CLOWN //CLOWN //CLOWN //CLOWN //CLOWN //CLOWN //CLOWN 


//SETUP //SETUP //SETUP //SETUP //SETUP //SETUP //SETUP 
//SETUP-ADMIN
Route::get('/admin/custom/packages/setup', [CustomPackagesPagesController::class, 'setup'])->middleware(['auth', 'verified','admin'])->name('customsetup');
Route::get('/admin/custom/packages/setup/add', [CustomPackagesPagesController::class, 'setupAdd'])->middleware(['auth', 'verified','admin'])->name('customsetupadd');
Route::post('/admin/custom/packages/setup/store', [CustomPackagesController::class, 'setupStore'])->middleware(['auth', 'verified','admin'])->name('customsetup.store');
Route::get('/admin/custom/packages/setup/view', [CustomPackagesPagesController::class, 'setupView'])->middleware(['auth', 'verified','admin'])->name('customsetup.view');
Route::get('/admin/custom/packages/setup/edit/{setup_id}', [CustomPackagesPagesController::class, 'setupEdit'])->middleware(['auth', 'verified','admin'])->name('customsetup.edit');
Route::put('/admin/custom/packages/setup/update/{setup_id}', [CustomPackagesController::class, 'setupUpdate'])->middleware(['auth', 'verified','admin'])->name('customsetup.update');
Route::get('/admin/custom/packages/setup/destroy/{setup_id}', [CustomPackagesController::class, 'setupDestroy'])->middleware(['auth', 'verified','admin'])->name('customsetup.destroy');


//SETUP-MANAGER
Route::get('/manager/custom/packages/setup', [MgrCustomPackagesPagesController::class, 'setup'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup');
Route::get('/manager/custom/packages/setup/add', [MgrCustomPackagesPagesController::class, 'setupAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customsetupadd');
Route::post('/manager/custom/packages/setup/store', [MgrCustomPackagesController::class, 'setupStore'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup.store');
Route::get('/manager/custom/packages/setup/view', [MgrCustomPackagesPagesController::class, 'setupView'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup.view');
Route::get('/manager/custom/packages/setup/edit/{setup_id}', [MgrCustomPackagesPagesController::class, 'setupEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup.edit');
Route::put('/manager/custom/packages/setup/update/{setup_id}', [MgrCustomPackagesController::class, 'setupUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup.update');
Route::get('/manager/custom/packages/setup/destroy/{setup_id}', [MgrCustomPackagesController::class, 'setupDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customsetup.destroy');
//SETUP //SETUP //SETUP //SETUP //SETUP //SETUP //SETUP


//FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT 
//FACEPAINT-ADMIN
Route::get('/admin/custom/packages/facepaint', [CustomPackagesPagesController::class, 'facepaint'])->middleware(['auth', 'verified','admin'])->name('customfacepaint');
Route::get('/admin/custom/packages/facepaint/add', [CustomPackagesPagesController::class, 'facepaintAdd'])->middleware(['auth', 'verified','admin'])->name('customfacepaintadd');
Route::post('/admin/custom/packages/facepaint/store', [CustomPackagesController::class, 'facepaintStore'])->middleware(['auth', 'verified','admin'])->name('customfacepaint.store');
Route::get('/admin/custom/packages/facepaint/view', [CustomPackagesPagesController::class, 'facepaintView'])->middleware(['auth', 'verified','admin'])->name('customfacepaint.view');
Route::get('/admin/custom/packages/facepaint/edit/{facepaint_id}', [CustomPackagesPagesController::class, 'facepaintEdit'])->middleware(['auth', 'verified','admin'])->name('customfacepaint.edit');
Route::put('/admin/custom/packages/facepaint/update/{facepaint_id}', [CustomPackagesController::class, 'facepaintUpdate'])->middleware(['auth', 'verified','admin'])->name('customfacepaint.update');
Route::get('/admin/custom/packages/facepaint/destroy/{facepaint_id}', [CustomPackagesController::class, 'facepaintDestroy'])->middleware(['auth', 'verified','admin'])->name('customfacepaint.destroy');


//FACEPAINT-MANAGER
Route::get('/manager/custom/packages/facepaint', [MgrCustomPackagesPagesController::class, 'facepaint'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint');
Route::get('/manager/custom/packages/facepaint/add', [MgrCustomPackagesPagesController::class, 'facepaintAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaintadd');
Route::post('/manager/custom/packages/facepaint/store', [MgrCustomPackagesController::class, 'facepaintStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint.store');
Route::get('/manager/custom/packages/facepaint/view', [MgrCustomPackagesPagesController::class, 'facepaintView'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint.view');
Route::get('/manager/custom/packages/facepaint/edit/{facepaint_id}', [MgrCustomPackagesPagesController::class, 'facepaintEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint.edit');
Route::put('/manager/custom/packages/facepaint/update/{facepaint_id}', [MgrCustomPackagesController::class, 'facepaintUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint.update');
Route::get('/manager/custom/packages/facepaint/destroy/{facepaint_id}', [MgrCustomPackagesController::class, 'facepaintDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfacepaint.destroy');
//FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT



// CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE 




//PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES 
Route::resource('package', PackagesController::class);

//ADMIN PACKAGES
Route::get('/admin/packages/add', [PackagesPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpackage');
Route::post('/admin/custom/packages/add', [PackagesController::class, 'custom'])->middleware(['auth', 'verified','admin'])->name('addcustom');
Route::get('/admin/packages/view', [PackagesPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpackage');
Route::get('/admin/packages/customize', [PackagesPagesController::class, 'customize'])->middleware(['auth', 'verified','admin'])->name('customizepackage');
Route::get('/admin/packages/new/customize', [PackagesPagesController::class, 'newcustomize'])->middleware(['auth', 'verified','admin'])->name('newcustomizepackage');

// Route::get('/admin/packages/eye', [PackagesPagesController::class, 'eye'])->middleware(['auth', 'verified','admin'])->name('eyepackage');
// Route::get('/admin/packages/show', [PackagesController::class, 'show'])->middleware(['auth', 'verified','admin'])->name('showpackage');

Route::get('/package/{package_id}/show', [PackagesController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('showpackage');
Route::get('/package/{package_id}/edit', [PackagesController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('editpackage');
Route::post('/package/{package_id}', [PackagesController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('updatepackage');
Route::get('/package/{package_id}/destroy', [PackagesController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('destroypackage');
Route::get('/package/{package_id}/destroycustom', [CustomPackagesController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('destroycustom');

//MANAGER PACKAGES
Route::get('/manager/packages/add', [PackagesPagesController::class, 'manageradd'])->middleware(['auth', 'verified','manager'])->name('manageraddpackage');
Route::get('/manager/packages/view', [PackagesPagesController::class, 'managerview'])->middleware(['auth', 'verified','manager'])->name('managerviewpackage');
Route::get('/manager/packages/customize', [PackagesPagesController::class, 'managercustomize'])->middleware(['auth', 'verified','manager'])->name('managercustomizepackage');
Route::post('/manager/custom/packages/add', [PackagesController::class, 'managercustom'])->middleware(['auth', 'verified','manager'])->name('manageraddcustom');
Route::get('/manager/packages/new/customize', [PackagesPagesController::class, 'managernewcustomize'])->middleware(['auth', 'verified','manager'])->name('manager.newcustomizepackage');


Route::get('/manager/package/{package_id}/show', [PackagesController::class, 'managershow'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managershowpackage');
Route::get('/manager/package/{package_id}/edit', [PackagesController::class, 'manageredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managereditpackage');
Route::put('/manager/package/{package_id}', [PackagesController::class, 'managerupdate'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerupdatepackage');
Route::get('/manager/package/{package_id}/destroy', [PackagesController::class, 'managerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerdestroypackage');
//PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES 



// FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS 
Route::resource('faqs', FaqsController::class);
//OWNER
Route::get('/owner/faqs', [FaqsPagesController::class, 'ownerfaqs'])->middleware(['auth', 'verified','owner'])->name('ownerfaqs');
Route::get('/owner/faqs/view', [FaqsPagesController::class, 'ownerview'])->middleware(['auth', 'verified','owner'])->name('ownerviewfaqs');
Route::get('/owner/faqs/add', [FaqsPagesController::class, 'owneradd'])->middleware(['auth', 'verified','owner'])->name('owneraddfaqs');

Route::get('/owner/faqs/{faq_id}/edit', [FaqsController::class, 'owneredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownereditfaqs');
Route::post('/owner/faqs/{faq_id}', [FaqsController::class, 'ownerupdate'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownerupdatefaqs');
Route::get('/owner/faqs/{faq_id}/destroy', [FaqsController::class, 'ownerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownerdestroyfaqs');


//MANAGER 
Route::get('/manager/faqs', [FaqsPagesController::class, 'managerfaqs'])->middleware(['auth', 'verified','manager'])->name('managerfaqs');
Route::get('/manager/faqs/add', [FaqsPagesController::class, 'manageradd'])->middleware(['auth', 'verified','manager'])->name('manageraddfaqs');
Route::get('/manager/faqs/view', [FaqsPagesController::class, 'managerview'])->middleware(['auth', 'verified','manager'])->name('managerviewfaqs');

Route::get('/manager/faqs/{faq_id}/edit', [FaqsController::class, 'manageredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managereditfaqs');
Route::post('/manager/faqs/{faq_id}', [FaqsController::class, 'managerupdate'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerupdatefaqs');
Route::get('/manager/faqs/{faq_id}/destroy', [FaqsController::class, 'managerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerdestroyfaqs');


//ADMIN 
Route::get('/admin/faqs', [FaqsPagesController::class, 'faqs'])->middleware(['auth', 'verified','admin'])->name('adminfaqs');
Route::get('/admin/faqs/view', [FaqsPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewfaqs');
Route::get('/admin/faqs/add', [FaqsPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addfaqs');

Route::get('/faqs/{faq_id}/edit', [FaqsController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('editfaqs');
Route::post('/faqs/{faq_id}', [FaqsController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('updatefaqs');
Route::get('/faqs/{faq_id}/destroy', [FaqsController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('destroyfaqs');
// FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS // FAQS 



// POSTING// POSTING// POSTING// POSTING// POSTING // POSTING// POSTING// POSTING// POSTING// POSTING
Route::resource('/post', PostController::class);
//OWNER
Route::get('/owner/post', [PostPagesController::class, 'ownerpost'])->middleware(['auth', 'verified','owner'])->name('ownerpost');
Route::get('/owner/post/add', [PostPagesController::class, 'owneradd'])->middleware(['auth', 'verified','owner'])->name('owneraddpost');
Route::get('/owner/post/view', [PostPagesController::class, 'ownerview'])->middleware(['auth', 'verified','owner'])->name('ownerviewpost');

Route::get('/owner/post/{post_id}/edit', [PostController::class, 'owneredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownereditpost');
Route::get('/post/{post_id}/ownerdestroy', [PostController::class, 'ownerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownerdestroypost');

//MANAGER
Route::get('/manager/post', [PostPagesController::class, 'managerpost'])->middleware(['auth', 'verified','manager'])->name('managerpost');
Route::get('/manager/post/add', [PostPagesController::class, 'manageradd'])->middleware(['auth', 'verified','manager'])->name('manageraddpost');
Route::get('/manager/post/view', [PostPagesController::class, 'managerview'])->middleware(['auth', 'verified','manager'])->name('managerviewpost');

Route::get('/manager/post/{post_id}/edit', [PostController::class, 'managerredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managereditpost');
Route::get('/manager/post/{post_id}/destroy', [PostController::class, 'managerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerdestroypost');

//ADMIN
Route::get('/admin/post', [PostPagesController::class, 'post'])->middleware(['auth', 'verified','admin'])->name('adminpost');
Route::get('/admin/post/add', [PostPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpost');
Route::get('/admin/post/view', [PostPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpost');

Route::get('/post/{post_id}/edit', [PostController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('editpost');
Route::post('/post/{post_id}', [PostController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin','owner','manager')
    ->name('updatepost');
Route::get('/post/{post_id}/destroy', [PostController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('destroypost');

// POSTING// POSTING// POSTING// POSTING// POSTING // POSTING// POSTING// POSTING// POSTING// POSTING


//APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT 
Route::resource('/appointment', AppointmentController::class);

Route::post('/appointment/meeting', [AppointmentController::class, 'meeting'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('appointment.meeting');



// ACCEPT // ACCEPT // ACCEPT // ACCEPT // ACCEPT // ACCEPT 
Route::put('/appointment/{appointment_id}/accept', [AppointmentController::class, 'accept'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.accept');

Route::put('/appointment/manager/{appointment_id}/accept', [ManagerAppointmensController::class, 'accept'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.accept');
// ACCEPT // ACCEPT // ACCEPT // ACCEPT // ACCEPT // ACCEPT 



//DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE 
Route::put('/appointment/{appointment_id}/done', [AppointmentController::class, 'done'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.done');

Route::put('/appointment/manager/{appointment_id}/done', [ManagerAppointmensController::class, 'done'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.done');
//DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE //DONE 



//REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK 
Route::put('/appointment/{appointment_id}/rebook', [AppointmentController::class, 'rebook'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.rebook');

Route::put('/appointment/manager/{appointment_id}/rebook', [ManagerAppointmensController::class, 'rebook'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.rebook');
//REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK //REBOOK 



//CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT 
Route::put('/appointment/{appointment_id}/cancel', [AppointmentController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.cancel');

Route::put('/appointment/manager/{appointment_id}/cancel', [ManagerAppointmensController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.cancel');
//CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT //CANCEL-EVENT 



//CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING 
Route::put('/appointment/{appointment_id}/cancel/meeting', [AppointmentController::class, 'cancelmeeting'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.cancel.meeting');

Route::put('/appointment/manager/{appointment_id}/cancel/meeting', [ManagerAppointmensController::class, 'cancelmeeting'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.cancel.meeting');
//CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING 



//DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT 
Route::get('/appointment/{appointment_id}/details-edit', [AppointmentController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('details.edit');

Route::get('/appointment/manager/{appointment_id}/details-edit', [ManagerAppointmensController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.details.edit');
//DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT 



// DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE 
Route::put('/appointment/{appointment_id}/save', [AppointmentController::class, 'save'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.save');

Route::put('/appointment/manager/{appointment_id}/save', [ManagerAppointmensController::class, 'save'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.save');
// DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE 

//APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT //APPOINTMENT 




//DATE BLOCKING UNBLOCKING //DATE BLOCKING UNBLOCKING //DATE BLOCKING UNBLOCKING
//ADMIN
Route::post('/admin/date/block', [AppointmentController::class, 'block'])->middleware(['auth', 'verified','admin'])->name('admin.block');
Route::post('/admin/date/unblock', [AppointmentController::class, 'unblock'])->middleware(['auth', 'verified','admin'])->name('admin.unblock');
Route::post('/admin/app/date/block', [AppointmentController::class, 'appblock'])->middleware(['auth', 'verified','admin'])->name('admin.appblock');
Route::post('/admin/app/date/unblock', [AppointmentController::class, 'appunblock'])->middleware(['auth', 'verified','admin'])->name('admin.appunblock');

//OWNER
Route::post('/owner/date/block', [OwnerAppointmentsController::class, 'block'])->middleware(['auth', 'verified','owner'])->name('owner.block');
Route::post('/owner/date/unblock', [OwnerAppointmentsController::class, 'unblock'])->middleware(['auth', 'verified','owner'])->name('owner.unblock');

//MANAGER
Route::post('/manager/date/block', [ManagerAppointmensController::class, 'block'])->middleware(['auth', 'verified','manager'])->name('manager.block');
Route::post('/manager/date/unblock', [ManagerAppointmensController::class, 'unblock'])->middleware(['auth', 'verified','manager'])->name('manager.unblock');
Route::post('/manager/app/date/block', [AppointmentController::class, 'appblock'])->middleware(['auth', 'verified','manager'])->name('manager.appblock');
Route::post('/manager/app/date/unblock', [AppointmentController::class, 'appunblock'])->middleware(['auth', 'verified','manager'])->name('manager.appunblock');

//DATE BLOCKING UNBLOCKING //DATE BLOCKING UNBLOCKING //DATE BLOCKING UNBLOCKING


//USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT 
Route::get('/admin/{id}/edit', [UsertypeController::class, 'edit'])
    ->middleware(['auth', 'verified','admin'])
    ->name('usertype-edit');
Route::put('/admin/{id}', [UsertypeController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('usertype-update');
//USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT //USERTYPE EDIT 


//MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER 
Route::get('/managerdashboard', [ManagerController::class, 'managerdashboard'])->middleware(['auth', 'verified','manager'])->name('managerdashboard');
Route::get('/managerappointments', [ManagerController::class, 'managerappointments'])->middleware(['auth', 'verified','manager'])->name('managerappointments');
Route::get('/managerpackages', [ManagerController::class, 'managerpackages'])->middleware(['auth', 'verified','manager'])->name('managerpackages');
Route::get('/managerreviews', [ManagerController::class, 'managerreviews'])->middleware(['auth', 'verified','manager'])->name('managerreviews');
Route::get('/managerchat', [ManagerController::class, 'managerchat'])->middleware(['auth', 'verified','manager'])->name('managerchat');
Route::get('/managerusers', [ManagerController::class, 'managerusers'])->middleware(['auth', 'verified','manager'])->name('managerusers');

//MANAGER CALENDAR //MANAGER CALENDAR //MANAGER CALENDAR //MANAGER CALENDAR 
Route::get('/manager/calendar/data', [ManagerAppointmentsPagesController::class, 'calendar'])->middleware(['auth', 'verified','manager'])->name('managercalendar');
Route::get('/manager/calendar', [ManagerAppointmentsPagesController::class, 'calendarView'])->middleware(['auth', 'verified','manager'])->name('managercalendarView');

Route::get('/manager/meetingCalendar', [ManagerAppointmentsPagesController::class, 'meetingCalendarView'])->middleware(['auth', 'verified','manager'])->name('managermeetingCalendarView');
Route::get('/manager/meetingCalendar/data', [ManagerAppointmentsPagesController::class, 'meetingCalendar'])->middleware(['auth', 'verified','manager'])->name('managermeetingCalendar');

//MANAGER CALENDAR //MANAGER CALENDAR //MANAGER CALENDAR //MANAGER CALENDAR 

Route::get('/manager/pending', [ManagerAppointmentsPagesController::class, 'pending'])->middleware(['auth', 'verified','manager'])->name('manager.pending');
Route::get('/manager/pending/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'pendingView'])->middleware(['auth', 'verified','manager'])->name('manager.pendingView');

Route::get('/manager/booked', [ManagerAppointmentsPagesController::class, 'booked'])->middleware(['auth', 'verified','manager'])->name('manager.booked');
Route::get('/manager/booked/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'bookedView'])->middleware(['auth', 'verified','manager'])->name('manager.bookedView');

Route::get('/manager/cancelled', [ManagerAppointmentsPagesController::class, 'cancelled'])->middleware(['auth', 'verified','manager'])->name('manager.cancelled');
Route::get('/manager/cancelled/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'cancelledView'])->middleware(['auth', 'verified','manager'])->name('manager.cancelledView');

Route::get('/manager/done', [ManagerAppointmentsPagesController::class, 'done'])->middleware(['auth', 'verified','manager'])->name('manager.done');
Route::get('/manager/done/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'doneView'])->middleware(['auth', 'verified','manager'])->name('manager.doneView');



//MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS 
Route::get('/manager/notifications', [ManagerController::class, 'notifications'])->middleware(['auth', 'verified','manager'])->name('manager.notifications');
Route::get('/fetch-manager-unread-count', [AppointmentController::class, 'fetchManagerUnreadCount'])->middleware(['auth', 'verified','manager'])->name('fetch.manager.unread.count');
Route::get('/fetch-manager-unopened-messages-count', [AppointmentController::class, 'fetchManagerUnopenedMessageCount'])->middleware(['auth', 'verified','manager'])->name('fetch.manager.unopened.message.count');

//MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS //MANAGER NTOIFICATIONS 




//MANAGER APPOINTMENTS //MANAGER APPOINTMENTS //MANAGER APPOINTMENTS //MANAGER APPOINTMENTS 
Route::get('/manager/direct', [ManagerAppointmentsPagesController::class, 'direct'])->middleware(['auth', 'verified','manager'])->name('managerdirect');
Route::post('/manager/direct/save', [ManagerAppointmensController::class, 'directsave'])->middleware(['auth', 'verified','manager'])->name('managerdirectsave');

//MANAGER APPOINTMENTS //MANAGER APPOINTMENTS //MANAGER APPOINTMENTS //MANAGER APPOINTMENTS 



//MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW 
Route::get('/manager/reviews/pending', [ReviewController::class, 'managerpending'])->middleware(['auth', 'verified','manager'])->name('managerreviewpending');
Route::get('/manager/reviews/approved', [ReviewController::class, 'managerapproved'])->middleware(['auth', 'verified','manager'])->name('managerreviewapproved');
Route::put('/manager/reviews/pending/to/approved/{review_id}', [ReviewController::class, 'managerstatusApproved'])->middleware(['auth', 'verified','manager'])->name('managerreviews.approve');
Route::put('/manager/reviews/approved/to/pending/{review_id}', [ReviewController::class, 'managerstatusPending'])->middleware(['auth', 'verified','manager'])->name('managerreviews.pending');
//MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW 

//MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER 


//OWNER
Route::get('/ownerdashboard', [OwnerController::class, 'ownerdashboard'])->middleware(['auth', 'verified','owner'])->name('ownerdashboard');
// Route::get('/ownercalendar', [OwnerController::class, 'ownercalendar'])->middleware(['auth', 'verified','owner'])->name('ownercalendar');

Route::get('/owner/calendar/data', [OwnerAppointmentsPagesController::class, 'calendar'])->middleware(['auth', 'verified','owner'])->name('ownercalendar');
Route::get('/owner/calendar', [OwnerAppointmentsPagesController::class, 'calendarView'])->middleware(['auth', 'verified','owner'])->name('ownercalendarView');

Route::get('/ownerbooking', [OwnerController::class, 'ownerbooking'])->middleware(['auth', 'verified','owner'])->name('ownerbooking');
Route::get('/ownerchat', [OwnerController::class, 'ownerchat'])->middleware(['auth', 'verified','owner'])->name('ownerchat');



//OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS 
Route::get('/fetch-owner-unopened-messages-count', [AppointmentController::class, 'fetchOwnerUnopenedMessageCount'])->middleware(['auth', 'verified','owner'])->name('fetch.owner.unopened.message.count');
Route::get('/fetch-owner-unread-count', [AppointmentController::class, 'fetchOwnerUnreadCount'])->middleware(['auth', 'verified','owner'])->name('fetch.owner.unread.count');
Route::get('/owner/notifications', [OwnerController::class, 'notifications'])->middleware(['auth', 'verified','owner'])->name('owner.notifications');

//OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS 



//CLIENT
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified','user'])->name('dashboard');
Route::get('/chat', [UserController::class, 'chat'])->middleware(['auth', 'verified','user'])->name('chat');



Route::get('/fetch-unread-messages-count', [AppointmentController::class, 'fetchUserUnreadMessageCount'])->middleware(['auth', 'verified','user'])->name('fetch.user.unread.message.count');
Route::get('/notifications', [UserController::class, 'notifications'])->middleware(['auth', 'verified','user'])->name('notifications');
Route::get('/fetch-unread-count', [AppointmentController::class, 'fetchUnreadCount'])->middleware(['auth', 'verified','user'])->name('fetch.unread.count');



Route::get('/aboutus', [UserController::class, 'aboutus'])->middleware(['auth', 'verified','user'])->name('aboutus');
Route::get('/faqs', [UserController::class, 'faqs'])->middleware(['auth', 'verified','user'])->name('faqs');
Route::get('/reviews', [UserController::class, 'reviews'])->middleware(['auth', 'verified','user'])->name('reviews');
Route::get('/makereviews/{appointment_id}', [UserController::class, 'makereviews'])->middleware(['auth', 'verified','user'])->name('makereviews');
Route::get('/myevent', [UserController::class, 'myevent'])->middleware(['auth', 'verified','user'])->name('myevent');
Route::get('/mybooked', [UserController::class, 'mybooked'])->middleware(['auth', 'verified','user'])->name('mybooked');
Route::get('/mydone', [UserController::class, 'mydone'])->middleware(['auth', 'verified','user'])->name('mydone');
Route::get('/myrequest', [UserController::class, 'myrequest'])->middleware(['auth', 'verified','user'])->name('myrequest');
Route::get('/events/data', [UserController::class, 'events'])->middleware(['auth', 'verified','user'])->name('events');
Route::get('/events', [UserController::class, 'eventsView'])->middleware(['auth', 'verified','user'])->name('eventsView');
Route::get('/book-form', [UserController::class, 'book'])->middleware(['auth', 'verified','user'])->name('book-form');
Route::get('/form', [UserController::class, 'form'])->middleware(['auth', 'verified','user'])->name('form');
Route::get('/meeting-form', [UserController::class, 'meetingform'])->middleware(['auth', 'verified','user'])->name('meetingform');
Route::get('/idverify', [UserController::class, 'idverify'])->middleware(['auth', 'verified','user'])->name('idverify');
Route::get('/personal/{id}', [UserController::class, 'personal'])->middleware(['auth', 'verified','user'])->name('personal');
Route::patch('/update-personal/{id}', [UserController::class, 'update'])->middleware(['auth', 'verified','user'])->name('update-personal');

//REVIEWS

Route::post('/reviews/store', [ReviewController::class, 'store'])
    ->middleware(['auth', 'verified','user'])
    ->name('reviews.store');



//VERIFY
Route::get('/verify/{id}/edit', [VerifyIdController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('verify.edit');

Route::get('/manager/verify/{id}/edit', [VerifyIdController::class, 'manageredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerverify.edit');
    
Route::put('/verify/{id}', [VerifyIdController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('verify.update');

Route::put('/manager/verify/{id}', [VerifyIdController::class, 'managerupdate'])
    ->middleware(['auth', 'verified','manager'])
    ->name('managerverify.update');


Route::get('/unread-message-count', [ChatController::class, 'fetchUnreadMessageCount'])->name('fetchUnreadMessageCount');


require __DIR__.'/auth.php';
