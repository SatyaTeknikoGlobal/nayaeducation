<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
use Artisan;
// use App\Http\Controllers\Admin\FacultyController;

use Stichoza\GoogleTranslate\GoogleTranslate;


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





// Route::get('/', function () {
//     return view('welcome');
// });

//Route::any('/', 'HomeController@index');
///////////////////////////////////SADMIN/////////////////////////////////////////

// $SADMIN_ROUTE_NAME = CustomHelper::getSadminRouteName();

Route::get('phpartisan', function(){
    $cmd = request('cmd');
    if(!empty($cmd)){
        $exitCode = Artisan::call("$cmd");
    }
});
Route::get('/language/{lang}','LanguageController@setLanguage')->name('lang');



Route::get('/translate', function () {
    $lang = new GoogleTranslate('en');
    return $lang->setSource('en')->setTarget('or')->translate("Hello World!....");

});





// Route::match(['get', 'post'], 'sadmin/login', 'Sadmin\LoginController@index')->name('sadmin.login');


Route::match(['get', 'post'], 'get_city', 'Admin\HomeController@get_city')->name('get_city');





////////////////////////////////////////ADMIN//////////////////////////////////////////

Route::match(['get', 'post'], '/user-logout', 'Auth\LoginController@logout');


$ADMIN_ROUTE_NAME = CustomHelper::getAdminRouteName();


/////Login
Route::match(['get', 'post'], 'admin/login', 'Admin\LoginController@index');

Route::match(['get', 'post'], 'admin/logout', 'Admin\LoginController@logout');

/////Register


Route::match(['get', 'post'], 'admin/register', 'Admin\LoginController@register')->name('admin.register');


/////Forgot Password
Route::match(['get', 'post'], 'admin/forgot-password', 'Admin\LoginController@forgot')->name('admin.forgot');
Route::match(['get', 'post'], 'admin/reset', 'Admin\LoginController@reset')->name('admin.reset');



