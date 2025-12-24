<?php

namespace App\Livewire;

use App\Models\Role;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleForm extends Component
{
    public $name;
    public $roleId;
    public $permissions = [];
    public $isEditing = false;
    public $selectedPermissions;
    public $assignedUsers = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditing = true;
            $role = ModelsRole::with('users')->findOrFail($id);
            $this->roleId = $role->id;
            $this->name = $role->name;
            $this->assignedUsers = $role->users;

            $this->permissions = $role->permissions->pluck('id')
                ->mapWithKeys(fn($id) => [$id => true])
                ->toArray();
        }
    }

    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->implode("\n");
        $this->dispatch('swal:error', message: $errorText);
    }

    public function rules()
    {
        return [
            'roleId' => 'nullable|exists:roles,id', 
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ];
    }

    
    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->flashValidationError($e);
        }
        if ($this->roleId) {
            $role = ModelsRole::findOrFail($this->roleId);
            $role->name = $this->name;
            $role->save();
        } else {
            $role = ModelsRole::create([
                'name' => $this->name,
                'guard_name' => 'web',
            ]);
        }

        $selectedPermissions = collect($this->permissions)
            ->filter(fn($value) => $value == true)
            ->keys()
            ->toArray();

        $role->syncPermissions($selectedPermissions);
        $this->dispatch('swal:success', message: 'Role saved successfully!');
        if(!$this->isEditing) {
            return redirect()->route('role.detail', $role->id);

        }
    }

    public function delete($id = null)
    {
        $id = $id ?? $this->roleId;

        if(!$id) {
            $this->dispatch('swal:error', message: 'Peran tidak ditemukan...');
            return;
        }

        try {
            $role = ModelsRole::findOrFail($id);

            if ($role->users()->exists()) {
                $userCount = $role->users()->count();
                $this->dispatch('swal:error', 
                    message: "Gagal menghapus! Masih ada {$userCount} pengguna yang menggunakan peran ini."
                );
                return; 
            }

            $role->delete();
            
            $this->dispatch('swal:success', message: 'Peran berhasil dihapus...');
            return redirect()->route('role.index');

        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $allPermissions = Permission::orderBy('group_name', 'asc')->get();
        return view('livewire.role-form', [
            'groupedPermissions' => $allPermissions->groupBy('group_name')
        ]);
    }
}
