<?php
namespace Tests\Feature\Trainee;

use App\Model\User;
use App\Model\UserPlanPurchase;
use App\Model\Trainer;
use App\Model\TrainerSchedule;
use App\Model\Ratings;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;


class TrainingTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_user_can_join_meetings()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        
        $schedule = factory(TrainerSchedule::class)->create([
            'user_id' =>  $user->id,
            'date' =>  date('Y-m-d'),
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $parameter =[
        'id' =>$schedule->id,
        ];

        $parameter= \Crypt::encrypt($parameter);

        $response = $this->post(route('trainingtrainee',$parameter));
        $response->assertStatus(200);
    }
    public function test_user_can_not_join_meetings()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
    
        $schedule = factory(TrainerSchedule::class)->create([
            'user_id' =>  $user->id,
            'date' =>  '2020-01-01',
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $parameter =[
        'id' =>$schedule->id,
        ];

        $parameter= \Crypt::encrypt($parameter);
        
        $response = $this->post(route('trainingtrainee',$parameter));
        $response->assertStatus(302);
    }

    public function test_user_can_view_ratings_page()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
    
        $schedule = factory(TrainerSchedule::class)->create([
            'user_id' =>  $user->id,
            'date' =>  '2020-01-01',
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);         

        $parameter =[
        'schedule_id' =>$schedule->id,
        ];

        $parameter= \Crypt::encrypt($parameter);
        
        $response = $this->get(route('userRatings',$parameter));
        $response->assertStatus(200);
    }
    public function test_user_can_submit_ratings()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $trainer = factory(Trainer::class)->create();
        $schedule = factory(TrainerSchedule::class)->create([
            'user_id' =>  $user->id,
            'trainer_id' =>  $trainer->id,
            'date' =>  '2020-01-01',
            'time' =>  date('H:i:s'),
            'is_occupied'=>1
        ]);  
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        

        // $ratings = factory(Ratings::class)->create([
        //     'user_id'=>$user->id,
        //     'trainer_id' =>$schedule->trainer_id
        // ]);         

        // $parameter =[
        // 'schedule_id' =>$schedule->id,
        // ];

        // $parameter= \Crypt::encrypt($parameter);
        
        $response = $this->post(route('userRatingsSubmit'),[
            'user_id'=>$schedule->user_id,
            'schedule_id'=>$schedule->id,
            'trainer_id'=>$trainer->id,
            'star_ratings'=>1
        ]);
        $response->assertStatus(200);
    }
    // public function test_user_can_saved_favourite()
    // {
    //     $user = factory(User::class)->create();
    //     $this->actingAs($user)
    //                      ->withSession(['user' => $user,'user_type'=>'trainee']);
    //     $trainer = factory(Trainer::class)->create();


    //     $response = $this->post(route('favouritetrainer'),
    //         [
    //             'trainer_id'=>$trainer->id,
    //             'user_id'=>$user->id
    //         ]
    //     );
    //     $response->assertStatus(302);
    // }
    // public function test_user_can_remove_favourite()
    // {
    //     $user = factory(User::class)->create();
    //     $this->actingAs($user)
    //                      ->withSession(['user' => $user,'user_type'=>'trainee']);
    //     $trainer = factory(Trainer::class)->create();


    //     $response = $this->post(route('favouritetrainer'),
    //         [
    //             'trainer_id'=>$trainer->id,
    //             'user_id'=>$user->id
    //         ]
    //     );
    //     $response->assertStatus(302);
    // }
    
    
    
}
