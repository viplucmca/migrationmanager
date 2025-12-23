<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRM\ApplicationsController;
use App\Http\Controllers\CRM\OfficeVisitController;
// OLD APPOINTMENT CONTROLLER REMOVED - AppointmentsController deleted
// use App\Http\Controllers\CRM\AppointmentsController;
use App\Http\Controllers\CRM\BookingAppointmentsController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Applications, Office Visits & Appointments Routes
|--------------------------------------------------------------------------
|
| All routes for visa application management, office visit tracking,
| and appointment scheduling functionality.
|
| Prefix: None (routes at root level)
| Middleware: auth:admin (inherited from web.php)
|
*/

/*---------- Applications Management ----------*/
Route::get('/applications', [ApplicationsController::class, 'index'])->name('applications.index');
Route::get('/applications/create', [ApplicationsController::class, 'create'])->name('applications.create');
Route::get('/applications/detail/{id}', [ApplicationsController::class, 'detail'])->name('applications.detail');
Route::post('/applications-import', [ApplicationsController::class, 'import'])->name('applications.import');

/*---------- Application Operations ----------*/
Route::get('/getapplicationdetail', [ApplicationsController::class, 'getapplicationdetail']);
Route::post('/load-application-insert-update-data', [ApplicationsController::class, 'loadApplicationInsertUpdateData']);
Route::get('/updatestage', [ApplicationsController::class, 'updatestage']);
Route::get('/completestage', [ApplicationsController::class, 'completestage']);
Route::get('/updatebackstage', [ApplicationsController::class, 'updatebackstage']);
Route::get('/get-applications-logs', [ApplicationsController::class, 'getapplicationslogs']);
Route::get('/get-applications', [ApplicationsController::class, 'getapplications']);

Route::post('/discontinue_application', [ApplicationsController::class, 'discontinue_application']);
Route::post('/revert_application', [ApplicationsController::class, 'revert_application']);

/*---------- Application Notes & Communication ----------*/
Route::post('/create-app-note', [ApplicationsController::class, 'addNote']);
Route::get('/getapplicationnotes', [ApplicationsController::class, 'getapplicationnotes']);
Route::post('/application-sendmail', [ApplicationsController::class, 'applicationsendmail']);

/*---------- Application Messages (Client Portal) ----------*/
Route::get('/clients/matter-messages', [ApplicationsController::class, 'getMatterMessages'])->name('clients.matter-messages');
Route::post('/clients/send-message', [ApplicationsController::class, 'sendMessageToClient'])->name('clients.send-message');

/*---------- Broadcasting Auth ----------*/
// Broadcasting authentication is handled by Laravel's built-in BroadcastServiceProvider
// Channel authorization is defined in routes/channels.php
// The /broadcasting/auth route is automatically registered by Broadcast::routes()

/*---------- Application Updates ----------*/
Route::get('/application/updateintake', [ApplicationsController::class, 'updateintake']);
Route::get('/application/updatedates', [ApplicationsController::class, 'updatedates']);
Route::get('/application/updateexpectwin', [ApplicationsController::class, 'updateexpectwin']);
Route::get('/application/getapplicationbycid', [ApplicationsController::class, 'getapplicationbycid']);

/*---------- Application Agents ----------*/
Route::post('/application/spagent_application', [ApplicationsController::class, 'spagent_application']);
Route::post('/application/sbagent_application', [ApplicationsController::class, 'sbagent_application']);
Route::post('/application/application_ownership', [ApplicationsController::class, 'application_ownership']);
Route::get('/superagent', [ApplicationsController::class, 'superagent']);
Route::get('/subagent', [ApplicationsController::class, 'subagent']);

/*---------- Application Fees ----------*/
Route::post('/applicationsavefee', [ApplicationsController::class, 'applicationsavefee']);

/*---------- Application Documents ----------*/
Route::get('/application/export/pdf/{id}', [ApplicationsController::class, 'exportapplicationpdf']);
Route::post('/add-checklists', [ApplicationsController::class, 'addchecklists']);
Route::post('/application/checklistupload', [ApplicationsController::class, 'checklistupload']);
Route::get('/deleteapplicationdocs', [ApplicationsController::class, 'deleteapplicationdocs']);
Route::get('/application/publishdoc', [ApplicationsController::class, 'publishdoc']);
Route::post('/application/approve-document', [ApplicationsController::class, 'approveDocument']);
Route::post('/application/reject-document', [ApplicationsController::class, 'rejectDocument']);
Route::get('/application/download-document', [ApplicationsController::class, 'downloadDocument']);

/*---------- Migration Index ----------*/
Route::get('/migration', [ApplicationsController::class, 'migrationindex'])->name('migration.index');

/*
|--------------------------------------------------------------------------
| Office Visits Management
|--------------------------------------------------------------------------
*/

Route::get('/office-visits', [OfficeVisitController::class, 'index'])->name('officevisits.index');
Route::get('/office-visits/waiting', [OfficeVisitController::class, 'waiting'])->name('officevisits.waiting');
Route::get('/office-visits/attending', [OfficeVisitController::class, 'attending'])->name('officevisits.attending');
Route::get('/office-visits/completed', [OfficeVisitController::class, 'completed'])->name('officevisits.completed');
Route::get('/office-visits/archived', [OfficeVisitController::class, 'archived'])->name('officevisits.archived');
Route::get('/office-visits/create', [OfficeVisitController::class, 'create'])->name('officevisits.create');

