<?php

use App\Http\Controllers\Agent\AgentPropertyController;
use App\Http\Controllers\Agent\PackageController;
use App\Http\Controllers\Backend\AmenititesController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogPostController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ManageUsersController;
use App\Http\Controllers\Backend\PermissionController;
use App\Http\Controllers\Backend\PropertyMessageController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\ScheduleController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Frontend\ComparelistController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\SettingController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route 
Route::get('/', [UserController::class, 'Index']);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

     Route::controller(UserController::class)->group(function () {

          Route::get('/user/profile','UserProfile')->name('user.profile'); 

          Route::post('/user/profile/store','UserProfileStore')->name('user.profile.store');

          Route::get('/user/logout','UserLogout')->name('user.logout'); 

          Route::get('/user/change/password','UserChangePassword')->name('user.change.password'); 

          Route::post('/user/password/update','UserPasswordUpdate')->name('user.password.update');
     });

 

     Route::controller(WishlistController::class)->group(function () {

         Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');

         Route::get('/get-wishlist-property','GetWishlistProperty');

         Route::get('/wishlist-remove/{id}', 'WishlistRemove');

     });

     Route::controller(ComparelistController::class)->group(function () {

          Route::get('/user/comparelist', 'UserComparelist')->name('user.comparelist');

          Route::get('/get-comparelist-property','GetComparelistProperty');

          Route::get('/comparelist-remove/{id}', 'ComparelistRemove');
     });

     Route::controller(ScheduleController::class)->group(function(){

          Route::get('/user/schedule/request','UserScheduleRequest')->name('user.schedule.request');

          // Route::get('/agent/schedule/details/{id}','AgentScheduleDetails')->name('agent.schedule.details');

          // Route::post('/agent/schedule/confirm','AgentScheduleConfirm')->name('agent.schedule.confirm');
          
     });


});

require __DIR__.'/auth.php';


  
Route::get('/agent/login', [AgentController::class, 'AgentLogin'])->name('agent.login')->middleware(RedirectIfAuthenticated::class); 

Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');


 /// Agent Group Middleware 
Route::middleware(['auth','role:agent'])->group(function(){

     Route::controller(AgentController::class)->group(function(){

          Route::get('/agent/dashboard','AgentDashboard')->name('agent.dashboard');

          Route::get('/agent/logout','AgentLogout')->name('agent.logout');

          Route::get('/agent/profile','AgentProfile')->name('agent.profile');

          Route::post('/agent/profile/store','AgentProfileStore')->name('agent.profile.store');

          Route::get('/agent/change/password','AgentChangePassword')->name('agent.change.password');

          Route::post('/agent/update/password','AgentUpdatePassword')->name('agent.update.password');
     });

     Route::controller(AgentPropertyController::class)->group(function(){

          Route::get('/agent/all/property','AgentAllProperty')->name('agent.all.property');

          Route::get('/agent/add/property','AgentAddProperty')->name('agent.add.property');

          Route::post('/agent/store/property','AgentStoreProperty')->name('agent.store.property');

          Route::get('/agent/edit/property/{id}','AgentEditProperty')->name('agent.edit.property');

          Route::post('/agent/update/property','AgentUpdateProperty')->name('agent.update.property');

          Route::post('/agent/update/property/thambnail','AgentUpdatePropertyThambnail')->name('agent.update.property.thambnail');

          Route::post('/agent/update/property/multiimage','AgentUpdatePropertyMultiimage')->name('agent.update.property.multiimage');

          Route::get('/agent/delete/property/multiimage/{id}','AgentDeletePropertyMultiimage')->name('agent.delete.property.multiimage');

          Route::post('/agent/store/property/multiimage','AgentStorePropertyMultiimage')->name('agent.store.new.multiimage');

          Route::post('/agent/update/property/facility','AgentUpdatePropertyFacility')->name('agent.update.property.facility');

          Route::get('/agent/details/property/{id}','AgentDetailsProperty')->name('agent.details.property');

          Route::get('/agent/delete/property/{id}','AgentDeleteProperty')->name('agent.delete.property');
          
     });

     Route::controller(PackageController::class)->group(function(){

          Route::get('/buy/package','BuyPackage')->name('buy.package');

          Route::get('/buy/business/plan','BuyBusinessPlan')->name('buy.business.plan');

          Route::post('/store/business/plan','StoreBusinessPlan')->name('store.business.plan');

          Route::get('/buy/professional/plan','BuyProfessionalPlan')->name('buy.professional.plan');

          Route::post('/store/professional/plan','StoreProfessionalPlan')->name('store.professional.plan');

          Route::get('/package/history','PackageHistory')->name('package.history');

          Route::get('/package/invoice/{id}','PackageInvoice')->name('package.invoice');

     
     });

     Route::controller(PropertyMessageController::class)->group(function(){

          Route::get('/agent/property/message','AgentPropertyMessage')->name('agent.property.message');

          Route::get('/agent/message/details/{id}','AgentMessageDetails')->name('agent.message.details');

     });

     Route::controller(ScheduleController::class)->group(function(){

          Route::get('/agent/schedule/request','AgentScheduleRequest')->name('agent.schedule.request');

          Route::get('/agent/schedule/details/{id}','AgentScheduleDetails')->name('agent.schedule.details');

          Route::post('/agent/schedule/confirm','AgentScheduleConfirm')->name('agent.schedule.confirm');
          
     });


}); // End Group Agent Middleware







Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login')->middleware(RedirectIfAuthenticated::class); 

  /// Admin Group Middleware 
