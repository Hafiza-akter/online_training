<?php
namespace Tests\Feature\Auth;

use App\Model\User;
use App\Model\Trainer;
use App\Model\UserEquipment;
use App\Model\TrainerEquipment;

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
     * The user will abel to show registration form
     *
     */
    public function test_user_can_see_register_form()
    {
        $response = $this->get(route('traineeSignup'));

        $response->assertStatus(200);
    }

    /**
     * The trainer will abel to show registration form
     *
     */
    public function test_trainer_can_see_register_form()
    {
        $response = $this->get(route('trainerSignup'));

        $response->assertStatus(200);
    }

    /**
     * A valid user can be registered.
     *
     */
    public function test_registers_valid_user()
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

     /**
     * A valid trainer can be registered.
     *
     */
    public function test_registers_valid_trainer()
    {
        $this->withoutExceptionHandling();

        Event::fake();
        $response = $this->post(route('trainerSignup.submit'), [
            'email' => 'tst.infso@gmail.com'
        ]);

        $this->assertDatabaseHas('tbl_trainers', [
            'email' => 'tst.infso@gmail.com'
        ]);

        \Event::assertDispatched(NewUserRegisteredEvent::class);
        $response->assertRedirect(route('signup.verificationview'));
        $response->assertStatus(302);

    }

    /**
     * An invalid user is not registered.
     *
     */
    public function test_doesnot_register_an_invalid_user()
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

    /**
     * An invalid trainer is not registered.
     *
     */
    public function test_doesnot_register_an_invalid_trainer()
    {
        // $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create([
            'email' => 'tst.infso@gmail.com'
        ]);

        $response = $this->post(route('trainerSignup.submit'), [
            'email' => 'tst.infso@gmail.com'
        ]);

        $response->assertSessionHasErrors(['email']);
        $response->assertStatus(302);
    }
    /**
     * An  user is can update info after verification is done
     *
     */

    public function test_update_user_info()
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
     /**
     * A  trainer  can update info after verification is done
     *
     */

    public function test_update_trainer_info()
    {
        $this->withoutExceptionHandling();
        $user = factory(Trainer::class)->create();

        $response = $this->post(route('trainerSignupUpdate.submit'), [
            'email' => $user->email,
            'user_id' => $user->id,
            'first_name'=>'test',
            'sex'=>'male',
            'password'=>'password',
            'password_confirmation'=>'password'

        ]);
        

        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainer']);
        $response->assertRedirect(route('calendar.view','month'));


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
    public function test_trainer_has_a_equipment()
    {
        $this->withExceptionHandling();

        $user = factory(Trainer::class)->create();
        $UserEquipment = factory(TrainerEquipment::class)->create(['trainer_id' => $user->id]); 

        // Method 1:
        $this->assertInstanceOf(TrainerEquipment::class, $user->equipment); 
        
        // Method 2:
        // $this->assertEquals(1, $user->equipment->count()); 
    }
}
