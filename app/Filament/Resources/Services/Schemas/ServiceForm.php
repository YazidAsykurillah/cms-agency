<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Service')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('General Information')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                \Filament\Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                \Filament\Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                    ])
                                    ->required()
                                    ->default('draft'),
                                \Filament\Forms\Components\Toggle::make('featured')
                                    ->label('Featured Service'),
                                \Filament\Forms\Components\Textarea::make('short_description')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\FileUpload::make('featured_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('services')
                                    ->required()
                                    ->columnSpanFull(),
                                                                \Filament\Forms\Components\TextInput::make('call_to_action_text'),
                            ])->columns(2),

                        \Filament\Schemas\Components\Tabs\Tab::make('Content Strategy')
                            ->schema([
                                \Filament\Forms\Components\RichEditor::make('full_description')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('problem_statement')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('solution_approach')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\Repeater::make('process_steps')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('step_title')->required(),
                                        \Filament\Forms\Components\Textarea::make('description')->required(),
                                    ])
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\Repeater::make('faq')
                                    ->label('Frequently Asked Questions')
                                    ->schema([
                                        \Filament\Forms\Components\TextInput::make('question')->required(),
                                        \Filament\Forms\Components\Textarea::make('answer')->required(),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Schemas\Components\Tabs\Tab::make('SEO Configuration')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('meta_title')
                                    ->required(),
                                \Filament\Forms\Components\TextInput::make('meta_keywords'),
                                \Filament\Forms\Components\Textarea::make('meta_description')
                                    ->required()
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\FileUpload::make('og_image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('services')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
