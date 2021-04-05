<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/{page}', 'AdminController@index');
Route::get('/', function () {
    return view('login');
})->name('login');
Route::post('migration/user-migration', 'MigrationController@userMigration');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    //Dashboard Controller Routes
    Route::get('/dashboard', 'DashboardController@getDashboard');
    Route::get('/getTicketsGraphData', 'DashboardController@getGraphData');
    //Users Controller Routes
    Route::get('/users', 'AdminUserController@index');
    Route::get('/add-user', 'AdminUserController@addUserIndex');
    Route::get('/user/{id}', 'AdminUserController@userIndex');
    Route::get('/update-user/{id}', 'AdminUserController@updateUserIndex');

    Route::get('/getUsers', 'AdminUserController@getUsers');
    Route::get('/getUser/{id}', 'AdminUserController@getUser');
    Route::get('/getOrganizationUsers/{organizationId}', 'AdminUserController@getOrganizationUsers');
    Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
    Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
    Route::get('/updateUserStatus/{userId}', 'AdminUserController@updateUserStatus');
    Route::get('/updateEmailStatus/{id}', 'AdminUserController@updateEmailStatus');
    Route::get('/login-from-user/{id}', 'AdminUserController@loginFromUser');

    Route::post('/create-user', 'AdminUserController@createUser');
    Route::post('/edit-user/{id}', 'AdminUserController@editUser');
    Route::post('/delete-user/{id}', 'AdminUserController@deleteUser');
    Route::post('/reset-password/{id}', 'AdminUserController@resetUserPassword');

    //Organization Controller Routes
    Route::get('/organizations', 'OrganizationController@index');
    Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
    Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
    Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

    Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
    Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
    Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');
    Route::get('/updateOrganizationStatus/{id}', 'OrganizationController@updateOrganizationStatus');

    Route::post('/create-organization', 'OrganizationController@createOrganization');
    Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
    Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');

    //Role Controller Routes
    Route::get('/roles', 'RoleController@index');
    Route::get('/add-role', 'RoleController@addRoleIndex');
    Route::get('/update-role/{id}', 'RoleController@updateRoleIndex');
    Route::get('/role/{id}', 'RoleController@roleIndex');

    Route::get('/getRoles', 'RoleController@getRoles');
    Route::get('/getRole/{id}', 'RoleController@getRole');

    Route::post('/create-role', 'RoleController@createRole');
    Route::post('/edit-role/{id}', 'RoleController@editRole');
    Route::post('/delete-role/{id}', 'RoleController@deleteRole');


    //Ticket Controller Routes
    Route::get('/tickets', 'TicketsController@index');
    Route::get('/add-ticket', 'TicketsController@addTicketIndex');
    Route::get('/ticket/{ticketId}', 'TicketsController@ticketIndex');
    Route::get('/update-ticket/{ticketId}', 'TicketsController@updatedTicketIndex');

    Route::get('/getTickets', 'TicketsController@getTickets');
    Route::get('/removeAttachment/{attachmentId}', 'TicketsController@removeAttachment');

    Route::post('/create-ticket', 'TicketsController@createTicket');
    Route::post('/edit-ticket/{editTicket}', 'TicketsController@editTicket');
    Route::post('/delete-ticket/{editTicket}', 'TicketsController@deleteTicket');

    //Ticket Attachment Controller Routes
    Route::get('/ticket-attachment', 'TicketAttachmentController@index');

    Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
    Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');
    Route::get('/deleteAttachment/{attachmentID}', 'TicketAttachmentController@deleteAttachment');

    Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');

    //Reports Controller Routes
    Route::get('/reports', 'ReportsController@index');
    Route::get('/getTicketSummary', 'ReportsController@getTicketSummary');
    Route::get('/getOrganizationSummary', 'ReportsController@getOrganizationSummary');
    Route::get('/getUsersRawData', 'ReportsController@getUsersRawData');


    //Ticket Controller Routes
    Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');
    // FileAttachmentController Routes
    Route::post('/attachFiles', 'FileAttachmentController@uploadFile');


    //Discussion Controller Routes
    Route::post('/create-discussion/{ticketId}', 'DiscussionController@createDiscussion');
    Route::get('/changeMessageStatus/{messageId}', 'DiscussionController@changeMessageStatus');
});
// Route::group(['middleware' => ['auth', 'admin']], function () {
//     //Dashboard Controller Routes
//     Route::get('/dashboard', 'Admin\DashboardController@getDashboard');
//     Route::get('/getTicketsGraphData', 'Admin\DashboardController@getGraphData');

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');


