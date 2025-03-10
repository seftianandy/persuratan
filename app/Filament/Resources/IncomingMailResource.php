<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomingMailResource\Pages;
use App\Filament\Resources\IncomingMailResource\RelationManagers;
use App\Models\IncomingMail;
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

class IncomingMailResource extends Resource
{
    protected static ?string $model = IncomingMail::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationLabel = 'Surat Masuk';

    protected static ?string $pluralModelLabel = 'Surat Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sender_id')
                    ->label('Pengirim Surat')
                    ->relationship('sender', 'name') // Nama fungsi relasi di model IncomingMail
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('receiver_id')
                    ->label('Penerima Surat')
                    ->relationship('reciver', 'name') // Nama fungsi relasi di model IncomingMail
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('reference_number')
                    ->label('No. Surat')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $existingMail = IncomingMail::where('reference_number', $state)->first();

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
                    ->label('Tgl. Surat Ditermia')
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
                    ->label('Upload File Surat (PDF)')
                    ->required()
                    ->storeFiles(false) // Jangan simpan ke storage
                    ->disk('local') // Gunakan disk 'local' sementara
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(2024) // Maksimal 2MB
                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->getClientOriginalName()) // Simpan dengan nama asli
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file')
                    ->label('File Surat')
                    ->formatStateUsing(fn ($state, $record) => $state
                        ? '<a href="'.route('incoming-mails.preview', $record->id).'" style="color:red;" target="_blank">Lihat File</a>'
                        : 'No File')
                    ->html(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tgl. Surat Diterima')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Pengirim')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reciver.name')
                    ->label('Penerima')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('No. Surat')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListIncomingMails::route('/'),
            'create' => Pages\CreateIncomingMail::route('/create'),
            'edit' => Pages\EditIncomingMail::route('/{record}/edit'),
        ];
    }
}
