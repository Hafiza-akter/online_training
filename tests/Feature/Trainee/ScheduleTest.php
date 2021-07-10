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


class ScheduleTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_user_can_see_monthly_calendar_view()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);


        $response = $this->get(route('traineeCalendar.view'));
        $response->assertStatus(200);
    }

    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_can_see_valid_date_reservation_page()
    {
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween('now', '+5 days')->format('Y-m-d');
                       
        $response = $this->post(route('traineeCalendar.submit'),[
            'selected_date' => $fakeDate
        ]);


       $response->assertRedirect(route('datereservation',$fakeDate));

        $response->assertStatus(302);
    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */

    public function test_user_can_see_not_see_past_date_reservation_page()
    {
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween( '-5 days','now')->format('Y-m-d');
                       
        $response = $this->post(route('traineeCalendar.submit'),[
            'selected_date' => $fakeDate
        ]);


       // $response->assertRedirect(route('traineeCalendar.view'));

        $response->assertStatus(302);
    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_can_not_see_reservation_page_when_plan_date_expired()
    {   
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id,
            'created_at' =>'2021-06-15',
            'purchase_plan_id' =>1
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+10 days')->format('Y-m-d');
                       
        $response = $this->post(route('traineeCalendar.submit'),[
            'selected_date' => '2021-07-16'
        ]);
        // $response->assertRedirect(route('traineeCalendar.view'));

        $response->assertStatus(302);
    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_user_can_not_see_reservation_page_when_weekly_plan_limit_excced()
    {   
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id,
            'purchase_plan_id'=>1
        ]);
        // dd( \Carbon\Carbon::now()->addDays(rand(1, 30)));
        $schedule = factory(TrainerSchedule::class,3)->create([
            'user_id' =>  $user->id,
            'is_occupied'=>1
        ]);


        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d');
        
        $response = $this->post(route('trainerSubmitBytime'),[
            'selected_date' => $fakeDate
        ]);
        // $response->assertRedirect(route('traineeCalendar.view'));

        $response->assertStatus(302);
    }

    
    
}
