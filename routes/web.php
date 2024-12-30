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
use App\Http\Controllers\SampleController;
use App\Http\Controllers\OwnerCustomPackagesController;
use App\Http\Controllers\OwnerCustomPackagesPagesController;
use App\Http\Controllers\NewSampleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DishesController;
use App\Http\Controllers\ReminderController;

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
Route::get('/unread-message-count', [ChatController::class, 'fetchUnreadMessageCount'])->name('fetchUnreadMessageCount');

//REMINDER //REMINDER //REMINDER //REMINDER //REMINDER //REMINDER //REMINDER 
Route::post('/reminder/booked/{appointment_id}', [ReminderController::class, 'booked'])
    ->name('reminder.booked');
//REMINDER //REMINDER //REMINDER //REMINDER //REMINDER //REMINDER //REMINDER 

//PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF 
//REPORTS //REPORTS //REPORTS //REPORTS //REPORTS //REPORTS //REPORTS 
Route::post('/reports/booked-month', [ReportController::class, 'bookedMonth'])
    ->name('reports.booked.month');

Route::post('/reports/done-month', [ReportController::class, 'doneMonth'])
    ->name('reports.done.month');

Route::post('/reports/pending-month', [ReportController::class, 'pendingMonth'])
    ->name('reports.pending.month');

Route::post('/reports/cancelled-month', [ReportController::class, 'cancelledMonth'])
    ->name('reports.cancelled.month');
//REPORTS //REPORTS //REPORTS //REPORTS //REPORTS //REPORTS //REPORTS 

//DETAILS //DETAILS //DETAILS //DETAILS //DETAILS //DETAILS //DETAILS 
Route::post('/reports/booked-details/{appointment_id}', [ReportController::class, 'bookedDetails'])
    ->name('reports.booked.details');

Route::post('/reports/done-details/{appointment_id}', [ReportController::class, 'doneDetails'])
    ->name('reports.done.details');

Route::post('/reports/pending-details/{appointment_id}', [ReportController::class, 'pendingDetails'])
    ->name('reports.pending.details');

Route::post('/reports/cancelled-details/{appointment_id}', [ReportController::class, 'cancelledDetails'])
    ->name('reports.cancelled.details');
//DETAILS //DETAILS //DETAILS //DETAILS //DETAILS //DETAILS //DETAILS 

//CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT
Route::post('/contract/{appointment_id}', [ReportController::class, 'contract'])
    ->name('contract');
//CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT
//PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF //PDF 

