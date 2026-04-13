<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_loads_successfully(): void
    {
        $this->get(route('tasks.index'))->assertStatus(200)->assertViewIs('tasks.index');
    }

    public function test_index_shows_tasks(): void
    {
        Task::factory(3)->create();
        $this->get(route('tasks.index'))->assertStatus(200)->assertViewHas('tasks');
    }

    public function test_index_returns_correct_counts(): void
    {
        Task::factory(2)->pending()->create();
        Task::factory(1)->inProgress()->create();
        Task::factory(3)->completed()->create();

        $counts = $this->get(route('tasks.index'))->viewData('counts');

        $this->assertEquals(6, $counts['total']);
        $this->assertEquals(2, $counts['pending']);
        $this->assertEquals(1, $counts['in_progress']);
        $this->assertEquals(3, $counts['completed']);
    }

    public function test_index_filters_by_status(): void
    {
        Task::factory(2)->pending()->create();
        Task::factory(3)->completed()->create();

        $tasks = $this->get(route('tasks.index', ['status' => 'pending']))->viewData('tasks');
        $this->assertEquals(2, $tasks->total());
    }

    public function test_index_searches_by_title(): void
    {
        Task::factory()->create(['title' => 'Fix the login bug']);
        Task::factory()->create(['title' => 'Write unit tests']);

        $tasks = $this->get(route('tasks.index', ['search' => 'login']))->viewData('tasks');
        $this->assertEquals(1, $tasks->total());
    }

    public function test_create_page_loads(): void
    {
        $this->get(route('tasks.create'))->assertStatus(200)->assertViewIs('tasks.create');
    }

    public function test_can_create_a_task(): void
    {
        $response = $this->post(route('tasks.store'), [
            'title'    => 'Build the API',
            'status'   => 'pending',
            'priority' => 'high',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['title' => 'Build the API']);
    }

    public function test_cannot_create_task_without_title(): void
    {
        $this->post(route('tasks.store'), ['title' => '', 'status' => 'pending', 'priority' => 'medium'])
             ->assertSessionHasErrors('title');
        $this->assertDatabaseCount('tasks', 0);
    }

    public function test_cannot_create_task_with_past_due_date(): void
    {
        $this->post(route('tasks.store'), [
            'title' => 'Task', 'status' => 'pending', 'priority' => 'medium',
            'due_date' => now()->subDay()->format('Y-m-d'),
        ])->assertSessionHasErrors('due_date');
    }

    public function test_can_view_a_task(): void
    {
        $task = Task::factory()->create();
        $this->get(route('tasks.show', $task))->assertStatus(200)->assertViewHas('task', $task);
    }

    public function test_show_returns_404_for_nonexistent_task(): void
    {
        $this->get(route('tasks.show', 999))->assertStatus(404);
    }

    public function test_can_update_a_task(): void
    {
        $task = Task::factory()->pending()->create(['title' => 'Old Title']);

        $this->put(route('tasks.update', $task), [
            'title' => 'New Title', 'status' => 'in_progress', 'priority' => 'high',
        ])->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'New Title', 'status' => 'in_progress']);
    }

    public function test_can_quick_update_status(): void
    {
        $task = Task::factory()->pending()->create();

        $this->patch(route('tasks.update-status', $task), ['status' => 'completed']);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_can_delete_a_task(): void
    {
        $task = Task::factory()->create();
        $this->delete(route('tasks.destroy', $task))->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
