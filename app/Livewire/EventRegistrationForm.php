<?php

namespace App\Livewire;

use App\Enum\FormFieldFormat;
use App\Forms\OrderForm;
use App\Models\Event;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Livewire\Component;

class EventRegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Event $event;

    public function mount(Event $event): void
    {
        $this->event = $event;

        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return OrderForm::create(form: $form, includeShippingAddress: false)
            ->statePath('data');
    }

    public function getEventSpecificFormFields(): array
    {
        $fields = [];

        foreach ($this->event->form->fields as $field) {
            $key = Str::slug(title: $field->label, separator: "_");
            switch ($field->format) {
                case FormFieldFormat::TEXT:
                    $fields[$field->label] = TextInput::make($key);
                    break;
                case FormFieldFormat::EMAIL:
                    $fields[$field->label] = TextInput::make($key)->email();
                    break;
                case FormFieldFormat::NUMBER:
                    $fields[$field->label] = TextInput::make($key);
                    break;
                case FormFieldFormat::PHONE:
                case FormFieldFormat::BOOL:
                    $fields[$field->label] = Checkbox::make($key);
                    break;
                case FormFieldFormat::SELECT:
                    $fields[$field->label] = Select::make($key)->options($field->options);
                    if ($field->max > 1) {
                        $fields[$field->label]->multiple()
                            ->maxItems((int)$field->max);
                        if ($field->min > 0) {
                            $fields[$field->label]->minItems((int)$field->min);
                        }
                    }
                    break;
                case FormFieldFormat::CHECKBOX:
                    $fields[$field->label] = CheckboxList::make($key)
                        ->options($field->options);
                    if ($field->min > 0) {
                        $fields[$field->label]->minItems((int)$field->min);
                    }
                    if ($field->max > 0) {
                        $fields[$field->label]->maxItems((int)$field->max);
                    }
                    break;
                case FormFieldFormat::DATE:
                    $fields[$field->label] = DatePicker::make($key)->native(false)
                        ->minDate($field->min)
                        ->maxDate($field->max);
                    break;
                case FormFieldFormat::TIME:
                    $fields[$field->label] = TimePicker::make($key)->native(false);
                    break;
                case FormFieldFormat::DATETIME:
                    $fields[$field->label] = DateTimePicker::make($key)->native(false);
                    break;
            }

            $fields[$field->label]->required($field->is_required);

            if (!empty($help = $field->help_text)) {
                $fields[$field->label]->helperText($help);
            }
        }

        return [Grid::make([
            'default' => 1,
            'sm' => 3,
            'md' => 6,
            'lg' => 12,
        ])->schema($fields)];
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.event-registration-form');
    }
}
