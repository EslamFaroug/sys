<?php

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
// test
// route::prefix('layouts')-> group(['middleware' => 'roles', 'roles'=> ['Admin']],function()
// {
// 		Route::get('index','MainPageController@admin');
// 		Route::get('main','MainPageController@index');


// 	});
	Route::get('/lang','LangController@changeLanguage');

	Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

	Route::get('/','MainPageController@index');
	Route::get('/orginal','MainPageController@orginal');
	Route::get('/profile1','MainPageController@profile1');

	// ADD Roles
	Route::post('/add-role',[
		'uses' => 'MainPageController@addRole',
		'as' => 'layouts.admin',
		'middleware' => 'roles',
		'roles' => ['admin']
	]);
	Route::get('/admin',[
		'uses' => 'MainPageController@admin',
		'as' => 'layouts.admin',
		'middleware' => 'roles',
		'roles' => ['admin']
	]);
	Route::get('/teacher',[
		'uses' => 'MainPageController@teacher',
		'as' => 'teachers.teacher',
		'middleware' => 'roles',
		'roles' => ['admin','teacher']
	]);
	Route::get('/access-denied', 'MainPageController@accessDenied');
		// UserController:=> UserController
		// Route::get('/users',[
		// 		'uses' => 'UserController@index',
		// 		'as' => 'users.index',
		// 		'middleware' => 'roles',
		// 		'roles' => ['admin']
		// 	]);





	Route::group(['prefix'=>'users', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','UserController@index');
		Route::post('store','UserController@store');
		Route::post('edit/{id}','UserController@edit');
		Route::post('destroy/{id}','UserController@destroy');
		Route::post('update/{id}','UserController@update');
            Route::post('getStates','UserController@getStates');
            Route::put('roleChange','UserController@roleChange');

	});



// Home:=> HomeController
Route::group(['prefix'=>'home', 'middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','HomeController@index');
    });


// Counteris:=> CounteryController
Route::group(['prefix'=>'countries', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','CounteryController@index');
		Route::post('store','CounteryController@store');
		Route::post('edit/{id}','CounteryController@edit');
		Route::post('destroy/{id}','CounteryController@destroy');
		Route::post('update/{id}','CounteryController@update');
		Route::post('getStates','CounteryController@getStates');

	});

// States:=> StateController
Route::group(['prefix'=>'states', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','StateController@index');
		Route::post('store','StateController@store');
		Route::post('edit/{id}','StateController@edit');
		Route::post('destroy/{id}','StateController@destroy');
		Route::post('update/{id}','StateController@update');
		Route::post('getRegional','StateController@getRegional');

	});

// Regionals:=> RegionalController
Route::group(['prefix'=>'regionals', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','RegionalController@index');
		Route::post('store','RegionalController@store');
		Route::post('edit/{id}','RegionalController@edit');
		Route::post('destroy/{id}','RegionalController@destroy');
		Route::post('update/{id}','RegionalController@update');
	});

// Units:=> UnitController
Route::group(['prefix'=>'units', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','UnitController@index');
		Route::post('store','UnitController@store');
		Route::post('edit/{id}','UnitController@edit');
		Route::post('destroy/{id}','UnitController@destroy');
		Route::post('update/{id}','UnitController@update');
		Route::post('getUnits','UnitController@getUnits');
	});


// Types_univers:=> TypeController
Route::group(['prefix'=>'types_univers', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
            Route::get('index','TypeController@index');
            Route::get('getUniversities','TypeController@getUniversities');
		Route::post('store','TypeController@store');
		Route::post('edit/{id}','TypeController@edit');
		Route::post('destroy/{id}','TypeController@destroy');
		Route::post('update/{id}','TypeController@update');

	});

// universities :=> UniversityController
Route::group(['prefix'=>'universities', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','UniversityController@index');
		Route::post('store','UniversityController@store');
		Route::post('edit/{id}','UniversityController@edit');
		Route::post('destroy/{id}','UniversityController@destroy');
		Route::post('update/{id}','UniversityController@update');
		Route::post('getColleges','UniversityController@getColleges');

	});

