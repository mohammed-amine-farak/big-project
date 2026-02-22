<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MathLiveEditor extends Component
{
    public $id;
    public $name;
    public $value;
    public $label;
    public $height;
    public $showToolbar;
    public $virtualKeyboardMode;
    public $inlineShortcuts;
    public $smartMode;
    public $placeholder;

    public function __construct(
        $id = null,
        $name = 'math_expression',
        $value = '',
        $label = 'محرر المعادلات الرياضية',
        $height = 'auto',
        $showToolbar = true,
        $virtualKeyboardMode = 'auto',
        $inlineShortcuts = true,
        $smartMode = true,
        $placeholder = 'اكتب معادلتك هنا...'
    ) {
        $this->id = $id ?? 'math-editor-' . uniqid();
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->height = $height;
        $this->showToolbar = $showToolbar;
        $this->virtualKeyboardMode = $virtualKeyboardMode;
        $this->inlineShortcuts = $inlineShortcuts;
        $this->smartMode = $smartMode;
        $this->placeholder = $placeholder;
    }

    public function render()
    {
        return view('components.math-live-editor');
    }
}