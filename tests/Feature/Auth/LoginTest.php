<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;
use App\Model\User;

// user can view a login form
// user cannot view a login form when authenticated
// user can login with correct credentials
// user cannot login with a non-existent email
// user cannot login with incorrect password
// user can logout, when already authenticated
// user reset  password

class LoginTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
   
    public function test_user_can_view_a_login_form()
    {  
        
        $this->withoutExceptionHandling();
        // $this->WithoutMiddleware();

        $_SERVER['PHP_AUTH_PW'] = 'olft';

        $response = $this->get('login/trainee');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login_trainee');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $_SERVER['PHP_AUTH_PW'] = 'olft';
        $this->withoutExceptionHandling();

        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('login/trainee');
        $response->assertStatus(200);

        // $response->assertRedirect('traineeCalendar.view');
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $this->WithoutMiddleware();
        $_SERVER['PHP_AUTH_PW'] = 'olft';

         $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel')
        ]);

        $response = $this->post(route('traineeLogin.submit'), [
            'username' => $user->email,
            'password' => 'i-love-laravel'
        ]);


        $response->assertRedirect(route('traineeCalendar.view'));
        $response->assertStatus(302);
   

        // $this->assertAuthenticatedAs($user);
    }
    public function test_user_cannot_login_with_incorrect_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);
        
        $response = $this->from(route('traineeLogin'))->post(route('traineeLogin.submit'), [
            'username' => $user->email,
            'password' => 'invalid-password'
        ]);
        
        $response->assertRedirect(route('traineeLogin'));
        // $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }



    public function test_login_user_can_log_out()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get(route('traineeLogout'));

        $response->assertStatus(302);

    }
}