// Colleges:=> CollegesController
Route::group(['prefix'=>'colleges', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','CollegesController@index');
		Route::post('store','CollegesController@store');
		Route::post('edit/{id}','CollegesController@edit');
		Route::post('destroy/{id}','CollegesController@destroy');
		Route::post('update/{id}','CollegesController@update');
		Route::post('getRegional','CollegesController@getRegional');
		Route::post('getDepartments','CollegesController@getDepartments');

	});

// Departments :=> Departments
Route::group(['prefix'=>'departments', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','DepartmentsController@index');
		Route::post('store','DepartmentsController@store');
		Route::post('edit/{id}','DepartmentsController@edit');
		Route::post('destroy/{id}','DepartmentsController@destroy');
		Route::post('update/{id}','DepartmentsController@update');
	});

// specials:=> SpecialController
Route::group(['prefix'=>'specials', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','SpecialController@index');
		Route::post('store','SpecialController@store');
		Route::post('edit/{id}','SpecialController@edit');
		Route::post('destroy/{id}','SpecialController@destroy');
		Route::post('update/{id}','SpecialController@update');
		Route::post('getSpecials','SpecialController@getSpecials');

	});

// Qualifications :=> QualificatController:=>
Route::group(['prefix'=>'qualifications', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','QualificatController@index');
		Route::post('store','QualificatController@store');
		Route::post('edit/{id}','QualificatController@edit');
		Route::post('destroy/{id}','QualificatController@destroy');
		Route::post('update/{id}','QualificatController@update');
	});

// Degrees :=> DegreeController
Route::group(['prefix'=>'degrees', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','DegreeController@index');
		Route::post('store','DegreeController@store');
		Route::post('edit/{id}','DegreeController@edit');
		Route::post('destroy/{id}','DegreeController@destroy');
		Route::post('update/{id}','DegreeController@update');
	});

// Work_types :=> WorkController
Route::group(['prefix'=>'work_types', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','WorkController@index');
		Route::post('store','WorkController@store');
		Route::post('edit/{id}','WorkController@edit');
		Route::post('destroy/{id}','WorkController@destroy');
		Route::post('update/{id}','WorkController@update');
	});

// management jobs :=> MangejobController
Route::group(['prefix'=>'mangejobs', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','MangejobController@index');
		Route::post('store','MangejobController@store');
		Route::post('edit/{id}','MangejobController@edit');
		Route::post('destroy/{id}','MangejobController@destroy');
		Route::post('update/{id}','MangejobController@update');
	});


// Study :=> StudyController
Route::group(['prefix'=>'study_types', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','StudyController@index');
		Route::post('store','StudyController@store');
		Route::post('edit/{id}','StudyController@edit');
		Route::post('destroy/{id}','StudyController@destroy');
		Route::post('update/{id}','StudyController@update');
	});

// Teachers :=>

// Basic Information  TeacherController
Route::group(['prefix'=>'teachers', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','TeacherController@index');
		Route::post('store','TeacherController@store');
		Route::post('edit/{id}','TeacherController@edit');
		Route::post('destroy/{id}','TeacherController@destroy');
		Route::post('update/{id}','TeacherController@update');
	});
// contact information:=> ContactController
Route::group(['prefix'=>'tr_contact', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','ContactController@index');
		Route::post('store','ContactController@store');
		Route::post('edit/{id}','ContactController@edit');
		Route::post('destroy/{id}','ContactController@destroy');
		Route::post('update','ContactController@update');

	});

// Certificates :=> CertificateController
Route::group(['prefix'=>'certificates', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','CertificateController@index')->name('cert');
		Route::post('store','CertificateController@store');
            Route::post('view/{id}','CertificateController@view');
            Route::post('edit/{id}','CertificateController@edit');
		Route::post('destroy/{id}','CertificateController@destroy');
		Route::post('update/{id}','CertificateController@update');

	});

