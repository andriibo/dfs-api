<?php

namespace App\Http\Middleware;

use App\Repositories\ContestUserRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContestUserAccess
{
    public function __construct(private readonly ContestUserRepository $contestUserRepository)
    {
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $entryId = $this->getEntryId($request);
        $entryContestUser = $this->contestUserRepository->getById($entryId);

        if ($request->user()->id !== $entryContestUser->user_id) {
            return response()->json(['message' => 'You are not allowed to see this lineup.'], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }

    /** @throws \Exception */
    protected function getEntryId(Request $request): int
    {
        if (!($entryId = $request->route('entryId'))) {
            throw new \Exception('Missing entryId');
        }

        return (int) $entryId;
    }
}
