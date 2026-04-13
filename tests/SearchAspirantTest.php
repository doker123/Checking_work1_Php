<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Src\Session;
use Src\View;
use Src\Auth\Auth;
use Controller\Report\ReportController;
use Model\ScientificDirector;
use Model\Aspirant;
use Model\DevelopmentTeam;

class SearchAspirantTest extends TestCase
{
    private function setupRequest(string $method, array $data): void
    {
        $_SERVER['REQUEST_METHOD'] = $method;
        $_POST = $data;
        $_GET = [];
    }

    protected function setUp(): void
    {
        parent::setUp();

        if (!function_exists('getallheaders')) {
            function getallheaders() { return []; }
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SERVER['DOCUMENT_ROOT'] = 'C:/Programs/xampp/htdocs';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_POST = [];
        $_GET = [];

        $config = include __DIR__ . '/../config/app.php';
        $config['db'] = include __DIR__ . '/../config/db.php';
        $config['path'] = include __DIR__ . '/../config/path.php';

        $GLOBALS['app'] = new \Src\Application($config);

        if (!function_exists('app')) {
            function app() {
                return $GLOBALS['app'];
            }
        }
    }

    protected function tearDown(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_unset();
        }
        $_POST = [];
        $_GET = [];
        parent::tearDown();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchFormReturnsView(): void
    {
        Auth::generateCSRF();
        $this->setupRequest('GET', []);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirantForm();
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Поиск аспирантов', $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchWithEmptyQueryReturnsEmptyResults(): void
    {
        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => '']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Поиск аспирантов', $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchWithShortQueryReturnsEmptyResults(): void
    {
        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'а']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Аспиранты не найдены', $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchByDirectorFullName(): void
    {
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        $director = ScientificDirector::create([
            'login' => 'director_search_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Алексей',
            'patronum' => 'Петрович',
            'last_name' => 'Петров',
            'date_of_birth' => '1975-05-10',
            'gender' => 1,
            'citizenship' => 'РФ',
            'academic_degree' => 'д.т.н.',
            'title_id' => $titleId,
        ]);

        $aspirant1 = Aspirant::create([
            'login' => 'aspirant_s1_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Иван',
            'patronum' => 'Иванович',
            'last_name' => 'Иванов',
            'date_of_birth' => '1995-03-15',
            'gender' => 1,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        $aspirant2 = Aspirant::create([
            'login' => 'aspirant_s2_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Мария',
            'patronum' => 'Сергеевна',
            'last_name' => 'Сидорова',
            'date_of_birth' => '1996-07-20',
            'gender' => 0,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        DevelopmentTeam::create([
            'director_id' => $director->director_id,
            'aspirant_id' => $aspirant1->aspirant_id,
        ]);

        DevelopmentTeam::create([
            'director_id' => $director->director_id,
            'aspirant_id' => $aspirant2->aspirant_id,
        ]);

        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'Петров']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Иванов', $output);
        $this->assertStringContainsString('Сидорова', $output);

        DevelopmentTeam::where('director_id', $director->director_id)->delete();
        $aspirant1->delete();
        $aspirant2->delete();
        $director->delete();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchByDirectorLastNameOnly(): void
    {
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        $director = ScientificDirector::create([
            'login' => 'director_lname_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Елена',
            'patronum' => 'Владимировна',
            'last_name' => 'Смирнова',
            'date_of_birth' => '1980-11-25',
            'gender' => 0,
            'citizenship' => 'РФ',
            'academic_degree' => 'к.ф.н.',
            'title_id' => $titleId,
        ]);

        $aspirant = Aspirant::create([
            'login' => 'aspirant_ln_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Дмитрий',
            'patronum' => 'Алексеевич',
            'last_name' => 'Козлов',
            'date_of_birth' => '1997-01-10',
            'gender' => 1,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        DevelopmentTeam::create([
            'director_id' => $director->director_id,
            'aspirant_id' => $aspirant->aspirant_id,
        ]);

        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'Смирнова']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Козлов', $output);

        DevelopmentTeam::where('director_id', $director->director_id)->delete();
        $aspirant->delete();
        $director->delete();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchReturnsNoResultsForNonMatchingQuery(): void
    {
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        $director = ScientificDirector::create([
            'login' => 'director_nomatch_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Олег',
            'patronum' => 'Николаевич',
            'last_name' => 'Волков',
            'date_of_birth' => '1978-08-14',
            'gender' => 1,
            'citizenship' => 'РФ',
            'academic_degree' => 'д.б.н.',
            'title_id' => $titleId,
        ]);

        $aspirant = Aspirant::create([
            'login' => 'aspirant_nm_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Анна',
            'patronum' => 'Павловна',
            'last_name' => 'Новикова',
            'date_of_birth' => '1998-04-05',
            'gender' => 0,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        DevelopmentTeam::create([
            'director_id' => $director->director_id,
            'aspirant_id' => $aspirant->aspirant_id,
        ]);

        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'Несуществующий']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringNotContainsString('Новикова', $output);

        DevelopmentTeam::where('director_id', $director->director_id)->delete();
        $aspirant->delete();
        $director->delete();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchByDirectorFirstName(): void
    {
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        $director = ScientificDirector::create([
            'login' => 'director_fname_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Николай',
            'patronum' => 'Иванович',
            'last_name' => 'Федоров',
            'date_of_birth' => '1982-02-28',
            'gender' => 1,
            'citizenship' => 'РФ',
            'academic_degree' => 'к.т.н.',
            'title_id' => $titleId,
        ]);

        $aspirant = Aspirant::create([
            'login' => 'aspirant_fn_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Ольга',
            'patronum' => 'Дмитриевна',
            'last_name' => 'Белова',
            'date_of_birth' => '1999-09-12',
            'gender' => 0,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        DevelopmentTeam::create([
            'director_id' => $director->director_id,
            'aspirant_id' => $aspirant->aspirant_id,
        ]);

        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'Николай']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Белова', $output);

        DevelopmentTeam::where('director_id', $director->director_id)->delete();
        $aspirant->delete();
        $director->delete();
    }

    /**
     * @runInSeparateProcess
     */
    public function testSearchWithMultipleDirectors(): void
    {
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        $director1 = ScientificDirector::create([
            'login' => 'director_multi1_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Андрей',
            'patronum' => 'Сергеевич',
            'last_name' => 'Кузнецов',
            'date_of_birth' => '1976-06-18',
            'gender' => 1,
            'citizenship' => 'РФ',
            'academic_degree' => 'д.т.н.',
            'title_id' => $titleId,
        ]);

        $director2 = ScientificDirector::create([
            'login' => 'director_multi2_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Татьяна',
            'patronum' => 'Андреевна',
            'last_name' => 'Кузнецова',
            'date_of_birth' => '1983-12-03',
            'gender' => 0,
            'citizenship' => 'РФ',
            'academic_degree' => 'к.х.н.',
            'title_id' => $titleId,
        ]);

        $aspirant1 = Aspirant::create([
            'login' => 'aspirant_m1_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Павел',
            'patronum' => 'Олегович',
            'last_name' => 'Морозов',
            'date_of_birth' => '1997-05-22',
            'gender' => 1,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        $aspirant2 = Aspirant::create([
            'login' => 'aspirant_m2_' . md5((string)time()),
            'password' => 'password123',
            'name' => 'Светлана',
            'patronum' => 'Игоревна',
            'last_name' => 'Волкова',
            'date_of_birth' => '1998-08-30',
            'gender' => 0,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        DevelopmentTeam::create([
            'director_id' => $director1->director_id,
            'aspirant_id' => $aspirant1->aspirant_id,
        ]);

        DevelopmentTeam::create([
            'director_id' => $director2->director_id,
            'aspirant_id' => $aspirant2->aspirant_id,
        ]);

        Auth::generateCSRF();
        $this->setupRequest('POST', ['search' => 'Кузнец']);
        $request = new Request();

        $controller = new ReportController();

        ob_start();
        try {
            $controller->searchAspirant($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Морозов', $output);
        $this->assertStringContainsString('Волкова', $output);

        DevelopmentTeam::where('director_id', $director1->director_id)->delete();
        DevelopmentTeam::where('director_id', $director2->director_id)->delete();
        $aspirant1->delete();
        $aspirant2->delete();
        $director1->delete();
        $director2->delete();
    }
}
