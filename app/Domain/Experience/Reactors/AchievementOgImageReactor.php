<?php

namespace App\Domain\Experience\Reactors;

use App\Domain\Experience\Commands\SaveAchievementOgImage;
use App\Domain\Experience\Events\AchievementUnlocked;
use App\Domain\Experience\Projections\UserAchievementProjection;
use App\Models\User;
use App\Support\Browsershot\Browsershot;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class AchievementOgImageReactor extends Reactor implements ShouldQueue
{
    public function __construct(private Browsershot $browsershot)
    {
    }

    public function __invoke(AchievementUnlocked $event): void
    {
        $user = User::query()->where('id', $event->userId)->firstOrFail();

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('slug', $event->slug)->firstOrFail();

        $path = $userAchievement->getOgImagePath();

        $this->generateImage($user, $userAchievement, $path);

        command(SaveAchievementOgImage::forUserAchievement(
            userAchievement: $userAchievement,
        ));
    }

    public function generateImage(
        User $user,
        UserAchievementProjection $userAchievement,
        string $path,
    ) {
        Storage::disk('public')->put(
            $path,
            $this->browsershot
                ->setHtml(
                    view('front.profile.achievementOgImage', [
                        'achievement' => $userAchievement,
                        'user' => $user,
                    ])->render()
                )
                ->devicePixelRatio(2)
                ->windowSize(1200, 630)
                ->screenshot()
        );
    }
}