/*---------- Office Visit Operations ----------*/
Route::post('/checkin', [OfficeVisitController::class, 'checkin']);
Route::get('/get-checkin-detail', [OfficeVisitController::class, 'getcheckin']);
Route::post('/update_visit_purpose', [OfficeVisitController::class, 'update_visit_purpose']);
Route::post('/update_visit_comment', [OfficeVisitController::class, 'update_visit_comment']);
Route::post('/attend_session', [OfficeVisitController::class, 'attend_session']);
Route::post('/complete_session', [OfficeVisitController::class, 'complete_session']);
Route::get('/office-visits/change_assignee', [OfficeVisitController::class, 'change_assignee']);

/*
|--------------------------------------------------------------------------
| OLD APPOINTMENT SYSTEM REMOVED
|--------------------------------------------------------------------------
| All routes for the old appointment booking system have been removed.
| The old AppointmentsController has been deleted.
| 
| Use the new booking system at /booking/appointments instead.
|
*/

/*---------- OLD APPOINTMENT ROUTES - ALL REMOVED ----------*/
// Route::resource('appointments', AppointmentsController::class);
// Route::get('/appointments-education', [AppointmentsController::class, 'appointmentsEducation']);
// Route::get('/appointments-jrp', [AppointmentsController::class, 'appointmentsJrp']);
// Route::get('/appointments-tourist', [AppointmentsController::class, 'appointmentsTourist']);
// Route::get('/appointments-others', [AppointmentsController::class, 'appointmentsOthers']);
// Route::get('/appointments-adelaide', [AppointmentsController::class, 'appointmentsAdelaide']);
// Route::get('/deleteappointment', [AppointmentsController::class, 'deleteappointment']);
// Route::post('/add-appointment', [AppointmentsController::class, 'addAppointment']);
// Route::post('/add-appointment-book', [AppointmentsController::class, 'addAppointmentBook']);
// Route::post('/editappointment', [AppointmentsController::class, 'editappointment']);
// Route::post('/updatefollowupschedule', [AppointmentsController::class, 'updatefollowupschedule']);
// Route::get('/updateappointmentstatus/{status}/{id}', [AppointmentsController::class, 'updateappointmentstatus']);
// Route::post('/update_appointment_status', [AppointmentsController::class, 'update_appointment_status']);
// Route::post('/update_appointment_priority', [AppointmentsController::class, 'update_appointment_priority']);
// Route::post('/update_apppointment_comment', [AppointmentsController::class, 'update_apppointment_comment']);
// Route::post('/update_apppointment_description', [AppointmentsController::class, 'update_apppointment_description']);
// Route::get('/get-appointments', [AppointmentsController::class, 'getAppointments']);
// Route::get('/getAppointmentdetail', [AppointmentsController::class, 'getAppointmentdetail']);
// Route::get('/get-assigne-detail', [AppointmentsController::class, 'assignedetail']);
// Route::get('/change_assignee', [AppointmentsController::class, 'change_assignee']);
// Route::post('/getdatetimebackend', [AppointmentsController::class, 'getDateTimeBackend']);
// Route::post('/getdisableddatetime', [AppointmentsController::class, 'getDisabledDateTime']);

/*
|--------------------------------------------------------------------------
| Website Booking Appointments (Synced from Bansal Website)
|--------------------------------------------------------------------------
|
| Routes for managing appointments synced from the Bansal Immigration
| public website. This is a separate system from manual appointments.
|
*/

Route::controller(BookingAppointmentsController::class)
    ->prefix('booking')
    ->name('booking.')
    ->group(function () {
        
        // Appointment List & Views
        Route::get('/appointments', 'index')->name('appointments.index');
        Route::get('/appointments/{id}/edit', 'edit')
            ->name('appointments.edit')
            ->whereNumber('id');
        Route::put('/appointments/{id}', 'update')
            ->name('appointments.update')
            ->whereNumber('id');
        
        // Appointment Detail
        Route::get('/appointments/{id}', 'show')
            ->name('appointments.show')
            ->whereNumber('id');
        
        // Get appointment as JSON (for modals/AJAX)
        Route::get('/appointments/{id}/json', 'getAppointmentJson')
            ->name('appointments.json')
            ->whereNumber('id');
        
        // Calendar Views (by type)
        Route::get('/calendar/{type}', 'calendar')
            ->name('appointments.calendar')
            ->whereIn('type', ['paid', 'jrp', 'education', 'tourist', 'adelaide']);
        
        // Update Actions
        Route::post('/appointments/{id}/update-status', 'updateStatus')
            ->name('appointments.update-status')
            ->whereNumber('id');
        
        Route::post('/appointments/{id}/update-consultant', 'updateConsultant')
            ->name('appointments.update-consultant')
            ->whereNumber('id');
        
        Route::post('/appointments/{id}/update-datetime', 'update')
            ->name('appointments.update-datetime')
            ->whereNumber('id');
        
        Route::post('/appointments/{id}/add-note', 'addNote')
            ->name('appointments.add-note')
            ->whereNumber('id');
        
        Route::post('/appointments/{id}/update-followup', 'updateFollowUp')
            ->name('appointments.update-followup')
            ->whereNumber('id');
        
        Route::post('/appointments/{id}/send-reminder', 'sendReminder')
            ->name('appointments.send-reminder')
            ->whereNumber('id');
        
        // Bulk Actions
        Route::post('/appointments/bulk-update-status', 'bulkUpdateStatus')
            ->name('appointments.bulk-update-status');
        
        // Export
        Route::get('/appointments/export', 'export')
            ->name('appointments.export');
        
        // Sync Management
        Route::get('/sync/dashboard', 'syncDashboard')
            ->name('sync.dashboard');
        
        Route::get('/sync/stats', 'syncStats')
            ->name('sync.stats');
        
        Route::post('/sync/manual', 'manualSync')
            ->name('sync.manual')
            ->middleware('can:trigger-manual-sync');
        
        // API endpoints for datatables
        Route::get('/api/appointments', 'getAppointments')
            ->name('api.appointments');
    });

