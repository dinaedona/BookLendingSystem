<?php

namespace App\Models\User;
use App\Utils\Parser;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\ValidationException;

class Member
{
    public function __construct(
        private readonly MemberId $id,
        private readonly Name $name,
        private readonly Email $email,
        private readonly string $membershipDate
    ) {
    }

    /**
     * @throws ValidationException
     */
    public static function fromArray(array $data): self
    {
        return new self(
            MemberId::fromInt(Parser::parseInt($data, 'id')),
            Name::fromString(Parser::parseString($data, 'name')),
            Email::fromString(Parser::parseString($data, 'email')),
            Parser::parseString($data, 'membership_date')
        );
    }

    /**
     * @throws ValidationException
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            MemberId::fromInt(Parser::parseInt($data, 'id')),
            Name::fromString(Parser::parseString($data, 'name')),
            Email::fromString(Parser::parseString($data, 'email'), true),
           Parser::parseString($data, 'membership_date')
        );
    }

    public function getId(): ?MemberId
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getMembershipDate(): string
    {
        return $this->membershipDate;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

}
