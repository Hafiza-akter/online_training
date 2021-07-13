<?php
namespace Tests\Feature\Trainee;

use App\Model\User;
use App\Model\UserPlanPurchase;
use App\Model\Trainer;
use App\Model\TrainerSchedule;
use App\Model\UserEquipment;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;


class FavouriteTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_user_can_see_trainrList()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->get(route('trainerlist'));
        $response->assertStatus(200);
    }
    public function test_user_can_see_trainerDetails()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        $trainer = factory(Trainer::class)->create();


        $response = $this->get(route('trainerDetails',$trainer->id));
        $response->assertStatus(200);
    }
    public function test_user_can_saved_favourite()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        $trainer = factory(Trainer::class)->create();


        $response = $this->post(route('favouritetrainer'),
            [
                'trainer_id'=>$trainer->id,
                'user_id'=>$user->id
            ]
        );
        $response->assertStatus(302);
    }
    public function test_user_can_remove_favourite()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        $trainer = factory(Trainer::class)->create();


        $response = $this->post(route('favouritetrainer'),
            [
                'trainer_id'=>$trainer->id,
                'user_id'=>$user->id
            ]
        );
        $response->assertStatus(302);
    }
    
    
    
}
