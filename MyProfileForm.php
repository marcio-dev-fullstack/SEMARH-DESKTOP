<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Rule;

class MyProfileForm extends Component
{
    public $user;

    // Profile properties
    #[Rule('required|min:3', as: 'Nome Completo')]
    public $name = '';

    #[Rule('required|email', as: 'E-mail')]
    public $email = '';

    #[Rule('nullable|string|min:10', as: 'Celular')]
    public $celular = '';

    // Password change properties
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        // Placeholder: Em uma aplicação real, usaria Auth::user()
        // $this->user = Auth::user();
        $this->user = (object) [
            'id' => 1,
            'name' => 'Márcio Rodrigues',
            'email' => 'marcio.oliveira@semarh.gov.br',
            'celular' => '(62) 99646-6033',
            'password' => Hash::make('password'), // Senha de exemplo para validação
        ];

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->celular = $this->user->celular;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'celular' => 'nullable|string|min:10',
        ]);

        // Placeholder: Lógica para atualizar o usuário no banco.
        // $this->user->update(['name' => $this->name, 'email' => $this->email, 'celular' => $this->celular]);

        session()->flash('profile_message', 'Perfil atualizado com sucesso!');
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, $this->user->password)) {
                    $fail('A senha atual está incorreta.');
                }
            }],
            'new_password' => 'required|min:8|same:new_password_confirmation',
        ]);

        // Placeholder: Lógica para atualizar a senha no banco.
        // $this->user->update(['password' => Hash::make($this->new_password)]);

        session()->flash('password_message', 'Senha alterada com sucesso!');
        $this->reset('current_password', 'new_password', 'new_password_confirmation');
    }

    public function render()
    {
        return view('livewire.admin.my-profile-form');
    }
}