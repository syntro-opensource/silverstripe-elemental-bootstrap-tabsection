<?php

namespace Syntro\ElementalTabSection\Model;

use SilverStripe\Forms\TextField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldList;
use SilverStripe\AssetAdmin\Forms\UploadField;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use Syntro\SilverStripeElementalBaseitems\Model\BaseItem;
use Syntro\ElementalTabSection\Elements\TabSection;

/**
 * TabPanel
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class TabPanel extends BaseItem
{
    /**
     * @var string
     */
    private static $table_name = 'ElementalBootstrapTabPanel';

    /**
     * @var array
     */
    private static $db = [
        'Sort' => 'Int',
        'Content' => 'HTMLText',

    ];

    private static $default_sort = ['Sort' => 'ASC'];

    /**
     * @var array
     */
    private static $has_one = [
        'Section' => TabSection::class,
        'Image' => Image::class,
        'CTALink' => Link::class
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image',
        'CTALink'
    ];

    private static $defaults = [
        'ShowTitle' => true
    ];

    private static $summary_fields = [
        'Image.StripThumbnail',
        'Title',
        'Content.LimitWordCount'
    ];

    /**
     * fieldLabels - apply labels
     *
     * @param  boolean $includerelations = true
     * @return array
     */
    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Image.StripThumbnail'] = _t(__CLASS__ . '.IMAGE', 'Image');
        $labels['Image'] = _t(__CLASS__ . '.IMAGE', 'Image');
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['Content.Summary'] = _t(__CLASS__ . '.SUMMARY', 'Summary');
        $labels['CTALink'] = _t(__CLASS__ . '.CALLTOACTIONLINK', 'Call to action Link');
        return $labels;
    }

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            /** @var FieldList $fields */
            $fields->removeByName([
                'Sort',
                'SectionID',
                'CTALinkID'
            ]);

            $fields->dataFieldByName('Content')
                ->setTitle(_t(
                    __CLASS__ . '.CONTENT',
                    'Content'
                ));

            // Add Image Upload Field
            $fields->addFieldToTab(
                'Root.Main',
                $imageField = UploadField::create(
                    'Image',
                    $this->fieldLabel('Image')
                ),
                'Content'
            );
            $imageField->setFolderName('Uploads/TabPanels');


            $fields->addFieldToTab(
                'Root.Main',
                LinkField::create(
                    'CTALink',
                    $this->fieldLabel('CTALink'),
                    $this
                )
            );
        });

        return parent::getCMSFields();
    }
}
