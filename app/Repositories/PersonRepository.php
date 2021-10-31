<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Support\Facades\Auth;

class PersonRepository
{
    public ?Person $person;

    public function setPerson($person): bool
    {
        if (filter_var($person, FILTER_VALIDATE_INT))
            $this->person = Person::find($person);
        else
            $this->person = $person;
        return (bool)$this->person;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function create(string $firstName, string $lastName, int $userID = null): bool
    {
        $person = Person::create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'user_id'    => $userID ?? Auth::id()
        ]);
        if (!$person) return false;
        $this->setPerson($person);
        return true;
    }

    public function update(string $firstName, string $lastName): bool
    {
        return $this->getPerson()->update(['first_name' => $firstName, 'last_name' => $lastName]);
    }

    public function delete(): bool
    {
        return $this->getPerson()->delete();
    }
}
