<?php

namespace App\Filament\Resources;

use App\Enum\OrderCountry;
use App\Enum\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class OrderResource extends CommonResource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = "Objednávka";
    protected static ?string $pluralModelLabel = "Objednávky";
    protected static ?string $recordTitleAttribute = 'full_billing_name';
    protected static string $defaultSortColumn = 'created_at';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Billing Info + Company + Billing Address Section
                Section::make('Billing Information')
                    ->collapsible()
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('billing_first_name')
                                    ->label("First Name")
                                    ->required(),
                                TextInput::make('billing_last_name')
                                    ->label("Last Name")
                                    ->required(),
                                TextInput::make('email')
                                    ->label("Email")
                                    ->email()
                                    ->required(),
                            ]),
                        Checkbox::make('is_company')
                            ->label("Is Company?")
                            ->reactive(),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('company_name')
                                    ->label("Company Name")
                                    ->visible(fn ($get) => $get('is_company'))
                                    ->required(),
                                TextInput::make('business_id')
                                    ->label("Business ID")
                                    ->visible(fn ($get) => $get('is_company'))
                                    ->required(),
                                TextInput::make('vat_id')
                                    ->label("VAT ID")
                                    ->visible(fn ($get) => $get('is_company'))
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('billing_address')
                                    ->label("Address")
                                    ->required(),
                                TextInput::make('billing_city')
                                    ->label("City")
                                    ->required(),
                                TextInput::make('billing_zip')
                                    ->label("ZIP Code")
                                    ->required(),
                                Select::make('billing_country')
                                    ->label("Country")
                                    ->options(OrderCountry::translations())
                                    ->required(),
                            ]),
                        Checkbox::make('is_shipping_address')
                            ->label("Different Shipping Address?")
                            ->reactive(),
                        Grid::make(3)
                            ->visible(fn ($get) => $get('is_shipping_address'))
                            ->schema([
                                TextInput::make('shipping_first_name')
                                    ->label("First Name")
                                    ->required(),
                                TextInput::make('shipping_last_name')
                                    ->label("Last Name")
                                    ->required(),
                                TextInput::make('shipping_address')
                                    ->label("Address")
                                    ->required(),
                                TextInput::make('shipping_city')
                                    ->label("City")
                                    ->required(),
                                TextInput::make('shipping_zip')
                                    ->label("ZIP Code")
                                    ->required(),
                                Select::make('shipping_country')
                                    ->label("Country")
                                    ->options(OrderCountry::translations())
                                    ->required(),
                            ]),
                    ]),

                // Order Products Section
                Section::make('Order Products')
                    ->collapsible()
                    ->schema([
                        Repeater::make('orderItems')
                            ->relationship()
                            ->schema([
                                TextInput::make('name')
                                    ->label("Product Name")
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label("Quantity")
                                    ->numeric()
                                    ->required(),
                                TextInput::make('price_per_unit')
                                    ->label("Price Per Unit")
                                    ->numeric()
                                    ->required(),
                                TextInput::make('discount_amount_per_unit')
                                    ->label("Discount Per Unit")
                                    ->numeric(),
                                TextInput::make('total_no_vat')
                                    ->label("Total (No VAT)")
                                    ->numeric()
                                    ->disabled(),
                                TextInput::make('vat_amount')
                                    ->label("VAT Amount")
                                    ->numeric()
                                    ->disabled(),
                                TextInput::make('total_with_vat')
                                    ->label("Total (With VAT)")
                                    ->numeric()
                                    ->disabled(),
                            ])
                            ->columns(3),
                    ]),

                // Summary Section
                Section::make('Order Summary')
                    ->collapsible()
                    ->visibleOn("edit")
                    ->schema([
                        Placeholder::make('subtotal')
                            ->label("Subtotal")
                            ->content(fn ($record) => $record->subtotal),
                        Placeholder::make('discount_amount')
                            ->label("Discount")
                            ->content(fn ($record) => $record->discount_amount),
                        Placeholder::make('shipping_type_price')
                            ->label("Shipping Cost")
                            ->content(fn ($record) => $record->shipping_type_price),
                        Placeholder::make('payment_type_price')
                            ->label("Payment Cost")
                            ->content(fn ($record) => $record->payment_type_price),
                        Placeholder::make('total_no_vat')
                            ->label("Total (No VAT)")
                            ->content(fn ($record) => $record->total_no_vat),
                        Placeholder::make('vat_amount')
                            ->label("VAT Amount")
                            ->content(fn ($record) => $record->vat_amount),
                        Placeholder::make('total_with_vat')
                            ->label("Total (With VAT)")
                            ->content(fn ($record) => $record->total_with_vat),
                    ]),
            ]);
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['name'] = TextColumn::make('name')->label('Názov')->sortable()->searchable();

        $columns['status'] = TextColumn::make('status')
            ->label('Stav')
            ->badge()
            ->color(fn(string $state): string => OrderStatus::colors()[$state]);

        return $columns;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
