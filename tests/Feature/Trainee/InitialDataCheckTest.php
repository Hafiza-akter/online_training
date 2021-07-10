<?php
namespace Tests\Feature\Trainee;

use App\Model\User;
use App\Model\UserPlanPurchase;
use App\Model\UserEquipment;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;


class InitialDataCheckTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_physical_data_form()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        $response = $this->get(route('physicaldata'));
        $response->assertStatus(200);
    }

    // /**
    //  * A valid user can be registered.
    //  *
    //  * @return void
    //  */
    public function test_physical_data_form_submit()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
      
        $response = $this->post(route('physicaldata.submit'), [
                    'weight' => 75,
                    'sex' => 'male',
                    'height' => 160,
                    'birthday' => '01/01/2000',
                    'user_id' => $user->id, 
                    'pal' => 'medium'
        ]);


        $response->assertRedirect(route('purchaseplan'));
        $response->assertStatus(302);

    }

    // /**
    //  * An invalid user is not registered.
    //  *
    //  * @return void
    //  */
    public function test_show_purchaseplan_form()
    {

        $user = factory(User::class)->create([
            'weight' => 75,
            'sex' => 'male',
            'length' => 160,
            'dob' => '01/01/2000',
            'pal' => 1.75
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);

        $response = $this->get(route('purchaseplan'));


        $this->assertStringContainsString('dataset', $response->content());
        $response->assertSuccessful();

        $response->assertStatus(200);
    }
        // /**
    //  * An invalid user is not registered.
    //  *
    //  * @return void
    //  */
    public function test_show_physical_data_form_if_some_data_is_empty()
    {
        $user = factory(User::class)->create([
            'pal'=>null,
            'length'=> null
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        $response = $this->get(route('purchaseplan'));

        $response->assertRedirect(route('physicaldata'));
        $response->assertStatus(302);
    }
        // /**
    //  * An invalid user is not registered.
    //  *
    //  * @return void
    //  */
    public function test_a_user_has_a_active_purchase_plan_or_not()
    {
        $user = factory(User::class)->create();
        $plan = factory(UserPlanPurchase::class)->create([
            'user_id' =>$user->id
        ]);
        $this->actingAs($user)
                         ->withSession(['user' => $user,'user_type'=>'trainee']);
        // $this->assertInstanceOf(UserPlanPurchase::class, $user->purchasPlan); 
        $this->assertInstanceOf(UserPlanPurchase::class, activePurchasePlan($user->id)); 
        // $this->assertInstancTrue(activePurchasePlan($user->id));


    }

    
}
