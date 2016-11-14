<?php
class Mycompany_Productreviewrecaptcha_Model_System_Config_Source_Dropdown_Theme {
    public function toOptionArray() {
        return array(
            array(
                'value' => 'light',
                'label' => 'Light (default)',
            ),
            array(
                'value' => 'dark',
                'label' => 'Dark',
            ),
        );
    }
}