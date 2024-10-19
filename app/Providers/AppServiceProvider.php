<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $unreadCount = 0;
        
            if (Auth::check()) {
                $user = Auth::user();
        
                // Check if the user's type is 'user'
                if ($user->usertype === 'user') {
                    // Count unread appointments
                    $unreadAppointmentsCount = $user->appointment()
                        ->where('isread', 'unread')
                        ->count();
        
                    // Check `verifyisread` and `submitisread` fields for the authenticated user
                    $unreadVerifyCount = ($user->verifyisread === 'unread') ? 1 : 0;
                    $unreadSubmitCount = ($user->submitisread === 'unread') ? 1 : 0;
        
                    // Total unread count
                    $unreadCount = $unreadAppointmentsCount + $unreadVerifyCount + $unreadSubmitCount;
                }

                // Check if the user's type is 'admin'
                elseif ($user->usertype === 'admin') {

                    $unreadAppointmentsCount = \App\Models\Appointment::where('isadminread', 'unread')->count();

                    // Count rows in the users table where `submitisadminread` is "unread" and `verifystatus` is "unverified"
                    $unreadAdminCount = \App\Models\User::where('submitisadminread', 'unread')
                        ->where('usertype', 'user')
                        ->where('verifystatus', 'unverified')
                        ->count();

                    // Set unread count for admin
                    $unreadCount = $unreadAppointmentsCount + $unreadAdminCount;
                }

                // Check if the user's type is 'manager'
                elseif ($user->usertype === 'manager') {

                    // Count all appointments where `ismanagerread` is "unread"
                    $unreadAppointmentsCount = \App\Models\Appointment::where('ismanagerread', 'unread')->count();


                    // Count rows in the users table where `submitisadminread` is "unread" and `verifystatus` is "unverified"
                    $unreadAdminCount = \App\Models\User::where('submitismanagerread', 'unread')
                        ->where('usertype', 'user')
                        ->where('verifystatus', 'unverified')
                        ->count();

                    // Set unread count for admin
                    $unreadCount = $unreadAppointmentsCount + $unreadAdminCount;
                }
            }
        
            $view->with('unreadCount', $unreadCount);
        });

        // Add a new View Composer for chat unread counter
        View::composer('*', function ($view) {
            $unreadChatCount = 0;

            if (Auth::check()) {
                $user = Auth::user();

                // Check if the user's type is "user"
                if ($user->usertype === 'user') {
                    // Count unread messages where receiver_id is the authenticated user's ID and receiverisread is "unread"
                    $unreadChatCount = \App\Models\Message::where('receiver_id', $user->id)
                        ->where('receiverisread', 'unread')
                        ->count();
                }
            }

            // Pass the unread chat count to all views
            $view->with('unreadChatCount', $unreadChatCount);
        });
        
        Paginator::useBootstrap();
    }
}
