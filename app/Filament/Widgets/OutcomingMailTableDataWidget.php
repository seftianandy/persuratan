<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\OutcomingMail;
use Filament\Widgets\TableWidget as BaseWidget;

class OutcomingMailTableDataWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Surat Keluar Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OutcomingMail::query()
            )
            ->columns([
                Tables\Columns\TextColumn::make('file')
                    ->label('File Surat')
                    ->formatStateUsing(fn ($state, $record) => $state
                        ? '<a href="'.route('outcoming-mails.preview', $record->id).'" style="color:red;" target="_blank">Lihat File</a>'
                        : 'No File')
                    ->html(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tgl. Surat Diterima')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('No. Surat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reciver.name')
                    ->label('Penerima')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sender.name')
                    ->label('Pengirim')
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
            ]);
    }
}
