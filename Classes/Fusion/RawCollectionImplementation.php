<?php
namespace DasPerfekteTeam\Podcaster\Fusion;

use Neos\Fusion\FusionObjects\AbstractFusionObject;

/**
 *
 */
class RawCollectionImplementation extends AbstractFusionObject
{
    /**
     * The number of rendered nodes, filled only after evaluate() was called.
     *
     * @var integer
     */
    protected $numberOfRenderedNodes;

    /**
     * Render the array collection by triggering the itemRenderer for every element
     *
     * @return array
     */
    public function getCollection()
    {
        return $this->fusionValue('collection');
    }

    /**
     * @return string
     */
    public function getItemName()
    {
        return $this->fusionValue('itemName');
    }

    /**
     * @return string
     */
    public function getItemKey()
    {
        return $this->fusionValue('itemKey');
    }

    /**
     * If set iteration data (index, cycle, isFirst, isLast) is available in context with the name given.
     *
     * @return string
     */
    public function getIterationName()
    {
        return $this->fusionValue('iterationName');
    }

    /**
     * Evaluate the collection nodes as concatenated string
     *
     * @return array
     * @throws TypoScriptException
     */
    public function evaluate()
    {
        return $this->evaluateAsArray();
    }

    /**
     * Evaluate the collection nodes as array
     *
     * @return array
     * @throws TypoScriptException
     */
    public function evaluateAsArray()
    {
        $collection = $this->getCollection();

        $result = [];
        if ($collection === null) {
            return $result;
        }
        $this->numberOfRenderedNodes = 0;
        $itemName = $this->getItemName();
        if ($itemName === null) {
            throw new Exception('The Collection needs an itemName to be set.', 1344325771);
        }
        $itemKey = $this->getItemKey();
        $iterationName = $this->getIterationName();
        $collectionTotalCount = count($collection);
        foreach ($collection as $collectionKey => $collectionElement) {
            $context = $this->runtime->getCurrentContext();
            $context[$itemName] = $collectionElement;
            if ($itemKey !== null) {
                $context[$itemKey] = $collectionKey;
            }
            if ($iterationName !== null) {
                $context[$iterationName] = $this->prepareIterationInformation($collectionTotalCount);
            }

            $this->runtime->pushContextArray($context);
            $result[] = $this->runtime->render($this->path . '/itemRenderer');
            $this->runtime->popContext();
            $this->numberOfRenderedNodes++;
        }

        return $result;
    }

    /**
     * @param integer $collectionCount
     * @return array
     */
    protected function prepareIterationInformation($collectionCount)
    {
        $iteration = [
            'index' => $this->numberOfRenderedNodes,
            'cycle' => ($this->numberOfRenderedNodes + 1),
            'isFirst' => false,
            'isLast' => false,
            'isEven' => false,
            'isOdd' => false
        ];

        if ($this->numberOfRenderedNodes === 0) {
            $iteration['isFirst'] = true;
        }
        if (($this->numberOfRenderedNodes + 1) === $collectionCount) {
            $iteration['isLast'] = true;
        }
        if (($this->numberOfRenderedNodes + 1) % 2 === 0) {
            $iteration['isEven'] = true;
        } else {
            $iteration['isOdd'] = true;
        }

        return $iteration;
    }
}
