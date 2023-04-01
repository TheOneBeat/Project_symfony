<?php
namespace App\Service;

class PasswordChecker
{
    private $forbiddenPasswords = ['azerty', 'qwerty', '123456'];

    public function isPasswordRobust(string $password): bool
    {
        if (strlen($password) < 6) {
            return false;
        }

        foreach ($this->forbiddenPasswords as $forbiddenPassword) {
            if ($password === $forbiddenPassword) {
                return false;
            }
        }

        return true;
    }
}