Route::middleware(['auth','role:admin'])->group(function(){ 

     /// Admin Group Middleware
     Route::controller(AdminController::class)->group(function(){
          
          Route::get('/admin/dashboard','AdminDashboard')->name('admin.dashboard'); 

          Route::get('/admin/logout','AdminLogout')->name('admin.logout'); 

          Route::get('/admin/profile','AdminProfile')->name('admin.profile'); 

          Route::post('/admin/profile/store','AdminProfileStore')->name('admin.profile.store'); 

          Route::get('/admin/change/password','AdminChangePassword')->name('admin.change.password'); 

          Route::post('/admin/update/password','AdminUpdatePassword')->name('admin.update.password');
     });

     // Property Type All Route 
     Route::controller(PropertyTypeController::class)->group(function(){

          Route::get('/all/type', 'AllType')->name('all.type'); 
          Route::get('/add/type', 'AddType')->name('add.type');
          Route::post('/store/type', 'StoreType')->name('store.type'); 
          Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
          Route::post('/update/type', 'UpdateType')->name('update.type');
          Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');  

     });


     // Amenities Type All Route 
     Route::controller(AmenititesController::class)->group(function(){

          Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie'); 
          Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
          Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie'); 
          Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
          Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
          Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');  

     });


     // Property All Route 
     Route::controller(PropertyController::class)->group(function(){

          Route::get('/all/property', 'AllProperty')->name('all.property'); 
          Route::get('/add/property', 'AddProperty')->name('add.property');
          Route::post('/store/property', 'StoreProperty')->name('store.property');
          Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
          Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');
          Route::post('/update/property', 'UpdateProperty')->name('update.property');
          Route::post('/update/property/thambnail', 'UpdatePropertyThambnail')->name('update.property.thambnail');
          Route::post('/update/property/multiimage', 'UpdatePropertyMultiimage')->name('update.property.multiimage');
          Route::get('/delete/property/multiimage/{id}', 'DeletePropertyMultiimage')->name('delete.property.multiimage');
          Route::post('/store/new/multiimage', 'StoreNewMultiimage')->name('store.new.multiimage');
          Route::post('/update/property/facility', 'UpdatePropertyFacility')->name('update.property.facility');
          Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
          Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
          Route::post('/active/property', 'ActiveProperty')->name('active.property');
     

     });

     Route::controller(ManageUsersController::class)->group(function(){

          Route::get('/all/agents','AllAgent')->name('all.agent');

          Route::get('/add/agent','AddAgent')->name('add.agent');

          Route::post('/store/agent','StoreAgent')->name('store.agent');

          Route::get('/edit/agent/{id}','EditAgent')->name('edit.agent');

          Route::post('/edit/agent','UpdateAgent')->name('update.agent');

          Route::get('/delete/agent/{id}','DeleteAgent')->name('delete.agent');

          Route::post('/active/agent','ActiveAgent')->name('active.agent');

          Route::post('/inactive/agent','InactiveAgent')->name('inactive.agent');
     });

     Route::controller(PackageController::class)->group(function(){

          Route::get('/admin/package/history','AdminPackageHistory')->name('admin.package.history');

          Route::get('/admin/package/invoice/{id}','AdminPackageInvoice')->name('admin.package.invoice');
     });


     Route::controller(PropertyMessageController::class)->group(function(){

          Route::get('/admin/property/message','AdminPropertyMessage')->name('admin.property.message');

          Route::get('/admin/message/details/{id}','AdminMessageDetails')->name('admin.message.details');
     });

     Route::controller(StateController::class)->group(function(){

          Route::get('/all/state','AllState')->name('all.state');

          Route::get('/add/state','AddState')->name('add.state');

          Route::post('/store/state','StoreState')->name('store.state');

          Route::get('/edit/state/{id}','EditState')->name('edit.state');

          Route::post('/update/state','UpdateState')->name('update.state');

          Route::get('/delete/state/{id}','DeleteState')->name('delete.state');
     });

     Route::controller(TestimonialController::class)->group(function(){

          Route::get('/all/testimonials','AllTestimonials')->name('all.testimonials');

          Route::get('/add/testimonial','AddTestimonial')->name('add.testimonial');

          Route::post('/store/testimonial','StoreTestimonial')->name('store.testimonial');

          Route::get('/edit/testimonial/{id}','EditTestimonial')->name('edit.testimonial');

          Route::post('/update/testimonial','UpdateTestimonial')->name('update.testimonial');

          Route::get('/delete/testimonial/{id}','DeleteTestimonial')->name('delete.testimonial');
     });

     Route::controller(BlogCategoryController::class)->group(function(){

          Route::get('/all/blog/category','AllBlogCategory')->name('all.blog.Categories');

          Route::post('/store/blog/category','StoreBlogCategory')->name('store.blog.category');

          Route::get('/edit/blog/category/{id}', 'EditBlogCategory');

          Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');

          Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');

     });

     Route::controller(BlogPostController::class)->group(function(){

          Route::get('/all/blog/post','AllBlogPost')->name('all.blog.posts');

          Route::get('/add/blog/post','AddBlogPost')->name('add.blog.post');

          Route::post('/store/blog/post','StoreBlogPost')->name('store.blog.post');

          Route::get('/edit/blog/post/{id}','EditBlogPost')->name('edit.blog.post');

          Route::post('/update/blog/post','UpdateBlogPost')->name('update.blog.post');

          Route::get('/delete/blog/post/{id}','DeleteBlogPost')->name('delete.blog.post');
     });

     Route::controller(CommentController::class)->group(function(){

          Route::get('/all/blog/comments','AllBlogComment')->name('all.blog.comment');

          Route::get('/admin/comment/reply/{id}','AdminCommentReply')->name('admin.comment.reply');

          Route::post('/admin/message/reply','AdminMessageReply')->name('admin.message.reply');
     });

     //SMTP Setting

     Route::controller(SettingController::class)->group(function(){

          Route::get('/smtp/setting','SmtpSetting')->name('smtp.setting');

          Route::post('/update/site/setting','UpdateSiteSetting')->name('update.site.setting');
     });

     //Site Setting

     Route::controller(SettingController::class)->group(function(){

          Route::get('/site/setting','SiteSetting')->name('site.setting');

          Route::post('/update/smtp/setting','UpdateSmtpSetting')->name('update.smtp.setting');
     });

     Route::controller(PermissionController::class)->group(function(){

          Route::get('/all/permissions','AllPermission')->name('all.permissions');

          Route::get('/add/permission','AddPermission')->name('add.permission');

          Route::post('/store/permission','StorePermission')->name('store.permission');

          Route::get('/edit/permission/{id}','EditPermission')->name('edit.permission');

          Route::post('/update/permission','UpdatePermission')->name('update.permission');

          Route::get('/delete/permission/{id}','DeletePermission')->name('delete.permission');

          // Import & Export

          Route::get('/import/permission','ImportPermission')->name('import.permission');

          Route::get('/export/permission','ExportPermission')->name('export.permission');

          Route::post('/import/permission','Import')->name('import');
     });


     Route::controller(RoleController::class)->group(function(){

          Route::get('/all/roles','AllRole')->name('all.roles');

          Route::get('/add/role','AddRole')->name('add.role');

          Route::post('/store/role','StoreRole')->name('store.role');

          Route::get('/edit/role/{id}','EditRole')->name('edit.role');

          Route::post('/update/role','UpdateRole')->name('update.role');

          Route::get('/delete/role/{id}','DeleteRole')->name('delete.role');

     });

     Route::controller(RolePermissionController::class)->group(function(){

          Route::get('/add/role/permission','AddRolePermission')->name('add.role.permission');

          Route::post('/store/role/permission','StoreRolePermission')->name('store.role.permission');

          Route::get('/all/role/permission','AllRolePermission')->name('all.role.permission');

          Route::get('/Edit/role/permission/{id}','EditRolePermission')->name('Edit.role.permission');

          

     });


}); // End Group Admin Middleware

