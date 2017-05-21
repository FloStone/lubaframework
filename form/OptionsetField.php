<?php

namespace Luba\Form;
use Luba\Form\SelectField;

class OptionsetField extends SelectField
{

    /**
     * Render the Select field
     *
     * @return array
     */
    public function render()
    {
        $id = $this->name;
        $name = $this->name;
        $attributes = $this->renderAttributes($this->attributes);
        $label = $this->label;
        $labelAttributes = $this->renderAttributes($this->labelAttributes);

        $select = "<ul class=\"optionset\" id=\"$id\" $attributes>\r\n"; // name=\"$name\"

        $i = 0;
        foreach ($this->options as $value => $title)
        {
            $strict = false;
            if($value == 0) {
                //Strange php behaviour needs this on in_array(0, ["somestring"])
                $strict = true;
            }
            if ($this->default !== null && in_array($value, $this->default, $strict))
                $checked = "checked=\"checked\"";
            else
                $checked ="";

            $select .= "<li><input type=\"radio\" name=\"$name\" id=\"$name-$i\" value=\"$value\" $checked><label for=\"$name-$i\">$title</label></option>\r\n";
            $i++;
        }

        $select .= "</ul>\r\n";

        return [
            'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
            'field' => $select,
            'type' => "select"
        ];
    }
}