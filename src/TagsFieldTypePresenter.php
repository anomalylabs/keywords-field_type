<?php namespace Anomaly\TagsFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;

/**
 * Class TagsFieldTypePresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TagsFieldTypePresenter extends FieldTypePresenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var TagsFieldType
     */
    protected $object;

    /**
     * Return the tags wrapped in labels.
     *
     * @param  string $class the class to give each tag
     * @return string
     */
    public function labels($class = 'tag-default')
    {
        return array_map(
            function ($tag) use ($class) {
                return '<span class="tag ' . $class . '">' . $tag . '</span>';
            },
            $this->object->getValue()
        );
    }

    /**
     * Gets related entries and wraps in links
     *
     * @param  string $class the to give each tag
     * @return string
     */
    public function relatedLabels($class = 'tag-default')
    {
        $links = '';

        foreach($this->object->getRelated([$this->entry->id]) as $entry){
            $links .= '<a class="tag ' . $class . '" href="'.$entry->route('view').'">' . $entry->title . '</a>';
        }

        return $links;
    }

    /**
     * Return the string form of the value.
     *
     * @return string
     */
    public function __toString()
    {
        if (!$value = $this->object->getValue()) {
            return '';
        }

        return json_encode($value);
    }
}
