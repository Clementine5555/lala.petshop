<?php

namespace App\Filament\Admin\Resources\ActivityLogs;

use BackedEnum;
// Import Model Spatie
use Filament\Tables\Table;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Activitylog\Models\Activity as ActivityModel; 

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityModel::class;
    
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    
    protected static ?string $navigationLabel = 'Activity Logs';
    protected static ?string $slug = 'activity-logs';

    public static function canCreate(): bool { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canDeleteAny(): bool { return false; }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')
                    ->columns(3)
                    ->schema([
                        // Siapa: Pelaku Perubahan
                        TextEntry::make('causer.name')
                            ->label('Pelaku')
                            ->placeholder('Sistem / Tidak Terdeteksi'),
                        
                        // Waktunya Kapan
                        TextEntry::make('created_at')
                            ->label('Waktu Kejadian')
                            ->dateTime('d M Y, H:i:s'),

                        // Tabel Apa
                        TextEntry::make('subject_type')
                            ->label('Tabel/Model')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state)), 
                    ]),

                    Section::make('Detail Perubahan')
                    ->description('Nilai lama (old) dan nilai baru (attributes) yang tersimpan di kolom properties (JSON).')
                    ->columns(2)
                    ->schema([
                        // Nilai Lama: properties.old
                        KeyValueEntry::make('properties.old')
                            ->label('Nilai Sebelum Perubahan')
                            ->placeholder('Data baru dibuat.')
                            ->columnSpan(1)
                            ->state(fn (ActivityModel $record) => $record->properties->get('old') ?? []),
                        
                        // Nilai Baru: properties.attributes
                        KeyValueEntry::make('properties.attributes')
                            ->label('Nilai Setelah Perubahan')
                            ->placeholder('Data dihapus.')
                            ->columnSpan(1)
                            ->state(fn (ActivityModel $record) => $record->properties->get('attributes') ?? []),
                    ]),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Waktunya Kapan
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Siapa (Pelaku)
                TextColumn::make('causer.name') 
                    ->label('Pelaku')
                    ->placeholder('Sistem')
                    ->searchable(),

                // Tabel Apa (Subject Type)
                TextColumn::make('subject_type')
                    ->label('Tabel/Model')
                    ->formatStateUsing(fn (string $state): string => str_replace('App\\Models\\', '', $state))
                    ->sortable(),
                    
                // Apa yang Diubah
                TextColumn::make('description')
                    ->label('Aksi')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'secondary',
                    }),
                    
                TextColumn::make('subject_id')
                    ->label('ID Record')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                // EditAction::make(),
                // DeleteAction::make(),
                // ForceDeleteAction::make(),
                // RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                    // ForceDeleteBulkAction::make(),
                    // RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
