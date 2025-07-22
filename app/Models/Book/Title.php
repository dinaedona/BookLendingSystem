<?php

namespace App\Models\Book;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Title
{

    /**
     * @throws ValidationException
     */
    private function __construct(private readonly string $title)
    {
         $this->validate(['title' => $this->title]);
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    /**
     * @throws ValidationException
     */
    public static function fromString(string $title): self
    {
        return new self($title);
    }

    public function asString(): string
    {
        return $this->title;
    }
}

