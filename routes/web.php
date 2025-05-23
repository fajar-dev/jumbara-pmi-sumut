<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoordinatorController;
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
use App\Http\Controllers\ServiceController;
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


Route::prefix('/auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit')->middleware('guest');
    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot')->middleware('guest');
    Route::post('/forgot-password', [AuthController::class, 'forgotSubmit'])->name('forgot.submit')->middleware('guest');
    Route::get('/forget/{token}/reset', [AuthController::class, 'reset'])->name('reset')->middleware('guest');
    Route::post('/forget/{token}/reset', [AuthController::class, 'resetSubmit'])->name('reset.submit')->middleware('guest');
    Route::get('/change-password', [AuthController::class, 'change'])->name('change')->middleware('auth');
    Route::post('/change-password', [AuthController::class, 'changeSubmit'])->name('change.submit')->middleware('auth');
    Route::get('/auth/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::prefix('/app')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('app.profile');
        Route::post('/', [ProfileController::class, 'profileUpdate'])->name('app.profile.update');
        Route::post('/signin-method', [ProfileController::class, 'signinUpdate'])->name('app.profile.signin');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('app.profile.change-password');
    });
    Route::get('/service', [ServiceController::class, 'handle'])->name('service');
    Route::get('/member-type/{id}/participant-types', [ServiceController::class, 'participantType'])->name('participant-type');
});

