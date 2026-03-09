<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProblemsController;
use App\Http\Controllers\AttemptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SteamAuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\HemisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\StudentProblemsController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentProgramController;
use App\Http\Controllers\TournamentUniversityController;
use App\Http\Controllers\TournamentUserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WeekController;
use App\Models\Rating;
use App\Models\Tournament;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $activeTournament = Tournament::where('home', '1')->first();
    $topUsers = collect();
    if ($activeTournament) {
        $topUsers = Rating::where('tournament_id', $activeTournament->id)
            ->with('user.university')
            ->orderBy('score', 'desc')
            ->orderBy('penalty')
            ->orderBy('attempts')
            ->orderBy('secret')
            ->take(5)->get();
    }
    return view('welcome', compact(['activeTournament', 'topUsers']));
});
/*Route::get('/login/steam', SteamAuthController::class)
    ->middleware('guest')
    ->name('login.steam');
*/
/*Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'submit'])->name('login.submit');

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
*/
Auth::routes();

/*Route::prefix('login')->group(function () {
    Route::get('/', [LoginController::class, 'student_index'])->name('login.student.index');
    Route::post('/', [HemisController::class, 'student_login'])->name('student.login');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});*/

/*Route::get('/gemini', [GeminiController::class, 'index'])->name('gemini.form');
Route::post('/gemini/analyze', [GeminiController::class, 'analyze'])->name('gemini.analyze');
Route::get('/gemini-models', [GeminiController::class, 'models'])->name('gemini.models');*/

Route::resource('user', UserProfileController::class)->only('show');
Route::get('/faqs', function () {
    $faqs = \App\Models\Faq::orderBy('order', 'asc')->get();
    return view('faqs', compact('faqs'));
})->name('public.faqs');

Route::prefix('home')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::resource('tournaments', StudentProblemsController::class)->only(['index', 'show', 'update'])->names('student.tournaments');
    Route::post('tournaments/activated', [StudentProblemsController::class, 'activated'])->name('problems.activated');
    Route::resource('problems', ProblemController::class)->only(['index', 'show']);
    Route::post('problems/check_code', [SubmissionController::class, 'checkCode'])->name('problems.check_code');
    Route::resource('submissions', SubmissionController::class)->only(['index']);
    Route::resource('ratings', RatingController::class)->only('index');
    Route::resource('options', OptionController::class)->only('index', 'store');
    Route::prefix('verify-account')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('student.verify');
        Route::post('/send', [VerificationController::class, 'sendCode'])->name('student.verify.send');
        Route::post('/submit', [VerificationController::class, 'verify'])->name('student.verify.submit');
    });
});
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::resource('tournaments', TournamentController::class)->only(['index', 'create', 'store', 'edit', 'update']);
    Route::resource('problems', AdminProblemsController::class)->names('admin.problems');
    Route::resource('programs', ProgramController::class)->only(['index', 'update']);
    Route::patch('faqs/{faq}/move-up', [FaqController::class, 'moveUp'])->name('faqs.move-up');
    Route::patch('faqs/{faq}/move-down', [FaqController::class, 'moveDown'])->name('faqs.move-down');
    Route::resource('faqs', FaqController::class, ['as' => 'admin']);
    Route::prefix('tournaments')->group(function () {
        Route::resource('program-languages', TournamentProgramController::class)->only(['edit', 'update']);
        Route::resource('universities', TournamentUniversityController::class)->only(['edit', 'update']);
        Route::resource('applications', TournamentUserController::class)->only(['show']);
        Route::put('applications/{tournament}/applications/{user}', [TournamentUserController::class, 'updateApplication'])->name('applications.update');
        Route::resource('weeks', WeekController::class)->only(['show', 'edit', 'update']);
        Route::get('/weeks/{tournament_id}/{week_id}/edit', [WeekController::class, 'week_edit'])->name('weeks.week_edit');
        Route::put('/weeks/{tournament_id}/{week_id}', [WeekController::class, 'week_update'])->name('weeks.week_update');
        Route::delete('/weeks/{tournament_id}/{week_id}', [WeekController::class, 'week_destroy'])->name('weeks.week_destroy');
    });
    //Route::resource('ratings', RatingController::class)->only('index');
});
