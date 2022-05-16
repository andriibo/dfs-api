<?php

namespace App\Http\Middleware;

use App\Repositories\ContestUserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContestUserAccess
{
    public function __construct(private readonly ContestUserRepository $contestUserRepository)
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $contestUserId = $this->getContestUserId($request);
        $entryContestUser = $this->contestUserRepository->getById($contestUserId);

        if ($request->user()->id !== $entryContestUser->user_id) {
            return response()->json(['message' => 'You are not allowed to see this lineup.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    /** @throws \Exception */
    private function getContestUserId(Request $request): int
    {
        if (!($contestUserId = $request->route('id'))) {
            throw new \Exception('Missing id');
        }

        return (int) $contestUserId;
    }
}
