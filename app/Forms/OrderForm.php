<?php

namespace App\Forms;

use App\Enum\OrderCountry;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;

class OrderForm extends Form
{
    public static bool $includeShippingAddress = true;

    public static function create(Form $form, bool $includeShippingAddress = true, array $formFields = []): Form
    {
        self::$includeShippingAddress = $includeShippingAddress;

        $formFields = !empty($formFields) ? $formFields : self::getFormFields();

        $form->schema($formFields);

        return $form;
    }

    public static function getFormFields(): array
    {
        return [
            Wizard::make([
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
                    ])
                    ->visible(fn() => self::$includeShippingAddress),
                Step::make('payment')
                    ->label(__("ord_section_payment"))
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        self::getPaymentFields(),
                    ]),
            ])->skippable(false),
        ];
    }

    private static function getBillingInfoFields()
    {
        $gridBillingFields = [];

        $gridBillingFields['billing_first_name'] = TextInput::make('billing_first_name')
            ->label(__('ord_fld_billing_first_name'))
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingFields['billing_last_name'] = TextInput::make('billing_last_name')
            ->label(__('ord_fld_billing_last_name'))
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
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingFields['billing_phone'] = TextInput::make('billing_phone')
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
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_business_id'] = TextInput::make('company_business_id')
            ->label(__('ord_fld_company_business_id'))
            ->visible(fn($get) => !empty($get('is_company')))
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_tax_id'] = TextInput::make('company_tax_id')
            ->label(__('ord_fld_company_tax_id'))
            ->visible(fn($get) => !empty($get('is_company')))
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridCompanyFields['company_vat_id'] = TextInput::make('company_vat_id')
            ->label(__('ord_fld_company_vat_id'))
            ->visible(fn($get) => !empty($get('is_company')))
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
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingAddressFields['billing_city'] = TextInput::make('billing_city')
            ->label(__('ord_fld_billing_city'))
            ->required()
            ->columnSpan([
                'default' => 12,
                'sm' => 3,
                'md' => 4,
                'lg' => 3,
            ]);

        $gridBillingAddressFields['billing_zip'] = TextInput::make('billing_zip')
            ->label(__('ord_fld_billing_zip'))
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

        $gridShippingAddressFields['is_shipping_address'] = Checkbox::make('is_shipping_address')
            ->label(__('ord_fld_is_shipping_address'))
            ->columnSpan('full')
            ->live()
            ->inline();

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
            ->placeholder(__('ord_fld_shipping_country_placeholder'))
            ->required()
            ->visible(fn($get) => $get('is_shipping_address'))
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
        ])->schema($gridShippingAddressFields);
    }

    private static function getPaymentFields()
    {
        $paymentFields = [];

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
}
