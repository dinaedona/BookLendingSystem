<?php

declare(strict_types=1);

namespace App\Models\Common;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
abstract class Id
{
    /**
     * @param int|null $value
     * @return static|null
     */
    public static function fromNullableInt(?int $value): ?self
    {
        return $value !== null ? self::fromInt($value) : null;
    }

    /**
     * @throws ValidationException
     */
    final private function __construct(private readonly int $value)
    {
        $this->validate(['id' => $value]);
    }

    public function asInt(): int
    {
        return $this->value;
    }

    /**
     * @param static $id
     * @return bool
     */
    public function equals(Id $id): bool
    {
        return $this->value === $id->value;
    }

    public function equalsInt(int $id): bool
    {
        return $this->value === $id;
    }


    /**
     * @param positive-int $id
     * @return static
     */
    public static function fromInt(int $id): static
    {
        return new static($id);
    }

    /**
     * @throws ValidationException
     */
    private function validate(array $data): void
    {
        $validator = Validator::make($data, [
            'id' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
