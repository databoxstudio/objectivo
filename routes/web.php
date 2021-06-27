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



Route::get('/', function () {

    return redirect(route('login'));

});



Auth::routes();



Route::get('/home', 'HomeController@index')->name('home');



Route::namespace('CoreModule')->prefix('coreModule')->middleware(['auth'])->name('coreModule.')->group(function () {



Route::get('/emailmanagement','AdministrativeSettingsController@emailmanagement')->name('administrativeSettings.emailmanagement');

Route::get('/deliverytypes','AdministrativeSettingsController@deliverytypes')->name('administrativeSettings.deliverytypes');

Route::get('/adddeliverytype','AdministrativeSettingsController@adddeliverytype')->name('administrativeSettings.adddeliverytype');

Route::post('/createdeliverytype','AdministrativeSettingsController@createdeliverytype')->name('administrativeSettings.createdeliverytype');

Route::get('/editdeliverytype/{id}','AdministrativeSettingsController@editdeliverytype')->name('administrativeSettings.editdeliverytype');

Route::post('/updatedeliverytype','AdministrativeSettingsController@updatedeliverytype')->name('administrativeSettings.updatedeliverytype');

Route::get('/deletedeliverytype/{id}','AdministrativeSettingsController@deletedeliverytype')->name('administrativeSettings.deletedeliverytype');



Route::get('/warehouses','AdministrativeSettingsController@warehouses')->name('administrativeSettings.warehouses');

Route::get('/addwarehouse','AdministrativeSettingsController@addwarehouse')->name('administrativeSettings.addwarehouse');

Route::post('/createwarehouse','AdministrativeSettingsController@createwarehouse')->name('administrativeSettings.createwarehouse');

Route::get('/editwarehouse/{id}','AdministrativeSettingsController@editwarehouse')->name('administrativeSettings.editwarehouse');

Route::post('/updatewarehouse','AdministrativeSettingsController@updatewarehouse')->name('administrativeSettings.updatewarehouse');

Route::get('/deletewarehouse/{id}','AdministrativeSettingsController@deletewarehouse')->name('administrativeSettings.deletewarehouse');





Route::get('/banks','AdministrativeSettingsController@banks')->name('administrativeSettings.banks');

Route::get('/addbank','AdministrativeSettingsController@addbank')->name('administrativeSettings.addbank');

Route::post('/createbank','AdministrativeSettingsController@createbank')->name('administrativeSettings.createbank');

Route::get('/editbank/{id}','AdministrativeSettingsController@editbank')->name('administrativeSettings.editbank');

Route::post('/updatebank','AdministrativeSettingsController@updatebank')->name('administrativeSettings.updatebank');

Route::get('/deletebank/{id}','AdministrativeSettingsController@deletebank')->name('administrativeSettings.deletebank');



Route::get('/get-cities','AdministrativeSettingsController@getCities')->name('administrativeSettings.getCities');


});





/*

    UserModule

*/

Route::namespace('UsersModule')->prefix('UsersModule')->middleware(['auth'])->name('usersModule.')->group(function () {

    

     // UserModule         



     Route::get('/users','UsersController@index')->name('users');

     Route::get('/users/create','UsersController@create')->name('create');

     Route::post('/users/save','UsersController@save')->name('save');

     Route::get('/users/edit/{id}','UsersController@edit')->name('edit');

     Route::post('/users/update','UsersController@update')->name('update');

     

     Route::get('/users/editprofile','UsersController@editprofile')->name('editprofile');

     Route::post('/users/updateprofile','UsersController@updateprofile')->name('updateprofile');

     

     Route::get('/users/view/{id}','UsersController@view')->name('view');



         Route::get('/users/assignagent','UsersController@assignagent')->name('assignagent');

Route::post('/users/assignagentaction','UsersController@assignagentaction')->name('assignagentaction');



   





         Route::get('/changePassword','UsersController@changePassword')->name('changePassword');

     Route::post('/changeAdminPassword','UsersController@changeAdminPassword')->name('changeAdminPassword');





      

  

});



/*

    agentsModule

*/

Route::namespace('AgentsModule')->prefix('AgentsModule')->middleware(['auth'])->name('agentsModule.')->group(function () {

    

     // UserModule         



     Route::get('/agents','AgentController@index')->name('agents');

     Route::get('/agents/create','AgentController@create')->name('create');

     Route::post('/agents/save','AgentController@save')->name('save');

     Route::get('/agents/edit/{id}','AgentController@edit')->name('edit');

     Route::post('/agents/update','AgentController@update')->name('update');

     Route::get('/agents/view/{id}','AgentController@view')->name('view');

     

     Route::get('/agents/blacklistedDa','AgentController@blacklistedDa')->name('blacklistedDa');

     

     Route::get('/agents/delete/{id}','AgentController@delete')->name('delete');

     

     Route::get('/agents/enable/{id}','AgentController@enable')->name('enable');

     Route::get('/agents/blacklist/{id}','AgentController@blacklist')->name('blacklist');



            Route::get('/agents/exportAgents','AgentController@exportAgents')->name('exportAgents');




});



/*

    supervisors Module

*/

Route::namespace('SupervisorsModule')->prefix('SupervisorsModule')->middleware(['auth'])->name('supervisorsModule.')->group(function () {

    

     // UserModule         



     Route::get('/supervisors','SupervisorController@index')->name('supervisors');

     Route::get('/supervisors/create','SupervisorController@create')->name('create');

     Route::post('/supervisors/save','SupervisorController@save')->name('save');

     Route::get('/supervisors/edit/{id}','SupervisorController@edit')->name('edit');

     Route::post('/supervisors/update','SupervisorController@update')->name('update');

     Route::get('/supervisors/view/{id}','SupervisorController@view')->name('view');

     Route::get('/supervisors/delete/{id}','SupervisorController@delete')->name('delete');

          Route::get('/supervisors/exportSupervisor','SupervisorController@exportSupervisor')->name('exportSupervisor');



});



/*

    Reports Module

*/

Route::namespace('ReportsModule')->prefix('ReportsModule')->middleware(['auth'])->name('reportsModule.')->group(function () {

    

     // ReportModule         



     Route::get('/dailydeliveryreport','ReportController@dailydeliveryreport')->name('dailydeliveryreport');

     Route::get('/viewdailyreport','ReportController@viewdailyreport')->name('viewdailyreport');

     

     Route::get('/weeklydeliveryreport','ReportController@weeklydeliveryreport')->name('weeklydeliveryreport');

     Route::get('/cosolreportofda','ReportController@cosolreportofda')->name('cosolreportofda');

     Route::get('/dawiseloginhr','ReportController@dawiseloginhr')->name('dawiseloginhr');

 Route::get('/exportweeklyReport', 'ReportController@exportweeklyReport')->name('exportweeklyReport');



});



/*

    ManagePages

*/

Route::namespace('PagesModule')->prefix('PagesModule')->middleware(['auth'])->name('pagesModule.')->group(function () {

    

     // ManagePages         



     Route::get('/managepages','PagesModuleController@index')->name('managepages');



     Route::get('/managepages/create','PagesModuleController@create')->name('create');

     Route::post('/managepages/add','PagesModuleController@add')->name('add');



     Route::get('/managepages/edit/{id}','PagesModuleController@edit')->name('edit');

     Route::post('/managepages/update','PagesModuleController@update')->name('update');

     

      

  

});

Route::get('changepassword', function() {
    $user = App\User::where('email', 'dheeraj.malik@gmail.com')->first();
    $user->password = Hash::make('123456');
    $user->save();
 
    echo 'Password changed successfully.';
});