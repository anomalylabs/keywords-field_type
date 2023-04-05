<?php namespace Anomaly\TagsFieldType;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\TagsFieldType\Command\ParseOptions;
use Illuminate\Support\Collection;

/**
 * Class TagsFieldTypeOptions
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TagsFieldTypeOptions
{
    /**
     * Handle the select options.
     *
     * @param TagsFieldType $fieldType
     */
    public function handle(TagsFieldType $fieldType)
    {
        $options = array_get($fieldType->getConfig(), 'options', []);

        /**
         * Parse options from
         * the config GUI.
         */
        if (is_string($options)) {
            $options = dispatch_sync(new ParseOptions($options));
        }

        if ($options instanceof Collection) {

            if ($options->isEmpty()) {
                $options = [];
            }

            /**
             * A collection of Eloquent models.
             */
            if ($first = $options->first() instanceof EloquentModel) {
                $value = $first instanceof EntryInterface
                    ? $first->getTitleName()
                    : 'id';

                $options = $options->pluck($value);
            }

            /**
             * A collection of string values.
             */
            if (is_string($first)) {
                $options = $options->all();
            }
        }

        $fieldType->setOptions((array)$options);
    }
}
