<?php

namespace App\Livewire\Document\Partial;

use Livewire\Component;

class DocOpenSite extends Component
{
    protected $listeners = ['openDocSide' => 'open'];

    public $show = false;

    public function open()
    {
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.document.partial.doc-open-site');
    }
}
