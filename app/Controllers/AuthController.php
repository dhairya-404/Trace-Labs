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

        $email = trim((string)$request->post('email', ''));
        $password = (string)$request->post('password', '');

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
            'error' => 'Invalid analyst identity or security passkey. Please verify your credentials.'
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
