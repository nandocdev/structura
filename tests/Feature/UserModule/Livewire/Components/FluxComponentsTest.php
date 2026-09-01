<?php

namespace Tests\Feature\UserModule\Livewire\Components;

use App\Modules\UserModule\Livewire\Components\BadgeStatus;
use App\Modules\UserModule\Livewire\Components\CheckboxField;
use App\Modules\UserModule\Livewire\Components\SelectField;
use App\Modules\UserModule\Livewire\Components\SwitchField;
use App\Modules\UserModule\Livewire\Components\TableList;
use Livewire\Livewire;
use Tests\TestCase;

class FluxComponentsTest extends TestCase
{
    /**
     * Test SelectField component renders correctly
     */
    public function test_select_field_renders(): void
    {
        Livewire::test(SelectField::class, [
            'label' => 'Role',
            'model' => 'role',
            'placeholder' => 'Select a role...',
            'options' => ['admin' => 'Administrator', 'user' => 'User'],
        ])
            ->assertSee('Role')
            ->assertSee('Select a role...')
            ->assertSee('Administrator');
    }

    /**
     * Test SelectField updates model value
     */
    public function test_select_field_updates_model(): void
    {
        Livewire::test(SelectField::class, [
            'label' => 'Role',
            'model' => 'role',
            'options' => ['admin' => 'Administrator', 'user' => 'User'],
        ])
            ->set('modelValue', 'admin')
            ->assertSet('modelValue', 'admin');
    }

    /**
     * Test CheckboxField component renders correctly
     */
    public function test_checkbox_field_renders(): void
    {
        Livewire::test(CheckboxField::class, [
            'label' => 'I agree to terms',
            'model' => 'agreeTerms',
        ])
            ->assertSee('I agree to terms');
    }

    /**
     * Test CheckboxField toggles value
     */
    public function test_checkbox_field_toggles(): void
    {
        Livewire::test(CheckboxField::class, [
            'label' => 'I agree to terms',
            'model' => 'agreeTerms',
        ])
            ->set('modelValue', true)
            ->assertSet('modelValue', true)
            ->set('modelValue', false)
            ->assertSet('modelValue', false);
    }

    /**
     * Test SwitchField component renders correctly
     */
    public function test_switch_field_renders(): void
    {
        Livewire::test(SwitchField::class, [
            'label' => 'Enable notifications',
            'model' => 'notificationsEnabled',
            'description' => 'Receive email notifications',
        ])
            ->assertSee('Enable notifications')
            ->assertSee('Receive email notifications');
    }

    /**
     * Test SwitchField toggles state
     */
    public function test_switch_field_toggles_state(): void
    {
        Livewire::test(SwitchField::class, [
            'label' => 'Enable notifications',
            'model' => 'notificationsEnabled',
        ])
            ->set('modelValue', true)
            ->assertSet('modelValue', true)
            ->set('modelValue', false)
            ->assertSet('modelValue', false);
    }

    /**
     * Test BadgeStatus renders variants
     */
    public function test_badge_status_renders_variants(): void
    {
        $variants = ['success', 'warning', 'danger', 'info', 'pending', 'inactive'];

        foreach ($variants as $variant) {
            Livewire::test(BadgeStatus::class, [
                'label' => 'Test Status',
                'variant' => $variant,
            ])
                ->assertSee('Test Status');
        }
    }

    /**
     * Test BadgeStatus with icon
     */
    public function test_badge_status_with_icon(): void
    {
        Livewire::test(BadgeStatus::class, [
            'label' => 'Active',
            'variant' => 'success',
            'icon' => 'check-circle',
        ])
            ->assertSee('Active');
    }

    /**
     * Test TableList component renders
     */
    public function test_table_list_renders(): void
    {
        Livewire::test(TableList::class, [
            'rows' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ],
            'columns' => [
                ['key' => 'name', 'label' => 'Name', 'sortable' => true],
                ['key' => 'email', 'label' => 'Email'],
            ],
        ])
            ->assertSee('Name')
            ->assertSee('Email')
            ->assertSee('John Doe')
            ->assertSee('jane@example.com');
    }

    /**
     * Test TableList sorting
     */
    public function test_table_list_sorting(): void
    {
        Livewire::test(TableList::class, [
            'rows' => [
                ['id' => 1, 'name' => 'John'],
                ['id' => 2, 'name' => 'Jane'],
            ],
            'columns' => [
                ['key' => 'name', 'label' => 'Name', 'sortable' => true],
            ],
        ])
            ->call('sort', 'name')
            ->assertSet('sortBy', 'name')
            ->assertSet('sortDirection', 'asc')
            ->call('sort', 'name')
            ->assertSet('sortDirection', 'desc');
    }

    /**
     * Test TableList empty state
     */
    public function test_table_list_empty_state(): void
    {
        Livewire::test(TableList::class, [
            'rows' => [],
            'columns' => [
                ['key' => 'name', 'label' => 'Name'],
            ],
            'emptyMessage' => 'No users found',
        ])
            ->assertSee('No users found');
    }
}
