<?php
namespace App\Service;

class PasswordChecker
{
    private $forbiddenPasswords = ['azerty', 'qwerty', '123456'];

    public function isPasswordRobust(string $password): array
    {
        if (strlen($password) < 6)
        {
            return [
                'isValid' => false,
                'errorMessage' => 'Le mot de passe doit contenir au moins 6 caractères.',


            ];
        }

        foreach ($this->forbiddenPasswords as $forbiddenPassword) {
            if ($password === $forbiddenPassword)
            {
                return [
                    'isValid' => false,
                    'errorMessage' => 'Le mot de passe est interdit. Veuillez en choisir un autre.',

                ];
            }
        }

        return ['isValid' => true,
            'errorMessage' => '',
            ];
    }
}
