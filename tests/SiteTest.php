<?php

use PHPUnit\Framework\TestCase;
use Src\Request;
use Src\Session;
use Src\View;
use Src\Auth\Auth;
use Controller\Site;
use Model\Admin;
use Model\Aspirant;
use Model\ScientificDirector;

class SiteTest extends TestCase
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
     * @dataProvider signupAdminDataProvider
     * @runInSeparateProcess
     */
    public function testSignupAdmin(string $httpMethod, array $userData, string $expectedMessage): void
    {
        Auth::generateCSRF();
        $userData['csrf_token'] = $_SESSION['csrf_token'];

        if (($userData['login'] ?? '') === 'login_is_busy') {
            $existingAdmin = Admin::first();
            if ($existingAdmin) {
                $userData['login'] = $existingAdmin->login;
            }
        }

        $this->setupRequest($httpMethod, $userData);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->signup($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        if (($userData['user_type'] ?? '') === 'admin' && !empty($userData['login'])) {
            $admin = Admin::where('login', $userData['login'])->first();
            if ($expectedMessage === 'redirect') {
                $this->assertNotNull($admin, 'Администратор должен быть создан');
                $admin->delete();
            }
        }

        if ($expectedMessage !== 'redirect') {
            $expectedPattern = '/' . preg_quote($expectedMessage, '/') . '/';
            $this->assertMatchesRegularExpression($expectedPattern, $output);
        }
    }

    public static function signupAdminDataProvider(): array
    {
        return [
            [
                'GET',
                ['user_type' => 'admin', 'name' => '', 'login' => '', 'password' => ''],
                '<h2 class="auth-title">Регистрация</h2>'
            ],
            [
                'POST',
                ['user_type' => 'admin', 'name' => '', 'login' => '', 'password' => ''],
                'Поле login обязательно для заполнения'
            ],
            [
                'POST',
                ['user_type' => 'admin', 'name' => 'Test Admin', 'login' => 'login_is_busy', 'password' => 'testpass123'],
                'Пользователь с таким логином уже существует'
            ],
            [
                'POST',
                ['user_type' => 'admin', 'name' => 'Новый Админ', 'login' => 'new_admin_' . md5((string)time()), 'password' => 'securepass123'],
                'redirect'
            ],
        ];
    }

    /**
     * @dataProvider signupAspirantDataProvider
     * @runInSeparateProcess
     */
    public function testSignupAspirant(string $httpMethod, array $userData, string $expectedMessage): void
    {
        Auth::generateCSRF();
        $userData['csrf_token'] = $_SESSION['csrf_token'];

        if (($userData['login'] ?? '') === 'login_is_busy') {
            $existingAspirant = Aspirant::first();
            if ($existingAspirant) {
                $userData['login'] = $existingAspirant->login;
            }
        }

        $this->setupRequest($httpMethod, $userData);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->signup($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        if (!empty($userData['login']) && $expectedMessage === 'redirect') {
            $aspirant = Aspirant::where('login', $userData['login'])->first();
            $this->assertNotNull($aspirant, 'Аспирант должен быть создан');
            $aspirant->delete();
        }

        if ($expectedMessage !== 'redirect') {
            $expectedPattern = '/' . preg_quote($expectedMessage, '/') . '/';
            $this->assertMatchesRegularExpression($expectedPattern, $output);
        }
    }

    public static function signupAspirantDataProvider(): array
    {
        return [
            [
                'GET',
                [
                    'user_type' => 'aspirant',
                    'name' => '', 'login' => '', 'password' => '',
                    'aspirant_last_name' => '', 'aspirant_patronum' => '',
                    'aspirant_date_of_birth' => '', 'aspirant_gender' => '',
                    'aspirant_citizenship' => '', 'aspirant_identity_document' => ''
                ],
                '<h2 class="auth-title">Регистрация</h2>'
            ],
            [
                'POST',
                [
                    'user_type' => 'aspirant',
                    'name' => 'Test', 'login' => 'testasp', 'password' => 'pass123',
                    'aspirant_last_name' => '', 'aspirant_patronum' => '',
                    'aspirant_date_of_birth' => '', 'aspirant_gender' => '',
                    'aspirant_citizenship' => '', 'aspirant_identity_document' => ''
                ],
                'Поле aspirant_last_name обязательно для заполнения'
            ],
            [
                'POST',
                [
                    'user_type' => 'aspirant',
                    'name' => 'Test', 'login' => 'login_is_busy', 'password' => 'pass123',
                    'aspirant_last_name' => 'Иванов', 'aspirant_patronum' => 'Иванович',
                    'aspirant_date_of_birth' => '1995-01-01', 'aspirant_gender' => '1',
                    'aspirant_citizenship' => 'РФ', 'aspirant_identity_document' => 'Паспорт'
                ],
                'Пользователь с таким логином уже существует'
            ],
            [
                'POST',
                [
                    'user_type' => 'aspirant',
                    'name' => 'Иван', 'login' => 'new_aspirant_' . md5((string)time()), 'password' => 'pass123',
                    'aspirant_last_name' => 'Иванов', 'aspirant_patronum' => 'Иванович',
                    'aspirant_date_of_birth' => '1995-05-15', 'aspirant_gender' => '1',
                    'aspirant_citizenship' => 'РФ', 'aspirant_identity_document' => 'Паспорт 1234'
                ],
                'redirect'
            ],
        ];
    }

    /**
     * @dataProvider signupDirectorDataProvider
     * @runInSeparateProcess
     */
    public function testSignupDirector(string $httpMethod, array $userData, string $expectedMessage): void
    {
        // Создаём фиктивного директора для теста "занятый логин"
        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;
        $dummyDirector = ScientificDirector::where('login', 'dummy_login_is_busy')->first();
        if (!$dummyDirector) {
            ScientificDirector::create([
                'login' => 'dummy_login_is_busy',
                'password' => 'dummy123',
                'name' => 'Dummy',
                'patronum' => 'Dummy',
                'last_name' => 'Dummy',
                'date_of_birth' => '1980-01-01',
                'gender' => 1,
                'citizenship' => 'РФ',
                'academic_degree' => 'к.т.н.',
                'title_id' => $titleId,
            ]);
        }

        Auth::generateCSRF();
        $userData['csrf_token'] = $_SESSION['csrf_token'];

        if (($userData['login'] ?? '') === 'login_is_busy') {
            $existingDirector = ScientificDirector::where('login', 'dummy_login_is_busy')->first();
            if ($existingDirector) {
                $userData['login'] = $existingDirector->login;
            }
        }

        $this->setupRequest($httpMethod, $userData);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->signup($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        if (!empty($userData['login']) && $expectedMessage === 'redirect') {
            $director = ScientificDirector::where('login', $userData['login'])->first();
            $this->assertNotNull($director, 'Научный руководитель должен быть создан');
            $director->delete();
        }

        if ($expectedMessage !== 'redirect') {
            $expectedPattern = '/' . preg_quote($expectedMessage, '/') . '/';
            $this->assertMatchesRegularExpression($expectedPattern, $output);
        }
    }

    public static function signupDirectorDataProvider(): array
    {
        return [
            [
                'GET',
                [
                    'user_type' => 'director',
                    'name' => '', 'login' => '', 'password' => '',
                    'director_last_name' => '', 'director_patronum' => '',
                    'director_date_of_birth' => '', 'director_gender' => '',
                    'director_citizenship' => ''
                ],
                '<h2 class="auth-title">Регистрация</h2>'
            ],
            [
                'POST',
                [
                    'user_type' => 'director',
                    'name' => 'Test', 'login' => 'testdir', 'password' => 'pass123',
                    'director_last_name' => '', 'director_patronum' => '',
                    'director_date_of_birth' => '', 'director_gender' => '',
                    'director_citizenship' => ''
                ],
                'Поле director_last_name обязательно для заполнения'
            ],
            [
                'POST',
                [
                    'user_type' => 'director',
                    'name' => 'Test', 'login' => 'login_is_busy', 'password' => 'pass123',
                    'director_last_name' => 'Петров', 'director_patronum' => 'Петрович',
                    'director_date_of_birth' => '1980-01-01', 'director_gender' => '1',
                    'director_citizenship' => 'РФ'
                ],
                'Пользователь с таким логином уже существует'
            ],
            [
                'POST',
                [
                    'user_type' => 'director',
                    'name' => 'Петр', 'login' => 'new_director_' . md5((string)time()), 'password' => 'pass123',
                    'director_last_name' => 'Петров', 'director_patronum' => 'Петрович',
                    'director_date_of_birth' => '1980-03-10', 'director_gender' => '1',
                    'director_citizenship' => 'РФ', 'director_academic_degree' => 'к.т.н.',
                    'director_title_id' => '1'
                ],
                'redirect'
            ],
        ];
    }
}
