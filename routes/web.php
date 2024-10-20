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


//PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES //PACKAGES 
Route::resource('package', PackagesController::class);

//ADMIN PACKAGES
Route::get('/admin/packages/add', [PackagesPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpackage');
Route::post('/admin/custom/packages/add', [PackagesController::class, 'custom'])->middleware(['auth', 'verified','admin'])->name('addcustom');
Route::get('/admin/packages/view', [PackagesPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpackage');
Route::get('/admin/packages/customize', [PackagesPagesController::class, 'customize'])->middleware(['auth', 'verified','admin'])->name('customizepackage');
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

//MANAGER PACKAGES
Route::get('/manager/packages/add', [PackagesPagesController::class, 'manageradd'])->middleware(['auth', 'verified','manager'])->name('manageraddpackage');
Route::get('/manager/packages/view', [PackagesPagesController::class, 'managerview'])->middleware(['auth', 'verified','manager'])->name('managerviewpackage');
Route::get('/manager/packages/customize', [PackagesPagesController::class, 'managercustomize'])->middleware(['auth', 'verified','manager'])->name('managercustomizepackage');
Route::post('/manager/custom/packages/add', [PackagesController::class, 'managercustom'])->middleware(['auth', 'verified','manager'])->name('manageraddcustom');


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


//APPOINTMENT
Route::resource('/appointment', AppointmentController::class);

Route::put('/appointment/{appointment_id}/accept', [AppointmentController::class, 'accept'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.accept');

Route::put('/appointment/{appointment_id}/done', [AppointmentController::class, 'done'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.done');

Route::put('/appointment/{appointment_id}/rebook', [AppointmentController::class, 'rebook'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.rebook');

Route::put('/appointment/{appointment_id}/cancel', [AppointmentController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.cancel');

Route::get('/appointment/{appointment_id}/details-edit', [AppointmentController::class, 'detailsedit'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('details.edit');

Route::put('/appointment/{appointment_id}/save', [AppointmentController::class, 'save'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.save');



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
