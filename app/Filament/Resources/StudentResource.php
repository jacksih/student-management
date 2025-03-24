<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Section;
use App\Models\Student;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Exports\StudentExporter;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->autofocus()
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->unique()
                    ->required(),
                Select::make('class_id')
                    ->relationship(name: 'class', titleAttribute: 'name')
                    ->label('Class')
                    ->live()
                    ->required(),
                Select::make('section_id')
                    ->label('Section')
                    ->options(function(Get $get){
                        $classId = $get('class_id');
                        if($classId){
                            return Section::where('class_id', $classId)->pluck('name', 'id')->toArray();
                        }
                    })
                    // ->relationship(name: 'section', titleAttribute: 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('section.name')
                    ->label('Section')
                    ->searchable()
                    ->badge()
                    ->sortable(),
                TextColumn::make('class.name')
                    ->label('Class')
                    ->searchable()
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->icon('heroicon-o-folder-arrow-down')
                    ->exporter(StudentExporter::class)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                ExportAction::make()
                    ->exporter(StudentExporter::class)
                    ->icon('heroicon-o-document-arrow-down')
                    ->label('Export'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                    ->exporter(StudentExporter::class)
                    ->icon('heroicon-o-document-arrow-down')
                    ->label('Export'),

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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
