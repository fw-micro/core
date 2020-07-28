<?php

namespace fw_micro\core\auth;

use fw_micro\pattern\Register\Register;
use fw_micro\security\CSRF;
use fw_micro\security\Password;

/**
 * Class Auth
 * @package fw_micro\core\auth
 */
class Auth implements AuthInterface
{
    private $errors = [];
    private $idIsAI = false;
    private $table = '';
    private $isCsrf = false;

    public function isLogin(): bool
    {
        return $_SESSION['auth'] ?? false;
    }

    public function login(string $login, string $password): bool
    {
        if ($this->isCsrf && !CSRF::validate()) {
            return false;
        }
        $login = sha1($login);
        $select = Register::get()->db->select($this->table, ['id', 'password'], ['login' => $login]);
        if (is_array($select) && count($select)) {
            if (Password::verify($password, $select['password'])) {
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $select['id'];
                return true;
            }
        }

        $this->errors[] = 'Not exist';
        $this->errors[] = Register::get()->db->error();
        return false;
    }

    public function logout(): void
    {
        session_destroy();
        session_regenerate_id();
        session_start();
    }

    public function register(string $login, string $password): bool
    {
        if ($this->isCsrf && !CSRF::validate()) {
            return false;
        }

        $login = sha1($login);
        $exist = Register::get()->db->select($this->table, ['id'], ['login' => $login]);

        if (is_array($exist) && count($exist)) {
            $this->errors[] = 'login exist';
            return false;
        }

        $hash = Password::hash($password);
        $data = [
            'login' => $login,
            'password' => $hash
        ];
        while (true) {
            if (!$this->idIsAI) {
                $data['id'] = Register::get()->db->count($this->table) + 1;
            }
            if (!Register::get()->db->insert($this->table, $data)) {
                if ($this->idIsAI) {
                    $this->errors[] = Register::get()->db->error();
                    return false;
                }
            } else {
                break;
            }
        }
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function __construct(array $config)
    {
        $this->table = $config['table'];
        $this->idIsAI = $config['idIsAI'];
        $this->isCsrf = $config['isCsrf'] ?? true;
    }
}
