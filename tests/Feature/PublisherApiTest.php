<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublisherApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_publisher_via_api(): void
    {
        $response = $this->postJson('/api/publishers', [
            'name' => '한빛미디어',
            'address' => '서울시 마포구',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => '한빛미디어',
                'address' => '서울시 마포구',
            ]);

        // 데이터베이스에 실제로 저장되었는지 확인
        $this->assertDatabaseHas('publishers', [
            'name' => '한빛미디어',
            'address' => '서울시 마포구',
        ]);
    }

    public function test_validation_works_for_publisher_creation(): void
    {
        $response = $this->postJson('/api/publishers', [
            // name과 address 없이 요청
        ]);

        $response->assertStatus(422) // Validation Error
            ->assertJsonValidationErrors(['name', 'address']);
    }
}


