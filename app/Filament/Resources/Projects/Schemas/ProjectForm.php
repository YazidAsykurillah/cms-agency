<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Tabs::make('Project')
                    ->tabs([
                        \Filament\Schemas\Components\Tabs\Tab::make('Basic')
                            ->schema([
                                \Filament\Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(fn (\Filament\Schemas\Components\Utilities\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                \Filament\Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                \Filament\Forms\Components\TextInput::make('client_name')
                                    ->label('Client Name'),
                                \Filament\Forms\Components\TextInput::make('industry'),
                                \Filament\Forms\Components\TextInput::make('project_year')
                                    ->label('Project Year')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(2099),
                                \Filament\Forms\Components\TextInput::make('service_type')
                                    ->label('Service Type'),
                                \Filament\Forms\Components\Textarea::make('excerpt')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('content')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        \Filament\Schemas\Components\Tabs\Tab::make('Case Study')
                            ->schema([
                                \Filament\Forms\Components\RichEditor::make('problem')
                                    ->label('Problem')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('solution')
                                    ->label('Solution')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\RichEditor::make('results')
                                    ->label('Results')
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Schemas\Components\Tabs\Tab::make('Media')
                            ->schema([
                                \Filament\Forms\Components\FileUpload::make('thumbnail')
                                    ->image()
                                    ->disk('public')
                                    ->directory('projects')
                                    ->columnSpanFull(),
                                \Filament\Forms\Components\TextInput::make('video_url')
                                    ->label('Video URL')
                                    ->url()
                                    ->columnSpanFull(),
                            ]),

                        \Filament\Schemas\Components\Tabs\Tab::make('Publishing')
                            ->schema([
                                \Filament\Forms\Components\Toggle::make('is_published')
                                    ->label('Published'),
                                \Filament\Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured'),
                                \Filament\Forms\Components\TextInput::make('meta_title')
                                    ->label('Meta Title'),
                                \Filament\Forms\Components\TextInput::make('meta_keywords')
                                    ->label('Meta Keywords'),
                                \Filament\Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
