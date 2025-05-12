<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExampleOutcomingMailResource\Pages;
use App\Filament\Resources\ExampleOutcomingMailResource\RelationManagers;
use App\Models\ExampleOutcomingMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;
use App\Forms\Components\FilePreview;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Clusters\Master;

class ExampleOutcomingMailResource extends Resource
{
    protected static ?string $model = ExampleOutcomingMail::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Contoh Surat Keluar';

    protected static ?string $pluralModelLabel = 'Contoh Surat Keluar';

    protected static ?string $label = 'Contoh Surat Keluar';

    protected static ?string $cluster = Master::class;

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Data Surat')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Surat')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('type')
                                    ->label('Tipe Surat')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('mail_code')
                                    ->label('Kode Surat')
                                    ->placeholder('Opsional')
                                    ->maxLength(255)
                                    ->default(null),
                            ])
                        ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Data Surat')
                            ->schema([
                                FilePreview::make('uuid')
                                    ->label('File Saat Ini'),
                                Forms\Components\Toggle::make('replace_file')
                                    ->label('Upload File Baru')
                                    ->reactive(),
                                Forms\Components\FileUpload::make('file')
                                    ->label('Upload File Surat (Word/PDF)')
                                    ->required()
                                    ->visible(fn ($get) => $get('replace_file'))
                                    ->storeFiles(false) // Jangan simpan ke storage
                                    ->disk('local') // Gunakan disk 'local' sementara
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    ])
                                    ->maxSize(5120) // Maksimal 5MB
                                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName()) // Simpan dengan nama asli
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state) {
                                            $set('file_type', $state->getMimeType()); // Simpan ekstensi file
                                        }
                                    }),
                                Forms\Components\TextInput::make('file_type')
                                    ->label('Tipe File')
                                    ->readOnly()
                                    ->visible(fn ($get) => $get('replace_file'))
                                    ->required(),
                            ])
                        ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file')
                    ->label('File Surat')
                    ->alignCenter()
                    ->formatStateUsing(fn ($state, $record) => $state
                        ? '<a href="'.route('example-outcoming-mails.preview', $record->uuid).'" style="color: red;" target="_blank">Download File</a>'
                        : 'No File')
                    ->html(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Surat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe Surat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mail_code')
                    ->label('Kode Surat')
                    ->default('(tanpa kode)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_type')
                    ->label('Tipe File')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'application/pdf' => 'PDF',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'Word',
                            default => 'Tidak Diketahui',
                        };
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            'application/pdf' => 'warning', // merah
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'primary', // biru
                            default => 'gray', // abu
                        };
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExampleOutcomingMails::route('/'),
            'create' => Pages\CreateExampleOutcomingMail::route('/create'),
            'edit' => Pages\EditExampleOutcomingMail::route('/{record}/edit'),
        ];
    }
}
