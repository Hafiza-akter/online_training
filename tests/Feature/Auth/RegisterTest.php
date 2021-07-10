<?php
namespace Tests\Feature\Auth;

use App\Model\User;
use App\Model\UserEquipment;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;

use Illuminate\Support\Facades\Mail;
use App\Events\NewUserRegisteredEvent;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function testRegisterFormDisplayed()
    {
        $response = $this->get(route('traineeSignup'));

        $response->assertStatus(200);
    }

    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function testRegistersAValidUser()
    {
        $this->withoutExceptionHandling();

        Event::fake();
        $response = $this->post(route('traineeSignup.submit'), [
            'email' => 'tst.infso@gmail.com'
        ]);

        $this->assertDatabaseHas('tbl_users', [
            'email' => 'tst.infso@gmail.com'
        ]);

        \Event::assertDispatched(NewUserRegisteredEvent::class);
        $response->assertRedirect(route('signup.verificationview'));
        $response->assertStatus(302);

    }

    // /**
    //  * An invalid user is not registered.
    //  *
    //  * @return void
    //  */
    public function testDoesNotRegisterAnInvalidUser()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create([
            'email' => 'tst.infso@gmail.com'
        ]);

        $response = $this->post(route('traineeSignup.submit'), [
            'email' => 'tst.infso@gmail.com'
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(302);
    }
        // /**
    //  * An invalid user is not registered.
    //  *
    //  * @return void
    //  */

    public function testUpdateUserInfo()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->post(route('traineeSignupUpdate.submit'), [
            'email' => $user->email,
            'user_id' => $user->id,
            'password'=>'password',
            'password_confirmation'=>'password'

        ]);
        $user = factory(UserEquipment::class)->create([
            'user_id' => $user->id
        ]);

        // $this->actingAs($user)
        //                  ->withSession(['user' => $user,'user_type'=>'trainee']);
        $response->assertStatus(200);

    }

    public function test_user_has_a_equipment()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $UserEquipment = factory(UserEquipment::class)->create(['user_id' => $user->id]); 

        // Method 1:
        $this->assertInstanceOf(UserEquipment::class, $user->equipment); 
        
        // Method 2:
        // $this->assertEquals(1, $user->equipment->count()); 
    }
}
