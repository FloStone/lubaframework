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

    public function __construct(string $name, string $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function render() : array
    {
        $content = $this->content;

        return ['label'=>'', 'field' => $content, 'type' => 'literal'];
    }
}