<?php
declare(strict_types=1);

namespace Tracelabs\Controllers;

use Tracelabs\Core\Controller;
use Tracelabs\Core\Request;
use Tracelabs\Models\User;

class AuthController extends Controller
{
    public function showLogin(Request $request): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            $this->redirect('/investigations');
            return;
        }

        $this->view('auth/login', [
            'pageTitle' => 'Sign In // TraceLab',
            'error' => null
        ], 'auth');
    }

    public function login(Request $request): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = (string)$request->post('email', 'analyst@tracelab.local');
        $password = (string)$request->post('password', 'tracelab2026');

        User::seedDefaultUser();
        $user = User::authenticate($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $this->redirect('/investigations');
            return;
        }

        $this->view('auth/login', [
            'pageTitle' => 'Sign In // TraceLab',
            'error' => 'Invalid analyst credentials. (Hint: analyst@tracelab.local / tracelab2026)'
        ], 'auth');
    }

    public function logout(Request $request): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('/login');
    }
}
