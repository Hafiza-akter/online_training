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


class ReservationTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_user_can_see_reservation_view_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->get(route('reservation'));
        $response->assertStatus(200);
    }

    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_can_see_sort_reservation_page()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->get(route('sorting'));
        $response->assertStatus(200);

    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_reservation_page_by_history()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->post(route('sorting'),[
            'sorting'=>'history'
        ]);
        $response->assertStatus(200);

    }
     // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_reservation_page_by_recommened()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->post(route('sorting'),[
            'sorting'=>'recommended'
        ]);
        $response->assertStatus(200);

    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_reservation_avaialable_time()
    {
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id,
            'purchase_plan_id'=>1
        ]);
        // dd( \Carbon\Carbon::now()->addDays(rand(1, 30)));
        $schedule = factory(TrainerSchedule::class,1)->create([
            'user_id' =>  $user->id,
            'date'=>$this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d')
        ]);


        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d');

        $response = $this->get(route('datereservation',$fakeDate));
                 
        $response->assertStatus(200);

    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_reservation_avaialable_time_submit()
    {
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id,
            'purchase_plan_id'=>1
        ]);
        // dd( \Carbon\Carbon::now()->addDays(rand(1, 30)));
        $schedule = factory(TrainerSchedule::class,1)->create([
            'user_id' =>  $user->id,
            'date'=>$this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d')
        ]);


        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d');

        $response = $this->get(route('datereservation',$fakeDate));
                 
        $response->assertStatus(200);

    }
    
}
