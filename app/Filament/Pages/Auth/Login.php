<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action as FormAction;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form->schema([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getRememberFormComponent(),
            Section::make('Masuk Cepat Demo Portofolio (1-Klik)')
                ->description('Pilih peran di bawah untuk langsung mencoba aplikasi tanpa mengetik akun.')
                ->schema([
                    Actions::make([
                        FormAction::make('demo_superadmin')
                            ->label('Superadmin')
                            ->color('primary')
                            ->action(fn () => $this->loginAsDemo('superadmin', 'DemoEsurat123')),
                        FormAction::make('demo_admin')
                            ->label('Admin Persuratan')
                            ->color('info')
                            ->action(fn () => $this->loginAsDemo('admin', 'DemoEsurat123')),
                        FormAction::make('demo_pegawai')
                            ->label('Pegawai')
                            ->color('gray')
                            ->action(fn () => $this->loginAsDemo('pegawai', 'DemoEsurat123')),
                    ])->fullWidth(),
                ])
                ->compact(),
        ]);
    }

    public function loginAsDemo(string $username, string $password): ?LoginResponse
    {
        $this->form->fill([
            'username' => $username,
            'password' => $password,
            'remember' => true,
        ]);

        return $this->authenticate();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label(__('app.username'))
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /** @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => (string) $data['username'],
            'password' => (string) $data['password'],
            'is_active' => true,
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
