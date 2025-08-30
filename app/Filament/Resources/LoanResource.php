<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoanResource\Pages;
use App\Filament\Resources\LoanResource\RelationManagers;
use App\Models\Loan;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Perhitungan Saldo';

    protected static ?string $label = 'Pinjaman';

    protected static ?string $navigationLabel = 'Pinjaman';

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
                Forms\Components\DatePicker::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.nama_lengkap')
                    ->sortable()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_pinjaman')
                    ->prefix('Rp.')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cicilan')
                    ->prefix('Rp.')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jangka_waktu')
                    ->suffix(' Bulan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status_pinjaman')
                    ->searchable()
                    ->options([
                        'lunas' => 'Lunas',
                        'belum_lunas' => 'Belum Lunas',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('bunga')
                    ->suffix('%')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status_pengajuan')
                    ->searchable()
                    ->options([
                        'pending' => 'Pending',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_persetujuan')
                    ->date()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Tambah Pinjaman';
    }
}