// Experiences/Jobs :=> ExperiencController
Route::group(['prefix'=>'experiences', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','ExperiencController@index');
		Route::post('store','ExperiencController@store');
		Route::post('edit/{id}','ExperiencController@edit');
		Route::post('destroy/{id}','ExperiencController@destroy');
		Route::post('update/{id}','ExperiencController@update');

	});

// Skills /Activities :=> SkillsController
Route::group(['prefix'=>'skills', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','SkillsController@index');
		Route::post('store','SkillsController@store');
		Route::post('edit/{id}','SkillsController@edit');
		Route::post('destroy/{id}','SkillsController@destroy');
		Route::post('update/{id}','SkillsController@update');

	});


// Training $ Cources :=> TrainController
Route::group(['prefix'=>'training', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','TrainController@index');
		Route::post('store','TrainController@store');
		Route::post('edit/{id}','TrainController@edit');
            Route::post('view/{id}','TrainController@view');
            Route::post('destroy/{id}','TrainController@destroy');
		Route::post('update/{id}','TrainController@update');

	});


//Papers :=> PaperController
Route::group(['prefix'=>'papers', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','PaperController@index');
		Route::post('store','PaperController@store');
		Route::post('edit/{id}','PaperController@edit');
            Route::post('view/{id}','PaperController@view');
            Route::post('destroy/{id}','PaperController@destroy');
		Route::post('update/{id}','PaperController@update');
	});


//Researches :=> ResearchController
Route::group(['prefix'=>'researches', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','ResearchController@index');
		Route::post('store','ResearchController@store');
		Route::post('edit/{id}','ResearchController@edit');
		Route::post('view/{id}','ResearchController@view');
            Route::post('destroy/{id}','ResearchController@destroy');
		Route::post('update/{id}','ResearchController@update');
	});
//Books:=>  BookController
Route::group(['prefix'=>'books', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','BookController@index');
		Route::post('store','BookController@store');
            Route::post('edit/{id}','BookController@edit');
            Route::post('view/{id}','BookController@view');
		Route::post('destroy/{id}','BookController@destroy');
		Route::post('update/{id}','BookController@update');
	});

//Interests:=>  InterestController
Route::group(['prefix'=>'interests', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','InterestController@index');
		Route::post('store','InterestController@store');
		Route::post('edit/{id}','InterestController@edit');
		Route::post('destroy/{id}','InterestController@destroy');
		Route::post('update/{id}','InterestController@update');
	});

//Conferences:=>  ConferenceController
Route::group(['prefix'=>'conferences', 'middleware'=>'roles', 'roles'=>'admin'],
		function() {
		Route::get('index','ConferenceController@index');
		Route::post('store','ConferenceController@store');
		Route::post('edit/{id}','ConferenceController@edit');
		Route::post('destroy/{id}','ConferenceController@destroy');
		Route::post('update/{id}','ConferenceController@update');
	});


// TeacherReports:=>TeacherReportsController:=>
Route::group(['prefix'=>'re_teachers','middleware'=>'roles', 'roles'=>'admin'],
	function() {
	    Route::get('all_teachers','TeacherReportsController@index');
        Route::get('tr_data/{id}','TeacherReportsController@viewTeacher');
        Route::get('print/teacher/{id}','TeacherReportsController@printTeacher');
        Route::post('print/teachers/','TeacherReportsController@printTeachers');
	    Route::post('result','TeacherReportsController@resultTeacher');
});


// TeacherReports:=>TeacherReportsController:=>
Route::group(['prefix'=>'re_contacts','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','ContactReportController@index');
        Route::get('contact/{id}','ContactReportController@viewContact');
        Route::get('contact/print/{id}','ContactReportController@printContact');
        Route::post('contacts/print','ContactReportController@printContacts');
        Route::post('result','ContactReportController@resultContact');
    });


// CertificateReport:=>CertificateReportController:=>
Route::group(['prefix'=>'re_certificates','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','CertificateReportController@index');
        Route::get('certificate/{id}','CertificateReportController@viewCertificate');
        Route::get('certificate/print/{id}','CertificateReportController@printCertificate');
        Route::post('certificates/print','CertificateReportController@printCertificates');
        Route::post('result','CertificateReportController@resultCertificate');
    });


