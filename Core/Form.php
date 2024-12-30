<?php

namespace App\Core;

class Form
{

    // la variable qui va contenir le formulaire
    private $formcode = '';
    /**
     * function to create form
     *
     * @return string
     */
    public function createForm(): string
    {
        return $this->formcode;
    }
    /**
     * function to add attribute in form
     *
     * @param array $attributes
     * @return string
     */
    private function addAttribute(array $attributes): string
    {
        $atr = '';

        // on definit les attributs courts
        $short = ['required', 'checked', 'disabled', 'autofocus'];

        // on parcours le tableau des attributs
        foreach ($attributes as $attribute => $value) {
            // on verifie si on a les attributs cours
            if (in_array($attribute, $short) && $value === true) {
                $atr .= "  $short";
            } else {
                $atr .= "  $attribute =\"$value\"";
            }
        }
        return $atr;
    }

    public static function isValide(array $form, array $fields)
    {
        foreach ($fields as $field) {
            // on verifie si le champs existe dans le formulaire ou il est absent 
            if (!isset($form[$field]) || empty($form[$field])) {
                return false;
            }
        }
        return true;
    }

    /**
     * function to begin form
     *
     * @param string $method
     * @param string $action
     * @param array $attribute
     * @return self
     */
    public function beginForm(string $method = 'post', string $action = '#', array $attribute = null): self
    {
        $this->formcode .= "<form metho='$method'  action='$action'";
        $this->formcode .= $attribute ? $this->addAttribute($attribute) . '>' : '>';

        return $this;
    }

    /**
     * function to close form
     *
     * @return self
     */
    public function endForm(): self
    {
        $this->formcode .= '</form>';
        return $this;
    }

    /**
     * function to add label
     *
     * @param string $for
     * @param string $text
     * @param array|null $attributes
     * @return self
     */
    public function label(string $for, string $text, array $attributes = null): self
    {
        $this->formcode .= "<label for='$for' ";
        $this->formcode .= $attributes ? $this->addAttribute($attributes) : '';
        $this->formcode .= "> $text </label>";
        return $this;
    }

    /**
     * function to input field
     *
     * @param string $type
     * @param string $name
     * @param string $id
     * @param string $value
     * @param array|null $attributes
     * @return self
     */
    public function input(string $type, string $name, string $id, string $value = '', array $attributes = null): self
    {
        $this->formcode .= "<input type='$type' name='$name' id='$id' value='$value' ";
        $this->formcode .= $attributes ? $this->addAttribute($attributes) . '>' : '>';
        return $this;
    }


    /**
     * function for textarea
     *
     * @param string $name
     * @param string $id
     * @param string $text
     * @param array|null $attributes
     * @return self
     */
    public function textarea(string $name, string $id, string $text, array $attributes = []): self
    {
        $this->formcode .= "<textarea name='$name' id='$id' ";
        $this->formcode .= $attributes ? $this->addAttribute($attributes) : '';
        $this->formcode .= ">$text </textarea>";
        return $this;
    }

    /**
     * function to add button 
     *
     * @param array|null $attributes
     * @param string $text
     * @return self
     */
    public function button(string $text, array $attributes = []): self
    {
        $this->formcode .= '<button';
        $this->formcode .= $attributes ? $this->addAttribute($attributes) : '';
        $this->formcode .= ">$text </button>";
        return $this;
    }
}
