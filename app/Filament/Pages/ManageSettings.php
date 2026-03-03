<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

class ManageSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static \UnitEnum|string|null $navigationGroup = 'System';
    protected static ?string $title = 'Site Settings';

    public ?array $data = [];

    public function mount(): void
    {
        abort_unless(auth()->user()->can('manage_settings'), 403);

        $settings = \App\Models\Setting::getSettings();
        $this->getSchema('form')->fill($settings->toArray());
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('manage_settings');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Settings')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('General')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('agency_name')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('tagline')
                                    ->maxLength(255),
                                \Filament\Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Branding')
                            ->schema([
                                \Filament\Forms\Components\FileUpload::make('logo_light')
                                    ->image()
                                    ->disk('public')
                                    ->directory('')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml']),
                                \Filament\Forms\Components\FileUpload::make('logo_dark')
                                    ->image()
                                    ->disk('public')
                                    ->directory('')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml']),
                                \Filament\Forms\Components\FileUpload::make('favicon')
                                    ->image()
                                    ->disk('public')
                                    ->directory('')
                                    ->maxSize(2048)
                                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml']),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Contact')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('mobile_number')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\Textarea::make('address')
                                    ->columnSpanFull(),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Social Media')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('instagram_url')
                                    ->url()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('linkedin_url')
                                    ->url()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('youtube_url')
                                    ->url()
                                    ->maxLength(255),
                                \Filament\Forms\Components\TextInput::make('tiktok_url')
                                    ->url()
                                    ->maxLength(255),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('SEO')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('default_meta_title')
                                    ->required()
                                    ->maxLength(255),
                                \Filament\Forms\Components\Textarea::make('default_meta_description')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\FileUpload::make('default_og_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('')
                                    ->maxSize(2048),
                            ]),
                        \Filament\Schemas\Components\Tabs\Tab::make('Script Integration')
                            ->schema([
                                \Filament\Forms\Components\Textarea::make('head_script')
                                    ->label('Head Script (Before </head>)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\Textarea::make('body_script')
                                    ->label('Body Script (Before </body>)')
                                    ->rows(5)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
            ])
            ->model(\App\Models\Setting::getSettings())
            ->operation('edit')
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label(__('Save Settings'))
                ->submit('save'),
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Form::make([
                    \Filament\Schemas\Components\EmbeddedSchema::make('form'),
                ])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    \Filament\Schemas\Components\Actions::make($this->getFormActions())
                        ->alignment(\Filament\Support\Enums\Alignment::Start),
                ]),
            ]);
    }

    public function save(): void
    {
        try {
            $data = $this->getSchema('form')->getState();

            $settings = \App\Models\Setting::getSettings();
            $settings->update($data);

            \Filament\Notifications\Notification::make()
                ->success()
                ->title('Settings Saved')
                ->send();
        } catch (\Filament\Exceptions\ValidationException $exception) {
            \Filament\Notifications\Notification::make()
                ->danger()
                ->title('Validation Error')
                ->body('Please check the form for errors.')
                ->send();
            throw $exception;
        }
    }
}
