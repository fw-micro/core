<?php

namespace fw_micro\core\auth;

/**
 * Interface AuthInterface
 * @package fw_micro\core\auth
 */
interface AuthInterface
{
    public function __construct(array $config);

    /**
     * @return bool
     */
    public function isLogin(): bool;

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login(string $login, string $password): bool;

    /**
     *
     */
    public function logout(): void;

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function register(string $login, string $password): bool;

    /**
     * @return array
     */
    public function getErrors(): array;
}
