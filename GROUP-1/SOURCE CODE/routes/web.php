<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfferImagesController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\BarterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportImageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QtyController;

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


// Unprotected Routes
Route::group([], function() {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    })->name('welcome');
});

Route::group(['middleware' => 'auth'], function() {
    
    // Post Controller Routes
    Route::resource('post', PostController::class);
    Route::get('getPostAuthor/{postID}', [PostController::class, 'extractUser']);
    Route::get('postExistsInConversation/{postID}', [PostController::class, 'postExistsInConversation']);
    Route::get('postOffers/{postID}', [PostController::class, 'getPostOffers']);
    Route::get('getAuthUserPosts', [PostController::class, 'getAuthUserPosts']);
    Route::get('getUserPosts/{userID}', [PostController::class, 'getUserPosts']);
    Route::get('getPost/{postID}', [PostController::class, 'get']);
    Route::get('postExists/{postID}', [PostController::class, 'exists']);

    //Report Image Controller Routes
    Route::post('reportImg/process', [ReportImageController::class, 'store']);
    Route::post('reportImg/revert', [ReportImageController::class, 'revert']);
    Route::get('reportImg/{reportID}', [ReportImageController::class, 'get']);

    // Post Image Controller Routes
    Route::post('postImg/process', [PostImageController::class, 'store']);
    Route::post('postImg/revert', [PostImageController::class, 'revert']);
    Route::get('postImg/{postID}', [PostImageController::class, 'getPostImage']);

    // Report Controller Routes
    Route::post('report/store', [ReportController::class, 'store']);
    Route::post('report/absolve', [ReportController::class, 'absolve']);
    Route::post('report/ban', [ReportController::class, 'ban']);
    Route::post('report/warn', [ReportController::class, 'warn']);
    Route::get('offenseLevel/{userID}', [ReportController::class, 'getOffenseLevel']);
    
    // Cart Controller Routes
    Route::resource('cart', CartController::class);

    // Offer Controller Routes
    Route::resource('offer', OfferController::class);
    Route::put('rejectOffer/{offerID}', [OfferController::class, 'rejectOffer'])->name('rejectOffer');
    Route::post('offerExists/post/{postID}/user/{userID}', [OfferController::class, 'offerExists']);
    Route::put('acceptOffer/{offerID}', [OfferController::class, 'acceptOffer']);
    Route::get('getOffer/{offerID}', [OfferController::class, 'get']);
    Route::get('getOfferOfAuthUser/{postID}/{otherUserID}', [OfferController::class, 'getOfferOfAuthUser']);
    Route::get('getOfferCount/{postID}', [OfferController::class, 'getOfferCount']);
    Route::get('getOfferToUser/{userID}', [OfferController::class, 'getOfferToUser']);

    // Message Controller Routes
    Route::resource('message', MessageController::class);
    Route::get('messages/{convoID}', [MessageController::class, 'getMessages']);
    Route::get('lastMessage/{convoID}', [MessageController::class, 'getLastMessage']);
    Route::post('msgImg/process', [MessageController::class, 'storeImage']);   
    Route::get('getMessagesOfUser', [MessageController::class, 'getMessagesOfUser']);
    
    // Conversation Controller Routes
    Route::get('conversation/{convoID}', [ConversationController::class, 'getConversation']);
    Route::get('conversations', [ConversationController::class, 'getConversations']);
    Route::get('getConvoFromPost/{postID}', [ConversationController::class, 'getConvoFromPost']);
   
    // User Controller Routes 
    Route::get('user/{id}', [UserController::class, 'getUser']);
    Route::get('currentUser', [UserController::class, 'getCurrentUser']);
    Route::get('name/{id}', [UserController::class, 'getName']);
    Route::post('promotion', [UserController::class, 'setPromotion']);
    Route::get('promotion/{id}', [UserController::class, 'getPromotion']);

    // Admin Routes
    Route::get('modifyTypes', [UserController::class, 'modifyTypes'])->name('modifyTypes');
    Route::get('viewModerators', [UserController::class, 'viewModerators'])->name('viewModerators');
    Route::get('viewReports', [ReportController::class, 'viewReports'])->name('viewReports');
    Route::get('send-email/{email}', [MailController::class, 'sendEmail']);
    Route::get('send-warning-email/{email}', [MailController::class, 'sendWarningEmail']);
 
    // Offer Images Controller
    Route::get('offerImages/{offerID}', [OfferImagesController::class, 'getOfferImage']);

    // Barter Controller
    Route::post('startBarter', [BarterController::class, 'startBarter']);
    Route::get('barterExists/{convoID}', [BarterController::class, 'barterExists']);
    Route::get('barterDone/{postID}', [BarterController::class, 'isDone']);

    // Feedback Controller
    Route::resource('feedback', FeedbackController::class);
    Route::put('feedback/edit', [FeedbackController::class, 'update']);
    Route::get('getFeedback/{postID}', [FeedbackController::class, 'getFeedback']);
    Route::get('getUserFeedbacks/{userID}', [FeedbackController::class, 'getUserFeedbacks']);
    Route::get('getAllFeedback/{userID}', [FeedbackController::class, 'getAllFeedback']);

    // Category Controller
    Route::put('category/edit', [CategoryController::class, 'edit']);
    Route::delete('category/delete/{categoryID}', [CategoryController::class, 'delete']);
    Route::post('category/add', [CategoryController::class, 'add']);

    // Qty Controller
    Route::put('qty/edit', [QtyController::class, 'edit']);
    Route::post('qty/add', [QtyController::class, 'add']);
    Route::delete('qty/delete/{qtyID}', [QtyController::class, 'delete']);
});

// Protected Routes
Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', [PostController::class, 'sortPosts'])->name('dashboard');
    Route::get('/profile/{id?}', [UserController::class, 'getProfile'])->name('userProfile');
    Route::get('/messages', [ConversationController::class, 'showConversations'])->name('messages');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
    Route::get('/offersMade', [OfferController::class, 'showOffers'])->name('offersMade');
    Route::get('/getTransactionHistory', [UserController::class, 'getTransactionHistory'])->name('transactionHistory');
});