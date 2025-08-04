<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SavingResource\Pages;
use App\Filament\Resources\SavingResource\RelationManagers;
use App\Models\Member;
use App\Models\Saving;
use Filament\Tables\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SavingResource extends Resource
{
    protected static ?string $model = Saving::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Perhitungan Saldo';

    protected static ?string $label = 'Simpanan';

    protected static ?string $navigationLabel = 'Simpanan';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('member_id')
                    ->label('Nama Anggota')
                    ->options(Member::all()->pluck('nama_lengkap', 'id'))
                    ->required()
                    ->searchable(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('member.nama_lengkap')
                    ->label('Nama Anggota')
                    ->searchable(),
                TextColumn::make('jenis_simpanan')
                    ->label('Jenis Simpanan')
                    ->searchable(),
                TextColumn::make('jumlah_simpanan')
                    ->label('Nominal Simpanan')
                    ->prefix('Rp.')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tanggal_transaksi')
                    ->label('Tanggal Transaksi')
                    ->date()
                    ->sortable(),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
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
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => Pages\ListSavings::route('/'),
            'create' => Pages\CreateSaving::route('/create'),
            'edit' => Pages\EditSaving::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
