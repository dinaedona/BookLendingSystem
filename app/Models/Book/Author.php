<?php

namespace App\Models\Book;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Author
{

    /**
     * @throws ValidationException
     */
    private function __construct(private readonly string $name)
    {
         $this->validate(['name' => $this->name]);
    }

    /**
     * @throws ValidationException
     * mixed[]
     */
    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:150'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @throws ValidationException
     */
    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function asString(): string
    {
        return $this->name;
    }
}

