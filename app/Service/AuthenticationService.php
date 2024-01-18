<?php

namespace Service;

use Model\User;

class AuthenticationService
{
    private User $user;
    public function getCurrentUser(): ?User
    {
        if (isset($this->user)) {
            return $this->user;
        }

        session_start();
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            $user = User::getOneById($userId);

            $this->user = $user;

            return $user;
        } else {
            return null;
        }
    }
}