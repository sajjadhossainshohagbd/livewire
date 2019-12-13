<?php

namespace Tests;

use Livewire\Component;
use Livewire\LivewireManager;

class ComponentCanBeFilledTest extends TestCase
{
    /** @test */
    public function can_fill_from_an_array()
    {
        $component = app(LivewireManager::class)->test(ComponentWithFillableProperties::class);

        $component->assertSee('public');
        $component->assertSee('protected');
        $component->assertSee('private');

        $component->call('callFill', [
            'publicProperty' => 'Caleb',
            'protectedProperty' => 'Caleb',
            'privateProperty' => 'Caleb',
        ]);

        $component->assertSee('Caleb');
        $component->assertSee('protected');
        $component->assertSee('private');
    }

    /** @test */
    public function can_fill_from_an_object()
    {
        $component = app(LivewireManager::class)->test(ComponentWithFillableProperties::class);

        $component->assertSee('public');
        $component->assertSee('protected');
        $component->assertSee('private');

        $component->call('callFill', new User());

        $component->assertSee('Caleb');
        $component->assertSee('protected');
        $component->assertSee('private');
    }
}

class User {
    public $publicProperty = 'Caleb';
    public $protectedProperty = 'Caleb';
    public $privateProperty = 'Caleb';
}

class ComponentWithFillableProperties extends Component
{
    public $publicProperty = 'public';
    protected $protectedProperty = 'protected';
    private $privateProperty = 'private';

    public function callFill($values)
    {
        $this->fill($values);
    }

    public function render()
    {
        return view('fillable-view', [
            'publicProperty' => $this->publicProperty,
            'protectedProperty' => $this->protectedProperty,
            'privateProperty' => $this->privateProperty,
        ]);
    }
}