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

class LoginTest extends TestCase
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
    public function testLoginGetReturnsForm(): void
    {
        Auth::generateCSRF();

        $this->setupRequest('GET', []);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->login($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Авторизация', $output);
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginWithInvalidCSRF(): void
    {
        $_SESSION['csrf_token'] = 'valid_token';

        $this->setupRequest('POST', [
            'login' => 'test',
            'password' => 'test',
            'csrf_token' => 'invalid_token'
        ]);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->login($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        $this->assertStringContainsString('Неверный CSRF-токен', $output);
    }

    /**
     * @dataProvider loginDataProvider
     * @runInSeparateProcess
     */
    public function testLogin(array $userData, string $expectedResult): void
    {
        Auth::generateCSRF();
        $userData['csrf_token'] = $_SESSION['csrf_token'];

        $this->setupRequest('POST', $userData);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->login($request);
        } catch (\Exception $e) {
        }
        $output = ob_get_clean();

        if ($expectedResult === 'redirect') {
            $this->assertNotNull(Session::get('user_id'), 'user_id должен быть установлен в сессии');
            $this->assertNotNull(Session::get('user_type'), 'user_type должен быть установлен в сессии');
        } else {
            $this->assertStringContainsString($expectedResult, $output);
        }
    }

    public static function loginDataProvider(): array
    {
        $testLogin = 'login_test_' . md5((string)time());
        $testPassword = 'testpass123';

        Admin::create([
            'login' => $testLogin,
            'password' => $testPassword,
            'name' => 'Login Test Admin',
        ]);

        return [
            [
                ['login' => '', 'password' => ''],
                'Неверный логин или пароль'
            ],
            [
                ['login' => $testLogin, 'password' => 'wrongpassword'],
                'Неверный логин или пароль'
            ],
            [
                ['login' => 'nonexistent_user', 'password' => $testPassword],
                'Неверный логин или пароль'
            ],
            [
                ['login' => $testLogin, 'password' => $testPassword],
                'redirect'
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginAsAspirant(): void
    {
        $testLogin = 'aspirant_login_' . md5((string)time());
        $testPassword = 'aspirant_pass_123';

        Aspirant::create([
            'login' => $testLogin,
            'password' => $testPassword,
            'name' => 'Test',
            'patronum' => 'Test',
            'last_name' => 'Aspirant',
            'date_of_birth' => '1995-01-01',
            'gender' => 1,
            'citizenship' => 'РФ',
            'identity_document' => 'Паспорт',
        ]);

        Auth::generateCSRF();

        $this->setupRequest('POST', [
            'login' => $testLogin,
            'password' => $testPassword,
            'csrf_token' => $_SESSION['csrf_token']
        ]);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->login($request);
        } catch (\Exception $e) {
        }
        ob_end_clean();

        $this->assertEquals('aspirant', Session::get('user_type'));

        Aspirant::where('login', $testLogin)->delete();
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoginAsDirector(): void
    {
        $testLogin = 'director_login_' . md5((string)time());
        $testPassword = 'director_pass_123';

        $title = \Model\AcademicTitle::first();
        $titleId = $title ? $title->title_id : null;

        ScientificDirector::create([
            'login' => $testLogin,
            'password' => $testPassword,
            'name' => 'Test',
            'patronum' => 'Test',
            'last_name' => 'Director',
            'date_of_birth' => '1980-01-01',
            'gender' => 1,
            'citizenship' => 'РФ',
            'academic_degree' => 'к.т.н.',
            'title_id' => $titleId,
        ]);

        Auth::generateCSRF();

        $this->setupRequest('POST', [
            'login' => $testLogin,
            'password' => $testPassword,
            'csrf_token' => $_SESSION['csrf_token']
        ]);
        $request = new Request();

        $controller = new Site();

        ob_start();
        try {
            $controller->login($request);
        } catch (\Exception $e) {
        }
        ob_end_clean();

        $this->assertEquals('director', Session::get('user_type'));

        ScientificDirector::where('login', $testLogin)->delete();
    }
}