//     //Ticket Controller Routes
//     Route::get('/tickets', 'TicketsController@index');
//     Route::get('/add-ticket', 'TicketsController@addTicketIndex');
//     Route::get('/ticket/{ticketId}', 'TicketsController@ticketIndex');
//     Route::get('/update-ticket/{ticketId}', 'TicketsController@updatedTicketIndex');

//     Route::get('/getTickets', 'TicketsController@getTickets');
//     Route::get('/removeAttachment/{attachmentId}', 'TicketsController@removeAttachment');

//     Route::post('/create-ticket', 'TicketsController@createTicket');
//     Route::post('/edit-ticket/{editTicket}', 'TicketsController@editTicket');
//     Route::post('/delete-ticket/{editTicket}', 'TicketsController@deleteTicket');

//     //Ticket Attachment Controller Routes
//     Route::get('/ticket-attachment', 'TicketAttachmentController@index');

//     Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
//     Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');

//     Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');


//     //Email Controller Routes
//     Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');

//     // FileAttachmentController Routes
//     Route::post('/attachFiles', 'FileAttachmentController@uploadFile');

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
//     Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
//     Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
//     Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');

//     Route::post('/create-organization', 'OrganizationController@createOrganization');
//     Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
//     Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');


//     //Raw Data
//     Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
// });
// Route::group(['middleware' => ['auth', 'personnelAdmin']], function () {

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
//     Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
//     Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
//     Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');

//     Route::post('/create-organization', 'OrganizationController@createOrganization');
//     Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
//     Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');
//     //Dashboard Controller Routes
//     Route::get('/dashboard', 'PersonnelAdmin\DashboardController@getDashboard');
//     Route::get('/getTicketsGraphData', 'PersonnelAdmin\DashboardController@getGraphData');
//     //Users Controller Routes
//     Route::get('/users', 'PersonnelAdmin\UserController@index');
//     Route::get('/add-user', 'PersonnelAdmin\UserController@addUserIndex');
//     Route::get('/user/{id}', 'PersonnelAdmin\UserController@userIndex');
//     Route::get('/update-user/{id}', 'PersonnelAdmin\UserController@updateUserIndex');

//     Route::get('/getUsers', 'PersonnelAdmin\UserController@getUsers');
//     Route::get('/getUser/{id}', 'PersonnelAdmin\UserController@getUser');
//     Route::get('/getOrganizationUsers/{organizationId}', 'PersonnelAdmin\UserController@getOrganizationUsers');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'PersonnelAdmin\UserController@getOrganizationUsersRawData');
//     Route::get('/getPersonnelRawData', 'PersonnelAdmin\UserController@getPersonnelRawData');

//     Route::post('/create-user', 'PersonnelAdmin\UserController@createUser');
//     Route::post('/edit-user/{id}', 'PersonnelAdmin\UserController@editUser');
//     Route::post('/delete-user/{id}', 'PersonnelAdmin\UserController@deleteUser');


//     //Ticket Controller Routes
//     Route::get('/tickets', 'PersonnelAdmin\TicketController@index');
//     Route::get('/add-ticket', 'PersonnelAdmin\TicketController@addTicketIndex');
//     Route::get('/ticket/{ticketId}', 'PersonnelAdmin\TicketController@ticketIndex');
//     Route::get('/update-ticket/{ticketId}', 'PersonnelAdmin\TicketController@updatedTicketIndex');

//     Route::get('/getTickets', 'PersonnelAdmin\TicketController@getTickets');
//     Route::get('/removeAttachment/{attachmentId}', 'PersonnelAdmin\TicketController@removeAttachment');

//     Route::post('/create-ticket', 'PersonnelAdmin\TicketController@createTicket');
//     Route::post('/edit-ticket/{editTicket}', 'PersonnelAdmin\TicketController@editTicket');
//     Route::post('/delete-ticket/{editTicket}', 'PersonnelAdmin\TicketController@deleteTicket');

