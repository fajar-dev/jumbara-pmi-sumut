<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\SettingController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::prefix('/news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('news.show');
});

// Route::prefix('/report')->group(function () {
//     Route::get('/', [ReportController::class, 'index'])->name('report');
//     Route::get('/{slug}', [ReportController::class, 'show'])->name('report.show');
// });

Route::prefix('/survey')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('survey');
    Route::get('/{slug}', [SurveyController::class, 'show'])->name('survey.show');
    Route::post('/{id}/sumbit', [SurveyController::class, 'submit'])->name('survey.submit');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
    Route::post('/forgot-password', [AuthController::class, 'forgotSubmit'])->name('forgot.submit');
    Route::get('/forget/{token}/reset', [AuthController::class, 'reset'])->name('reset');
    Route::post('/forget/{token}/reset', [AuthController::class, 'resetSubmit'])->name('reset.submit');
})->middleware(['guest']);
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('/app')->group(function () {
    Route::prefix('/master-data')->group(function () {
        Route::prefix('/member-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'member'])->name('admin.master-data.member');
            Route::post('/add', [MasterDataController::class, 'memberStore'])->name('admin.master-data.member.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'memberUpdate'])->name('admin.master-data.member.update');
            Route::get('/{id}/destroy', [MasterDataController::class, 'memberDestroy'])->name('admin.master-data.member.destroy');
        });
        Route::prefix('/participant-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'participant'])->name('admin.master-data.participant');
            Route::post('/add', [MasterDataController::class, 'participantStore'])->name('admin.master-data.participant.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'participantUpdate'])->name('admin.master-data.participant.update');
            Route::get('/{id}/destroy', [MasterDataController::class, 'participantDestroy'])->name('admin.master-data.participant.destroy');
        });
        Route::prefix('/activity-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'activity'])->name('admin.master-data.activity');
            Route::post('/add', [MasterDataController::class, 'activityStore'])->name('admin.master-data.activity.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'activityUpdate'])->name('admin.master-data.activity.update');
            Route::get('/{id}/destroy', [MasterDataController::class, 'activityDestroy'])->name('admin.master-data.activity.destroy');
        });
    });

    Route::prefix('/event')->group(function () {
        Route::prefix('/contingent')->group(function () {
            Route::get('/', [EventController::class, 'contingent'])->name('admin.event.contingent');
            Route::post('/add', [EventController::class, 'contingentStore'])->name('admin.event.contingent.store');
            Route::post('/{id}/edit', [EventController::class, 'contingentUpdate'])->name('admin.event.contingent.update');
            Route::get('/{id}/destroy', [EventController::class, 'contingentDestroy'])->name('admin.event.contingent.destroy');
        });
        Route::prefix('/activity')->group(function () {
            Route::get('/', [EventController::class, 'activity'])->name('admin.event.activity');
            Route::post('/add', [EventController::class, 'activityStore'])->name('admin.event.activity.store');
            Route::post('/{id}/edit', [EventController::class, 'activityUpdate'])->name('admin.event.activity.update');
            Route::get('/{id}/destroy', [EventController::class, 'activityDestroy'])->name('admin.event.activity.destroy');
        });
    });

    Route::prefix('/news')->group(function () {
        Route::get('/', [NewsController::class, 'news'])->name('admin.news');
        Route::get('/add', [NewsController::class, 'newsAdd'])->name('admin.news.add');
        Route::post('/add', [NewsController::class, 'newsStore'])->name('admin.news.store');
        Route::get('/{id}/edit', [NewsController::class, 'newsEdit'])->name('admin.news.edit');
        Route::post('/{id}/edit', [NewsController::class, 'newsUpdate'])->name('admin.news.update');
        Route::get('/{id}/destroy', [NewsController::class, 'newsDestroy'])->name('admin.news.destroy');
        Route::prefix('/category')->group(function () {
            Route::get('/', [NewsController::class, 'category'])->name('admin.category');
            Route::post('/add', [NewsController::class, 'categoryStore'])->name('admin.category.store');
            Route::post('/{id}/edit', [NewsController::class, 'categoryUpdate'])->name('admin.category.update');
            Route::get('/{id}/destroy', [NewsController::class, 'categoryDestroy'])->name('admin.category.destroy');
        });
    });
    
    Route::prefix('/announcement')->group(function () {
        Route::get('/', [AnnouncementController::class, 'announcement'])->name('admin.announcement');
        Route::get('/add', [AnnouncementController::class, 'announcementAdd'])->name('admin.announcement.add');
        Route::post('/add', [AnnouncementController::class, 'announcementStore'])->name('admin.announcement.store');
        Route::get('/{id}/edit', [AnnouncementController::class, 'announcementEdit'])->name('admin.announcement.edit');
        Route::post('/{id}/edit', [AnnouncementController::class, 'announcementUpdate'])->name('admin.announcement.update');
        Route::get('/{id}/destroy', [AnnouncementController::class, 'announcementDestroy'])->name('admin.announcement.destroy');
    });
    
    Route::prefix('/survey')->group(function () {
        Route::get('/', [SurveyController::class, 'survey'])->name('admin.survey');
        Route::get('/add', [SurveyController::class, 'surveyAdd'])->name('admin.survey.add');
        Route::post('/add', [SurveyController::class, 'surveyStore'])->name('admin.survey.store');
        Route::get('/{id}/destroy', [SurveyController::class, 'surveyDestroy'])->name('admin.survey.destroy');
        Route::get('/{id}/create-form', [SurveyController::class, 'surveyCreateForm'])->name('admin.survey.create-form');
        Route::post('/{id}/create-form/submit', [SurveyController::class, 'surveyCreateFormSubmit'])->name('admin.survey.create-form.submit');
        Route::get('/{id}/respondent', [SurveyController::class, 'surveyRespondent'])->name('admin.survey.respondent');
        Route::get('/{id}/respondent/destroy', [SurveyController::class, 'surveyRespondentDestroy'])->name('admin.survey.respondent.destroy');
    
    });
    
    Route::prefix('/message')->group(function () {
        Route::post('/', [MessageController::class, 'store'])->name('message.store');
        Route::get('/', [MessageController::class, 'message'])->name('admin.message');
        Route::get('/{id}/destroy', [MessageController::class, 'messageDestroy'])->name('admin.message.destroy');
    });
    
    Route::prefix('/user')->group(function () {
        Route::get('/', [UserController::class, 'user'])->name('admin.user');
        Route::post('/add', [UserController::class, 'userStore'])->name('admin.user.store');
        Route::post('/{id}/edit', [UserController::class, 'userUpdate'])->name('admin.user.update');
        Route::get('/{id}/destroy', [UserController::class, 'userDestroy'])->name('admin.user.destroy');
    });

    Route::prefix('/setting')->group(function () {
        Route::prefix('/faq')->group(function () {
            Route::get('/', [SettingController::class, 'faq'])->name('admin.setting.faq');
            Route::post('/add', [SettingController::class, 'faqStore'])->name('admin.setting.faq.store');
            Route::post('/{id}/edit', [SettingController::class, 'faqUpdate'])->name('admin.setting.faq.update');
            Route::get('/{id}/destroy', [SettingController::class, 'faqDestroy'])->name('admin.setting.faq.destroy');
        });
    });
    
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile');
        Route::post('/', [ProfileController::class, 'profileUpdate'])->name('admin.profile.update');
        Route::post('/signin-method', [ProfileController::class, 'signinUpdate'])->name('admin.profile.signin');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('admin.profile.change-password');
    });
})->middleware('auth');