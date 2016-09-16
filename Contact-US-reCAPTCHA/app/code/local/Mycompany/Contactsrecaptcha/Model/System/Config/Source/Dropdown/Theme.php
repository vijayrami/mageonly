<?php
class Mycompany_Contactsrecaptcha_Model_System_Config_Source_Dropdown_Theme
{
    /**
     * Generate theme options array
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'light',
                'label' => 'Light (default)',
            ),
            array(
                'value' => 'dark',
                'label' => 'Dark',
            )
        );
    }
}