//     //Ticket Controller Routes
//     Route::get('/ticket-attachment', 'TicketAttachmentController@index');

//     Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
//     Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');

//     Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');

//     //Reports Controller Routes
//     Route::get('/reports', 'ReportsController@index');
//     Route::get('/getTicketSummary', 'ReportsController@getTicketSummary');
//     Route::get('/getOrganizationSummary', 'ReportsController@getOrganizationSummary');


//     //Ticket Controller Routes
//     Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');

//     // FileAttachmentController Routes
//     Route::post('/attachFiles', 'FileAttachmentController@uploadFile');

//     //Raw Data
//     Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
// });
// Route::group(['middleware' => ['auth', 'personnel']], function () {

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
//     Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
//     Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
//     Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');

//     Route::post('/create-organization', 'OrganizationController@createOrganization');
//     Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
//     Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');
//     //Dashboard Controller Routes
//     Route::get('/dashboard', 'personnel\DashboardController@getDashboard');
//     Route::get('/getTicketsGraphData', 'personnel\DashboardController@getGraphData');


//     //Ticket Controller Routes
//     Route::get('/tickets', 'PersonnelAdmin\TicketController@index');
//     Route::get('/add-ticket', 'PersonnelAdmin\TicketController@addTicketIndex');
//     Route::get('/ticket/{ticketId}', 'PersonnelAdmin\TicketController@ticketIndex');
//     Route::get('/update-ticket/{ticketId}', 'PersonnelAdmin\TicketController@updatedTicketIndex');

//     Route::get('/getTickets', 'PersonnelAdmin\TicketController@getTickets');
//     Route::get('/removeAttachment/{attachmentId}', 'PersonnelAdmin\TicketController@removeAttachment');

//     Route::post('/create-ticket', 'PersonnelAdmin\TicketController@createTicket');
//     Route::post('/edit-ticket/{editTicket}', 'PersonnelAdmin\TicketController@editTicket');
//     Route::post('/delete-ticket/{editTicket}', 'PersonnelAdmin\TicketController@deleteTicket');

//     //Ticket Controller Routes
//     Route::get('/ticket-attachment', 'TicketAttachmentController@index');

//     Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
//     Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');

//     Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');

//     //Ticket Controller Routes
//     Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');

//     // FileAttachmentController Routes
//     Route::post('/attachFiles', 'FileAttachmentController@uploadFile');

//     //Raw Data
//     Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
// });
// Route::group(['middleware' => ['auth', 'firmaAdmin']], function () {

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
//     Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
//     Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
//     Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');

//     Route::post('/create-organization', 'OrganizationController@createOrganization');
//     Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
//     Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');
//     //Dashboard Controller Routes
//     Route::get('/dashboard', 'FirmaAdmin\DashboardController@getDashboard');
//     Route::get('/getTicketsGraphData', 'FirmaAdmin\DashboardController@getGraphData');


//     //Ticket Controller Routes
//     Route::get('/tickets', 'FirmaAdmin\TicketController@index');
//     Route::get('/add-ticket', 'FirmaAdmin\TicketController@addTicketIndex');
//     Route::get('/ticket/{ticketId}', 'FirmaAdmin\TicketController@ticketIndex');
//     Route::get('/update-ticket/{ticketId}', 'FirmaAdmin\TicketController@updatedTicketIndex');

//     Route::get('/getTickets', 'FirmaAdmin\TicketController@getTickets');
//     Route::get('/removeAttachment/{attachmentId}', 'FirmaAdmin\TicketController@removeAttachment');

//     Route::post('/create-ticket', 'FirmaAdmin\TicketController@createTicket');
//     Route::post('/edit-ticket/{editTicket}', 'FirmaAdmin\TicketController@editTicket');
//     Route::post('/delete-ticket/{editTicket}', 'FirmaAdmin\TicketController@deleteTicket');


//     //Users Controller Routes
//     Route::get('/users', 'FirmaAdmin\UserController@index');
//     Route::get('/add-user', 'FirmaAdmin\UserController@addUserIndex');
//     Route::get('/user/{id}', 'FirmaAdmin\UserController@userIndex');
//     Route::get('/update-user/{id}', 'FirmaAdmin\UserController@updateUserIndex');

