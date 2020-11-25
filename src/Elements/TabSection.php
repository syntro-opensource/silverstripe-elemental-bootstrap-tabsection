<?php

namespace Syntro\ElementalTabSection\Elements;

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use DNADesign\Elemental\Models\BaseElement;
use Syntro\ElementalTabSection\Model\TabPanel;

/**
 *  Bootstrap based Tab section
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class TabSection extends BaseElement
{

    private static $icon = 'font-icon-page-multiple';
    /**
     * This defines the block name in the CSS
     *
     * @config
     * @var string
     */
    private static $block_name = 'tab-section';

    /**
     * @var bool
     */
    private static $inline_editable = false;

    private static $styles = [];

    /**
     * @var string
     */
    // private static $icon = 'font-icon-attention';

    /**
     * @var string
     */
    private static $table_name = 'ElementTabSection';

    /**
     * set to false if image option should not show up
     *
     * @config
     * @var bool
     */
    private static $allow_image_background = true;

    /**
     * Available background colors for this Element
     *
     * @config
     * @var array
     */
    private static $background_colors = [];

    private static $text_colors = [];

    /**
     * Color mapping from background color. This is mainly intended
     * to set a default color on the section-level, ensuring text is readable.
     * Colors of subelementscan be added via templates
     *
     * @config
     * @var array
     */
    private static $text_colors_by_background = [
        'light' => 'default',
        'dark' => 'light',
    ];

    private static $db = [
        'Content' => 'Text',
    ];

    private static $has_many = [
        'TabPanels' => TabPanel::class
    ];

    /**
     * @var array
     */
    private static $owns = [
        'TabPanels'
    ];



    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->dataFieldByName('Content')
                ->setTitle(_t(
                    __CLASS__ . '.CONTENT',
                    'Content'
                ));

            if ($this->ID) {
                /** @var GridField $panels */
                $panels = $fields->dataFieldByName('TabPanels');
                $panels->setTitle($this->fieldLabel('TabPanels'));

                $fields->removeByName('TabPanels');

                $config = $panels->getConfig();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                $config->removeComponentsByType(GridFieldAddExistingAutocompleter::class);
                $config->removeComponentsByType(GridFieldDeleteAction::class);

                $fields->addFieldToTab('Root.Main', $panels);
            }
        });

        return parent::getCMSFields();
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return sprintf(
            '%s: "%s"',
            _t(
                __CLASS__ . '.SUMMARY',
                'one panel|{count} panels',
                ['count' => $this->TabPanels()->count()]
            ),
            implode('", "', $this->TabPanels()->map('Title')->keys())
        );
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = $this->getSummary();
        return $blockSchema;
    }

    /**
     * getType - get the element type
     *
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Tab Section');
    }
}
