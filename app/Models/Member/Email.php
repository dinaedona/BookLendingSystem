<?php

namespace App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class Email
{
    /**
     * @throws ValidationException
     */
    private function __construct(
        private readonly string $email,
        private readonly bool $isUnique
    )
    {
        $this->validate(['email' => $email], $this->isUnique);
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data, bool $isUnique): void
    {
        $validationRules = 'required|email|max:150';
        if ($isUnique) {
            $validationRules .= '|unique:users,email';
        }
        $validator = Validator::make($data, [
            'email' => $validationRules
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @throws ValidationException
     */
    public static function fromString(string $email, bool $isUnique = false): self
    {
        return new self($email, $isUnique);
    }

    public function asString(): string
    {
        return $this->email;
    }
}
