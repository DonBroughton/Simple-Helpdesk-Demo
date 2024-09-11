<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_must_be_logged_in_to_see_ticket_creation_page(): void
    {
        $response = $this->get(route('ticket.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_a_user_must_be_logged_in_to_see_previous_tickets_page(): void
    {
        $response = $this->get(route('ticket.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_a_logged_in_user_can_see_their_tickets()
    {
        $this->seed();

        $primaryUser = User::factory()->create([
            'is_admin'  =>  false,
        ]);

        $irrelevantUser = User::factory()->create([
            'is_admin'  =>  false,
        ]);

        $ticket1 = Ticket::factory()->create([
            'user_id'  =>  $primaryUser->id,
            'title'  =>  'User One - Ticket One',
            'priority_id' => 1,
        ]);

        $ticket2 = Ticket::factory()->create([
            'user_id'  =>  $primaryUser->id,
            'title'  =>  'User One - Ticket Two',
            'priority_id' => 1,
        ]);

        $ticket3 = Ticket::factory()->create([
            'user_id'  =>  $irrelevantUser->id,
            'title'  =>  'User Two - Ticket Two',
            'priority_id' => 1,
        ]);

        $this->actingAs($primaryUser);

        $response = $this->get(route('ticket.index'));
        $response->assertStatus(200);

        $response->assertSee($ticket1->name);
        $response->assertSee($ticket2->name);
        $response->assertDontSee($ticket3->name);
    }

    public function test_a_logged_in_user_can_only_view_details_of_their_ticket()
    {
        $this->seed();

        $primaryUser = User::factory()->create([
            'is_admin'  =>  false,
        ]);

        $irrelevantUser = User::factory()->create([
            'is_admin'  =>  false,
        ]);

        $ticket1 = Ticket::factory()->create([
            'user_id'  =>  $primaryUser->id,
            'title'  =>  'User One - Ticket One',
            'priority_id' => 1,
        ]);

        $ticket2 = Ticket::factory()->create([
            'user_id'  =>  $primaryUser->id,
            'title'  =>  'User One - Ticket Two',
            'priority_id' => 1,
        ]);

        $ticket3 = Ticket::factory()->create([
            'user_id'  =>  $irrelevantUser->id,
            'title'  =>  'User Two - Ticket Two',
            'priority_id' => 1,
        ]);

        $this->actingAs($primaryUser);

        $response = $this->get(route('ticket.show', $ticket1));
        $response->assertStatus(200);

        $response->assertSee($ticket1->name);
        $response->assertDontSee($ticket2->name);
        $response->assertDontSee($ticket3->name);

        $response = $this->get(route('ticket.show', $ticket2));
        $response->assertStatus(200);

        $response = $this->get(route('ticket.show', $ticket3));
        $response->assertStatus(403);
    }

    public function test_submitting_a_ticket_fails_without_a_title()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'title'  =>  '',

            'description' => 'A VALID TEST DESCRIPTION',
            'priority_id' => 1
        ];

        $response = $this->post(route('ticket.store'), $formData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
        $this->assertDatabaseMissing('tickets', [
            'description' => $formData['description'],
        ]);
    }

    public function test_submitting_a_ticket_fails_without_a_description()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'description' => '',

            'title'  =>  'A VALID TITLE',
            'priority_id' => 1,
        ];

        $response = $this->post(route('ticket.store'), $formData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('description');
        $this->assertDatabaseMissing('tickets', [
            'title' => $formData['title'],
        ]);
    }

    public function test_submitting_a_ticket_fails_without_a_priority()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'priority_id' => null,

            'title'  =>  'A VALID TITLE',
            'description' => 'A VALID TEST DESCRIPTION',
        ];

        $response = $this->post(route('ticket.store'), $formData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('priority');
        $this->assertDatabaseMissing('tickets', [
            'title' => $formData['title'],
        ]);
    }

    public function test_a_ticket_reply_requires_a_logged_in_user()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'is_open'  =>  true,
        ]);

        // THE USER DOES NOT LOG IN

        $formData = [
            'reply' => 'THIS IS A VALID REPLY.',
        ];

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_replies_must_be_of_appropriate_length()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'is_open'  =>  true,
        ]);

        $this->actingAs($user);

        // This reply is too short
        $formData = [
            'reply' => '',
        ];

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('reply');
    }

    public function test_an_open_ticket_can_receive_a_reply_by_its_creator()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'is_open'  =>  true,
        ]);

        $this->actingAs($user);

        $formData = [
            'reply' => 'THIS IS A VALID REPLY.',
        ];

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);

        $response->assertSessionHas(['status' => 'Thank you, your reply has been added.']);

        $this->assertDatabaseHas('ticket_replies', [
            'body' => $formData['reply'],
        ]);
    }

    public function test_an_open_ticket_can_receive_a_reply_by_an_admin()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'is_admin'  =>  true,
        ]);
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'is_open'  =>  true,
        ]);

        $this->actingAs($admin);

        $formData = [
            'reply' => 'THIS IS A VALID REPLY.',
        ];

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);

        $response->assertSessionHas(['status' => 'Thank you, your reply has been added.']);

        $this->assertDatabaseHas('ticket_replies', [
            'body' => $formData['reply'],
        ]);
    }

    public function test_an_open_ticket_cannot_receive_a_reply_from_a_non_creating_user()
    {
        $creatingUser = User::factory()->create();
        $nonCreatingUser = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'user_id' => $creatingUser->id,
            'is_open'  =>  true,
        ]);

        $this->actingAs($nonCreatingUser);

        $formData = [
            'reply' => 'THIS IS A VALID REPLY.',
        ];

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);

        $response->assertStatus(403);

        $response->assertSessionMissing(['status' => 'Thank you, your reply has been added.']);

        $this->assertDatabaseMissing('ticket_replies', [
            'body' => $formData['reply'],
        ]);
    }

    public function test_a_closed_ticket_is_unable_to_receive_replies_from_users_or_admins()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);
        $ticket = Ticket::factory()->create([
            'is_open'  =>  false,

            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $formData = [
            'reply' => 'THIS IS A VALID REPLY.',
        ];
        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('ticket_replies', [
            'body' => $formData['reply'],
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('ticket.reply.store', [$ticket]), $formData);
        $response->assertStatus(403);
        $this->assertDatabaseMissing('ticket_replies', [
            'body' => $formData['reply'],
        ]);
    }
}
