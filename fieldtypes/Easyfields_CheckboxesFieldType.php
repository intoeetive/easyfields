<?php
namespace Craft;


class Easyfields_CheckboxesFieldType extends BaseOptionsFieldType
{

	protected $multi = true;

	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc IComponentType::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Easy Checkboxes');
	}

	/**
	 * @inheritDoc IFieldType::getInputHtml()
	 *
	 * @param string $name
	 * @param mixed  $values
	 *
	 * @return string
	 */
	public function getInputHtml($name, $values)
	{
		$options = $this->getTranslatedOptions();


		return craft()->templates->render('_includes/forms/checkboxGroup', array(
			'name'    => $name,
			'options' => $options,
			'values'  => $values
		));
	}


	protected function getOptionsSettingsLabel()
	{
		return Craft::t('Checkbox Options');
	}
    
    
   	public function getSettingsHtml()
	{
		$options = $this->getOptions();
        $optionsList = "";
        foreach ($options as $option)
        {
            $optionsList .= $option['label']."\n";
        }
        $optionsList = trim($optionsList);

        $input = craft()->templates->render('_includes/forms/textarea', array(
            'id'           => 'options',
            'name'         => 'options',
            'rows'         => 20,
            'value'        => $optionsList
        ));
        return craft()->templates->render('_includes/forms/field', array(
            'label'        => $this->getOptionsSettingsLabel(),
            'instructions' => Craft::t('Define each option as separate row.'),
            'id'           => 'options',
            'input'        => $input
        ));
        
	}

	/**
	 * @inheritDoc ISavableComponentType::prepSettings()
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function prepSettings($settings)
	{
		if (!empty($settings['options']))
		{
			$options = explode("\n", $settings['options']);
            $settings['options'] = [];
            foreach ($options as $option)
            {
                $option = trim($option);
                $settings['options'][$option] = $option;
            }
		}

		return $settings;
	}
}
