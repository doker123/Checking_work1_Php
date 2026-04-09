<?php

use Src\Route;

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/admin/titles', [Controller\Admin\AcademicTitleController::class, 'index'])
    ->middleware('role:admin');
Route::add('GET', '/admin/titles/create', [Controller\Admin\AcademicTitleController::class, 'create'])
    ->middleware('role:admin');
Route::add('POST', '/admin/titles/store', [Controller\Admin\AcademicTitleController::class, 'store'])
    ->middleware('role:admin');
Route::add('GET', '/admin/titles/{id}', [Controller\Admin\AcademicTitleController::class, 'view'])
    ->middleware('role:admin');
Route::add('GET', '/admin/titles/{id}/edit', [Controller\Admin\AcademicTitleController::class, 'edit'])
    ->middleware('role:admin');
Route::add('POST', '/admin/titles/{id}/update', [Controller\Admin\AcademicTitleController::class, 'update'])
    ->middleware('role:admin');
Route::add('GET', '/admin/titles/{id}/delete', [Controller\Admin\AcademicTitleController::class, 'delete'])
    ->middleware('role:admin');

Route::add('GET', '/admin/statuses', [Controller\Admin\StatusDissertationController::class, 'index'])
    ->middleware('role:admin');
Route::add('GET', '/admin/statuses/create', [Controller\Admin\StatusDissertationController::class, 'create'])
    ->middleware('role:admin');
Route::add('POST', '/admin/statuses/store', [Controller\Admin\StatusDissertationController::class, 'store'])
    ->middleware('role:admin');
Route::add('GET', '/admin/statuses/{id}', [Controller\Admin\StatusDissertationController::class, 'view'])
    ->middleware('role:admin');
Route::add('GET', '/admin/statuses/{id}/edit', [Controller\Admin\StatusDissertationController::class, 'edit'])
    ->middleware('role:admin');
Route::add('POST', '/admin/statuses/{id}/update', [Controller\Admin\StatusDissertationController::class, 'update'])
    ->middleware('role:admin');
Route::add('GET', '/admin/statuses/{id}/delete', [Controller\Admin\StatusDissertationController::class, 'delete'])
    ->middleware('role:admin');

Route::add('GET', '/admin/aspirants', [Controller\Admin\AspirantController::class, 'index'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/aspirants/create', [Controller\Admin\AspirantController::class, 'create'])
    ->middleware('role:admin');
Route::add('POST', '/admin/aspirants/store', [Controller\Admin\AspirantController::class, 'store'])
    ->middleware('role:admin');
Route::add('GET', '/admin/aspirants/{id}', [Controller\Admin\AspirantController::class, 'view'])
    ->middleware('role:admin,director,aspirant');
Route::add('GET', '/admin/aspirants/{id}/edit', [Controller\Admin\AspirantController::class, 'edit'])
    ->middleware('role:admin');
Route::add('POST', '/admin/aspirants/{id}/update', [Controller\Admin\AspirantController::class, 'update'])
    ->middleware('role:admin');
Route::add('GET', '/admin/aspirants/{id}/delete', [Controller\Admin\AspirantController::class, 'delete'])
    ->middleware('role:admin');

Route::add('GET', '/admin/directors', [Controller\Admin\DirectorController::class, 'index'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/directors/create', [Controller\Admin\DirectorController::class, 'create'])
    ->middleware('role:admin');
Route::add('POST', '/admin/directors/store', [Controller\Admin\DirectorController::class, 'store'])
    ->middleware('role:admin');
Route::add('GET', '/admin/directors/{id}', [Controller\Admin\DirectorController::class, 'view'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/directors/{id}/edit', [Controller\Admin\DirectorController::class, 'edit'])
    ->middleware('role:admin');
Route::add('POST', '/admin/directors/{id}/update', [Controller\Admin\DirectorController::class, 'update'])
    ->middleware('role:admin');
Route::add('GET', '/admin/directors/{id}/delete', [Controller\Admin\DirectorController::class, 'delete'])
    ->middleware('role:admin');

Route::add('GET', '/admin/teams', [Controller\Admin\TeamController::class, 'index'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/teams/create', [Controller\Admin\TeamController::class, 'create'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/teams/store', [Controller\Admin\TeamController::class, 'store'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/teams/{id}', [Controller\Admin\TeamController::class, 'view'])
    ->middleware('role:admin,director,aspirant');
Route::add('GET', '/admin/teams/{id}/edit', [Controller\Admin\TeamController::class, 'edit'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/teams/{id}/update', [Controller\Admin\TeamController::class, 'update'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/teams/{id}/delete', [Controller\Admin\TeamController::class, 'delete'])
    ->middleware('role:admin,director');

Route::add('GET', '/admin/dissertations', [Controller\Admin\DissertationController::class, 'index'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/dissertations/create', [Controller\Admin\DissertationController::class, 'create'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/dissertations/store', [Controller\Admin\DissertationController::class, 'store'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/dissertations/{id}', [Controller\Admin\DissertationController::class, 'view'])
    ->middleware('role:admin,director,aspirant');
Route::add('GET', '/admin/dissertations/{id}/edit', [Controller\Admin\DissertationController::class, 'edit'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/dissertations/{id}/update', [Controller\Admin\DissertationController::class, 'update'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/dissertations/{id}/delete', [Controller\Admin\DissertationController::class, 'delete'])
    ->middleware('role:admin,director');

Route::add('GET', '/admin/publications', [Controller\Admin\PublicationController::class, 'index'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/publications/create', [Controller\Admin\PublicationController::class, 'create'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/publications/store', [Controller\Admin\PublicationController::class, 'store'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/publications/{id}', [Controller\Admin\PublicationController::class, 'view'])
    ->middleware('role:admin,director,aspirant');
Route::add('GET', '/admin/publications/{id}/edit', [Controller\Admin\PublicationController::class, 'edit'])
    ->middleware('role:admin,director');
Route::add('POST', '/admin/publications/{id}/update', [Controller\Admin\PublicationController::class, 'update'])
    ->middleware('role:admin,director');
Route::add('GET', '/admin/publications/{id}/delete', [Controller\Admin\PublicationController::class, 'delete'])
    ->middleware('role:admin,director');

Route::add('GET', '/report/defend', [Controller\Report\ReportController::class, 'defendReportForm']);

Route::add('POST', '/report/defend', [Controller\Report\ReportController::class, 'defendReport']);

Route::add('GET', '/report/search-aspirant', [Controller\Report\ReportController::class, 'searchAspirantForm']);

Route::add('POST', '/report/search-aspirant', [Controller\Report\ReportController::class, 'searchAspirant']);


Route::add('GET', '/post', [Controller\Public\PublicationsController::class, 'post']);
