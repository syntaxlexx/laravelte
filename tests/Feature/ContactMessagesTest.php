<?php

use App\Events\ContactFormWasFilled;
use App\Listeners\ContactFormHasBeenFilled;
use App\Mail\ContactFormMailable;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

beforeEach(function () {
    seedConfigurations();
    increaseThrottles();
});

it('can post a contact messages', function () {
    $item = ContactMessage::factory()->create();

    Event::fake();

    $response = $this->post(route('contact.store'), $item->toArray(), inertiaHeaders());
    $response->assertSessionHasNoErrors();

    Event::assertDispatched(ContactFormWasFilled::class);

    Event::assertListening(
        ContactFormWasFilled::class,
        ContactFormHasBeenFilled::class
    );

    $this->followRedirects($response)->assertSee('success');
})->group('browser');

it('sends an email after posting a contact messages', function () {
    $contactMessage = ContactMessage::factory()->create();

    Mail::fake();

    event(new ContactFormWasFilled($contactMessage));

    Mail::assertQueued(ContactFormMailable::class, function ($mail) use ($contactMessage) {
        return $mail->contactMessage->id == $contactMessage->id;
    });

})->group('browser');

it('does not send an email after posting a contact message with no email', function () {
    $contactMessage = ContactMessage::factory()->create([
        'email' => null
    ]);

    Mail::fake();

    event(new ContactFormWasFilled($contactMessage));

    Mail::assertNotQueued(ContactFormMailable::class, function ($mail) use ($contactMessage) {
        return $mail->contactMessage->id == $contactMessage->id;
    });

})->group('browser');

it('can post a contact messages if logged in', function () {
    $item = ContactMessage::factory()->create();
    $user = User::factory()->create();
    actingAsSanctum($user);

    $response = $this->post('/contact', $item->toArray(), inertiaHeaders());
    $response->assertSessionHasNoErrors();

    $this->followRedirects($response)->assertSee('success');
})->group('browser');

test('must provide name in contact message', function () {
    $item = ContactMessage::factory()->create();

    $data = $item->toArray();
    unset($data['name']);

    $response = $this->post('/contact', $data);
    $response->assertSessionHasErrors('name');

})->group('browser');

test('must provide subject in contact message', function () {
    $item = ContactMessage::factory()->create();

    $data = $item->toArray();
    unset($data['subject']);

    $response = $this->post('/contact', $data);
    $response->assertSessionHasErrors('subject');
})->group('browser');

test('must provide body in contact message', function () {
    $item = ContactMessage::factory()->create();

    $data = $item->toArray();
    unset($data['body']);

    $response = $this->post('/contact', $data);
    $response->assertSessionHasErrors('body');
})->group('browser');

test('must provide the phone if email is missing in contact message', function () {
    $item = ContactMessage::factory()->create();

    $data = $item->toArray();
    unset($data['phone']);
    unset($data['email']);

    $response = $this->post('/contact', $data);
    $response->assertSessionHasErrors('phone');

    $item = ContactMessage::factory()->create([
        'phone' => null,
    ]);

    $data = $item->toArray();
    unset($data['email']);

    $response = $this->post('/contact', $data);
    $response->assertSessionHasErrors('phone');

})->group('browser');


// api
// ---------------------------------------------
test('api - it can post a contact messages', function () {
    $item = ContactMessage::factory()->create();

    $response = $this->postJson('/api/contact', $item->toArray());

    $response->assertStatus(200);
})->group('api');
