<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;
use App\Model\Admin;

// user can view a login form
// user cannot view a login form when authenticated
// user can login with correct credentials
// user cannot login with a non-existent email
// user cannot login with incorrect password
// user can logout, when already authenticated
// user reset  password

class AdminLoginTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    

    /**
     * The trainer able to view  login form
     *
     */
    public function test_admin_can_view_a_login_form()
    {  
        
        $this->withoutExceptionHandling();


        $response = $this->get('admin/login');

        $response->assertSuccessful();
        $response->assertViewIs('admin.auth.login');
    }

    /**
     * The trainer will not able to view  login form
     *
     */

    public function test_admin_cannot_view_a_login_form_when_authenticated()
    {
        $this->withoutExceptionHandling();

        $user = factory(Admin::class)->make();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'admin']);

        $response = $this->actingAs($user)->get('admin/login');
        $response->assertStatus(302);

        // $response->assertRedirect('traineeCalendar.view');
    }
   
  
    /**
     * The admin will not able to login using correct credentials
     *
     */
    public function test_admin_cannot_login_with_incorrect_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(Admin::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);
        
        $response = $this->from(route('admin.login'))->post(route('admin.Login.submit'), [
            'username' => $user->email,
            'password' => 'invalid-password'
        ]);
        
        $response->assertRedirect(route('admin.login'));
        // $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /**
     * The admin will able to login using correct credentials
     *
     */
    public function test_admin_can_login_with_correct_credentials()
    {
        $this->WithoutMiddleware();

         $user = factory(Admin::class)->create([
            'password' => bcrypt('i-love-laravel')
        ]);

        $response = $this->post(route('admin.Login.submit'), [
            'username' => $user->email,
            'password' => 'i-love-laravel'
        ]);


        $response->assertRedirect(route('admin.dashboard'));
        $response->assertStatus(302);
   

        // $this->assertAuthenticatedAs($user);
    }
    

    public function test_login_admin_can_log_out()
    {
        $this->withoutExceptionHandling();

        $user = factory(Admin::class)->create();

        $response = $this->actingAs($user)->get(route('admin.logout'));

        $response->assertStatus(302);

    }
}
