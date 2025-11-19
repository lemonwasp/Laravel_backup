<?php

namespace Tests\Unit;

use App\Interfaces\PublisherRepositoryInterface;
use App\Models\Publisher;
use Mockery;
use Tests\TestCase;

class PublisherControllerTest extends TestCase
{
    public function test_store_method_creates_publisher(): void
    {
        // 1. PublisherRepositoryInterface의 모의(Mock) 객체를 만듭니다.
        $mockRepository = Mockery::mock(PublisherRepositoryInterface::class);

        // 2. createPublisher 메소드가 특정 인자(배열)로 호출될 때,
        //    미리 준비된 Publisher 모델 객체를 반환하도록 예상 동작을 정의합니다.
        $mockRepository->shouldReceive('createPublisher')
            ->once()
            ->with(['name' => '테스트 출판사', 'address' => '테스트 주소'])
            ->andReturn(new Publisher(['id' => 1, 'name' => '테스트 출판사', 'address' => '테스트 주소']));

        // 3. 서비스 컨테이너에 모의 객체를 바인딩합니다.
        //    이제 컨트롤러는 실제 리포지터리 대신 이 모의 객체를 주입받게 됩니다.
        $this->app->instance(PublisherRepositoryInterface::class, $mockRepository);

        // 4. API 엔드포인트를 호출합니다.
        $response = $this->postJson('/api/publishers', [
            'name' => '테스트 출판사',
            'address' => '테스트 주소',
        ]);

        // 5. 응답을 검증합니다.
        $response->assertStatus(201)
            ->assertJson([
                'name' => '테스트 출판사'
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}


