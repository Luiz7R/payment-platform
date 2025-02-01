<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionsControllerTest extends TestCase
{

    use DatabaseMigrations;

    public function testUserShouldNotSenderWrongReceiverId(): void
    {
        $sender = User::factory()->create();
        $sender->user_type = User::COMMON;
        $sender->setBalance(125);

        $payload = [
            'receiver_id' => 'dontexist',
            'sender_id' => $sender->id,
            'amount' => 123
        ];

        $request = $this->post(route('createTransaction'), $payload);

        $request->assertSeeText('The Retailer provided does not exist');
        $request->assertStatus(422);

        $sender->delete();
    }

    public function testUserShouldNotSenderWrongSenderId(): void
    {
        $retailer = User::factory()->create();
        $retailer->user_type = User::MERCHANT;

        $payload = [
            'receiver_id' => $retailer->id,
            'sender_id' => 'dontexist',
            'amount' => 123
        ];

        $request = $this->post(route('createTransaction'), $payload);

        $request->assertSeeText('The Costumer provided does not exist');
        $request->assertStatus(422);

        $retailer->delete();
    }

    public function testRetailerShouldNotTransfer(): void
    {
        $retailer = User::factory()->create();
        $sender = User::factory()->create();

        $retailer->user_type = User::MERCHANT;
        $sender->user_type = User::COMMON;

        $payload = [
            'sender_id' => $retailer->id,
            'receiver_id' => $sender->id,
            'amount' => 123
        ];

        $request = $this->post(route('createTransaction'), $payload);

        $request->assertSeeText('Retailers cannot make transactions');
        $request->assertStatus(422);

        $sender->delete();
        $retailer->delete();
    }

    public function testSenderHaveInsufficientBalance(): void
    {
        $sender = User::factory()->create();
        $sender->setBalance(200);
        $sender->user_type = User::COMMON;
        $sender->save();

        $retailer = User::factory()->create();
        $retailer->user_type = User::MERCHANT;
        $retailer->save();

        $payload = [
            'sender_id' => $sender->id,
            'receiver_id' => $retailer->id,
            'amount' => 777
        ];

        $request = $this->post(route('createTransaction'), $payload);

        $request->assertSeeText("Insufficient amount to transfer");
        $request->assertStatus(400);

        $sender->delete();
        $retailer->delete();
    }

    public function test_money_transfer_completes_successfully(): void
    {
        $sender = User::factory()->create();
        $sender->setBalance(1200);
        $sender->user_type = User::COMMON;
        $sender->save();

        $retailer = User::factory()->create();
        $retailer->user_type = User::MERCHANT;
        $retailer->save();

        $payload = [
            'sender_id' => $sender->id,
            'receiver_id' => $retailer->id,
            'amount' => 777
        ];

        $request = $this->post(route('createTransaction'), $payload);

        $request->assertSeeText('Transaction completed successfully');
        $request->assertStatus(200);

        $sender->delete();
        $retailer->delete();
    }
}
