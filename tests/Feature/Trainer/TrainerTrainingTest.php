<?php
namespace Tests\Feature\Trainee;

use App\Model\User;
use App\Model\UserPlanPurchase;
use App\Model\Trainer;
use App\Model\TrainerSchedule;
use App\Model\Ratings;
use App\Model\Course;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;


class TrainerTrainingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_trainer_can_join_meetings()
    {
        $this->withoutExceptionHandling();

        $user = factory(Trainer::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
        
        $schedule = factory(TrainerSchedule::class)->create([
            'trainer_id' =>  $user->id,
            'date' =>  date('Y-m-d'),
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $parameter =[
        'id' =>$schedule->id,
        ];

        $parameter= \Crypt::encrypt($parameter);

        $response = $this->post(route('training',$parameter));
        $response->assertStatus(200);
    }
    public function test_trainer_can_not_join_meetings()
    {
        $this->withoutExceptionHandling();

        $user = factory(Trainer::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
    
        $schedule = factory(TrainerSchedule::class)->create([
            'trainer_id' =>  $user->id,
            'date' =>  '2020-01-01',
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $parameter =[
        'id' =>$schedule->id,
        ];

        $parameter= \Crypt::encrypt($parameter);
        
        $response = $this->post(route('training',$parameter));
        $response->assertStatus(302);
    }

    public function test_trainer_can_set_exericese_date()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $trainer = factory(Trainer::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
    
        $schedule = factory(TrainerSchedule::class)->create([
            'user_id' =>  $user->id,
            'trainer_id' =>  $trainer->id,
            'date' =>  '2020-01-01',
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $course = factory(Course::class)->create();
        $response = $this->post(route('training_performance'),
            [
                'course'=>$course->id,
                'schedule_id'=>$schedule->id,
                'set1_times'=>2,
                'set1_kg'=>40,
                'exercise_comment'=>'test',
                'efficiency'=>30

            ]
        );
        $response->assertStatus(200);
    }
    public function test_trainer_can_view_trainingList()
    {
        $this->withoutExceptionHandling();

        $user = factory(Trainer::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);

        $response = $this->get(route('traininglist'));
        $response->assertViewIs('pages.trainer.traininglist');
    }
       
}
