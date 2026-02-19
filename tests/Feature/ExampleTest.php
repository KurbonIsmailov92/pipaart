<?php

describe('Courses', function () {
    it('shows paginated courses list', function () {
        $response = $this->get('/courses/list');
        $response->assertStatus(200);
    });

    it('validates store course', function () {
        $response = $this->post('/courses/list', []);
        $response->assertSessionHasErrors(['title', 'description', 'hours']);
    });

    it('prevents non-admin user from deleting courses', function () {
        $user = \App\Models\User::factory()->create(['is_admin'=>false]);
        $this->actingAs($user);
        $course = \App\Models\Course::factory()->create();

        $response = $this->delete('/courses/' . $course->id);
        $response->assertStatus(403);
    });
});

describe('Home', function () {
    it('returns a successful response', function () {
        $response = $this->get('/');
        $response->assertStatus(200);
    });
});
