<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PinjamanRelationManager extends RelationManager
{
    protected static string $relationship = 'pinjaman';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('member_id')
                    ->label('ID Anggota')
                    ->required()
                    ->default(fn() => $this->getOwnerRecord()?->id)
                    ->disabled(),
                Forms\Components\DatePicker::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->default(now())
                    ->maxDate(now())
                    ->required(),
                Forms\Components\TextInput::make('jumlah_pinjaman')
                    ->prefix('Rp.')
                    ->label('Jumlah Pinjaman')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $jumlah = (float) $get('jumlah_pinjaman');
                        $jangka = (float) $get('jangka_waktu');
                        $bunga = (float) $get('bunga');
                        $total = $jumlah + ($jumlah * $bunga / 100);
                        $cicilan = ($jumlah > 0 && $jangka > 0) ? round($total / $jangka) : 0;
                        $set('cicilan', $cicilan);
                    }),
                Forms\Components\TextInput::make('jangka_waktu')
                    ->suffix('Bulan')
                    ->label('Jangka Waktu')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $jumlah = (float) $get('jumlah_pinjaman');
                        $jangka = (float) $get('jangka_waktu');
                        $bunga = (float) $get('bunga');
                        $total = $jumlah + ($jumlah * $bunga / 100);
                        $cicilan = ($jumlah > 0 && $jangka > 0) ? round($total / $jangka) : 0;
                        $set('cicilan', $cicilan);
                    }),
                Forms\Components\TextInput::make('bunga')
                    ->suffix('%')
                    ->label('Bunga')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $jumlah = (float) $get('jumlah_pinjaman');
                        $jangka = (float) $get('jangka_waktu');
                        $bunga = (float) $get('bunga');
                        $total = $jumlah + ($jumlah * $bunga / 100);
                        $cicilan = ($jumlah > 0 && $jangka > 0) ? round($total / $jangka) : 0;
                        $set('cicilan', $cicilan);
                    }),
                Forms\Components\TextInput::make('cicilan')
                    ->prefix('Rp.')
                    ->label('Cicilan per bulan')
                    ->required()
                    ->numeric(),
                Forms\Components\ToggleButtons::make('status_pinjaman')
                    ->label('Status Pinjaman')
                    ->options([
                        'lunas' => 'Lunas',
                        'belum_lunas' => 'Belum Lunas',
                    ])
                    ->grouped()
                    ->default('belum_lunas')
                    ->required(),
                Forms\Components\ToggleButtons::make('status_pengajuan')
                    ->label('Status Pengajuan')
                    ->options([
                        'pending' => 'Pending',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->grouped()
                    ->default('pending')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('loan')
            ->columns([
                Tables\Columns\TextColumn::make('member.nama_lengkap')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jumlah_pinjaman')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cicilan')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jangka_waktu')
                    ->suffix(' Bulan')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status_pinjaman')
                    ->options([
                        'lunas' => 'Lunas',
                        'belum_lunas' => 'Belum Lunas',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('bunga')
                    ->suffix('%')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status_pengajuan')
                    ->options([
                        'pending' => 'Pending',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->sortable(),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
