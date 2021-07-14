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


class UserManagementTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * The admin can see schedule management.
     *
     * @return void
     */
    public function test_admin_can_see_user_management_view()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $admin,'user_type'=>'admin']);


        $response = $this->get(route('user.list'));
        $response->assertStatus(200);
    }
    /**
     * The admin can see schedule management.
     *
     * @return void
     */
    public function test_admin_can_see_user_management_edit_view()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $admin,'user_type'=>'admin']);


        $response = $this->get(route('user.edit',$user->id));
        $response->assertStatus(200);
    }
    

    /**
     * The admin  submit edited   schedule
     *
     */
    public function test_admin_submitted_user_update()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $admin = factory(Admin::class)->create();
        $this->actingAs($admin)
                         ->withSession(['user' => $admin,'user_type'=>'admin']);
        
        $response = $this->post(route('user.edit.submit'),[
            'email' => $user->email,
            'name' =>'hello name', 
            'id' => $user->id
        ]);

        $response->assertRedirect(route('user.list'));

        $response->assertStatus(302);
    }

    
}
