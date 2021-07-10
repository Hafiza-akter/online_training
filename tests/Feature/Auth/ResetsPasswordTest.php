<?php

namespace Tests\Feature\Auth;
use App\Model\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;

use App\Mail\ForgetEmailController;
use App\Mail\ForgetPasswordSuccess;

use DateTime;
use DateInterval;

class ResetsPasswordTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Displays the reset password request form.
     *
     * @return void
     */
    public function testDisplaysPasswordResetRequestForm()
    {
        $response = $this->get(route('forgetPassword','trainee'));

        $response->assertStatus(200);
    }

    /**
     * Sends the password reset email when the user exists.
     *
     * @return void
     */
    public function testSendsPasswordResetEmail()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        // user token and expired time generate //
        $date= new DateTime();
        $new_time =  $date->add(new DateInterval('PT24H00S'));

        $details['token'] =  \Str::random(60).time();
        $details['is_verified'] =  2;
        $details['expired_at'] =  $new_time;

        $user = factory(User::class)->create($details);


        $response = $this->post(route('forgetPasswordEmail.submit'), ['email' => $user->email,'type'=>'trainee']);


        Mail::assertSent(ForgetEmailController::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $response->assertStatus(302);   
    }

    // /**
    //  * Does not send a password reset email when the user does not exist.
    //  *
    //  * @return void
    //  */
    public function testDoesNotSendPasswordResetEmail()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('forgetPasswordEmail.submit'), ['email' => 'invalid@email.com','type'=>'trainee']);

        $response->assertSessionHas('message');
        $response->assertStatus(302);
    }

    // /**
    //  * Displays the form to reset a password.
    //  *
    //  * @return void
    //  */
    public function testDisplaysPasswordResetForm()
    {           
        $this->withoutExceptionHandling();
        // user token and expired time generate //
        $date= new DateTime();
        $new_time =  $date->add(new DateInterval('PT24H00S'));
        $token = \Str::random(60).time();
        $details['token'] = $token;
        $details['is_verified'] =  2;
        $details['expired_at'] =  $new_time;

        $user = factory(User::class)->create($details);

        $response=$this->get("token-verify/".$token."/trainee");

        $response->assertStatus(200);
    }

    // /**
    //  * Allows a user to reset their password.
    //  *
    //  * @return void
    //  */
    public function testChangesAUsersPassword()
    {           
        Mail::fake();
        $this->withoutExceptionHandling();

        // user token and expired time generate //
        $date= new DateTime();
        $new_time =  $date->add(new DateInterval('PT24H00S'));
        $token = \Str::random(60).time();
        $details['token'] = $token;
        $details['is_verified'] =  2;
        $details['expired_at'] =  $new_time;

        $user = factory(User::class)->create($details);


        $response = $this->post(route('passwordVerifyTokenSubmit'), [
            'type' => 'trainee',
            'token' => $token,
            'password_confirmation' => 'password',
            'email' => $user->email,
            'password' => 'password'
        ]);

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
        Mail::assertSent(ForgetPasswordSuccess::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
    // /**
    //  * Token expired check.
    //  *
    //  * @return void
    //  */
    public function test_token_expired()
    {           
        Mail::fake();
        $this->withoutExceptionHandling();

        // user token and expired time generate //
        $date= new DateTime();
        $new_time =  '2021-03-15 22:34:07';
        $token = \Str::random(60).time();
        $details['token'] = $token;
        $details['is_verified'] =  2;
        $details['expired_at'] =  $new_time;

        $user = factory(User::class)->create($details);

        $response = $this->post(route('passwordVerifyTokenSubmit'), [
            'type' => 'trainee',
            'token' => $token,
            'password_confirmation' => 'password',
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertSessionHas('message');
        $response->assertStatus(302);

    }
}
