<?php

namespace Luba\Form;

class LiteralField extends FormField
{
    /**
     * Field content
     *
     * @var string
     */
    protected $content;

    public function __construct($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function render()
    {
        $content = $this->content;
        return ['label'=>'', 'field' => $content, 'type' => 'literal'];

        // return [
        //     'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
        //     'field' => "<textarea name=\"$name\" id=\"$name\" $attributes>$value</textarea>",
        //     'type' => 'textarea'
        // ];
    }
}