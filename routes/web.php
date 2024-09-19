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
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PackagesController;
use App\Http\Controllers\PackagesPagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostPagesController;
use App\Http\Controllers\UsertypeController;
use App\Http\Controllers\VerifyIdController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/send-message', [ChatController::class, 'sendMessage']);
Route::get('/get-messages', [ChatController::class, 'getMessages']);
Route::get('/get-users', [ChatController::class, 'getUsers']);
Route::get('/get-admin', [ChatController::class, 'getAdminAcc']);

//ADMIN
Route::get('/admin/dashboard', [AdminController::class, 'chat'])->middleware(['auth', 'verified','admin'])->name('admin.chat');
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
Route::get('/admin/approved', [AppointmentsPagesController::class, 'approved'])->middleware(['auth', 'verified','admin'])->name('approved');
Route::get('/admin/returned', [AppointmentsPagesController::class, 'returned'])->middleware(['auth', 'verified','admin'])->name('returned');
Route::get('/admin/cancelled', [AppointmentsPagesController::class, 'cancelled'])->middleware(['auth', 'verified','admin'])->name('cancelled');
Route::get('/admin/done', [AppointmentsPagesController::class, 'done'])->middleware(['auth', 'verified','admin'])->name('done');
Route::get('/admin/direct', [AppointmentsPagesController::class, 'direct'])->middleware(['auth', 'verified','admin'])->name('direct');


//ADMIN PACKAGES
Route::get('/admin/packages/add', [PackagesPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpackage');
Route::get('/admin/packages/view', [PackagesPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpackage');
Route::get('/admin/packages/customize', [PackagesPagesController::class, 'customize'])->middleware(['auth', 'verified','admin'])->name('customizepackage');
// Route::get('/admin/packages/eye', [PackagesPagesController::class, 'eye'])->middleware(['auth', 'verified','admin'])->name('eyepackage');
// Route::get('/admin/packages/show', [PackagesController::class, 'show'])->middleware(['auth', 'verified','admin'])->name('showpackage');
Route::resource('package', PackagesController::class);
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

//ADMIN FAQS
Route::get('/admin/faqs', [FaqsPagesController::class, 'faqs'])->middleware(['auth', 'verified','admin'])->name('adminfaqs');
Route::get('/admin/faqs/view', [FaqsPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewfaqs');
Route::get('/admin/faqs/add', [FaqsPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addfaqs');
Route::resource('faqs', FaqsController::class);
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

//ADMIN POST
Route::get('/admin/post', [PostPagesController::class, 'post'])->middleware(['auth', 'verified','admin'])->name('adminpost');
Route::get('/admin/post/add', [PostPagesController::class, 'add'])->middleware(['auth', 'verified','admin'])->name('addpost');
Route::get('/admin/post/view', [PostPagesController::class, 'view'])->middleware(['auth', 'verified','admin'])->name('viewpost');
Route::resource('/post', PostController::class);
Route::get('/post/{post_id}/edit', [PostController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('editpost');
Route::post('/post/{post_id}', [PostController::class, 'update'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('updatepost');
Route::get('/post/{post_id}/destroy', [PostController::class, 'destroy'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('destroypost');


//APPOINTMENT
Route::resource('/appointment', AppointmentController::class);

Route::put('/appointment/{appointment_id}/accept', [AppointmentController::class, 'accept'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.accept');

Route::put('/appointment/{appointment_id}/done', [AppointmentController::class, 'done'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.done');

Route::put('/appointment/{appointment_id}/cancel', [AppointmentController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('appointment.cancel');


//USERTYPE
Route::get('/admin/{id}/edit', [UsertypeController::class, 'edit'])
    ->middleware(['auth', 'verified','admin'])
    ->name('usertype-edit');
Route::put('/admin/{id}', [UsertypeController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('usertype-update');


//MANAGER
Route::get('/managerdashboard', [ManagerController::class, 'managerdashboard'])->middleware(['auth', 'verified','manager'])->name('managerdashboard');
Route::get('/managerappointments', [ManagerController::class, 'managerappointments'])->middleware(['auth', 'verified','manager'])->name('managerappointments');
Route::get('/managerpackages', [ManagerController::class, 'managerpackages'])->middleware(['auth', 'verified','manager'])->name('managerpackages');
Route::get('/managerreviews', [ManagerController::class, 'managerreviews'])->middleware(['auth', 'verified','manager'])->name('managerreviews');
Route::get('/managerchat', [ManagerController::class, 'managerchat'])->middleware(['auth', 'verified','manager'])->name('managerchat');
Route::get('/managerusers', [ManagerController::class, 'managerusers'])->middleware(['auth', 'verified','manager'])->name('managerusers');

//OWNER
Route::get('/ownerdashboard', [OwnerController::class, 'ownerdashboard'])->middleware(['auth', 'verified','owner'])->name('ownerdashboard');
Route::get('/ownercalendar', [OwnerController::class, 'ownercalendar'])->middleware(['auth', 'verified','owner'])->name('ownercalendar');
Route::get('/ownerbooking', [OwnerController::class, 'ownerbooking'])->middleware(['auth', 'verified','owner'])->name('ownerbooking');
Route::get('/ownerchat', [OwnerController::class, 'ownerchat'])->middleware(['auth', 'verified','owner'])->name('ownerchat');

//CLIENT
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified','user'])->name('dashboard');
Route::get('/chat', [UserController::class, 'chat'])->middleware(['auth', 'verified','user'])->name('chat');
Route::get('/aboutus', [UserController::class, 'aboutus'])->middleware(['auth', 'verified','user'])->name('aboutus');
Route::get('/faqs', [UserController::class, 'faqs'])->middleware(['auth', 'verified','user'])->name('faqs');
Route::get('/reviews', [UserController::class, 'reviews'])->middleware(['auth', 'verified','user'])->name('reviews');
Route::get('/events/data', [UserController::class, 'events'])->middleware(['auth', 'verified','user'])->name('events');
Route::get('/events', [UserController::class, 'eventsView'])->middleware(['auth', 'verified','user'])->name('eventsView');
Route::get('/book-form', [UserController::class, 'book'])->middleware(['auth', 'verified','user'])->name('book-form');
Route::get('/form', [UserController::class, 'form'])->middleware(['auth', 'verified','user'])->name('form');
Route::get('/idverify', [UserController::class, 'idverify'])->middleware(['auth', 'verified','user'])->name('idverify');
Route::get('/personal{id}', [UserController::class, 'personal'])->middleware(['auth', 'verified','user'])->name('personal');
Route::patch('/update-personal{id}', [UserController::class, 'update'])->middleware(['auth', 'verified','user'])->name('update-personal');

//VERIFY
Route::get('/verify/{id}/edit', [VerifyIdController::class, 'edit'])
    ->middleware(['auth', 'verified'])
    ->middleware('auth', 'admin')
    ->name('verify.edit');
    
Route::put('/verify/{id}', [VerifyIdController::class, 'update'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('verify.update');


require __DIR__.'/auth.php';