Route::prefix('/admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::prefix('/master-data')->group(function () {
        Route::prefix('/member-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'member'])->name('admin.master-data.member');
            Route::post('/add', [MasterDataController::class, 'memberStore'])->name('admin.master-data.member.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'memberUpdate'])->name('admin.master-data.member.update');
        });
        Route::prefix('/participant-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'participant'])->name('admin.master-data.participant');
            Route::post('/add', [MasterDataController::class, 'participantStore'])->name('admin.master-data.participant.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'participantUpdate'])->name('admin.master-data.participant.update');
            Route::post('/{id}/participation', [MasterDataController::class, 'memberParticipantion'])->name('admin.master-data.participant.member-participation');
        });
        Route::prefix('/activity-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'activity'])->name('admin.master-data.activity');
            Route::post('/add', [MasterDataController::class, 'activityStore'])->name('admin.master-data.activity.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'activityUpdate'])->name('admin.master-data.activity.update');
        });
        Route::prefix('/gender')->group(function () {
            Route::get('/', [MasterDataController::class, 'gender'])->name('admin.master-data.gender');
            Route::post('/add', [MasterDataController::class, 'genderStore'])->name('admin.master-data.gender.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'genderUpdate'])->name('admin.master-data.gender.update');
        });
        Route::prefix('/religion')->group(function () {
            Route::get('/', [MasterDataController::class, 'religion'])->name('admin.master-data.religion');
            Route::post('/add', [MasterDataController::class, 'religionStore'])->name('admin.master-data.religion.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'religionUpdate'])->name('admin.master-data.religion.update');
        });
        Route::prefix('/blood-type')->group(function () {
            Route::get('/', [MasterDataController::class, 'blood'])->name('admin.master-data.blood');
            Route::post('/add', [MasterDataController::class, 'bloodStore'])->name('admin.master-data.blood.store');
            Route::post('/{id}/edit', [MasterDataController::class, 'bloodUpdate'])->name('admin.master-data.blood.update');
        });
    });

    Route::prefix('/event')->group(function () {
        Route::prefix('/contingent')->group(function () {
            Route::get('/', [EventController::class, 'contingent'])->name('admin.event.contingent');
            Route::post('/add', [EventController::class, 'contingentStore'])->name('admin.event.contingent.store');
            Route::post('/{id}/edit', [EventController::class, 'contingentUpdate'])->name('admin.event.contingent.update');
            Route::post('/{id}/coordinator', [EventController::class, 'coordinatorStore'])->name('admin.event.contingent.coordinator.store');
            Route::get('/{id}/destroy', [EventController::class, 'contingentDestroy'])->name('admin.event.contingent.destroy');
            Route::get('/{id}/participant', [EventController::class, 'contingentparticipant'])->name('admin.event.contingent.participant');
            Route::get('/{id}/activity', [EventController::class, 'contingentActivity'])->name('admin.event.contingent.activity');
        });
        Route::prefix('/activity')->group(function () {
            Route::get('/', [EventController::class, 'activity'])->name('admin.event.activity');
            Route::post('/add', [EventController::class, 'activityStore'])->name('admin.event.activity.store');
            Route::post('/{id}/edit', [EventController::class, 'activityUpdate'])->name('admin.event.activity.update');
            Route::post('/{id}/rule', [EventController::class, 'participationRule'])->name('admin.event.activity.rule');
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
        Route::prefix('/admin')->group(function () {
            Route::get('/', [UserController::class, 'admin'])->name('admin.user.admin');
            Route::post('/add', [UserController::class, 'adminStore'])->name('admin.user.admin.store');
            Route::get('/{id}/destroy', [UserController::class, 'adminDestroy'])->name('admin.user.admin.destroy');
        });
        Route::prefix('/crew')->group(function () {
            Route::get('/', [UserController::class, 'crew'])->name('admin.user.crew');
            Route::post('/add', [UserController::class, 'crewStore'])->name('admin.user.crew.store');
            Route::post('/{id}/edit', [UserController::class, 'crewUpdate'])->name('admin.user.crew.update');
            Route::get('/{id}/destroy', [UserController::class, 'crewDestroy'])->name('admin.user.crew.destroy');
        });
    });

    Route::prefix('/setting')->group(function () {
        Route::prefix('/faq')->group(function () {
            Route::get('/', [SettingController::class, 'faq'])->name('admin.setting.faq');
            Route::post('/add', [SettingController::class, 'faqStore'])->name('admin.setting.faq.store');
            Route::post('/{id}/edit', [SettingController::class, 'faqUpdate'])->name('admin.setting.faq.update');
            Route::get('/{id}/destroy', [SettingController::class, 'faqDestroy'])->name('admin.setting.faq.destroy');
        });
        Route::prefix('/general')->group(function () {
            Route::get('/', [SettingController::class, 'general'])->name('admin.setting.general');
            Route::post('/edit', [SettingController::class, 'generalUpdate'])->name('admin.setting.general.update');
        });
        Route::prefix('/sponsor')->group(function () {
            Route::get('/', [SettingController::class, 'sponsor'])->name('admin.setting.sponsor');
            Route::post('/add', [SettingController::class, 'sponsorStore'])->name('admin.setting.sponsor.store');
            Route::post('/{id}/edit', [SettingController::class, 'sponsorUpdate'])->name('admin.setting.sponsor.update');
            Route::get('/{id}/destroy', [SettingController::class, 'sponsorDestroy'])->name('admin.setting.sponsor.destroy');
        });
    });
});


Route::prefix('/coordinator')->middleware(['auth', 'isCoordinator'])->group(function () {
    Route::prefix('/participant')->group(function () {
        Route::get('/', [CoordinatorController::class, 'participant'])->name('coordinator.participant');
        Route::post('/{provinceId}/{cityId}/check', [CoordinatorController::class, 'participantCheck'])->name('coordinator.participant.check');
        Route::get('/add', [CoordinatorController::class, 'participantAdd'])->name('coordinator.participant.add');
        Route::post('/add', [CoordinatorController::class, 'participantStore'])->name('coordinator.participant.store');
        Route::get('/{memberId}/completed', [CoordinatorController::class, 'participantCompleted'])->name('coordinator.participant.completed');
        Route::post('/{memberId}/completed', [CoordinatorController::class, 'participantCompletedStore'])->name('coordinator.participant.completed.store');
        Route::get('/register', [CoordinatorController::class, 'participantRegister'])->name('coordinator.participant.register');
        Route::post('/register', [CoordinatorController::class, 'participantRegisterStore'])->name('coordinator.participant.register.store');
        Route::get('/{id}/destroy', [CoordinatorController::class, 'participantDestroy'])->name('coordinator.participant.destroy');
    });

    Route::prefix('/activity')->group(function () {
        Route::get('/', [CoordinatorController::class, 'activity'])->name('coordinator.activity');
    });
});