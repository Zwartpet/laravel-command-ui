<?php

use Zwartpet\CommandUI\Livewire\CommandUIComponent;

Route::get(config('command-ui.uri'), CommandUIComponent::class)
    ->middleware(config('command-ui.middleware'));
