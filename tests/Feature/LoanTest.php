<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class LoanTest extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
     public function test_request_loan_with_valid_data()
     {
         $user = User::factory()->create();
         Sanctum::actingAs(
             $user,
             ['*']
         );

         $data = [
             'user_id' => $user->id,
             'amount' => 10000,
             'tenure' => 3
         ];

         $this->json('POST', route('loan.loanRequest'), $data)->assertStatus(200);
     }

     public function test_request_loan_with_invalid_user_id()
     {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => '',
            'amount' => 10000,
            'tenure' => 3
        ];

        $this->json('POST', route('loan.loanRequest'), $data)->assertStatus(422);
    }

     public function test_request_loan_with_invalid_amount()
     {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => $user->id,
            'amount' => 30000,
            'tenure' => 3
        ];

        $this->json('POST', route('loan.loanRequest'), $data)->assertStatus(422);
    }

    public function test_request_loan_with_invalid_tenure()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => $user->id,
            'amount' => 10000,
            'tenure' => 4
        ];

        $this->json('POST', route('loan.loanRequest'), $data)->assertStatus(422);
    }

    public function test_request_approve_loan()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => $user->id,
            'amount' => 10000,
            'tenure' => 3
        ];

        $response = $this->json('POST', route('loan.loanRequest'), $data)->getOriginalContent();

        $this->json('POST', route('loan.approve', ['loan_id' => $response['loan_details']['id']]))->assertStatus(200);
    }

    public function test_request_get_loan_details()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => $user->id,
            'amount' => 10000,
            'tenure' => 3
        ];

        $response = $this->json('POST', route('loan.loanRequest'), $data)->getOriginalContent();

        $this->json('GET', route('loan.show', ['loan_id' => $response['loan_details']['id']]))->assertStatus(200);
    }

    public function test_request_pay()
    {
        $user = User::factory()->create();
        Sanctum::actingAs(
            $user,
            ['*']
        );

        $data = [
            'user_id' => $user->id,
            'amount' => 10000,
            'tenure' => 3
        ];

        $response = $this->json('POST', route('loan.loanRequest'), $data)->getOriginalContent();

        $this->json('POST', route('loan.pay'), ['amount' => $response['loan_details']['amount'], 'repayment_date' => '2022-02-14', 'loan_id' => $response['loan_details']['id']])->assertStatus(200);
    }

}
