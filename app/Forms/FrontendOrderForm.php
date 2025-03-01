<?php

namespace App\Forms;

use App\Enum\OrderCountry;
use App\Models\PaymentType;
use App\Models\ShippingType;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\HtmlString;
use JaOcero\RadioDeck\Forms\Components\RadioDeck;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class FrontendOrderForm extends Form
{
    public static bool $includeShippingAddress = true;
    public static array $additionalWizardSteps = [];
    private static ?HtmlString $submitButton;
    private static Collection $shippingTypes;
    private static Collection $paymentTypes;
    private static \Illuminate\Support\Collection $cartItems;

    public static function create(Form $form, Collection $shippingTypes, Collection $paymentTypes, \Illuminate\Support\Collection $cartItems, bool $includeShippingAddress = true, array $additionalWizardSteps = [], ?HtmlString $submitButton = null): Form
    {
        self::$includeShippingAddress = $includeShippingAddress;
        self::$additionalWizardSteps = $additionalWizardSteps;
        self::$submitButton = $submitButton;
        self::$shippingTypes = $shippingTypes;
        self::$paymentTypes = $paymentTypes;
        self::$cartItems = $cartItems;

        $form->schema(self::getFormFields());

        return $form;
    }

    public static function getFormFields(): array
    {
        $steps = array_merge([
            Step::make('billing')
                ->label(__("ord_section_billing"))
                ->icon('heroicon-o-user')
                ->schema([
                    self::getBillingInfoFields(),
                    self::getCompanyFields(),
                    self::getBillingAddressFields(),
                ]),
            Step::make('shipping')
                ->label(__("ord_section_shipping"))
                ->icon('heroicon-o-truck')
                ->schema([
                    Grid::make([
                        'default' => 1,
                        'sm' => 3,
                        'md' => 6,
                        'lg' => 12,
                    ])->schema([
                        self::getShippingFields(),
                    ]),
                ]),
            Step::make('payment')
                ->label(__("ord_section_payment"))
                ->icon('heroicon-o-credit-card')
                ->schema([
                    self::getPaymentFields(),
                ]),
        ], self::createAdditionalSteps(), [
            Step::make('summary')
                ->label(__("ord_section_summary"))
                ->icon('heroicon-o-document-check')
                ->schema([
                    Placeholder::make('summary')
                        ->hiddenLabel()
                        ->content(function ($get) {
                            $data = [];

                            $billingData = [
                                __("ord_fld_billing_first_name") => $get('billing_first_name'),
                                __("ord_fld_billing_last_name") => $get('billing_last_name'),
                                __("ord_fld_email") => $get('email'),
                                __("ord_fld_billing_phone") => $get('billing_phone'),
                                __("ord_fld_billing_address") => $get('billing_address'),
                                __("ord_fld_billing_city") => $get('billing_city'),
                                __("ord_fld_billing_zip") => $get('billing_zip'),
                                __("ord_fld_billing_country") => $get('billing_country'),
                            ];

                            if (!empty($get('is_company'))) {
                                $billingData[__("ord_fld_company_name")] = $get('company_name');
                                $billingData[__("ord_fld_company_business_id")] = $get('company_business_id');
                                $billingData[__("ord_fld_company_tax_id")] = $get('company_tax_id');
                                $billingData[__("ord_fld_company_vat_id")] = $get('company_vat_id');
                            }

                            $data[__("ord_section_billing")] = $billingData;

                            $shippingData = [
                                __("ord_fld_shipping_type") => self::$shippingTypes->where("id", $get('shipping_type_id'))->first()->name,
                            ];

                            if (!empty($get('is_shipping_address'))) {
                                $shippingData[__("ord_fld_shipping_first_name")] = $get('shipping_first_name');
                                $shippingData[__("ord_fld_shipping_last_name")] = $get('shipping_last_name');
                                $shippingData[__("ord_fld_shipping_phone")] = $get('shipping_phone');
                                $shippingData[__("ord_fld_shipping_address")] = $get('shipping_address');
                                $shippingData[__("ord_fld_shipping_city")] = $get('shipping_city');
                                $shippingData[__("ord_fld_shipping_zip")] = $get('shipping_zip');
                                $shippingData[__("ord_fld_shipping_country")] = $get('shipping_country');
                            }

                            $data[__("ord_section_shipping")] = $shippingData;

                            $paymentData = [
                                __("ord_fld_payment_type") => self::$paymentTypes->where("id", $get('payment_type_id'))->first()->name,
                            ];

                            if (!empty($get('note'))) {
                                $paymentData[__("ord_fld_note")] = $get('note');
                            }

                            $data[__("ord_section_payment")] = $paymentData;

                            foreach (self::$additionalWizardSteps as $step) {
                                $data[$step['label']] = [];

                                foreach ($step['form_fields'] as $field) {
                                    if ($field instanceof Grid) {
                                        foreach ($field->getChildComponents() as $subfield) {
                                            $key = explode(".", $subfield->getKey());
                                            $key = end($key);
                                            $data[$step['label']][$subfield->getLabel()] = $get($key);
                                        }
                                    } else {
                                        $data[$step['label']][$field->getLabel()] = $get($field->getKey());
                                    }
                                }
                            }

                            // Render the Blade view with the data
                            return view('parts.order.frontend-order-summary', [
                                'data' => $data,
                                'cartItems' => self::$cartItems,
                            ]);
                        }),
                        Checkbox::make('terms')
                            ->label(__('ord_fld_terms'))
                            ->required()
                            ->columnSpan('full'),
                        Checkbox::make('marketing')
                            ->label(__('ord_fld_marketing'))
                            ->columnSpan('full'),
                    ]
                )]);

        $wizard = Wizard::make($steps)->skippable(false);

        if (self::$submitButton) {
            $wizard->submitAction(self::$submitButton);
        }

        return [
            $wizard,
        ];
    }

    private static function getBillingInfoFields()
    {
        $gridBillingFields = [];

        $gridBillingFields['billing_first_name'] = TextInput::make('billing_first_name')
            ->label(__('ord_fld_billing_first_name'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingFields['billing_last_name'] = TextInput::make('billing_last_name')
            ->label(__('ord_fld_billing_last_name'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingFields['email'] = TextInput::make('email')
            ->email()
            ->label(__('ord_fld_email'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingFields['billing_phone'] = PhoneInput::make('billing_phone')
            ->label(__('ord_fld_billing_phone'))
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        return Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($gridBillingFields);
    }

    private static function getCompanyFields()
    {
        $gridCompanyFields = [];

        $gridCompanyFields['is_company'] = Checkbox::make('is_company')
            ->label(__('ord_fld_is_company'))
            ->columnSpan('full')
            ->live()
            ->inline();

        $gridCompanyFields['company_name'] = TextInput::make('company_name')
            ->label(__('ord_fld_company_name'))
            ->visible(fn($get) => !empty($get('is_company')))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_business_id'] = TextInput::make('business_id')
            ->label(__('ord_fld_company_business_id'))
            ->required()
            ->maxLength(255)
            ->visible(fn($get) => !empty($get('is_company')))
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_tax_id'] = TextInput::make('tax_id')
            ->label(__('ord_fld_company_tax_id'))
            ->maxLength(255)
            ->visible(fn($get) => !empty($get('is_company')))
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_vat_id'] = TextInput::make('vat_id')
            ->label(__('ord_fld_company_vat_id'))
            ->visible(fn($get) => !empty($get('is_company')))
            ->maxLength(255)
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        return Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($gridCompanyFields);
    }

    private static function getBillingAddressFields()
    {
        $gridBillingAddressFields = [];

        $gridBillingAddressFields['billing_address'] = TextInput::make('billing_address')
            ->label(__('ord_fld_billing_address'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingAddressFields['billing_city'] = TextInput::make('billing_city')
            ->label(__('ord_fld_billing_city'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingAddressFields['billing_zip'] = TextInput::make('billing_zip')
            ->label(__('ord_fld_billing_zip'))
            ->maxLength(255)
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingAddressFields['billing_country'] = Select::make('billing_country')
            ->label(__('ord_fld_billing_country'))
            ->options(OrderCountry::translations())
            ->placeholder(__('ord_fld_billing_country_placeholder'))
            ->required()
            ->searchable()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        return Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($gridBillingAddressFields);
    }

    private static function getShippingFields()
    {
        $gridShippingAddressFields = [];

        $shippingTypes = empty(self::$shippingTypes) ? (self::$shippingTypes = ShippingType::visible()->get()) : self::$shippingTypes;

        $options = $shippingTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->name])->toArray();
        $descriptions = $shippingTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->description])->toArray();
        $icons = $shippingTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->icon])->toArray();

        $gridShippingAddressFields['shipping_type'] = RadioDeck::make('shipping_type_id')
            ->label(__('ord_fld_shipping_type'))
            ->options($options)
            ->descriptions($descriptions)
            ->icons($icons)
            ->default($shippingTypes->first()->id)
            ->required()
            ->color('primary')
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 6,
            ]);

        if (self::$includeShippingAddress) {
            $gridShippingAddressFields['is_shipping_address'] = Checkbox::make('is_shipping_address')
                ->label(__('ord_fld_is_shipping_address'))
                ->columnSpan('full')
                ->live()
                ->inline();

            $gridShippingAddressFields['shipping_first_name'] = TextInput::make('shipping_first_name')
                ->label(__('ord_fld_shipping_first_name'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);

            $gridShippingAddressFields['shipping_last_name'] = TextInput::make('shipping_last_name')
                ->label(__('ord_fld_shipping_last_name'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);

            $gridShippingAddressFields['shipping_phone'] = PhoneInput::make('shipping_phone')
                ->label(__('ord_fld_shipping_phone'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);


            $gridShippingAddressFields['shipping_address'] = TextInput::make('shipping_address')
                ->label(__('ord_fld_shipping_address'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);

            $gridShippingAddressFields['shipping_city'] = TextInput::make('shipping_city')
                ->label(__('ord_fld_shipping_city'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);

            $gridShippingAddressFields['shipping_zip'] = TextInput::make('shipping_zip')
                ->label(__('ord_fld_shipping_zip'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);

            $gridShippingAddressFields['shipping_country'] = Select::make('shipping_country')
                ->label(__('ord_fld_shipping_country'))
                ->options(OrderCountry::translations())
                ->searchable()
                ->placeholder(__('ord_fld_shipping_country_placeholder'))
                ->required()
                ->visible(fn($get) => $get('is_shipping_address'))
                ->columnSpan([
                    'default' => 12,
                    'sm' => 3,
                    'md' => 4,
                    'lg' => 3,
                ]);
        }

        return Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($gridShippingAddressFields);
    }

    private static function getPaymentFields()
    {
        $paymentFields = [];

        $paymentTypes = empty(self::$paymentTypes) ? (self::$paymentTypes = PaymentType::visible()->get()) : self::$paymentTypes;

        $options = $paymentTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->name])->toArray();
        $descriptions = $paymentTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->description])->toArray();
        $icons = $paymentTypes->mapWithKeys(fn($shippingType) => [$shippingType->id => $shippingType->icon])->toArray();

        $paymentFields['payment_type'] = RadioDeck::make('payment_type_id')
            ->label(__('ord_fld_payment_type'))
            ->options($options)
            ->descriptions($descriptions)
            ->default($paymentTypes->first()->id)
            ->icons($icons)
            ->color('primary')
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 6,
            ]);

        $paymentFields['note'] = Textarea::make('note')
            ->label(__('ord_fld_note'))
            ->placeholder(__('ord_fld_note_placeholder'))
            ->columnSpan('full')
            ->rows(4);

        return Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($paymentFields);
    }

    private static function createAdditionalSteps(): array
    {
        $steps = [];

        foreach (self::$additionalWizardSteps as $stepData) {
            $stepEl = Step::make($stepData["key"])
                ->label($stepData["label"])
                ->schema($stepData["form_fields"]);

            if (isset($stepData['settings'])) {
                $stepEl = $stepData['settings']($stepEl);
            }

            $steps[] = $stepEl;
        }

        return $steps;
    }
}
