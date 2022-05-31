<?php

namespace App\Services;

use App\Events\UserActivatedEvent;
use App\Exceptions\SocialiteServiceException;
use App\Helpers\FileHelper;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserSocialAccountRepository;
use App\Services\Users\UpdateAvatarService;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UserSocialAccountRepository $userSocialAccountRepository,
        private readonly UpdateAvatarService $updateAvatarService
    ) {
    }

    public function handle(string $provider): string
    {
        try {
            $user = $this->getUser($provider);

            return JWTAuth::fromUser($user);
        } catch (\Exception $e) {
            throw new SocialiteServiceException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    private function getUser(string $provider): User
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $account = $this->userSocialAccountRepository->getAccountByParams($provider, $socialUser->getId());

        if ($account) {
            return $account->user;
        }

        $user = $this->userRepository->getUserByEmail($socialUser->getEmail());

        if (!$user) {
            $user = $this->userRepository->create([
                'email' => $socialUser->getEmail(),
                'username' => $socialUser->getNickname(),
                'fullname' => $socialUser->getName(),
            ]);

            $file = FileHelper::createFromUrl($socialUser->getAvatar());
            $this->updateAvatarService->handle($user, $file);
            event(new UserActivatedEvent($user));
        }

        $user->userSocialAccounts()->create([
            'provider_id' => $socialUser->getId(),
            'provider_name' => $provider,
        ]);

        return $user;
    }
}
