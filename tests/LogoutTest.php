<?php

use PHPUnit\Framework\TestCase;
use Src\Session;
use Src\Auth\Auth;
use Src\Settings;

class LogoutTest extends TestCase
{
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

        $GLOBALS['app'] = new \Src\Application(new Settings([
            'app' => include __DIR__ . '/../config/app.php',
            'db' => include __DIR__ . '/../config/db.php',
            'path' => include __DIR__ . '/../config/path.php',
        ]));

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
        parent::tearDown();
    }

    public function testAuthLogoutClearsAuthData(): void
    {
        Session::set('user_id', 123);
        Session::set('user_type', 'admin');

        $this->assertEquals(123, Session::get('user_id'));

        Auth::logout();

        $this->assertNull(Session::get('user_id'));
        $this->assertNull(Session::get('user_type'));
    }
}
