<?php
namespace Tests\Feature\Trainee;

use App\Model\Admin;
use App\Model\User;
use App\Model\Trainer;
use App\Model\TrainerSchedule;
use App\Model\TrainerRecurringSchedule;
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


class ScheduleManagementTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The admin can see schedule management.
     *
     * @return void
     */
    public function test_admin_can_see_schedule_management_view()
    {
        $this->withoutExceptionHandling();
        $user = factory(Admin::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'admin']);


        $response = $this->get(route('admin.schedule.management.view'));
        $response->assertStatus(200);
    }
    /**
     * The admin can see  schedule management edit page.
     *
     * @return void
     */
    public function test_admin_can_see_schedule_edit_view()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin)
                         ->withSession(['user' => $admin,'user_type'=>'admin']);

        $schedule = factory(TrainerSchedule::class)->create(); 
        $response = $this->get(route('admin.schedule.management.view',$schedule->id));
        $response->assertStatus(200);
    }

    /**
     * The admin  submit edited   schedule
     *
     */
    public function test_admin_submitted_schedule()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin)
                         ->withSession(['user' => $admin,'user_type'=>'admin']);
        
        // $user = factory(User::class)->create();
        // $trainer = factory(Trainer::class)->create();

        $schedule = factory(TrainerSchedule::class)->create();   
       

        $response = $this->post(route('admin.schedule.management.edit.submit'),[
            'date' => '2020-01-01',
            'time' => '13:00:00',
            'user' =>  User::all()->random()->id,
            'trainer' => Trainer::all()->random()->id,
            'id' => $schedule->id
        ]);

        $response->assertRedirect(route('admin.schedule.management.view'));

        $response->assertStatus(302);
    }

    
}
