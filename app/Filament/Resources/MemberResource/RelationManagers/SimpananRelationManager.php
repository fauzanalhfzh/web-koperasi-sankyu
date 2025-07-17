<?php

namespace App\Filament\Resources\MemberResource\RelationManagers;

use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SimpananRelationManager extends RelationManager
{
    protected static string $relationship = 'simpanan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('member_id')
                    ->label('ID Anggota')
                    ->required()
                    ->default(fn() => $this->getOwnerRecord()?->id)
                    ->disabled(),
                Select::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->options([
                        'pokok' => 'Simpanan Pokok',
                        'wajib' => 'Simpanan Wajib',
                    ])
                    ->required(),
                TextInput::make('jumlah_simpanan')
                    ->label('Nominal Simpanan')
                    ->prefix('Rp.')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                DatePicker::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->maxDate(now())
                    ->required(),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('saving')
            ->columns([
                TextColumn::make('jumlah_simpanan')
                    ->label('Nominal Simpanan')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date()
                    ->sortable(),
                TextColumn::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->searchable(),
                TextColumn::make('member.nama_lengkap')
                    ->label('Nama Anggota')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Tanggal Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Tanggal Dihapus')
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
