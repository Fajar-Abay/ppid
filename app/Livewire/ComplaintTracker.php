<?php

namespace App\Livewire;

use App\Models\Complaint;
use Livewire\Component;

class ComplaintTracker extends Component
{
    public string $trackingCode = '';
    public ?Complaint $complaint = null;
    public bool $searched = false;

    public function track()
    {
        $this->validate([
            'trackingCode' => 'required|string'
        ]);

        $this->complaint = Complaint::with('responseLetter')->where('tracking_code', $this->trackingCode)->first();
        $this->searched = true;
    }

    public function render()
    {
        return view('livewire.complaint-tracker');
    }
}
