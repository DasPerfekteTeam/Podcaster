<?php
namespace DasPerfekteTeam\Podcaster\Fusion\Helpers;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Utility\ObjectAccess;

/**
 * Helper for building podcast (feed) rendering
 */
class FeedHelper implements ProtectedContextAwareInterface
{
    /**
     * @param array|\Iterator $array
     * @param string $propertyPath
     * @param string $matchValue
     * @return array
     */
    public function filterByProperty($array, $propertyPath, $matchValue)
    {
        if ($array instanceof \Iterator) {
            $array = iterator_to_array($array);
        }

        return array_filter($array, function ($item) use ($propertyPath, $matchValue) {
            $value = ObjectAccess::getPropertyPath($item, $propertyPath);
            return ($value == $matchValue);
        });
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
