<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserModal extends Component
{
    public $name;
    public $username;
    public $email;
    public $roleId;
    public $roles;
    public $password;
    public $confirmPassword;
    public $position;
    public $userId;
    public $isEditing = false;

    public function mount($id = null)
    {
        $this->roles = Role::get();
        // dd($this->id);
        if($id) {
            $this->isEditing = true;
            $this->userId = $id;
            $users = User::with('roles')->find($id);
            $this->name = $users->name;
            $this->username = $users->username;
            $this->email = $users->email;
            $this->roleId = $users->roles->first()->id;
        }        
    }

    private function flashValidationError($e)
    {
        $errorText = collect($e->errors())->flatten()->implode("\n");
        $this->dispatch('swal:error', message: $errorText);

    }

    public function rules()
    {
        if ($this->userId) {
            return [
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'roleId' => 'required|exists:roles,id',
                'password' => 'nullable|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
                'confirmPassword' => 'required_with:password|same:password',
            ];
        }
        
        return [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'roleId' => 'required|exists:roles,id',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            'confirmPassword' => 'required|same:password',
        ];

    }

    public function messages() {
        return [
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf kapital dan angka.',
            'confirmPassword.same' => 'Konfirmasi password harus sama dengan password.', 
        ];
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->flashValidationError($e);
        }

        $user = User::find($this->userId);

        if ($user) {
            $user->name     = $this->name;
            $user->username = $this->username;
            $user->email    = $this->email;

            if (!empty($this->password)) {
                if ($this->password !== $this->confirmPassword) {
                    return $this->dispatch('swal:error', message: 'Konfirmasi password tidak sama!');
                }
                $user->password = Hash::make($this->password);
            }

            $user->save();
        } else {
            $user = User::create([
                'name'     => $this->name,
                'username' => $this->username,
                'email'    => $this->email,
                'password' => !empty($this->password) ? Hash::make($this->password) : null,
            ]);
        }

        $user->roles()->sync([$this->roleId]);

        $this->dispatch('swal:success', message: 'Data User Berhasil Disimpan...');
    }


    public function delete($id = null)
    {
        $id = $id ?? $this->userId;

        if(!$id) {
            $this->dispatch('swal:error', message: 'User ga ketemu...');
        }

        try {
            $user = User::find($id);
            $user->delete();
            $this->dispatch('swal:success', message: 'User berhasil dihapus...');
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Gagal menghapus data: ' . $e->getMessage());

        }
    }

    public function render()
    {
        return view('livewire.user-modal');
    }
}
