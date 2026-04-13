<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_scope_by_status_filters_correctly(): void
    {
        Task::factory(3)->pending()->create();
        Task::factory(2)->completed()->create();

        $this->assertCount(3, Task::byStatus('pending')->get());
    }

    public function test_scope_overdue_excludes_completed(): void
    {
        Task::factory(2)->overdue()->create();
        Task::factory()->create(['due_date' => now()->subDays(5), 'status' => 'completed']);

        $this->assertCount(2, Task::overdue()->get());
    }

    public function test_status_badge_class_is_correct(): void
    {
        $this->assertEquals('badge-pending',     Task::factory()->make(['status' => 'pending'])->statusBadgeClass);
        $this->assertEquals('badge-in-progress', Task::factory()->make(['status' => 'in_progress'])->statusBadgeClass);
        $this->assertEquals('badge-completed',   Task::factory()->make(['status' => 'completed'])->statusBadgeClass);
    }

    public function test_is_overdue_true_for_past_pending_task(): void
    {
        $task = Task::factory()->make(['due_date' => now()->subDays(3), 'status' => 'pending']);
        $this->assertTrue($task->isOverdue);
    }

    public function test_is_overdue_false_for_completed_task(): void
    {
        $task = Task::factory()->make(['due_date' => now()->subDays(3), 'status' => 'completed']);
        $this->assertFalse($task->isOverdue);
    }

    public function test_due_date_cast_to_carbon(): void
    {
        $task = Task::factory()->create(['due_date' => '2099-06-15']);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $task->due_date);
    }
}
