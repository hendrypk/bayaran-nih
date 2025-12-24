<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RoleModal extends Component
{
    public $permissions;
    // public $groupedPermissions;

    public function mount()
    {
        $this->permissions = Permission::orderBy('group_name', 'asc')->orderBy('name', 'asc')->get();

        // $this->groupedPermissions = $this->permissions->groupBy('group_name');
        // dd($this->groupedPermissions);    
    }

    public function render()
    {
        return view('livewire.role-modal',[
            'groupedPermissions' => $this->permissions->groupBy('group_name')
        ]);
    }
}