// Admin
Route::group(['namespace' => 'Admin', 'prefix' => $ADMIN_ROUTE_NAME, 'as' => $ADMIN_ROUTE_NAME.'.', 'middleware' => ['authadmin']], function() {

    Route::get('/logout', 'LoginController@logout')->name('logout');


    Route::match(['get','post'],'/profile', 'HomeController@profile')->name('profile');
    Route::match(['get','post'],'/permission', 'HomeController@permission')->name('permission');
    Route::match(['get','post'],'/update_permission', 'HomeController@update_permission')->name('update_permission');
    
    Route::match(['get','post'],'/setting', 'HomeController@setting')->name('setting');


    Route::match(['get','post'],'/upload_xls', 'HomeController@upload_xls')->name('upload_xls');


    Route::match(['get','post'],'/get_blocks', 'HomeController@get_blocks')->name('get_blocks');
    Route::match(['get','post'],'/get_flats', 'HomeController@get_flats')->name('get_flats');


    

    Route::match(['get','post'],'/upload', 'HomeController@upload')->name('upload');

    Route::match(['get','post'],'/change-password', 'HomeController@change_password')->name('change_password');

    Route::get('/',  'HomeController@index')->name('home');

    Route::match(['get','post'],'get_sub_cat', 'HomeController@get_sub_cat')->name('get_sub_cat');


    // roles
    Route::group(['prefix' => 'roles', 'as' => 'roles' , 'middleware' => ['allowedmodule:roles,list'] ], function() {

        Route::get('/', 'RoleController@index')->name('.index');

        Route::match(['get', 'post'], 'add', 'RoleController@add')->name('.add');

        Route::match(['get', 'post'], 'get_roles', 'RoleController@get_roles')->name('.get_roles');

        Route::match(['get', 'post'], 'change_role_status', 'RoleController@change_role_status')->name('.change_role_status');
        Route::match(['get', 'post'], 'edit/{id}', 'RoleController@add')->name('.edit');

        Route::post('ajax_delete_image', 'RoleController@ajax_delete_image')->name('.ajax_delete_image');
        Route::match(['get','post'],'delete/{id}', 'RoleController@delete')->name('.delete');
    });




    Route::group(['prefix' => 'faculties' , 'as' => 'faculties', 'middleware' => ['allowedmodule:faculties,list'] ],  function() {

       Route::get('/', 'FacultyController@index')->name('.index');

       Route::match(['get','post'], 'get_faculty', 'FacultyController@get_faculty')->name('.get_faculty');

       Route::match(['get','post'], 'change_faculty_status', 'FacultyController@change_faculty_status')->name('.change_faculty_status');

       Route::match(['get','post'], 'edit/{id}' ,'FacultyController@add')->name('.edit');

       Route::match(['get','post'], 'get_profile' , 'FacultyController@get_profile')->name('.get_profile');

       Route::match(['get','post'], 'add', 'FacultyController@add')->name('.add');

       Route::match(['get','post'], 'delete/{id}', 'FacultyController@delete')->name('.delete');



         // Route::match(['get','post'], 'add', 'FacultyController@add')->name('.add');

         // Route::match(['get','post'], 'edit', 'FacultyController@add')->name('.edit');

         // Route::match(['get','post'], 'add', 'FacultyController@add')->name('.delete');




   });

    Route::group(['prefix' => 'courses' , 'as' => 'courses', 'middleware' => ['allowedmodule:courses,list'] ],  function() {

        Route::get('/', 'CourseController@index')->name('.index');

        Route::match(['get','post'], 'get_couses', 'CourseController@get_couses')->name('.get_couses');

        Route::match(['get','post'], 'add', 'CourseController@add')->name('.add');

        Route::match(['get','post'], 'edit/{id}', 'CourseController@add')->name('.edit');

        Route::match(['get','post'], 'delete/{id}', 'CourseController@delete')->name('.delete');

        Route::match(['get','post'], 'change_course_status', 'CourseController@change_course_status')->name('.change_course_status');

    });



    Route::group(['prefix' => 'subject' , 'as' => 'subject', 'middleware' => ['allowedmodule:subject,list'] ],  function() {

        Route::get('/', 'SubjectController@index')->name('.index');

        Route::match(['get','post'], 'get_couses','SubjectController@get_courses')->name('.get_courses');

        Route::match(['get','post'], 'add', 'SubjectController@add')->name('.add');

        Route::match(['get','post'], 'edit/{id}', 'SubjectController@add')->name('.edit');

        Route::match(['get','post'], 'delete/{id}', 'SubjectController@delete')->name('.delete');

        Route::match(['get','post'], 'change_course_status', 'SubjectController@change_course_status')->name('.change_course_status');

        Route::match(['get','post'],'getcontent/{id}', 'SubjectController@getcontent')->name('.getcontent');


        Route::match(['get','post'],'delete_content/{id}', 'SubjectController@delete_content')->name('.delete_content');
            // Route::match(['get','post'], 'get_couses','SubjectController@get_courses')->name('.get_courses');

        Route::match(['get','post'], 'addcontent/{id}', 'SubjectController@addcontent')->name('.addcontent');

             // Route::match(['get','post'], 'contentedit/{id}', 'SubjectController@addcontent')->name('.contentedit');

       

              // Route::match(['get','post'], 'change_course_status', 'ContentController@change_course_status')->name('.change_course_status');

    });



    Route::group(['prefix' => 'categories' , 'as' => 'categories', 'middleware' => ['allowedmodule:categories,list'] ],  function() {

        Route::get('/', 'CategoryController@index')->name('.index');

        Route::match(['get','post'], 'get_category', 'CategoryController@get_category')->name('.get_category');

        Route::match(['get','post'], 'add', 'CategoryController@add')->name('.add');

        Route::match(['get','post'], 'edit/{id}', 'CategoryController@add')->name('.edit');

        Route::match(['get','post'], 'delete/{id}', 'CategoryController@delete')->name('.delete');

        Route::match(['get','post'], 'change_category_status', 'CategoryController@change_category_status')->name('.change_category_status');

    });

//////////// BANNERS

    Route::group(['prefix' => 'banners' , 'as' => 'banners', 'middleware' => ['allowedmodule:banners,list'] ],  function() {
        Route::match(['get','post'],'/', 'BannerController@index')->name('.index');
        Route::match(['get','post'], 'add', 'BannerController@add')->name('.add');

        Route::match(['get','post'], 'edit/{id}', 'BannerController@add')->name('.edit');

        Route::match(['get','post'], 'delete/{id}', 'BannerController@delete')->name('.delete');
        Route::match(['get','post'], 'change_banner_status', 'BannerController@change_banner_status')->name('.change_banner_status');

    });


/////// USERS

     Route::group(['prefix' => 'user' , 'as' => 'user', 'middleware' => ['allowedmodule:user,list'] ],  function() {
        Route::match(['get','post'],'/', 'UserController@index')->name('.index');
        Route::match(['get','post'], 'add', 'UserController@add')->name('.add');

        Route::match(['get','post'], 'edit/{id}', 'UserController@add')->name('.edit');

        Route::match(['get','post'], 'wallet', 'UserController@wallet')->name('.wallet');
        
        Route::match(['get','post'], 'export', 'UserController@export')->name('.export');

        Route::match(['get','post'], 'delete/{id}', 'UserController@delete')->name('.delete');
        Route::match(['get','post'], 'subscription', 'UserController@subscription')->name('.subscription');

    });

     // contacts
       Route::group(['prefix' => 'contacts' , 'as' => 'contacts', 'middleware' => ['allowedmodule:contacts,list'] ],  function() {
        Route::match(['get','post'],'/', 'ContactController@index')->name('.index');
        // Route::match(['get','post'], 'add', 'ContactController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'ContactController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'ContactController@delete')->name('.delete');
        Route::match(['get','post'], 'change_contacts_status', 'ContactController@change_contacts_status')->name('.change_contacts_status');

    });



     // contacts
       Route::group(['prefix' => 'live_class' , 'as' => 'live_class', 'middleware' => ['allowedmodule:live_class,list'] ],  function() {
        Route::match(['get','post'],'/', 'LiveClassController@index')->name('.index');
         Route::match(['get','post'], 'add', 'LiveClassController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'LiveClassController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'LiveClassController@delete')->name('.delete');
        
        Route::match(['get','post'], 'change_liveclass_status', 'LiveClassController@change_liveclass_status')->name('.change_liveclass_status');

    });



     // chats
       Route::group(['prefix' => 'chats' , 'as' => 'chats', 'middleware' => ['allowedmodule:chats,list'] ],  function() {
        Route::match(['get','post'],'/', 'ChatController@index')->name('.index');
         Route::match(['get','post'], 'add', 'ChatController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'ChatController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'ChatController@delete')->name('.delete');
        Route::match(['get','post'], 'get_user_name', 'ChatController@get_user_name')->name('.get_user_name');
        Route::match(['get','post'], 'get_user_list' ,'ChatController@get_user_list')->name('.get_user_list');
        Route::match(['get','post'], 'get_user_chat', 'ChatController@get_user_chat')->name('.get_user_chat');
        Route::match(['get','post'], 'send_message', 'ChatController@send_message')->name('.send_message');
        Route::match(['get','post'], 'upload_file', 'ChatController@upload_file')->name('.upload_file');


    });


         // notifications
       Route::group(['prefix' => 'notifications' , 'as' => 'notifications', 'middleware' => ['allowedmodule:notifications,list'] ],  function() {
        Route::match(['get','post'],'/', 'NotificationController@index')->name('.index');
         Route::match(['get','post'], 'add', 'NotificationController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'NotificationController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'NotificationController@delete')->name('.delete');
        Route::match(['get','post'], 'send_users', 'NotificationController@send_users')->name('.send_users');

    });

           // dgl_form
       Route::group(['prefix' => 'dgl_form' , 'as' => 'dgl_form', 'middleware' => ['allowedmodule:dgl_form,list'] ],  function() {
        Route::match(['get','post'],'/', 'DGLController@index')->name('.index');
         Route::match(['get','post'], 'add', 'DGLController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'DGLController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'DGLController@delete')->name('.delete');
        Route::match(['get','post'], 'change_faq_status', 'DGLController@change_faq_status')->name('.change_faq_status');


    });
    

           // faqs
       Route::group(['prefix' => 'faqs' , 'as' => 'faqs', 'middleware' => ['allowedmodule:faqs,list'] ],  function() {
        Route::match(['get','post'],'/', 'FAQsController@index')->name('.index');
         Route::match(['get','post'], 'add', 'FAQsController@add')->name('.add');
        Route::match(['get','post'], 'edit/{id}', 'FAQsController@add')->name('.edit');
        Route::match(['get','post'], 'delete/{id}', 'FAQsController@delete')->name('.delete');
        Route::match(['get','post'], 'change_faq_status', 'FAQsController@change_faq_status')->name('.change_faq_status');


    });



    Route::group(['prefix' => 'subscriptions' , 'as' => 'subscriptions', 'middleware' => ['allowedmodule:subscriptions,list'] ],  function() {
        Route::match(['get','post'],'/', 'SubscriptionController@index')->name('.index');

    });














    
});



Route::get('/', 'HomeController@index')->name('home');

