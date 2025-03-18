<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutcomingMailResource\Pages;
use App\Filament\Resources\OutcomingMailResource\RelationManagers;
use App\Models\OutcomingMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class OutcomingMailResource extends Resource
{
    protected static ?string $model = OutcomingMail::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    protected static ?string $navigationLabel = 'Surat Keluar';

    protected static ?string $pluralModelLabel = 'Surat Keluar';

    protected static ?string $label = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Data Surat')
                            ->schema([
                                Forms\Components\TextInput::make('reference_number')
                                ->label('No. Surat')
                                ->required()
                                ->maxLength(255)
                                ->live()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $existingMail = OutcomingMail::where('reference_number', $state)->first();

                                    if ($existingMail) {
                                        $set('reference_number', null);
                                        \Filament\Notifications\Notification::make()
                                            ->title('Nomor Surat Sudah Digunakan')
                                            ->body("Nomor surat ini sudah digunakan untuk dokumen lain. <br />
                                                    <b>Judul</b> : {$existingMail->subject} <br />
                                                    <b>Pengirim</b> : {$existingMail->sender->name} <br />
                                                    <b>Penerima</b> : {$existingMail->reciver->name} <br />
                                                    <b>Tgl. Surat Diterima</b> : {$existingMail->date}")
                                            ->warning()
                                            ->send();
                                    }
                                }),
                            Forms\Components\DatePicker::make('date')
                                ->label('Tgl. Surat Dikirim')
                                ->default(now()->format('Y-m-d'))
                                ->required(),
                            Forms\Components\DatePicker::make('implementation_date')
                                ->label('Tgl. Pelaksanaan')
                                ->required(),
                            Forms\Components\Textarea::make('subject')
                                ->label('Judul Surat')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('description')
                                ->label('Deskripsi Surat')
                                ->required()
                                ->columnSpanFull(),
                                Forms\Components\FileUpload::make('file')
                                ->label('Upload File Surat (PDF atau File Gambar)')
                                ->required()
                                ->storeFiles(false) // Jangan simpan ke storage
                                ->disk('local') // Gunakan disk 'local' sementara
                                ->acceptedFileTypes([
                                    'application/pdf',
                                    'image/jpeg',
                                    'image/png',
                                    'image/png'
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
                                ->required(),
                        ])
                    ]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Info Surat')
                            ->schema([

                            Forms\Components\Select::make('sender_id')
                                ->label('Pengirim Surat')
                                ->relationship('sender', 'name') // Nama fungsi relasi di model IncomingMail
                                ->searchable()
                                ->preload()
                                ->required(),
                            Forms\Components\Select::make('receiver_id')
                                ->label('Surat Ditujukan Ke (Penerima)')
                                ->relationship('reciver', 'name') // Nama fungsi relasi di model IncomingMail
                                ->searchable()
                                ->preload()
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
                    ->formatStateUsing(fn ($state, $record) => $state
                        ? '<a href="'.route('outcoming-mails.preview', $record->id).'" style="color:red;" target="_blank">Lihat File</a>'
                        : 'No File')
                    ->html(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tgl. Surat Dikirim')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('implementation_date')
                    ->label('Tgl. Pelaksanaan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('No. Surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Pengirim')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reciver.name')
                    ->label('Penerima')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label('Judul Surat')
                    ->searchable(),
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
                // Tables\Actions\EditAction::make(),
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListOutcomingMails::route('/'),
            'create' => Pages\CreateOutcomingMail::route('/create'),
            'edit' => Pages\EditOutcomingMail::route('/{record}/edit'),
        ];
    }
}
