<?php

namespace App\Services;

use App\Exceptions\SocialiteServiceException;
use App\Helpers\FileHelper;
use App\Models\UserSocialAccount;
use App\Repositories\UserRepository;
use App\Services\Users\UpdateAvatarService;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialiteService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly UpdateAvatarService $updateAvatarService
    ) {
    }

    public function handle(string $provider): string
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            $account = UserSocialAccount::where([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
            ])->first();

            if (!$account) {
                $user = $this->userRepository->getUserByEmail($socialUser->getEmail());

                if (!$user) {
                    $user = $this->userRepository->create([
                        'email' => $socialUser->getEmail(),
                        'username' => $socialUser->getNickname(),
                        'fullname' => $socialUser->getName(),
                    ]);

                    $file = FileHelper::createFromUrl($socialUser->getAvatar());
                    $this->updateAvatarService->handle($user, $file);
                }

                $user->userSocialAccounts()->create([
                    'provider_id' => $socialUser->getId(),
                    'provider_name' => $provider,
                ]);
            }

            return JWTAuth::fromUser($user);
        } catch (\Exception $e) {
            throw new SocialiteServiceException($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
