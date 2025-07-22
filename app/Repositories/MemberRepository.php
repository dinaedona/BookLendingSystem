<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User\Member;
use App\Models\User\MemberId;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class MemberRepository
 *
 * Handles direct database queries for members.
 */
class MemberRepository
{
    /**
     * Find a member by ID.
     *
     * @param int $id
     * @return object
     * @throws ValidationException
     */
    public function findById(MemberId $id): Member
    {
        return Member::fromArray(DB::table('members')->where('id', $id->asInt())->first()->toArray());
    }

}
