<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MasterResource\Pages;
use App\Filament\Resources\MasterResource\RelationManagers;
use App\Models\Loan;
use App\Models\Master;
use App\Models\Saving;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MasterResource extends Resource
{
    protected static ?string $model = Master::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Master Simpanan';

    protected static ?string $navigationLabel = 'Master Simpanan';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('saving_id')
                    ->required()
                    ->label('Saving')
                    ->options(Saving::pluck('tanggal_transaksi', 'id')->toArray())
                    ->placeholder('Pilih Saving'),
                Forms\Components\TextInput::make('jenis_simpanan')
                    ->required()
                    ->label('Jenis Simpanan')
                    ->numeric(),
                Forms\Components\TextInput::make('jumlah_simpanan')
                    ->required()
                    ->label('Jumlah Simpanan')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('saving_id')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jumlah_simpanan')
                    ->label('Nominal Simpanan')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => Pages\ListMasters::route('/'),
            'create' => Pages\CreateMaster::route('/create'),
            'edit' => Pages\EditMaster::route('/{record}/edit'),
        ];
    }
}
