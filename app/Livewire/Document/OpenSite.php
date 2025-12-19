<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;

class DocOpenSite extends Component
{
    protected $listeners = ['openDocSide' => 'open'];

    public bool $show = false;

    public function open(): void
    {
        $this->show = true;
    }

    public function close(): void
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire..open-site');
    }
}
