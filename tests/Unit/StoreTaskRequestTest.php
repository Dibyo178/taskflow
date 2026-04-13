<?php

namespace Tests\Unit;

use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreTaskRequestTest extends TestCase
{
    private function validate(array $data)
    {
        $r = new StoreTaskRequest();
        return Validator::make($data, $r->rules(), $r->messages());
    }

    public function test_valid_data_passes(): void
    {
        $v = $this->validate(['title' => 'My Task', 'status' => 'pending', 'priority' => 'medium',
                              'due_date' => now()->addDays(3)->format('Y-m-d')]);
        $this->assertFalse($v->fails());
    }

    public function test_title_is_required(): void
    {
        $v = $this->validate(['title' => '', 'status' => 'pending', 'priority' => 'medium']);
        $this->assertTrue($v->fails());
        $this->assertArrayHasKey('title', $v->errors()->toArray());
    }

    public function test_invalid_status_fails(): void
    {
        $v = $this->validate(['title' => 'Task', 'status' => 'flying', 'priority' => 'medium']);
        $this->assertArrayHasKey('status', $v->errors()->toArray());
    }

    public function test_past_due_date_fails(): void
    {
        $v = $this->validate(['title' => 'Task', 'status' => 'pending', 'priority' => 'low',
                              'due_date' => now()->subDay()->format('Y-m-d')]);
        $this->assertArrayHasKey('due_date', $v->errors()->toArray());
    }
}
