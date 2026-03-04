<?php

namespace App\Domain\Models;

class User
{
    public protected(set) ?int $id;
    public protected(set) string $username;
    private ?string $password;

    /**
     * @param int|null $id
     * @param string $username
     * @param ?string $password
     */
    public function __construct(?int $id, string $username, ?string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->password);
    }
}