Route::get('/property/details/{id}/{slug}',[IndexController::class,'PropertyDetails'])->name('property.details');

//Add To Wishlist 

Route::post('/add-to-wishList/{property_id}',[WishlistController::class,'AddToWishlist']);

//Add To Comparelist 

Route::post('/add-to-compareList/{property_id}',[ComparelistController::class,'AddToComparelist']);

//send message from property details

Route::post('/property/message',[IndexController::class,'PropertyMessage'])->name('property.message');

//agent details

Route::get('/agent/details/{id}',[IndexController::class,'AgentDetails'])->name('agent.details');

//send message from agent details

Route::post('/agent/message',[IndexController::class,'AgentMessage'])->name('agent.message');

//Get All Rent properties

Route::get('/rent/property',[IndexController::class,'RentProperty'])->name('rent.property');

//Get All Buy properties

Route::get('/buy/property',[IndexController::class,'BuyProperty'])->name('buy.property');

//Get All Type properties

Route::get('/property/type/{id}',[IndexController::class,'PropertyType'])->name('property.type');

//Get All State Properties

Route::get('/state/details/{id}',[IndexController::class,'StateDetails'])->name('state.details');

//Home Page buy property search

Route::post('/buy/property/search',[IndexController::class,'BuyPropertySearch'])->name('buy.property.search');

//Home Page rent property search

Route::post('/rent/property/search',[IndexController::class,'RentPropertySearch'])->name('rent.property.search');

//All search property options

Route::post('/all/property/search',[IndexController::class,'AllPropertySearch'])->name('all.property.search');

//Blog Details Page

Route::get('/blog/details/{post_slug}',[IndexController::class,'BlogDetails'])->name('blog.details');

//Blog Category List

Route::get('/blog/category/list/{id}',[IndexController::class,'BlogCategoryList'])->name('blog.category.list');

//Blog List

Route::get('/blog',[IndexController::class,'BlogList'])->name('blog.list');

// Store Comment

Route::post('/store/comment',[CommentController::class,'StoreComment'])->name('store.comment');

// Schedule Message Request

Route::post('/store/schedule',[ScheduleController::class,'StoreSchedule'])->name('store.schedule');