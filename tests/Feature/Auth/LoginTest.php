<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;
use App\Model\User;
use App\Model\Trainer;

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
    

    /**
     * The user able to view  login form
     *
     */
    public function test_user_can_view_a_login_form()
    {  
        
        $this->withoutExceptionHandling();
        // $this->WithoutMiddleware();

        $_SERVER['PHP_AUTH_PW'] = 'olft';

        $response = $this->get('login/trainee');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login_trainee');
    }

    /**
     * The user will not able to view  login form
     *
     */

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $_SERVER['PHP_AUTH_PW'] = 'olft';
        $this->withoutExceptionHandling();

        $user = factory(User::class)->make();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $response = $this->actingAs($user)->get('login/trainee');
        $response->assertStatus(200);

        // $response->assertRedirect('traineeCalendar.view');
    }
    /**
     * The trainer able to view  login form
     *
     */
    public function test_trainer_can_view_a_login_form()
    {  
        
        $this->withoutExceptionHandling();
        // $this->WithoutMiddleware();

        $_SERVER['PHP_AUTH_PW'] = 'olft';

        $response = $this->get('login/trainer');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login_trainer');
    }

    /**
     * The trainer will not able to view  login form
     *
     */

    public function test_trainer_cannot_view_a_login_form_when_authenticated()
    {
        $_SERVER['PHP_AUTH_PW'] = 'olft';
        $this->withoutExceptionHandling();

        $user = factory(Trainer::class)->make();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);

        $response = $this->actingAs($user)->get('login/trainer');
        $response->assertStatus(200);

        // $response->assertRedirect('traineeCalendar.view');
    }

    /**
     * The user will able to login using correct credentials
     *
     */
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
    /**
     * The user will not able to login using correct credentials
     *
     */
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

    /**
     * The trainer will able to login using correct credentials
     *
     */
    public function test_trainer_can_login_with_correct_credentials()
    {
        $this->WithoutMiddleware();
        $_SERVER['PHP_AUTH_PW'] = 'olft';

         $user = factory(Trainer::class)->create([
            'password' => bcrypt('i-love-laravel')
        ]);

        $response = $this->post(route('trainerLogin.submit'), [
            'username' => $user->email,
            'password' => 'i-love-laravel'
        ]);


        $response->assertRedirect(route('calendar.view','month'));
        $response->assertStatus(302);
   

        // $this->assertAuthenticatedAs($user);
    }
    /**
     * The trainer will not able to login using correct credentials
     *
     */
    public function test_trainer_cannot_login_with_incorrect_password()
    {
        $this->withoutExceptionHandling();

        $user = factory(Trainer::class)->create([
            'password' => bcrypt('i-love-laravel'),
        ]);
        
        $response = $this->from(route('trainerLogin'))->post(route('trainerLogin.submit'), [
            'username' => $user->email,
            'password' => 'invalid-password'
        ]);
        
        $response->assertRedirect(route('trainerLogin'));
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
