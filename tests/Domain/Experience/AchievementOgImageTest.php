<?php

namespace Tests\Domain\Experience;

use App\Domain\Experience\Commands\UnlockAchievement;
use App\Domain\Experience\Events\AchievementUnlocked;
use Database\Factories\AchievementFactory;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\StoredEvents\HandleStoredEventJob;
use Tests\TestCase;

class AchievementOgImageTest extends TestCase
{
    /** @test */
    public function og_image_reactor_is_queued()
    {
        $achievement = AchievementFactory::new()->create();

        $user = UserFactory::new()->create();

        Bus::fake();

        command(new UnlockAchievement($user->uuid, $user->id, $achievement));

        Bus::assertDispatched(function (HandleStoredEventJob $job) {
            return $job->storedEvent->event_class === AchievementUnlocked::class;
        });
    }

    /** @test */
    public function og_image_is_stored_on_the_filesystem()
    {
        $achievement = AchievementFactory::new()->create();

        $user = UserFactory::new()->create();

        $storage = Storage::fake('public');

        command(new UnlockAchievement($user->uuid, $user->id, $achievement));

        /** @var \App\Domain\Experience\Projections\UserAchievementProjection $userAchievement */
        $userAchievement = $user->achievements()->where('achievement_id', $achievement->id)->first();

        $storage->assertExists($userAchievement->getOgImagePath());
    }
}
