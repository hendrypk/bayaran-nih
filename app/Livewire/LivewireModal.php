<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class LivewireModal extends Component
{
    public ?string $activeModal = null;
    public ?array $args = [];

    #[On('initModal')]
    public function initModal($modal, $args = []): void
    {
        $this->activeModal = $modal;
        $this->args = $args;

        $this->dispatch('modal-ready', modal: $modal);
    }

    #[On('closeModal')]
    public function closeModal() {
        $this->reset(['activeModal', 'args']);
    }

    public function render()
    {
        return view('livewire.livewire-modal');
    }
}