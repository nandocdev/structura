<?php

namespace Tests\Feature\UserModule\Livewire\Components;

use App\Modules\UserModule\Livewire\Components\BadgeStatus;
use App\Modules\UserModule\Livewire\Components\BreadcrumbsNav;
use App\Modules\UserModule\Livewire\Components\Callout;
use App\Modules\UserModule\Livewire\Components\Card;
use App\Modules\UserModule\Livewire\Components\CheckboxField;
use App\Modules\UserModule\Livewire\Components\PaginationNav;
use App\Modules\UserModule\Livewire\Components\SelectField;
use App\Modules\UserModule\Livewire\Components\SkeletonLoader;
use App\Modules\UserModule\Livewire\Components\SwitchField;
use App\Modules\UserModule\Livewire\Components\TableList;
use Livewire\Livewire;
use Tests\TestCase;

class FluxComponentsTest extends TestCase {
   /**
    * Test SelectField component renders correctly
    */
   public function test_select_field_renders(): void {
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
   public function test_select_field_updates_model(): void {
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
   public function test_checkbox_field_renders(): void {
      Livewire::test(CheckboxField::class, [
         'label' => 'I agree to terms',
         'model' => 'agreeTerms',
      ])
         ->assertSee('I agree to terms');
   }

   /**
    * Test CheckboxField toggles value
    */
   public function test_checkbox_field_toggles(): void {
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
   public function test_switch_field_renders(): void {
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
   public function test_switch_field_toggles_state(): void {
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
   public function test_badge_status_renders_variants(): void {
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
   public function test_badge_status_with_icon(): void {
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
   public function test_table_list_renders(): void {
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
   public function test_table_list_sorting(): void {
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
   public function test_table_list_empty_state(): void {
      Livewire::test(TableList::class, [
         'rows' => [],
         'columns' => [
            ['key' => 'name', 'label' => 'Name'],
         ],
         'emptyMessage' => 'No users found',
      ])
         ->assertSee('No users found');
   }

   /**
    * Test Card component renders
    */
   public function test_card_renders(): void {
      Livewire::test(Card::class, [
         'title' => 'Dashboard Widget',
         'description' => 'Main statistics',
      ])
         ->assertSee('Dashboard Widget')
         ->assertSee('Main statistics');
   }

   /**
    * Test Card with custom padding
    */
   public function test_card_custom_padding(): void {
      Livewire::test(Card::class, [
         'title' => 'Test Card',
         'padding' => 'lg',
         'padded' => true,
      ])
         ->assertSet('padding', 'lg')
         ->assertSet('padded', true);
   }

   /**
    * Test Callout component renders
    */
   public function test_callout_renders(): void {
      Livewire::test(Callout::class, [
         'message' => 'This is an info message',
         'variant' => 'info',
      ])
         ->assertSee('This is an info message');
   }

   /**
    * Test Callout with all variants
    */
   public function test_callout_variants(): void {
      $variants = ['info', 'success', 'warning', 'danger'];

      foreach ($variants as $variant) {
         Livewire::test(Callout::class, [
            'message' => 'Test message',
            'variant' => $variant,
         ])
            ->assertSee('Test message');
      }
   }

   /**
    * Test Callout dismissible
    */
   public function test_callout_dismissible(): void {
      Livewire::test(Callout::class, [
         'message' => 'Dismissible alert',
         'dismissible' => true,
      ])
         ->call('dismiss')
         ->assertSet('show', false);
   }

   /**
    * Test SkeletonLoader renders
    */
   public function test_skeleton_loader_renders(): void {
      Livewire::test(SkeletonLoader::class, [
         'count' => 3,
         'height' => '12',
      ])
         ->assertSee('animate-pulse');
   }

   /**
    * Test SkeletonLoader without animation
    */
   public function test_skeleton_loader_no_animation(): void {
      Livewire::test(SkeletonLoader::class, [
         'count' => 1,
         'animated' => false,
      ])
         ->assertSet('animated', false);
   }

   /**
    * Test BreadcrumbsNav renders
    */
   public function test_breadcrumbs_nav_renders(): void {
      Livewire::test(BreadcrumbsNav::class, [
         'breadcrumbs' => [
            ['label' => 'Home', 'href' => '/', 'active' => false],
            ['label' => 'Users', 'href' => '/users', 'active' => false],
            ['label' => 'Profile', 'active' => true],
         ],
      ])
         ->assertSee('Home')
         ->assertSee('Users')
         ->assertSee('Profile');
   }

   /**
    * Test BreadcrumbsNav empty state
    */
   public function test_breadcrumbs_nav_empty(): void {
      Livewire::test(BreadcrumbsNav::class, [
         'breadcrumbs' => [],
      ])
         ->assertDontSee('Home');
   }

   /**
    * Test PaginationNav renders
    */
   public function test_pagination_nav_renders(): void {
      Livewire::test(PaginationNav::class, [
         'paginator' => null,
      ])
         ->assertViewIs('livewire.user-module.components.pagination-nav');
   }
}
