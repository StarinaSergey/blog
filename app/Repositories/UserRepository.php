<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    private User $client;

    public function __construct(User $client)
    {
        $this->client = $client;
    }

    public function getClientForEmail(string $email): ?User
    {
        $clientModel = $this->client::where('email', '=', strtolower($email))
            ->first();

        if(($clientModel instanceof User)){
            return $clientModel;
        }
        return null;
    }

    public function setPassword(User $client, string $password): void
    {
        $client->password = $password;
        $client->save();
    }
}
