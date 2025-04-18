<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;

class DesignStatusController extends Controller
{
    public function toggle(Design $design)
    {
        // Authorization check
        $this->authorize('update', $design);
        
        $design->is_active = !$design->is_active;
        $design->save();
        
        $statusText = $design->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Design has been $statusText successfully.");
    }
}
