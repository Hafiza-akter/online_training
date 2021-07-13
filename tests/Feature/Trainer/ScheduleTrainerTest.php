<?php
namespace Tests\Feature\Trainee;

use App\Model\User;
use App\Model\Trainer;
use App\Model\TrainerSchedule;
use App\Model\TrainerRecurringSchedule;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;


class ScheduleTrainerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_trainer_can_see_calendar_view()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);


        $response = $this->get(route('calendar.view','month'));
        $response->assertStatus(200);
    }

    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_trainer_weekly_schedule_creation()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);

        $fakeDate = $this->faker->unique()->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s');
         $listArray[0]['start']= $fakeDate;       

        $response = $this->post(route('schedule'),[
            'list' => json_encode($listArray),
            'trainer_id' => $user->id,
            'type' => 'initial_registration',
            'user_id' => null,

        ]);


        $response->assertStatus(302);
    }

    public function test_trainer_weekly_schedule_cancel()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
        $schedule = factory(TrainerSchedule::class)->create([
            'trainer_id' =>  $user->id ]);

        $fakeDate = $this->faker->unique()->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s');
                   
        $response = $this->post(route('schedule'),[
            'db_schedule_id' => $schedule->id,
            'type' => 'weekcancel',
            'db_date'=>$schedule->date
        ]);

        $response->assertStatus(302);
    }
    public function test_trainer_recurring_schedule_creation()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);

        $fakeDate = $this->faker->unique()->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s');
        $listArray[0]= array(
                    'startTime'=>\Carbon\Carbon::now()->addDays(rand(1, 5))->format('Y-m-d'),
                    'unique_id'=>'test',
                    'startRecur'=>\Carbon\Carbon::now()->addDays(rand(1, 5))->format('Y-m-d'), 
                    'daysOfWeek'=> array(3)
                ) ;              
        $response = $this->post(route('schedule'),[
            'list' => json_encode($listArray),
            'trainer_id' => $user->id,
            'unique_id' => 'test',
            'type' => 'recuring_event',


        ]);


        $response->assertStatus(302);
    }

    public function test_trainer_recurring_schedule_cancel()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
        $schedule = factory(TrainerRecurringSchedule::class)->create([
            'trainer_id' =>  $user->id,  ]);

                   
        $response = $this->post(route('schedule'),[
            'db_schedule_id' => $schedule->id,
            'db_date'=>$schedule->date,
            'event_type'=>'recurring',
            'type'=>'weekcancel'
        ]);

        $response->assertStatus(302);
    }

    public function test_trainer_cannot_cancel_schedule_when_givine_time_limit_exceed()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
        $fakeDate = $this->faker->unique()->dateTimeBetween('now', '+5 days');

        $schedule = factory(TrainerSchedule::class)->create([
            'trainer_id' =>  $user->id ,
            'time' =>  '10:50:00',
            'date'=>'2021-06-15 11:00:00',
            'is_occupied' => 1]
        );

                   
        $response = $this->post(route('schedule'),[
            'db_schedule_id' => $schedule->id,
            'type' => 'weekcancel',
            'db_date'=>$schedule->date
        ]);

        $response->assertSessionHas('errors_m');
        $response->assertStatus(302);
    }
    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */

    // public function test_user_can_see_not_see_past_date_reservation_page()
    // {
    //     $user = factory(User::class)->create();
    //     $plan = factory(UserPlanPurchase::class)->create([
    //         'user_id' =>$user->id
    //     ]);
    //     $this->actingAs($user)
    //                      ->withSession(['user' => $user,'user_type'=>'trainee']);

    //     $fakeDate = $this->faker->unique()->dateTimeBetween( '-5 days','now')->format('Y-m-d');
                       
    //     $response = $this->post(route('traineeCalendar.submit'),[
    //         'selected_date' => $fakeDate
    //     ]);


    //    // $response->assertRedirect(route('traineeCalendar.view'));

    //     $response->assertStatus(302);
    // }
    // // /**
    // //  * A valid user can be registered.
    // //  *
    // //  * @return void
    // //  */
    // public function test_user_can_not_see_reservation_page_when_plan_date_expired()
    // {   
    //     $user = factory(User::class)->create();
    //     $plan = factory(UserPlanPurchase::class)->create([
    //         'user_id' =>$user->id,
    //         'created_at' =>'2021-06-15',
    //         'purchase_plan_id' =>1
    //     ]);
    //     $this->actingAs($user)
    //                      ->withSession(['user' => $user,'user_type'=>'trainee']);

    //     $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+10 days')->format('Y-m-d');
                       
    //     $response = $this->post(route('traineeCalendar.submit'),[
    //         'selected_date' => '2021-07-16'
    //     ]);
    //     // $response->assertRedirect(route('traineeCalendar.view'));

    //     $response->assertStatus(302);
    // }
    // // /**
    // //  * A valid user can be registered.
    // //  *
    // //  * @return void
    // //  */
    // public function test_user_can_not_see_reservation_page_when_weekly_plan_limit_excced()
    // {   
    //     $user = factory(User::class)->create();
    //     $plan = factory(UserPlanPurchase::class)->create([
    //         'user_id' =>$user->id,
    //         'purchase_plan_id'=>1
    //     ]);
    //     // dd( \Carbon\Carbon::now()->addDays(rand(1, 30)));
    //     $schedule = factory(TrainerSchedule::class,3)->create([
    //         'user_id' =>  $user->id,
    //         'is_occupied'=>1
    //     ]);


    //     $this->actingAs($user)
    //                      ->withSession(['user' => $user,'user_type'=>'trainee']);

    //     $fakeDate = $this->faker->unique()->dateTimeBetween( 'now','+1 days')->format('Y-m-d');
        
    //     $response = $this->post(route('trainerSubmitBytime'),[
    //         'selected_date' => $fakeDate
    //     ]);
    //     // $response->assertRedirect(route('traineeCalendar.view'));

    //     $response->assertStatus(302);
    // }

    
    
}