//     Route::get('/getUsers', 'FirmaAdmin\UserController@getUsers');
//     Route::get('/getUser/{id}', 'FirmaAdmin\UserController@getUser');
//     Route::get('/getOrganizationUsers/{organizationId}', 'FirmaAdmin\UserController@getOrganizationUsers');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'FirmaAdmin\UserController@getOrganizationUsersRawData');
//     Route::get('/getPersonnelRawData', 'FirmaAdmin\UserController@getPersonnelRawData');

//     Route::post('/create-user', 'FirmaAdmin\UserController@createUser');
//     Route::post('/edit-user/{id}', 'FirmaAdmin\UserController@editUser');
//     Route::post('/delete-user/{id}', 'FirmaAdmin\UserController@deleteUser');

//     //Ticket Attachment Controller Routes
//     Route::get('/ticket-attachment', 'TicketAttachmentController@index');

//     Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
//     Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');

//     Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');

//     //Ticket Controller Routes
//     Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');

//     // FileAttachmentController Routes
//     Route::post('/attachFiles', 'FileAttachmentController@uploadFile');

//     //Raw Data
//     Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
// });
// Route::group(['middleware' => ['auth', 'firmaUser']], function () {

//     //Organization Controller Routes
//     Route::get('/organizations', 'OrganizationController@index');
//     Route::get('/add-organization', 'OrganizationController@addOrganizationIndex');
//     Route::get('/organization/{id}', 'OrganizationController@organizationIndex');
//     Route::get('/update-organization/{id}', 'OrganizationController@updateOrganizationIndex');

//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
//     Route::get('/getOrganizations', 'OrganizationController@getOrganizations');
//     Route::get('/getOrganization/{id}', 'OrganizationController@getOrganization');

//     Route::post('/create-organization', 'OrganizationController@createOrganization');
//     Route::post('/edit-organization/{id}', 'OrganizationController@editOrganization');
//     Route::post('/delete-organization/{id}', 'OrganizationController@deleteOrganization');
//     //Dashboard Controller Routes
//     Route::get('/dashboard', 'FirmaUser\DashboardController@getDashboard');
//     Route::get('/getTicketsGraphData', 'FirmaUser\DashboardController@getGraphData');


//     //Ticket Controller Routes
//     Route::get('/tickets', 'FirmaUser\TicketController@index');
//     Route::get('/add-ticket', 'FirmaUser\TicketController@addTicketIndex');
//     Route::get('/ticket/{ticketId}', 'FirmaUser\TicketController@ticketIndex');
//     Route::get('/update-ticket/{ticketId}', 'FirmaUser\TicketController@updatedTicketIndex');

//     Route::get('/getTickets', 'FirmaUser\TicketController@getTickets');
//     Route::get('/removeAttachment/{attachmentId}', 'FirmaUser\TicketController@removeAttachment');

//     Route::post('/create-ticket', 'FirmaUser\TicketController@createTicket');
//     Route::post('/edit-ticket/{editTicket}', 'FirmaUser\TicketController@editTicket');
//     Route::post('/delete-ticket/{editTicket}', 'FirmaUser\TicketController@deleteTicket');


//     //Ticket Attachment Controller Routes
//     Route::get('/ticket-attachment', 'TicketAttachmentController@index');
//     Route::get('/getTicketAttachments', 'TicketAttachmentController@getTicketAttachments');
//     Route::get('/ticket-attachment/{ticketId}', 'TicketAttachmentController@getTicketAttachment');
//     Route::get('/addAttachment/{ticketId}', 'TicketAttachmentController@addAttachment');

//     //Ticket Controller Routes
//     Route::get('/send-update/{ticketId}', 'MailController@sendUpdate');

//     // FileAttachmentController Routes
//     Route::post('/attachFiles', 'FileAttachmentController@uploadFile');

//     //Raw Data
//     Route::get('/getPersonnelRawData', 'AdminUserController@getPersonnelRawData');
//     Route::get('/getOrganizationUsersRawData/{organizationId}', 'AdminUserController@getOrganizationUsersRawData');
//     Route::get('/getOrganizationsRawData', 'OrganizationController@getOrganizationsRawData');
// });