// ExperienceReport:=>ExperienceReportController:=>
Route::group(['prefix'=>'re_experiences','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','ExperienceReportController@index');
        Route::get('experience/{id}','ExperienceReportController@viewExperience');
        Route::get('experience/print/{id}','ExperienceReportController@printExperience');
        Route::post('experiences/print','ExperienceReportController@printExperiences');
        Route::post('result','ExperienceReportController@resultExperience');
    });


// SkillReports:=>SkillReportsController:=>
Route::group(['prefix'=>'re_skills','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','SkillReportsController@index');
        Route::get('skill/{id}','SkillReportsController@viewSkill');
        Route::get('skill/print/{id}','SkillReportsController@printSkill');
        Route::post('skills/print','SkillReportsController@printSkills');
        Route::post('result','SkillReportsController@resultSkill');
    });



// TrainingCourcesReports:=>TrainingReportsController:=>
Route::group(['prefix'=>'re_training','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','TrainingReportsController@index');
        Route::get('training/{id}','TrainingReportsController@viewTraining');
        Route::get('training/print/{id}','TrainingReportsController@printTraining');
        Route::post('trainings/print','TrainingReportsController@printTrainings');
        Route::post('result','TrainingReportsController@resultTraining');
    });

// PaperReports:=>PaperReportsController:=>
Route::group(['prefix'=>'re_papers','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','PaperReportsController@index');
        Route::get('paper/{id}','PaperReportsController@viewPaper');
        Route::get('paper/print/{id}','PaperReportsController@printPaper');
        Route::post('print/papers/','PaperReportsController@printPapers');
        Route::post('result','PaperReportsController@resultPaper');
    });



// ResearcheReports:=>ResearcheReportsController:=>
Route::group(['prefix'=>'re_researches','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','ResearcheReportsController@index');
        Route::get('researche/{id}','ResearcheReportsController@viewResearche');
        Route::get('researche/print/{id}','ResearcheReportsController@printResearche');
        Route::post('print/researches/','ResearcheReportsController@printResearches');
        Route::post('result','ResearcheReportsController@resultResearche');
    });


// BookReports:=>BookReportsController:=>
Route::group(['prefix'=>'re_books','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','BookReportsController@index');
        Route::get('book/{id}','BookReportsController@viewBook');
        Route::get('book/print/{id}','BookReportsController@printBook');
        Route::post('print/books/','BookReportsController@printBooks');
        Route::post('result','BookReportsController@resultBook');
    });


// InterestsReports:=>InterestsReportsController:=>
Route::group(['prefix'=>'re_interests','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','InterestsReportsController@index');
        Route::get('interest/{id}','InterestsReportsController@viewInterest');
        Route::get('interest/print/{id}','InterestsReportsController@printInterest');
        Route::post('interests/print','InterestsReportsController@printInterests');
        Route::post('result','InterestsReportsController@resultInterest');
    });

//ConferenceReports:=>ConferencesReportsController:=>
Route::group(['prefix'=>'re_conferences','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','ConferencesReportsController@index');
        Route::get('conference/{id}','ConferencesReportsController@viewConference');
        Route::get('conference/print/{id}','ConferencesReportsController@printConference');
        Route::post('conferences/print','ConferencesReportsController@printConferences');
        Route::post('result','ConferencesReportsController@resultConference');
    });


//GenaralStatistics:=>GenaralStatisticsController:=>
Route::group(['prefix'=>'GenaralStatistics','middleware'=>'roles', 'roles'=>'admin'],
    function() {
        Route::get('index','GenaralStatisticsController@index');
        Route::get('conference/{id}','GenaralStatisticsController@viewConference');
        Route::get('conference/print/{id}','GenaralStatisticsController@printConference');
        Route::post('store','GenaralStatisticsController@store');
        Route::post('show','GenaralStatisticsController@show');
        Route::post('view','GenaralStatisticsController@view');
        Route::delete('destroy','GenaralStatisticsController@destroy');
    });
