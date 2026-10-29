<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Storage;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Avatar upload
                FileUpload::make('profile_photo')
                    ->label('Profile Photo')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('avatars')
                    ->visibility('public')
                    ->deletable()
                    ->openable()
                    ->downloadable()
                    ->avatar()
                    ->helperText('Upload a profile picture. This image shows in the admin panel top bar instead of your initials.')
                    ->columnSpanFull(),

                // Name
                $this->getNameFormComponent(),

                // Email
                $this->getEmailFormComponent(),

                // Password (optional)
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    /**
     * Override the mutateFormDataBeforeSave to handle profile_photo saving.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // FileUpload returns an array for single files — flatten it
        if (isset($data['profile_photo']) && is_array($data['profile_photo'])) {
            $data['profile_photo'] = reset($data['profile_photo']) ?: null;
        }

        // Strip any leading slashes or storage/ prefix
        if (!empty($data['profile_photo']) && is_string($data['profile_photo'])) {
            $clean = ltrim($data['profile_photo'], '/');
            if (str_starts_with($clean, 'storage/')) {
                $clean = substr($clean, 8);
            }
            $data['profile_photo'] = ltrim($clean, '/');

            // Mirror to cPanel storage if available
            $localPath  = storage_path('app/public/' . $data['profile_photo']);
            $cpanelPath = '/home/kenyanba/public_html/storage/' . $data['profile_photo'];
            if (file_exists($localPath) && is_dir('/home/kenyanba/public_html/storage')) {
                @mkdir(dirname($cpanelPath), 0755, true);
                @copy($localPath, $cpanelPath);
            }
        }

        return $data;
    }

    /**
     * Override to pre-fill profile_photo correctly for FileUpload component.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $photo = $data['profile_photo'] ?? null;
        if ($photo) {
            $clean = ltrim($photo, '/');
            if (str_starts_with($clean, 'storage/')) {
                $clean = substr($clean, 8);
            }
            $clean = ltrim($clean, '/');

            $exists = Storage::disk('public')->exists($clean)
                || file_exists(storage_path('app/public/' . $clean))
                || file_exists('/home/kenyanba/public_html/storage/' . $clean);

            $data['profile_photo'] = $exists ? $clean : null;
        }

        return $data;
    }
}