//ADMIN
Route::get('/admin/chat', [AdminController::class, 'chat'])->middleware(['auth', 'verified','admin'])->name('admin.chat');
Route::get('/others', [AdminController::class, 'others'])->middleware(['auth', 'verified','admin'])->name('others');
Route::get('/admindashboard', [AdminController::class, 'admindashboard'])->middleware(['auth', 'verified','admin'])->name('admindashboard');
Route::get('/appointments', [AdminController::class, 'appointments'])->middleware(['auth', 'verified','admin'])->name('adminappointments');
Route::get('/users', [UsertypeController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('adminusers');
Route::get('/adminreviews', [AdminController::class, 'adminreviews'])->middleware(['auth', 'verified','admin'])->name('adminratings');
Route::get('/packages', [AdminController::class, 'packages'])->middleware(['auth', 'verified','admin'])->name('adminpackages');
Route::get('/logs', [AdminController::class, 'logs'])->middleware(['auth', 'verified','admin'])->name('adminlogs');
Route::get('/reports', [AdminController::class, 'reports'])->middleware(['auth', 'verified','admin'])->name('adminreports');
Route::get('/admin/profile', [AdminController::class, 'profile'])->middleware(['auth', 'verified','admin'])->name('profile');

//ADMIN APPOINTMENT
Route::get('/admin/calendar/data', [AppointmentsPagesController::class, 'calendar'])->middleware(['auth', 'verified','admin'])->name('calendar');
Route::get('/admin/calendar', [AppointmentsPagesController::class, 'calendarView'])->middleware(['auth', 'verified','admin'])->name('calendarView');

Route::get('/admin/meetingCalendar', [AppointmentsPagesController::class, 'meetingCalendarView'])->middleware(['auth', 'verified','admin'])->name('meetingCalendarView');
Route::get('/admin/meetingCalendar/data', [AppointmentsPagesController::class, 'meetingCalendar'])->middleware(['auth', 'verified','admin'])->name('meetingCalendar');

Route::get('/admin/archived/{appointment_id}/view', [AppointmentsPagesController::class, 'archivedView'])->middleware(['auth', 'verified','admin'])->name('archivedView');
Route::get('/admin/archived', [AppointmentsPagesController::class, 'archived'])->middleware(['auth', 'verified','admin'])->name('archived');
Route::get('/admin/booked', [AppointmentsPagesController::class, 'booked'])->middleware(['auth', 'verified','admin'])->name('booked');
Route::get('/admin/booked/{appointment_id}/view', [AppointmentsPagesController::class, 'bookedView'])->middleware(['auth', 'verified','admin'])->name('bookedView');
Route::get('/admin/pending', [AppointmentsPagesController::class, 'pending'])->middleware(['auth', 'verified','admin'])->name('pending');
Route::get('/admin/pending/{appointment_id}/view', [AppointmentsPagesController::class, 'pendingView'])->middleware(['auth', 'verified','admin'])->name('pendingView');
Route::get('/admin/cancelled/{appointment_id}/view', [AppointmentsPagesController::class, 'cancelledView'])->middleware(['auth', 'verified','admin'])->name('cancelledView');
Route::get('/admin/cancelled', [AppointmentsPagesController::class, 'cancelled'])->middleware(['auth', 'verified','admin'])->name('cancelled');
Route::get('/admin/done/{appointment_id}/view', [AppointmentsPagesController::class, 'doneView'])->middleware(['auth', 'verified','admin'])->name('doneView');
Route::get('/admin/done', [AppointmentsPagesController::class, 'done'])->middleware(['auth', 'verified','admin'])->name('done');
Route::get('/admin/approved', [AppointmentsPagesController::class, 'approved'])->middleware(['auth', 'verified','admin'])->name('approved');
Route::get('/admin/returned', [AppointmentsPagesController::class, 'returned'])->middleware(['auth', 'verified','admin'])->name('returned');
Route::get('/admin/direct', [AppointmentsPagesController::class, 'direct'])->middleware(['auth', 'verified','admin'])->name('direct');
Route::post('/admin/direct/save', [AppointmentController::class, 'directsave'])->middleware(['auth', 'verified','admin'])->name('directsave');
Route::get('/admin/cancelled/meeting', [AppointmentsPagesController::class, 'cancelledMeeting'])->middleware(['auth', 'verified','admin'])->name('cancelledMeeting');
Route::get('/admin/cancelled/meeting/{appointment_id}/view', [AppointmentsPagesController::class, 'cancelledmeetingView'])->middleware(['auth', 'verified','admin'])->name('cancelledMeetingView');


//REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS 
Route::get('/admin/reviews/pending', [ReviewController::class, 'pending'])->middleware(['auth', 'verified','admin'])->name('reviewpending');
Route::get('/admin/reviews/approved', [ReviewController::class, 'approved'])->middleware(['auth', 'verified','admin'])->name('reviewapproved');
Route::put('/admin/reviews/pending/to/approved/{review_id}', [ReviewController::class, 'statusApproved'])->middleware(['auth', 'verified','admin'])->name('reviews.approve');
Route::put('/admin/reviews/approved/to/pending/{review_id}', [ReviewController::class, 'statusPending'])->middleware(['auth', 'verified','admin'])->name('reviews.pending');
Route::put('/admin/reviews/response{review_id}', [ReviewController::class, 'response'])->middleware(['auth', 'verified','admin'])->name('reviews.response');

//REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS //REVIEWS 


//NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS 
Route::get('/fetch-admin-unread-count', [AppointmentController::class, 'fetchAdminUnreadCount'])->middleware(['auth', 'verified','admin'])->name('fetch.admin.unread.count');
Route::get('/admin/notifications', [AdminController::class, 'notifications'])->middleware(['auth', 'verified','admin'])->name('admin.notifications');
Route::get('/fetch-unopened-messages-count', [AppointmentController::class, 'fetchAdminUnopenedMessageCount'])->middleware(['auth', 'verified','admin'])->name('fetch.admin.unopened.message.count');

//NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS //NOTIFICATIONS 



// CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE 

// Route::resource('newpackage', CustomPackagesController::class);
Route::get('/admin/new/custom/packages/add', [CustomPackagesPagesController::class, 'customadd'])->middleware(['auth', 'verified','admin'])->name('custom.add');
Route::get('/admin/new/custom/packages/add/direct/{appointment_id}', [CustomPackagesPagesController::class, 'customaddDirect'])->middleware(['auth', 'verified','admin'])->name('custom.add.direct');
Route::post('/admin/new/custom/packages/store', [CustomPackagesController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('newcustom.package.store');
Route::post('/admin/new/custom/packages/store/direct/{appointment_id}', [CustomPackagesController::class, 'storeDirect'])->middleware(['auth', 'verified','admin'])->name('newcustom.package.store.direct');

Route::get('/manager/new/custom/packages/add', [MgrCustomPackagesPagesController::class, 'customadd'])->middleware(['auth', 'verified','manager'])->name('manager.custom.add');
Route::get('/manager/new/custom/packages/add/direct/{appointment_id}', [MgrCustomPackagesPagesController::class, 'customaddDirect'])->middleware(['auth', 'verified','manager'])->name('manager.custom.add.direct');
Route::post('/manager/new/custom/packages/store', [MgrCustomPackagesController::class, 'store'])->middleware(['auth', 'verified','manager'])->name('manager.newcustom.package.store');
Route::post('/manager/new/custom/packages/store/direct/{appointment_id}', [MgrCustomPackagesController::class, 'storeDirect'])->middleware(['auth', 'verified','manager'])->name('manager.newcustom.package.store.direct');

Route::get('/owner/new/custom/packages/add', [OwnerCustomPackagesPagesController::class, 'customadd'])->middleware(['auth', 'verified','owner'])->name('owner.custom.add');
Route::post('/owner/new/custom/packages/store', [OwnerCustomPackagesController::class, 'store'])->middleware(['auth', 'verified','owner'])->name('owner.newcustom.package.store');

//FOOD //FOOD //FOOD //FOOD //FOOD 
//FOOD-ADMIN
Route::get('/admin/custom/packages/food', [CustomPackagesPagesController::class, 'food'])->middleware(['auth', 'verified','admin'])->name('customfood');
Route::get('/admin/custom/packages/food/add', [CustomPackagesPagesController::class, 'foodAdd'])->middleware(['auth', 'verified','admin'])->name('customfoodadd');
Route::post('/admin/custom/packages/food/store', [CustomPackagesController::class, 'foodStore'])->middleware(['auth', 'verified','admin'])->name('customfood.store');
Route::get('/admin/custom/packages/food/view', [CustomPackagesPagesController::class, 'foodView'])->middleware(['auth', 'verified','admin'])->name('customfood.view');
Route::get('/admin/custom/packages/food/edit/{food_id}', [CustomPackagesPagesController::class, 'foodEdit'])->middleware(['auth', 'verified','admin'])->name('customfood.edit');
Route::put('/admin/custom/packages/food/update/{food_id}', [CustomPackagesController::class, 'foodUpdate'])->middleware(['auth', 'verified','admin'])->name('customfood.update');
Route::get('/admin/custom/packages/food/destroy/{food_id}', [CustomPackagesController::class, 'foodDestroy'])->middleware(['auth', 'verified','admin'])->name('customfood.destroy');

Route::get('/admin/custom/packages/beef', [CustomPackagesPagesController::class, 'beef'])->middleware(['auth', 'verified','admin'])->name('custombeef');
Route::get('/admin/custom/packages/beef/add', [CustomPackagesPagesController::class, 'beefAdd'])->middleware(['auth', 'verified','admin'])->name('custombeefadd');
Route::post('/admin/custom/packages/beef/store', [CustomPackagesController::class, 'beefStore'])->middleware(['auth', 'verified','admin'])->name('custombeef.store');
Route::get('/admin/custom/packages/beef/view', [CustomPackagesPagesController::class, 'beefView'])->middleware(['auth', 'verified','admin'])->name('custombeef.view');
Route::get('/admin/custom/packages/beef/edit/{beef_id}', [CustomPackagesPagesController::class, 'beefEdit'])->middleware(['auth', 'verified','admin'])->name('custombeef.edit');
Route::put('/admin/custom/packages/beef/update/{beef_id}', [CustomPackagesController::class, 'beefUpdate'])->middleware(['auth', 'verified','admin'])->name('custombeef.update');
Route::get('/admin/custom/packages/beef/destroy/{beef_id}', [CustomPackagesController::class, 'beefDestroy'])->middleware(['auth', 'verified','admin'])->name('custombeef.destroy');

Route::get('/admin/custom/packages/pork', [CustomPackagesPagesController::class, 'pork'])->middleware(['auth', 'verified','admin'])->name('custompork');
Route::get('/admin/custom/packages/pork/add', [CustomPackagesPagesController::class, 'porkAdd'])->middleware(['auth', 'verified','admin'])->name('customporkadd');
Route::post('/admin/custom/packages/pork/store', [CustomPackagesController::class, 'porkStore'])->middleware(['auth', 'verified','admin'])->name('custompork.store');
Route::get('/admin/custom/packages/pork/view', [CustomPackagesPagesController::class, 'porkView'])->middleware(['auth', 'verified','admin'])->name('custompork.view');
Route::get('/admin/custom/packages/pork/edit/{pork_id}', [CustomPackagesPagesController::class, 'porkEdit'])->middleware(['auth', 'verified','admin'])->name('custompork.edit');
Route::put('/admin/custom/packages/pork/update/{pork_id}', [CustomPackagesController::class, 'porkUpdate'])->middleware(['auth', 'verified','admin'])->name('custompork.update');
Route::get('/admin/custom/packages/pork/destroy/{pork_id}', [CustomPackagesController::class, 'porkDestroy'])->middleware(['auth', 'verified','admin'])->name('custompork.destroy');

Route::get('/admin/custom/packages/chicken', [CustomPackagesPagesController::class, 'chicken'])->middleware(['auth', 'verified','admin'])->name('customchicken');
Route::get('/admin/custom/packages/chicken/add', [CustomPackagesPagesController::class, 'chickenAdd'])->middleware(['auth', 'verified','admin'])->name('customchickenadd');
Route::post('/admin/custom/packages/chicken/store', [CustomPackagesController::class, 'chickenStore'])->middleware(['auth', 'verified','admin'])->name('customchicken.store');
Route::get('/admin/custom/packages/chicken/view', [CustomPackagesPagesController::class, 'chickenView'])->middleware(['auth', 'verified','admin'])->name('customchicken.view');
Route::get('/admin/custom/packages/chicken/edit/{chicken_id}', [CustomPackagesPagesController::class, 'chickenEdit'])->middleware(['auth', 'verified','admin'])->name('customchicken.edit');
Route::put('/admin/custom/packages/chicken/update/{chicken_id}', [CustomPackagesController::class, 'chickenUpdate'])->middleware(['auth', 'verified','admin'])->name('customchicken.update');
Route::get('/admin/custom/packages/chicken/destroy/{chicken_id}', [CustomPackagesController::class, 'chickenDestroy'])->middleware(['auth', 'verified','admin'])->name('customchicken.destroy');

Route::get('/admin/custom/packages/veggie', [CustomPackagesPagesController::class, 'veggie'])->middleware(['auth', 'verified','admin'])->name('customveggie');
Route::get('/admin/custom/packages/veggie/add', [CustomPackagesPagesController::class, 'veggieAdd'])->middleware(['auth', 'verified','admin'])->name('customveggieadd');
Route::post('/admin/custom/packages/veggie/store', [CustomPackagesController::class, 'veggieStore'])->middleware(['auth', 'verified','admin'])->name('customveggie.store');
Route::get('/admin/custom/packages/veggie/view', [CustomPackagesPagesController::class, 'veggieView'])->middleware(['auth', 'verified','admin'])->name('customveggie.view');
Route::get('/admin/custom/packages/veggie/edit/{veggie_id}', [CustomPackagesPagesController::class, 'veggieEdit'])->middleware(['auth', 'verified','admin'])->name('customveggie.edit');
Route::put('/admin/custom/packages/veggie/update/{veggie_id}', [CustomPackagesController::class, 'veggieUpdate'])->middleware(['auth', 'verified','admin'])->name('customveggie.update');
Route::get('/admin/custom/packages/veggie/destroy/{veggie_id}', [CustomPackagesController::class, 'veggieDestroy'])->middleware(['auth', 'verified','admin'])->name('customveggie.destroy');

Route::get('/admin/custom/packages/other', [CustomPackagesPagesController::class, 'other'])->middleware(['auth', 'verified','admin'])->name('customother');
Route::get('/admin/custom/packages/other/add', [CustomPackagesPagesController::class, 'otherAdd'])->middleware(['auth', 'verified','admin'])->name('customotheradd');
Route::post('/admin/custom/packages/other/store', [CustomPackagesController::class, 'otherStore'])->middleware(['auth', 'verified','admin'])->name('customother.store');
Route::get('/admin/custom/packages/other/view', [CustomPackagesPagesController::class, 'otherView'])->middleware(['auth', 'verified','admin'])->name('customother.view');
Route::get('/admin/custom/packages/other/edit/{other_id}', [CustomPackagesPagesController::class, 'otherEdit'])->middleware(['auth', 'verified','admin'])->name('customother.edit');
Route::put('/admin/custom/packages/other/update/{other_id}', [CustomPackagesController::class, 'otherUpdate'])->middleware(['auth', 'verified','admin'])->name('customother.update');
Route::get('/admin/custom/packages/other/destroy/{other_id}', [CustomPackagesController::class, 'otherDestroy'])->middleware(['auth', 'verified','admin'])->name('customother.destroy');


//FOOD-MANAGER
Route::get('/manager/custom/packages/food', [MgrCustomPackagesPagesController::class, 'food'])->middleware(['auth', 'verified','manager'])->name('manager.customfood');
Route::get('/manager/custom/packages/food/add', [MgrCustomPackagesPagesController::class, 'foodAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodadd');
Route::post('/manager/custom/packages/food/store', [MgrCustomPackagesController::class, 'foodStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.store');
Route::get('/manager/custom/packages/food/view', [MgrCustomPackagesPagesController::class, 'foodView'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.view');
Route::get('/manager/custom/packages/food/edit/{food_id}', [MgrCustomPackagesPagesController::class, 'foodEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.edit');
Route::put('/manager/custom/packages/food/update/{food_id}', [MgrCustomPackagesController::class, 'foodUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.update');
Route::get('/manager/custom/packages/food/destroy/{food_id}', [MgrCustomPackagesController::class, 'foodDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfood.destroy');

Route::get('/manager/custom/packages/beef', [MgrCustomPackagesPagesController::class, 'beef'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef');
Route::get('/manager/custom/packages/beef/add', [MgrCustomPackagesPagesController::class, 'beefAdd'])->middleware(['auth', 'verified','manager'])->name('manager.custombeefadd');
Route::post('/manager/custom/packages/beef/store', [MgrCustomPackagesController::class, 'beefStore'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef.store');
Route::get('/manager/custom/packages/beef/view', [MgrCustomPackagesPagesController::class, 'beefView'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef.view');
Route::get('/manager/custom/packages/beef/edit/{beef_id}', [MgrCustomPackagesPagesController::class, 'beefEdit'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef.edit');
Route::put('/manager/custom/packages/beef/update/{beef_id}', [MgrCustomPackagesController::class, 'beefUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef.update');
Route::get('/manager/custom/packages/beef/destroy/{beef_id}', [MgrCustomPackagesController::class, 'beefDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.custombeef.destroy');

Route::get('/manager/custom/packages/pork', [MgrCustomPackagesPagesController::class, 'pork'])->middleware(['auth', 'verified','manager'])->name('manager.custompork');
Route::get('/manager/custom/packages/pork/add', [MgrCustomPackagesPagesController::class, 'porkAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customporkadd');
Route::post('/manager/custom/packages/pork/store', [MgrCustomPackagesController::class, 'porkStore'])->middleware(['auth', 'verified','manager'])->name('manager.custompork.store');
Route::get('/manager/custom/packages/pork/view', [MgrCustomPackagesPagesController::class, 'porkView'])->middleware(['auth', 'verified','manager'])->name('manager.custompork.view');
Route::get('/manager/custom/packages/pork/edit/{pork_id}', [MgrCustomPackagesPagesController::class, 'porkEdit'])->middleware(['auth', 'verified','manager'])->name('manager.custompork.edit');
Route::put('/manager/custom/packages/pork/update/{pork_id}', [MgrCustomPackagesController::class, 'porkUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.custompork.update');
Route::get('/manager/custom/packages/pork/destroy/{pork_id}', [MgrCustomPackagesController::class, 'porkDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.custompork.destroy');

Route::get('/manager/custom/packages/chicken', [MgrCustomPackagesPagesController::class, 'chicken'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken');
Route::get('/manager/custom/packages/chicken/add', [MgrCustomPackagesPagesController::class, 'chickenAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customchickenadd');
Route::post('/manager/custom/packages/chicken/store', [MgrCustomPackagesController::class, 'chickenStore'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken.store');
Route::get('/manager/custom/packages/chicken/view', [MgrCustomPackagesPagesController::class, 'chickenView'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken.view');
Route::get('/manager/custom/packages/chicken/edit/{chicken_id}', [MgrCustomPackagesPagesController::class, 'chickenEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken.edit');
Route::put('/manager/custom/packages/chicken/update/{chicken_id}', [MgrCustomPackagesController::class, 'chickenUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken.update');
Route::get('/manager/custom/packages/chicken/destroy/{chicken_id}', [MgrCustomPackagesController::class, 'chickenDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customchicken.destroy');

Route::get('/manager/custom/packages/veggie', [MgrCustomPackagesPagesController::class, 'veggie'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie');
Route::get('/manager/custom/packages/veggie/add', [MgrCustomPackagesPagesController::class, 'veggieAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customveggieadd');
Route::post('/manager/custom/packages/veggie/store', [MgrCustomPackagesController::class, 'veggieStore'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie.store');
Route::get('/manager/custom/packages/veggie/view', [MgrCustomPackagesPagesController::class, 'veggieView'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie.view');
Route::get('/manager/custom/packages/veggie/edit/{veggie_id}', [MgrCustomPackagesPagesController::class, 'veggieEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie.edit');
Route::put('/manager/custom/packages/veggie/update/{veggie_id}', [MgrCustomPackagesController::class, 'veggieUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie.update');
Route::get('/manager/custom/packages/veggie/destroy/{veggie_id}', [MgrCustomPackagesController::class, 'veggieDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customveggie.destroy');

Route::get('/manager/custom/packages/other', [MgrCustomPackagesPagesController::class, 'other'])->middleware(['auth', 'verified','manager'])->name('manager.customother');
Route::get('/manager/custom/packages/other/add', [MgrCustomPackagesPagesController::class, 'otherAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customotheradd');
Route::post('/manager/custom/packages/other/store', [MgrCustomPackagesController::class, 'otherStore'])->middleware(['auth', 'verified','manager'])->name('manager.customother.store');
Route::get('/manager/custom/packages/other/view', [MgrCustomPackagesPagesController::class, 'otherView'])->middleware(['auth', 'verified','manager'])->name('manager.customother.view');
Route::get('/manager/custom/packages/other/edit/{other_id}', [MgrCustomPackagesPagesController::class, 'otherEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customother.edit');
Route::put('/manager/custom/packages/other/update/{other_id}', [MgrCustomPackagesController::class, 'otherUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customother.update');
Route::get('/manager/custom/packages/other/destroy/{other_id}', [MgrCustomPackagesController::class, 'otherDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customother.destroy');


//FOOD-OWNER
Route::get('/owner/custom/packages/food', [OwnerCustomPackagesPagesController::class, 'food'])->middleware(['auth', 'verified','owner'])->name('owner.customfood');
Route::get('/owner/custom/packages/food/add', [OwnerCustomPackagesPagesController::class, 'foodAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodadd');
Route::post('/owner/custom/packages/food/store', [OwnerCustomPackagesController::class, 'foodStore'])->middleware(['auth', 'verified','owner'])->name('owner.customfood.store');
Route::get('/owner/custom/packages/food/view', [OwnerCustomPackagesPagesController::class, 'foodView'])->middleware(['auth', 'verified','owner'])->name('owner.customfood.view');
Route::get('/owner/custom/packages/food/edit/{food_id}', [OwnerCustomPackagesPagesController::class, 'foodEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customfood.edit');
Route::put('/owner/custom/packages/food/update/{food_id}', [OwnerCustomPackagesController::class, 'foodUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customfood.update');
Route::get('/owner/custom/packages/food/destroy/{food_id}', [OwnerCustomPackagesController::class, 'foodDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customfood.destroy');


Route::get('/owner/custom/packages/beef', [OwnerCustomPackagesPagesController::class, 'beef'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef');
Route::get('/owner/custom/packages/beef/add', [OwnerCustomPackagesPagesController::class, 'beefAdd'])->middleware(['auth', 'verified','owner'])->name('owner.custombeefadd');
Route::post('/owner/custom/packages/beef/store', [OwnerCustomPackagesController::class, 'beefStore'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef.store');
Route::get('/owner/custom/packages/beef/view', [OwnerCustomPackagesPagesController::class, 'beefView'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef.view');
Route::get('/owner/custom/packages/beef/edit/{beef_id}', [OwnerCustomPackagesPagesController::class, 'beefEdit'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef.edit');
Route::put('/owner/custom/packages/beef/update/{beef_id}', [OwnerCustomPackagesController::class, 'beefUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef.update');
Route::get('/owner/custom/packages/beef/destroy/{beef_id}', [OwnerCustomPackagesController::class, 'beefDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.custombeef.destroy');

Route::get('/owner/custom/packages/pork', [OwnerCustomPackagesPagesController::class, 'pork'])->middleware(['auth', 'verified','owner'])->name('owner.custompork');
Route::get('/owner/custom/packages/pork/add', [OwnerCustomPackagesPagesController::class, 'porkAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customporkadd');
Route::post('/owner/custom/packages/pork/store', [OwnerCustomPackagesController::class, 'porkStore'])->middleware(['auth', 'verified','owner'])->name('owner.custompork.store');
Route::get('/owner/custom/packages/pork/view', [OwnerCustomPackagesPagesController::class, 'porkView'])->middleware(['auth', 'verified','owner'])->name('owner.custompork.view');
Route::get('/owner/custom/packages/pork/edit/{pork_id}', [OwnerCustomPackagesPagesController::class, 'porkEdit'])->middleware(['auth', 'verified','owner'])->name('owner.custompork.edit');
Route::put('/owner/custom/packages/pork/update/{pork_id}', [OwnerCustomPackagesController::class, 'porkUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.custompork.update');
Route::get('/owner/custom/packages/pork/destroy/{pork_id}', [OwnerCustomPackagesController::class, 'porkDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.custompork.destroy');

Route::get('/owner/custom/packages/chicken', [OwnerCustomPackagesPagesController::class, 'chicken'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken');
Route::get('/owner/custom/packages/chicken/add', [OwnerCustomPackagesPagesController::class, 'chickenAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customchickenadd');
Route::post('/owner/custom/packages/chicken/store', [OwnerCustomPackagesController::class, 'chickenStore'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken.store');
Route::get('/owner/custom/packages/chicken/view', [OwnerCustomPackagesPagesController::class, 'chickenView'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken.view');
Route::get('/owner/custom/packages/chicken/edit/{chicken_id}', [OwnerCustomPackagesPagesController::class, 'chickenEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken.edit');
Route::put('/owner/custom/packages/chicken/update/{chicken_id}', [OwnerCustomPackagesController::class, 'chickenUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken.update');
Route::get('/owner/custom/packages/chicken/destroy/{chicken_id}', [OwnerCustomPackagesController::class, 'chickenDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customchicken.destroy');

Route::get('/owner/custom/packages/veggie', [OwnerCustomPackagesPagesController::class, 'veggie'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie');
Route::get('/owner/custom/packages/veggie/add', [OwnerCustomPackagesPagesController::class, 'veggieAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customveggieadd');
Route::post('/owner/custom/packages/veggie/store', [OwnerCustomPackagesController::class, 'veggieStore'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie.store');
Route::get('/owner/custom/packages/veggie/view', [OwnerCustomPackagesPagesController::class, 'veggieView'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie.view');
Route::get('/owner/custom/packages/veggie/edit/{veggie_id}', [OwnerCustomPackagesPagesController::class, 'veggieEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie.edit');
Route::put('/owner/custom/packages/veggie/update/{veggie_id}', [OwnerCustomPackagesController::class, 'veggieUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie.update');
Route::get('/owner/custom/packages/veggie/destroy/{veggie_id}', [OwnerCustomPackagesController::class, 'veggieDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customveggie.destroy');

Route::get('/owner/custom/packages/other', [OwnerCustomPackagesPagesController::class, 'other'])->middleware(['auth', 'verified','owner'])->name('owner.customother');
Route::get('/owner/custom/packages/other/add', [OwnerCustomPackagesPagesController::class, 'otherAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customotheradd');
Route::post('/owner/custom/packages/other/store', [OwnerCustomPackagesController::class, 'otherStore'])->middleware(['auth', 'verified','owner'])->name('owner.customother.store');
Route::get('/owner/custom/packages/other/view', [OwnerCustomPackagesPagesController::class, 'otherView'])->middleware(['auth', 'verified','owner'])->name('owner.customother.view');
Route::get('/owner/custom/packages/other/edit/{other_id}', [OwnerCustomPackagesPagesController::class, 'otherEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customother.edit');
Route::put('/owner/custom/packages/other/update/{other_id}', [OwnerCustomPackagesController::class, 'otherUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customother.update');
Route::get('/owner/custom/packages/other/destroy/{other_id}', [OwnerCustomPackagesController::class, 'otherDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customother.destroy');

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


//FOODPACK-OWNER
Route::get('/owner/custom/packages/foodpack', [OwnerCustomPackagesPagesController::class, 'foodpack'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack');
Route::get('/owner/custom/packages/foodpack/add', [OwnerCustomPackagesPagesController::class, 'foodpackAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpackadd');
Route::post('/owner/custom/packages/foodpack/store', [OwnerCustomPackagesController::class, 'foodpackStore'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack.store');
Route::get('/owner/custom/packages/foodpack/view', [OwnerCustomPackagesPagesController::class, 'foodpackView'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack.view');
Route::get('/owner/custom/packages/foodpack/edit/{foodpack_id}', [OwnerCustomPackagesPagesController::class, 'foodpackEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack.edit');
Route::put('/owner/custom/packages/foodpack/update/{foodpack_id}', [OwnerCustomPackagesController::class, 'foodpackUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack.update');
Route::get('/owner/custom/packages/foodpack/destroy/{foodpack_id}', [OwnerCustomPackagesController::class, 'foodpackDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodpack.destroy');

//FOODPACK //FOODPACK //FOODPACK //FOODPACK //FOODPACK 


//FOODCART //FOODCART //FOODCART //FOODCART //FOODCART 
//FOODCART-ADMIN
Route::get('/admin/custom/packages/foodcart', [CustomPackagesPagesController::class, 'foodcart'])->middleware(['auth', 'verified','admin'])->name('customfoodcart');
Route::get('/admin/custom/packages/foodcart/add', [CustomPackagesPagesController::class, 'foodcartAdd'])->middleware(['auth', 'verified','admin'])->name('customfoodcartadd');
Route::post('/admin/custom/packages/foodcart/store', [CustomPackagesController::class, 'foodcartStore'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.store');
Route::get('/admin/custom/packages/foodcart/view', [CustomPackagesPagesController::class, 'foodcartView'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.view');
Route::get('/admin/custom/packages/foodcart/edit/{foodcart_id}', [CustomPackagesPagesController::class, 'foodcartEdit'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.edit');
Route::put('/admin/custom/packages/foodcart/update/{foodcart_id}', [CustomPackagesController::class, 'foodcartUpdate'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.update');
Route::get('/admin/custom/packages/foodcart/destroy/{foodcart_id}', [CustomPackagesController::class, 'foodcartDestroy'])->middleware(['auth', 'verified','admin'])->name('customfoodcart.destroy');


//FOODCART-MANAGER
Route::get('/manager/custom/packages/foodcart', [MgrCustomPackagesPagesController::class, 'foodcart'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart');
Route::get('/manager/custom/packages/foodcart/add', [MgrCustomPackagesPagesController::class, 'foodcartAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcartadd');
Route::post('/manager/custom/packages/foodcart/store', [MgrCustomPackagesController::class, 'foodcartStore'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.store');
Route::get('/manager/custom/packages/foodcart/view', [MgrCustomPackagesPagesController::class, 'foodcartView'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.view');
Route::get('/manager/custom/packages/foodcart/edit/{foodcart_id}', [MgrCustomPackagesPagesController::class, 'foodcartEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.edit');
Route::put('/manager/custom/packages/foodcart/update/{foodcart_id}', [MgrCustomPackagesController::class, 'foodcartUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.update');
Route::get('/manager/custom/packages/foodcart/destroy/{foodcart_id}', [MgrCustomPackagesController::class, 'foodcartDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customfoodcart.destroy');


//FOODCART-OWNER
Route::get('/owner/custom/packages/foodcart', [OwnerCustomPackagesPagesController::class, 'foodcart'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart');
Route::get('/owner/custom/packages/foodcart/add', [OwnerCustomPackagesPagesController::class, 'foodcartAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcartadd');
Route::post('/owner/custom/packages/foodcart/store', [OwnerCustomPackagesController::class, 'foodcartStore'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart.store');
Route::get('/owner/custom/packages/foodcart/view', [OwnerCustomPackagesPagesController::class, 'foodcartView'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart.view');
Route::get('/owner/custom/packages/foodcart/edit/{foodcart_id}', [OwnerCustomPackagesPagesController::class, 'foodcartEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart.edit');
Route::put('/owner/custom/packages/foodcart/update/{foodcart_id}', [OwnerCustomPackagesController::class, 'foodcartUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart.update');
Route::get('/owner/custom/packages/foodcart/destroy/{foodcart_id}', [OwnerCustomPackagesController::class, 'foodcartDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customfoodcart.destroy');

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


//LECHON-OWNER
Route::get('/owner/custom/packages/lechon', [OwnerCustomPackagesPagesController::class, 'lechon'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon');
Route::get('/owner/custom/packages/lechon/add', [OwnerCustomPackagesPagesController::class, 'lechonAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customlechonadd');
Route::post('/owner/custom/packages/lechon/store', [OwnerCustomPackagesController::class, 'lechonStore'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon.store');
Route::get('/owner/custom/packages/lechon/view', [OwnerCustomPackagesPagesController::class, 'lechonView'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon.view');
Route::get('/owner/custom/packages/lechon/edit/{lechon_id}', [OwnerCustomPackagesPagesController::class, 'lechonEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon.edit');
Route::put('/owner/custom/packages/lechon/update/{lechon_id}', [OwnerCustomPackagesController::class, 'lechonUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon.update');
Route::get('/owner/custom/packages/lechon/destroy/{lechon_id}', [OwnerCustomPackagesController::class, 'lechonDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customlechon.destroy');
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


//CAKE-OWNER
Route::get('/owner/custom/packages/cake', [OwnerCustomPackagesPagesController::class, 'cake'])->middleware(['auth', 'verified','owner'])->name('owner.customcake');
Route::get('/owner/custom/packages/cake/add', [OwnerCustomPackagesPagesController::class, 'cakeAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customcakeadd');
Route::post('/owner/custom/packages/cake/store', [OwnerCustomPackagesController::class, 'cakeStore'])->middleware(['auth', 'verified','owner'])->name('owner.customcake.store');
Route::get('/owner/custom/packages/cake/view', [OwnerCustomPackagesPagesController::class, 'cakeView'])->middleware(['auth', 'verified','owner'])->name('owner.customcake.view');
Route::get('/owner/custom/packages/cake/edit/{cake_id}', [OwnerCustomPackagesPagesController::class, 'cakeEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customcake.edit');
Route::put('/owner/custom/packages/cake/update/{cake_id}', [OwnerCustomPackagesController::class, 'cakeUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customcake.update');
Route::get('/owner/custom/packages/cake/destroy/{cake_id}', [OwnerCustomPackagesController::class, 'cakeDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customcake.destroy');
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


//CLOWN-OWNER
Route::get('/owner/custom/packages/clown', [OwnerCustomPackagesPagesController::class, 'clown'])->middleware(['auth', 'verified','owner'])->name('owner.customclown');
Route::get('/owner/custom/packages/clown/add', [OwnerCustomPackagesPagesController::class, 'clownAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customclownadd');
Route::post('/owner/custom/packages/clown/store', [OwnerCustomPackagesController::class, 'clownStore'])->middleware(['auth', 'verified','owner'])->name('owner.customclown.store');
Route::get('/owner/custom/packages/clown/view', [OwnerCustomPackagesPagesController::class, 'clownView'])->middleware(['auth', 'verified','owner'])->name('owner.customclown.view');
Route::get('/owner/custom/packages/clown/edit/{clown_id}', [OwnerCustomPackagesPagesController::class, 'clownEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customclown.edit');
Route::put('/owner/custom/packages/clown/update/{clown_id}', [OwnerCustomPackagesController::class, 'clownUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customclown.update');
Route::get('/owner/custom/packages/clown/destroy/{clown_id}', [OwnerCustomPackagesController::class, 'clownDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customclown.destroy');
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


//SETUP-OWNER
Route::get('/owner/custom/packages/setup', [OwnerCustomPackagesPagesController::class, 'setup'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup');
Route::get('/owner/custom/packages/setup/add', [OwnerCustomPackagesPagesController::class, 'setupAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customsetupadd');
Route::post('/owner/custom/packages/setup/store', [OwnerCustomPackagesController::class, 'setupStore'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup.store');
Route::get('/owner/custom/packages/setup/view', [OwnerCustomPackagesPagesController::class, 'setupView'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup.view');
Route::get('/owner/custom/packages/setup/edit/{setup_id}', [OwnerCustomPackagesPagesController::class, 'setupEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup.edit');
Route::put('/owner/custom/packages/setup/update/{setup_id}', [OwnerCustomPackagesController::class, 'setupUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup.update');
Route::get('/owner/custom/packages/setup/destroy/{setup_id}', [OwnerCustomPackagesController::class, 'setupDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customsetup.destroy');
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


//FACEPAINT-OWNER
Route::get('/owner/custom/packages/facepaint', [OwnerCustomPackagesPagesController::class, 'facepaint'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint');
Route::get('/owner/custom/packages/facepaint/add', [OwnerCustomPackagesPagesController::class, 'facepaintAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaintadd');
Route::post('/owner/custom/packages/facepaint/store', [OwnerCustomPackagesController::class, 'facepaintStore'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint.store');
Route::get('/owner/custom/packages/facepaint/view', [OwnerCustomPackagesPagesController::class, 'facepaintView'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint.view');
Route::get('/owner/custom/packages/facepaint/edit/{facepaint_id}', [OwnerCustomPackagesPagesController::class, 'facepaintEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint.edit');
Route::put('/owner/custom/packages/facepaint/update/{facepaint_id}', [OwnerCustomPackagesController::class, 'facepaintUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint.update');
Route::get('/owner/custom/packages/facepaint/destroy/{facepaint_id}', [OwnerCustomPackagesController::class, 'facepaintDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customfacepaint.destroy');
//FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT //FACEPAINT


//DESSERT //DESSERT //DESSERT //DESSERT //DESSERT
//DESSERT-ADMIN
Route::get('/admin/custom/packages/dessert', [CustomPackagesPagesController::class, 'dessert'])->middleware(['auth', 'verified','admin'])->name('customdessert');
Route::get('/admin/custom/packages/dessert/add', [CustomPackagesPagesController::class, 'dessertAdd'])->middleware(['auth', 'verified','admin'])->name('customdessertadd');
Route::post('/admin/custom/packages/dessert/store', [CustomPackagesController::class, 'dessertStore'])->middleware(['auth', 'verified','admin'])->name('customdessert.store');
Route::get('/admin/custom/packages/dessert/view', [CustomPackagesPagesController::class, 'dessertView'])->middleware(['auth', 'verified','admin'])->name('customdessert.view');
Route::get('/admin/custom/packages/dessert/edit/{dessert_id}', [CustomPackagesPagesController::class, 'dessertEdit'])->middleware(['auth', 'verified','admin'])->name('customdessert.edit');
Route::put('/admin/custom/packages/dessert/update/{dessert_id}', [CustomPackagesController::class, 'dessertUpdate'])->middleware(['auth', 'verified','admin'])->name('customdessert.update');
Route::get('/admin/custom/packages/dessert/destroy/{dessert_id}', [CustomPackagesController::class, 'dessertDestroy'])->middleware(['auth', 'verified','admin'])->name('customdessert.destroy');


//DESSERT-MANAGER
Route::get('/manager/custom/packages/dessert', [MgrCustomPackagesPagesController::class, 'dessert'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert');
Route::get('/manager/custom/packages/dessert/add', [MgrCustomPackagesPagesController::class, 'dessertAdd'])->middleware(['auth', 'verified','manager'])->name('manager.customdessertadd');
Route::post('/manager/custom/packages/dessert/store', [MgrCustomPackagesController::class, 'dessertStore'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert.store');
Route::get('/manager/custom/packages/dessert/view', [MgrCustomPackagesPagesController::class, 'dessertView'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert.view');
Route::get('/manager/custom/packages/dessert/edit/{dessert_id}', [MgrCustomPackagesPagesController::class, 'dessertEdit'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert.edit');
Route::put('/manager/custom/packages/dessert/update/{dessert_id}', [MgrCustomPackagesController::class, 'dessertUpdate'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert.update');
Route::get('/manager/custom/packages/dessert/destroy/{dessert_id}', [MgrCustomPackagesController::class, 'dessertDestroy'])->middleware(['auth', 'verified','manager'])->name('manager.customdessert.destroy');


//DESSERT-OWNER
Route::get('/owner/custom/packages/dessert', [OwnerCustomPackagesPagesController::class, 'dessert'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert');
Route::get('/owner/custom/packages/dessert/add', [OwnerCustomPackagesPagesController::class, 'dessertAdd'])->middleware(['auth', 'verified','owner'])->name('owner.customdessertadd');
Route::post('/owner/custom/packages/dessert/store', [OwnerCustomPackagesController::class, 'dessertStore'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert.store');
Route::get('/owner/custom/packages/dessert/view', [OwnerCustomPackagesPagesController::class, 'dessertView'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert.view');
Route::get('/owner/custom/packages/dessert/edit/{dessert_id}', [OwnerCustomPackagesPagesController::class, 'dessertEdit'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert.edit');
Route::put('/owner/custom/packages/dessert/update/{dessert_id}', [OwnerCustomPackagesController::class, 'dessertUpdate'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert.update');
Route::get('/owner/custom/packages/dessert/destroy/{dessert_id}', [OwnerCustomPackagesController::class, 'dessertDestroy'])->middleware(['auth', 'verified','owner'])->name('owner.customdessert.destroy');
//DESSERT //DESSERT //DESSERT //DESSERT //DESSERT


// CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE // CUSTOM PACKAGE 

//DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES 
Route::get('/admin/dishes', [DishesController::class, 'index'])->middleware(['auth', 'verified','admin'])->name('dish.index');
Route::get('/admin/dishes/add', [DishesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('dish.add');

//DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES //DISHES 


//PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES 
// Route::resource('package', PackagesController::class);
Route::post('/admin/packages/store', [PackagesController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('admin.package.store');
Route::post('/manager/packages/store', [PackagesController::class, 'store'])->middleware(['auth', 'verified','manager'])->name('manager.package.store');
Route::post('/owner/packages/store', [PackagesController::class, 'store'])->middleware(['auth', 'verified','owner'])->name('owner.package.store');


//ADMIN PACKAGES
Route::get('/admin/packages/add', [PackagesPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpackage');
Route::post('/admin/custom/packages/add', [PackagesController::class, 'custom'])->middleware(['auth', 'verified','admin'])->name('addcustom');
Route::get('/admin/packages/view', [PackagesPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpackage');
Route::get('/admin/packages/customize', [PackagesPagesController::class, 'customize'])->middleware(['auth', 'verified','admin'])->name('customizepackage');
Route::get('/admin/packages/new/customize', [PackagesPagesController::class, 'newcustomize'])->middleware(['auth', 'verified','admin'])->name('newcustomizepackage');
Route::get('/admin/packages/add/sample/{package_id}', [SampleController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addsample');
Route::post('/admin/packages/sample/store', [SampleController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('storesample');
// Route::post('/admin/packages/sample/store/new', [NewSampleController::class, 'store'])->middleware(['auth', 'verified','admin'])->name('storesample');

Route::get('/admin/packages/sample/edit/{sample_id}', [SampleController::class, 'edit'])->middleware(['auth', 'verified','admin'])->name('editsample');
Route::put('/admin/packages/sample/update/{sample_id}', [SampleController::class, 'update'])->middleware(['auth', 'verified','admin'])->name('updatesample');

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


Route::get('/admin/package/{package_id}/custom/edit', [CustomPackagesPagesController::class, 'customedit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.custom.editpackage');

Route::get('/admin/package/{package_id}/custom/edit/booked', [CustomPackagesPagesController::class, 'customeditBooked'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.custom.editpackage.booked');
    
Route::post('/admin/package/{package_id}/custom/update', [CustomPackagesController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.custom.updatepackage');

Route::post('/admin/package/{package_id}/custom/update/booked', [CustomPackagesController::class, 'updatebooked'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.booked.custom.updatepackage');


Route::get('/admin/packages/view/archived', [PackagesPagesController::class, 'viewArchived'])->middleware(['auth', 'verified','admin'])->name('admin.view.archive');

Route::get('/package/{package_id}/archive', [PackagesController::class, 'archive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.packages.archive');

Route::get('/package/{package_id}/unarchive', [PackagesController::class, 'unarchive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.packages.unarchive');

Route::get('/admin/packages/view/custom', [PackagesPagesController::class, 'viewCustom'])->middleware(['auth', 'verified','admin'])->name('admin.view.custom');

Route::get('/package/{package_id}/custom/edit', [CustomPackagesPagesController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('admin.packages.custom.edit');


//MANAGER PACKAGES
Route::get('/manager/packages/add', [PackagesPagesController::class, 'manageradd'])->middleware(['auth', 'verified','manager'])->name('manageraddpackage');
Route::get('/manager/packages/view', [PackagesPagesController::class, 'managerview'])->middleware(['auth', 'verified','manager'])->name('managerviewpackage');
Route::get('/manager/packages/customize', [PackagesPagesController::class, 'managercustomize'])->middleware(['auth', 'verified','manager'])->name('managercustomizepackage');
Route::post('/manager/custom/packages/add', [PackagesController::class, 'managercustom'])->middleware(['auth', 'verified','manager'])->name('manageraddcustom');
Route::get('/manager/packages/new/customize', [PackagesPagesController::class, 'managernewcustomize'])->middleware(['auth', 'verified','manager'])->name('manager.newcustomizepackage');
Route::get('/manager/packages/add/sample/{package_id}', [SampleController::class, 'addmanager'])->middleware(['auth', 'verified','manager'])->name('manager.addsample');
Route::post('/manager/packages/sample/store', [SampleController::class, 'store'])->middleware(['auth', 'verified','manager'])->name('manager.storesample');
Route::get('/manager/packages/sample/edit/{sample_id}', [SampleController::class, 'editmanager'])->middleware(['auth', 'verified','manager'])->name('manager.editsample');
Route::put('/manager/packages/sample/update/{sample_id}', [SampleController::class, 'updatemanager'])->middleware(['auth', 'verified','manager'])->name('manager.updatesample');

Route::get('/manager/package/{package_id}/show', [PackagesController::class, 'managershow'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managershowpackage');
Route::get('/manager/package/{package_id}/edit', [PackagesController::class, 'manageredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managereditpackage');
Route::post('/manager/package/{package_id}', [PackagesController::class, 'managerupdate'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerupdatepackage');
Route::get('/manager/package/{package_id}/destroy', [PackagesController::class, 'managerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('managerdestroypackage');
Route::get('/manager/package/{package_id}/destroycustom', [MgrCustomPackagesController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.destroycustom');


Route::get('/manager/package/{package_id}/custom/edit-package', [MgrCustomPackagesPagesController::class, 'customedit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.custom.editpackage');

Route::get('/manager/package/{package_id}/custom/edit/booked', [MgrCustomPackagesPagesController::class, 'customeditBooked'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.custom.editpackage.booked');
    
Route::post('/manager/package/{package_id}/custom/update', [MgrCustomPackagesController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.custom.updatepackage');

Route::post('/manager/package/{package_id}/custom/update/booked', [MgrCustomPackagesController::class, 'updatebooked'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.booked.custom.updatepackage');


Route::get('/manager/packages/view/archived', [PackagesPagesController::class, 'managerviewArchived'])->middleware(['auth', 'verified','manager'])->name('manager.view.archive');

Route::get('/manager/package/{package_id}/archive', [PackagesController::class, 'archive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.packages.archive');
    
Route::get('/manager/package/{package_id}/unarchive', [PackagesController::class, 'unarchive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.packages.unarchive');

Route::get('/manager/packages/view/custom', [PackagesPagesController::class, 'managerviewCustom'])->middleware(['auth', 'verified','manager'])->name('manager.view.custom');

Route::get('/manager/package/{package_id}/custom/edit', [CustomPackagesPagesController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'manager')
    ->name('manager.packages.custom.edit');


//OWNER PACKAGES
Route::get('/owner/packages/add', [PackagesPagesController::class, 'owneradd'])->middleware(['auth', 'verified','owner'])->name('owneraddpackage');
Route::get('/owner/packages/view', [PackagesPagesController::class, 'ownerview'])->middleware(['auth', 'verified','owner'])->name('ownerviewpackage');
Route::get('/owner/packages/customize', [PackagesPagesController::class, 'ownercustomize'])->middleware(['auth', 'verified','owner'])->name('ownercustomizepackage');
Route::get('/owner/packages/new/customize', [PackagesPagesController::class, 'ownernewcustomize'])->middleware(['auth', 'verified','owner'])->name('owner.newcustomizepackage');
Route::get('/owner/packages/add/sample/{package_id}', [SampleController::class, 'addowner'])->middleware(['auth', 'verified','owner'])->name('owner.addsample');
Route::post('/owner/packages/sample/store', [SampleController::class, 'store'])->middleware(['auth', 'verified','owner'])->name('owner.storesample');
Route::get('/owner/packages/sample/edit/{sample_id}', [SampleController::class, 'editowner'])->middleware(['auth', 'verified','owner'])->name('owner.editsample');
Route::put('/owner/packages/sample/update/{sample_id}', [SampleController::class, 'updateowner'])->middleware(['auth', 'verified','owner'])->name('owner.updatesample');

Route::get('/owner/package/{package_id}/show', [PackagesController::class, 'ownershow'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownershowpackage');
Route::get('/owner/package/{package_id}/edit', [PackagesController::class, 'owneredit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownereditpackage');
Route::put('/owner/package/{package_id}', [PackagesController::class, 'ownerupdate'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownerupdatepackage');
Route::get('/owner/package/{package_id}/destroy', [PackagesController::class, 'ownerdestroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('ownerdestroypackage');
Route::get('/owner/package/{package_id}/destroycustom', [OwnerCustomPackagesController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.destroycustom');


Route::get('/owner/package/{package_id}/custom/edit-package', [OwnerCustomPackagesPagesController::class, 'customedit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.custom.editpackage');

Route::post('/owner/package/{package_id}/custom/update', [OwnerCustomPackagesController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.custom.updatepackage');

Route::get('/owner/packages/view/archived', [PackagesPagesController::class, 'ownerviewArchived'])->middleware(['auth', 'verified','owner'])->name('owner.view.archive');

Route::get('/owner/package/{package_id}/archive', [PackagesController::class, 'archive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.packages.archive');
    
Route::get('/owner/package/{package_id}/unarchive', [PackagesController::class, 'unarchive'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.packages.unarchive');

Route::get('/owner/packages/view/custom', [PackagesPagesController::class, 'ownerviewCustom'])->middleware(['auth', 'verified','owner'])->name('owner.view.custom');

Route::get('/owner/package/{package_id}/custom/edit', [CustomPackagesPagesController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'owner')
    ->name('owner.packages.custom.edit');



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

Route::put('/appointment/client/{appointment_id}/cancel/meeting', [AppointmentController::class, 'clientcancelmeeting'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('client.appointment.cancel.meeting');
//CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING //CANCEL-MEETING 



//DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT 
//ADMIN
Route::get('/appointment/{appointment_id}/booked/details-edit', [AppointmentController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('details.edit');

Route::get('/appointment/{appointment_id}/pending/details-edit', [AppointmentController::class, 'detailspendingedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('pending.details.edit');

Route::get('/appointment/{appointment_id}/cancelled/details-edit', [AppointmentController::class, 'detailscancellededit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('cancelled.details.edit');

//MANAGER
Route::get('/appointment/manager/{appointment_id}/booked/details-edit', [ManagerAppointmensController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.details.edit');

Route::get('/appointment/manager/{appointment_id}/pending/details-edit', [ManagerAppointmensController::class, 'detailspendingedit'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.pending.details.edit');

Route::get('/appointment/manager/{appointment_id}/cancelled/details-edit', [ManagerAppointmensController::class, 'detailscancellededit'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.cancelled.details.edit');

//OWNER
Route::get('/appointment/owner/{appointment_id}/booked/details-edit', [OwnerAppointmentsController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'owner'])
    ->name('owner.details.edit');

//CLIENT
Route::put('/appointment/client/{appointment_id}/save', [AppointmentController::class, 'saveClient'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('client.appointment.save');

Route::put('/appointment/client/meeting/{appointment_id}/save', [AppointmentController::class, 'saveClientMeeting'])
    ->middleware(['auth', 'verified', 'user'])
    ->name('client.appointment.meeting.save');
//DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT //DETAILS-EDIT 



// DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE 
Route::put('/appointment/{appointment_id}/save', [AppointmentController::class, 'save'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.save');

Route::put('/appointment/manager/{appointment_id}/save', [ManagerAppointmensController::class, 'save'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.save');

Route::put('/appointment/owner/{appointment_id}/save', [OwnerAppointmentsController::class, 'save'])
    ->middleware(['auth', 'verified', 'owner'])
    ->name('owner.appointment.save');
// DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE // DETAILS-SAVE 



//DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE 
Route::delete('/appointment/{appointment_id}/delete', [AppointmentController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.delete');

Route::delete('/appointment/{appointment_id}/delete/meeting', [AppointmentController::class, 'destroyMeeting'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.delete.meeting');

Route::delete('/appointment/manager/{appointment_id}/delete', [ManagerAppointmensController::class, 'destroy'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.delete');

Route::delete('/appointment/manager/{appointment_id}/delete/meeting', [ManagerAppointmensController::class, 'destroyMeeting'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.delete.meeting');
//DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE //DELETE 


//ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE 
Route::get('/appointment/{appointment_id}/archive', [AppointmentController::class, 'archive'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.archive');

Route::get('/appointment/{appointment_id}/archive/pending', [AppointmentController::class, 'archivePending'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.archive.pending');

Route::get('/appointment/{appointment_id}/unarchive', [AppointmentController::class, 'unarchive'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.unarchive');

//MANAGER
Route::get('/appointment./manager/{appointment_id}/archive', [ManagerAppointmensController::class, 'archive'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.archive');

Route::get('/appointment/{appointment_id}/manager/archive/pending', [ManagerAppointmensController::class, 'archivePending'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.archive.pending');

Route::get('/appointment/{appointment_id}/manager/unarchive', [ManagerAppointmensController::class, 'unarchive'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.appointment.unarchive');
//ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE //ARCHIVE 

//CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT 
Route::put('/appointment/{appointment_id}/admin/contract', [AppointmentController::class, 'contract'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.attach.contract');

Route::put('/appointment/{appointment_id}/manager/contract', [ManagerAppointmensController::class, 'contract'])
    ->middleware(['auth', 'verified', 'manager'])
    ->name('manager.attach.contract');

Route::put('/appointment/{appointment_id}/owner/contract', [OwnerAppointmentsController::class, 'contract'])
    ->middleware(['auth', 'verified', 'owner'])
    ->name('owner.attach.contract');

//CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT //CONTRACT 

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
Route::get('/managerreports', [ManagerController::class, 'reports'])->middleware(['auth', 'verified','manager'])->name('managerreports');

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

Route::get('/manager/cancelled/meeting', [ManagerAppointmentsPagesController::class, 'cancelledMeeting'])->middleware(['auth', 'verified','manager'])->name('manager.cancelledMeeting');
Route::get('/manager/cancelled/meeting/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'cancelledmeetingView'])->middleware(['auth', 'verified','manager'])->name('manager.cancelledMeetingView');

Route::get('/manager/archived', [ManagerAppointmentsPagesController::class, 'archived'])->middleware(['auth', 'verified','manager'])->name('manager.archived');
Route::get('/manager/archived/{appointment_id}/view', [ManagerAppointmentsPagesController::class, 'archivedView'])->middleware(['auth', 'verified','manager'])->name('manager.archivedView');


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
Route::put('/manager/reviews/response{review_id}', [ReviewController::class, 'managerresponse'])->middleware(['auth', 'verified','manager'])->name('manager.reviews.response');

//MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW //MANAGER REVIEW 

//MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER //MANAGER 


//OWNER
Route::get('/ownerdashboard', [OwnerController::class, 'ownerdashboard'])->middleware(['auth', 'verified','owner'])->name('ownerdashboard');
// Route::get('/ownercalendar', [OwnerController::class, 'ownercalendar'])->middleware(['auth', 'verified','owner'])->name('ownercalendar');

Route::get('/owner/calendar/data', [OwnerAppointmentsPagesController::class, 'calendar'])->middleware(['auth', 'verified','owner'])->name('ownercalendar');
Route::get('/owner/calendar', [OwnerAppointmentsPagesController::class, 'calendarView'])->middleware(['auth', 'verified','owner'])->name('ownercalendarView');


Route::get('/ownerevents', [OwnerController::class, 'ownerevents'])->middleware(['auth', 'verified','owner'])->name('ownerevents');
Route::get('/ownerdirect', [OwnerAppointmentsPagesController::class, 'direct'])->middleware(['auth', 'verified','owner'])->name('ownerdirect');

Route::get('/owner/booked/events', [OwnerAppointmentsPagesController::class, 'booked'])->middleware(['auth', 'verified','owner'])->name('owner.booked');
Route::get('/owner/booked/{appointment_id}/view', [OwnerAppointmentsPagesController::class, 'bookedView'])->middleware(['auth', 'verified','owner'])->name('owner.bookedView');

Route::get('/owner/done/events', [OwnerAppointmentsPagesController::class, 'done'])->middleware(['auth', 'verified','owner'])->name('owner.done');
Route::get('/owner/done/{appointment_id}/view', [OwnerAppointmentsPagesController::class, 'doneView'])->middleware(['auth', 'verified','owner'])->name('owner.doneView');

Route::get('/owner/cancelled/events', [OwnerAppointmentsPagesController::class, 'cancelled'])->middleware(['auth', 'verified','owner'])->name('owner.cancelled');
Route::get('/owner/cancelled/{appointment_id}/view', [OwnerAppointmentsPagesController::class, 'cancelledView'])->middleware(['auth', 'verified','owner'])->name('owner.cancelledView');


Route::get('/ownerchat', [OwnerController::class, 'ownerchat'])->middleware(['auth', 'verified','owner'])->name('ownerchat');
Route::get('/owner/logs', [OwnerController::class, 'logs'])->middleware(['auth', 'verified','owner'])->name('ownerlogs');
Route::get('/owner/packages', [OwnerController::class, 'packages'])->middleware(['auth', 'verified','owner'])->name('ownerpackages');
Route::get('/owner/reviews', [OwnerController::class, 'reviews'])->middleware(['auth', 'verified','owner'])->name('ownerreviews');
Route::get('/ownerreports', [OwnerController::class, 'reports'])->middleware(['auth', 'verified','owner'])->name('ownerreports');

Route::post('/owner/direct/save', [OwnerAppointmentsController::class, 'directsave'])->middleware(['auth', 'verified','owner'])->name('ownerdirectsave');


Route::get('/owner/reviews/pending', [ReviewController::class, 'ownerpending'])->middleware(['auth', 'verified','owner'])->name('ownerreviewpending');
Route::get('/owner/reviews/approved', [ReviewController::class, 'ownerapproved'])->middleware(['auth', 'verified','owner'])->name('ownerreviewapproved');
Route::put('/owner/reviews/pending/to/approved/{review_id}', [ReviewController::class, 'ownerstatusApproved'])->middleware(['auth', 'verified','owner'])->name('ownerreviews.approve');
Route::put('/owner/reviews/approved/to/pending/{review_id}', [ReviewController::class, 'ownerstatusPending'])->middleware(['auth', 'verified','owner'])->name('ownerreviews.pending');
Route::put('/owner/reviews/response{review_id}', [ReviewController::class, 'ownerresponse'])->middleware(['auth', 'verified','owner'])->name('owner.reviews.response');



//OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS 
Route::get('/fetch-owner-unopened-messages-count', [AppointmentController::class, 'fetchOwnerUnopenedMessageCount'])->middleware(['auth', 'verified','owner'])->name('fetch.owner.unopened.message.count');
Route::get('/fetch-owner-unread-count', [AppointmentController::class, 'fetchOwnerUnreadCount'])->middleware(['auth', 'verified','owner'])->name('fetch.owner.unread.count');
Route::get('/owner/notifications', [OwnerController::class, 'notifications'])->middleware(['auth', 'verified','owner'])->name('owner.notifications');

//OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS //OWNER NOTIFICATIONS 



//CLIENT
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified','user'])->name('dashboard');
Route::get('/chat', [UserController::class, 'chat'])->middleware(['auth', 'verified','user'])->name('chat');
Route::get('/client/packages', [UserController::class, 'packages'])->middleware(['auth', 'verified','user'])->name('packages');
Route::get('/client/packages/see/{package_id}', [UserController::class, 'packageShow'])->middleware(['auth', 'verified','user'])->name('client.package.show');



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
Route::get('/mycancelled', [UserController::class, 'mycancelled'])->middleware(['auth', 'verified','user'])->name('mycancelled');
Route::get('/myrequest', [UserController::class, 'myrequest'])->middleware(['auth', 'verified','user'])->name('myrequest');
Route::get('/events/data', [UserController::class, 'events'])->middleware(['auth', 'verified','user'])->name('events');
Route::get('/events', [UserController::class, 'eventsView'])->middleware(['auth', 'verified','user'])->name('eventsView');
Route::get('/idverify', [UserController::class, 'idverify'])->middleware(['auth', 'verified','user'])->name('idverify');
Route::get('/personal/{id}', [UserController::class, 'personal'])->middleware(['auth', 'verified','user'])->name('personal');
Route::patch('/update-personal/{id}', [UserController::class, 'update'])->middleware(['auth', 'verified','user'])->name('update-personal');


Route::get('/book-form', [UserController::class, 'book'])->middleware(['auth', 'verified','user'])->name('book-form');
Route::get('/form', [UserController::class, 'form'])->middleware(['auth', 'verified','user'])->name('form');
Route::get('/form/meeting-edit/{appointment_id}', [UserController::class, 'formMeetingEdit'])->middleware(['auth', 'verified','user'])->name('form.meeting.edit');
Route::get('/form-edit/{appointment_id}', [UserController::class, 'formEdit'])->middleware(['auth', 'verified','user'])->name('form.edit');
Route::get('/meeting-form', [UserController::class, 'meetingform'])->middleware(['auth', 'verified','user'])->name('meetingform');


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





require __DIR__.'/auth.php';
