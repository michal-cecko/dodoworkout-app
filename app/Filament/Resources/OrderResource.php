<?php

namespace App\Filament\Resources;

use App\Enum\FormFieldFormat;
use App\Enum\OrderCountry;
use App\Enum\OrderStatus;
use App\Enum\OrderType;
use App\Filament\Resources\OrderResource\Pages;
use App\Livewire\EventRegistrationForm;
use App\Misc\MorphMap;
use App\Models\Event;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Service\AccountSubscription;
use App\Models\ShippingType;
use App\Services\OrderService;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

class OrderResource extends CommonResource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = "Objednávka";
    protected static ?string $pluralModelLabel = "Objednávky";
    protected static ?string $recordTitleAttribute = 'full_order_number';
    protected static string $defaultSortColumn = 'created_at';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';


    public static function form(Form $form): Form
    {
        $shippingTypes = ShippingType::select(['name', 'id', 'price'])->get();
        $paymentTypes = PaymentType::select(['name', 'id', 'price'])->get();

        return $form
            ->schema([
                Split::make([
                    Grid::make(1)->schema([
                        Section::make('Fakturačné údaje')
                            ->collapsible()
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('billing_first_name')
                                            ->label("Meno")
                                            ->required(),
                                        TextInput::make('billing_last_name')
                                            ->label("Priezvisko")
                                            ->required(),
                                        TextInput::make('email')
                                            ->label("Email")
                                            ->email()
                                            ->required(),
                                    ]),
                                Checkbox::make('is_company')
                                    ->label("Nákup na firmu?")
                                    ->reactive(),
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('company_name')
                                            ->label("Názov firmy")
                                            ->visible(fn($get) => $get('is_company'))
                                            ->required(),
                                        TextInput::make('business_id')
                                            ->label("IČO")
                                            ->visible(fn($get) => $get('is_company'))
                                            ->required(),
                                        TextInput::make('tax_id')
                                            ->label("DIČ")
                                            ->visible(fn($get) => $get('is_company'))
                                            ->required(),
                                        TextInput::make('vat_id')
                                            ->label("IČ DPH")
                                            ->visible(fn($get) => $get('is_company'))
                                            ->required(),
                                    ]),
                                Grid::make(4)
                                    ->schema([
                                        TextInput::make('billing_address')
                                            ->label("Ulica")
                                            ->required(),
                                        TextInput::make('billing_city')
                                            ->label("Mesto")
                                            ->required(),
                                        TextInput::make('billing_zip')
                                            ->label("PSČ")
                                            ->required(),
                                        Select::make('billing_country')
                                            ->label("Krajina")
                                            ->options(OrderCountry::translations())
                                            ->selectablePlaceholder(false)
                                            ->required(),
                                    ]),
                            ]),
                        Section::make('Dodacie údaje')
                            ->collapsible()
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('shipping_type')
                                            ->label("Spôsob dodania")
                                            ->options($shippingTypes->pluck('name', 'id'))
                                            ->reactive()
                                            ->afterStateHydrated(fn($state, callable $set) => self::updateShippingTypeState($state, $set, $shippingTypes))
                                            ->afterStateUpdated(fn($state, callable $set) => self::updateShippingTypeState($state, $set, $shippingTypes)),
                                        TextInput::make("shipping_type_label")
                                            ->label("Názov spôsobu dodania")
                                            ->required(),
                                        TextInput::make("shipping_type_price")
                                            ->label("Cena za dodanie")
                                            ->suffix("€")
                                            ->numeric(),
                                    ]),
                                Checkbox::make('is_shipping_address')
                                    ->label("Iná dodacia adresa?")
                                    ->reactive(),
                                Grid::make(3)
                                    ->visible(fn($get) => $get('is_shipping_address'))
                                    ->schema([
                                        TextInput::make('shipping_first_name')
                                            ->label("Meno")
                                            ->required(),
                                        TextInput::make('shipping_last_name')
                                            ->label("Priezvisko")
                                            ->required(),
                                        TextInput::make('shipping_address')
                                            ->label("Ulica")
                                            ->required(),
                                        TextInput::make('shipping_city')
                                            ->label("Mesto")
                                            ->required(),
                                        TextInput::make('shipping_zip')
                                            ->label("PSČ")
                                            ->required(),
                                        Select::make('shipping_country')
                                            ->selectablePlaceholder(false)
                                            ->label("Krajina")
                                            ->options(OrderCountry::translations())
                                            ->required(),
                                    ]),
                            ]),
                        Section::make('Platobné údaje')
                            ->collapsible()
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('payment_type_id')
                                            ->label("Spôsob platby")
                                            ->options($paymentTypes->pluck('name', 'id'))
                                            ->required()
                                            ->reactive()
                                            ->afterStateHydrated(fn($state, callable $set) => self::updatePaymentTypeState($state, $set, $paymentTypes))
                                            ->afterStateUpdated(fn($state, callable $set) => self::updatePaymentTypeState($state, $set, $paymentTypes)),
                                        TextInput::make("payment_type_label")
                                            ->label("Názov spôsobu platby")
                                            ->required(),
                                        TextInput::make("payment_type_price")
                                            ->label("Cena za spôsob platby")
                                            ->suffix("€")
                                            ->numeric(),
                                    ]),
                                Textarea::make('note')
                                    ->label("Poznámka")
                                    ->rows(4)
                                    ->columnSpan('full'),
                            ]),
                        Section::make('Objednané položky')
                            ->collapsible()
                            ->schema([
                                Repeater::make('orderItems')
                                    ->hiddenLabel()
                                    ->relationship()
                                    ->collapsible()
                                    ->addActionLabel('Pridať novú položku')
                                    ->deleteAction(fn(Action $action) => $action->requiresConfirmation())
                                    ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                    ->schema([
                                        MorphToSelect::make('orderable')
                                            ->label("Položka")
                                            ->types([
                                                MorphToSelect\Type::make(Event::class)
                                                    ->titleAttribute('order_item_name'),
                                            ])
                                            ->required(),
                                        TextInput::make('name')
                                            ->label("Názov")
                                            ->required(),
                                        TextInput::make('quantity')
                                            ->label("Množstvo")
                                            ->numeric()
                                            ->required()
                                            ->reactive(),
                                        TextInput::make('price_per_unit')
                                            ->label("Cena za jednotku")
                                            ->numeric()
                                            ->suffix("€")
                                            ->required()
                                            ->reactive(),
                                        TextInput::make('discount_amount_per_unit')
                                            ->label("Zľava za jednotku")
                                            ->numeric()
                                            ->suffix("€")
                                            ->reactive(),
                                        TextInput::make('total_no_vat')
                                            ->label("Celkom bez DPH")
                                            ->numeric()
                                            ->suffix("€")
                                            ->disabled(),
                                        TextInput::make('vat_amount')
                                            ->label("DPH")
                                            ->numeric()
                                            ->suffix("€")
                                            ->disabled(),
                                        TextInput::make('total_with_vat')
                                            ->label("Celkom s DPH")
                                            ->numeric()
                                            ->suffix("€")
                                            ->disabled(),
                                        Section::make("Informácie k udalosti")
                                            ->relationship("formSubmission")
                                            ->schema(function ($record, $set) {

                                                if (!$record) {
                                                    return [];
                                                }

                                                // Pre-fill the values from submission
                                                $record->loadMissing("formSubmission.form.formFields", "formSubmission.formFields.media", "formSubmission.formFields.formField");

                                                if (empty($record->formSubmission?->form->formFields)) {
                                                    return [];
                                                }

                                                $data = [];
                                                foreach ($record->formSubmission->formFields as $field) {
                                                    $data[$field->formField->slug] = $field;
                                                }

                                                $fields = EventRegistrationForm::buildFormFields($record->formSubmission->form->formFields);

                                                foreach ($fields as $key => $field) {
                                                    if (!isset($data[$field->getName()])) {
                                                        continue;
                                                    }

                                                    $submittedField = $data[$field->getName()];
                                                    if ($submittedField->value !== "_binary_") {
                                                        $field->afterStateHydrated(fn (?string $state, callable $set, $record) => $set($field->getName(), $submittedField->value))
                                                            ->disabled()
                                                            ->live();
                                                    } else {
                                                        $field = Placeholder::make($field->getName())
                                                            ->label($field->getLabel())
                                                            ->content(fn($record) => new HtmlString($submittedField->getMedia('media')->map(fn($media) => '<a href="' . $media->getUrl() . '" target="_blank">' . $media->file_name . '</a>')->join('<br>')))
                                                            ->columnSpan(12);

                                                        $fields[$key] = $field;
                                                    }
                                                }

                                                return [Grid::make([
                                                    'default' => 1,
                                                    'sm' => 3,
                                                    'md' => 6,
                                                    'lg' => 12,
                                                ])->schema($fields)];
                                            })
                                            ->visible(fn(Get $get, $record): bool => $record && $get('orderable_type') === MorphMap::getKeyByModel(Event::class)),
                                    ])
                                    ->columns(4)
                                    ->afterStateUpdated(fn($state, callable $set, $get) => self::recalculateSummary($state, $set, $get)),
                            ]),
                    ]),
                    Section::make('Objednávka')
                        ->collapsible()
                        ->visibleOn("edit")
                        ->schema([
                            ToggleButtons::make('status')
                                ->label("Stav")
                                ->options(OrderStatus::translations())
                                ->icons(OrderStatus::icons())
                                ->colors(OrderStatus::colors()),
                            Placeholder::make('subtotal')
                                ->label("Medzisúčet")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('subtotal'))),
                            Placeholder::make('discount_amount')
                                ->label("Zľava")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('discount_amount'))),
                            Placeholder::make('shipping_type_price')
                                ->label("Cena za spôsob dodania")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('shipping_type_price'))),
                            Placeholder::make('payment_type_price')
                                ->label("Cena za spôsob platby")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('payment_type_price'))),
                            Placeholder::make('total_no_vat')
                                ->label("Celkom bez DPH")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('total_no_vat'))),
                            Placeholder::make('vat_amount')
                                ->label("DPH")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('vat_amount'))),
                            Placeholder::make('total_with_vat')
                                ->label("Celkom s DPH")
                                ->content(fn($record, $get) => self::formatSummaryPrice($get('total_with_vat'))),
                        ])
                        ->grow(false),
                ])->columnSpan(12),
            ]);
    }

    private static function recalculateSummary(array $orderItems, callable $set, callable $get): void
    {
        $subtotal = 0;
        $discount = 0;

        $billingCountry = $get('billing_country');
        if(empty($billingCountry)) {
            return;
        }

        foreach ($orderItems as &$item) {
            $quantity = $item['quantity'] ?? 0;
            $pricePerUnit = $item['price_per_unit'] ?? 0;
            $discountPerUnit = $item['discount_amount_per_unit'] ?? 0;

            $itemTotalNoVat = $quantity * ($pricePerUnit - $discountPerUnit);
            $itemVat = round($itemTotalNoVat * OrderService::getVatPercentageForSpecificCountry(OrderCountry::from($get('billing_country'))) / 100, 2);
            $itemTotalWithVat = $itemTotalNoVat + $itemVat;

            $item['total_no_vat'] = $itemTotalNoVat;
            $item['vat_amount'] = $itemVat;
            $item['total_with_vat'] = $itemTotalWithVat;

            $subtotal += $quantity * $pricePerUnit;
            $discount += $quantity * $discountPerUnit;
        }

        $totalWithoutVAT = $subtotal - $discount;

        $vatPercentage = OrderService::getVatPercentageForSpecificCountry(OrderCountry::from($get('billing_country')));
        $vatAmount = round($totalWithoutVAT * $vatPercentage / 100, 2);
        $totalWithVAT = $totalWithoutVAT + $vatAmount;

        $set('orderItems', $orderItems);
        $set('subtotal', self::formatSummaryPrice($subtotal));
        $set('discount_amount', self::formatSummaryPrice($discount));
        $set('total_no_vat', self::formatSummaryPrice($totalWithoutVAT));
        $set('vat_amount', self::formatSummaryPrice($vatAmount));
        $set('total_with_vat', self::formatSummaryPrice($totalWithVAT));
    }

    public static function getTableColumns(): array
    {
        $columns = [];

        $columns['order_number'] = TextColumn::make('full_order_number')
            ->label('Číslo')
            ->sortable(['order_number'])
            ->searchable(['order_number']);

        $columns['name'] = TextColumn::make('full_billing_name')
            ->label('Objednávateľ')
            ->sortable(['billing_last_name', 'company_name', 'billing_first_name'])
            ->searchable(['billing_last_name', 'company_name', 'billing_first_name']);

        $columns['status'] = TextColumn::make('status')
            ->label('Stav')
            ->badge()
            ->getStateUsing(fn($record) => $record->status->translation())
            ->color(fn($record): string => $record->status->color())
            ->icon(fn($record): string => $record->status->icon());

        $columns['price'] = TextColumn::make('total_with_vat')
            ->label('Celkom s DPH')
            ->money('EUR')
            ->sortable(['billing_last_name', 'company_name', 'billing_first_name'])
            ->searchable(['billing_last_name', 'company_name', 'billing_first_name']);

        $columns['published_at'] = TextColumn::make('created_at')
            ->label('Dátum')->dateTime()->sortable()
            ->searchable();


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

    private static function formatSummaryPrice(null|float|string $total_with_vat): string
    {
        if (is_string($total_with_vat)) {
            $total_with_vat = floatval($total_with_vat);
        }

        if (empty($total_with_vat)) {
            $total_with_vat = 0;
        }

        return number_format($total_with_vat, 2) . '€';
    }

    private static function updateShippingTypeState($state, callable $set, $shippingTypes): void
    {
        $shippingType = $shippingTypes->where('id', $state)->first();
        if (!$shippingType) {
            return;
        }

        $set('shipping_type_label', $shippingType->name);
        $set('shipping_type_price', $shippingType->price);
    }

    private static function updatePaymentTypeState($state, callable $set, $paymentTypes): void
    {
        $paymentType = $paymentTypes->where('id', $state)->first();
        if (!$paymentType) {
            return;
        }

        $set('payment_type_label', $paymentType->name);
        $set('payment_type_price', $paymentType->price);
    }
}
