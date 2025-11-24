<?php

namespace App\Livewire\Organisation\Segment;

use Livewire\Component;
use App\Models\Segment;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Str;

class SegmentEdit extends Component
{
    use Interactions;

    public $segmentId;
    public $name = '';
    public $slug = '';
    public $status = 1;

    protected $listeners = [
        'loadData-edit-segment' => 'loadSegment'
    ];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ];
    }

    public function loadSegment($data)
    {
        $id = is_array($data) ? $data['id'] : $data;

        $segment = Segment::findOrFail($id);

        $this->segmentId = $segment->id;
        $this->name = $segment->name;
        $this->slug = $segment->slug;
        $this->status = $segment->status;

        $this->dispatch('open-modal-edit-segment'); // open modal
    }

    public function update()
    {
        $this->validate();

        $segment = Segment::findOrFail($this->segmentId);

        $segment->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'status' => $this->status,
        ]);

        $this->toast()->success('Success', 'Segment updated successfully')->send();

        $this->dispatch('close-modal-edit-segment');
        $this->dispatch('refresh-segment-list');
    }

    public function render()
    {
        return view('livewire.organisation.segment.segment-edit');
    }
}
