<?php

namespace Vbcod\Breadcrumbs;

use Vbcod\HtmlElement\Element;
use function PHPUnit\Framework\isInstanceOf;

class Breadcrumbs
{
    /* @var Element */
    private $outerElement;

    private $outerTag = 'div';

    private $outerTagClass = 'vbcod-breadcrumbs';

    /* @var Element[] */
    private $items = array();

    private $itemTag = 'span';

    private $itemTagClass = 'vbcod-breadcrumbs-item';

    /* @var Element */
    private $dividerElement;

    private $dividerTag = 'span';

    private $dividerInnerHtml = '/';

    private $dividerTagClass = 'vbcod-breadcrumbs-divider';

    public function __construct()
    {
        $this->outerElement   = new Element();
        $this->dividerElement = new Element();
    }

    public function render()
    {
        $this->dividerElement->setTag($this->dividerTag);
        $this->dividerElement->addClass($this->dividerTagClass);
        $this->dividerElement->setInnerHtml($this->dividerInnerHtml);
        $dividerRendered = $this->dividerElement->render();

        $itemsRendered = array();
        foreach ($this->items as $item){
            $item->setTag($this->itemTag);
            $item->addClass($this->itemTagClass);
            $itemsRendered[] = $item->render();
        }

        $outerElementInnerHtml = implode($dividerRendered,$itemsRendered);

        $this->outerElement->setInnerHtml($outerElementInnerHtml);
        $this->outerElement->addClass($this->outerTagClass);

        return $this->outerElement->render();
    }

    /**
     * @param string         $itemAssociativeName
     * @param string|Element $item
     * @return Breadcrumbs
     */
    public function addItem($item,$itemAssociativeName = ''){
        if(!is_string($item) && !is_a($item,Element::class)){
            return $this;
        }

        if(is_string($item)){
            $element = new Element();
            $element->setInnerHtml($item);
            $item = $element;
        }

        if(is_string($itemAssociativeName) && !empty($itemAssociativeName)){
            $this->items[$itemAssociativeName] = $item;
        }else{
            $this->items[] = $item;
        }

        return $this;
    }

    public function removeItemByAssociativeName($associativeName)
    {
        foreach ($this->items as $itemAssociativeName => $item){
            if($itemAssociativeName === $associativeName){
                unset($this->items[$associativeName]);
            }
        }
    }

    public function setDivider($dividerInnerHtml)
    {
        $this->dividerElement->setInnerHtml($this->dividerInnerHtml);
    }

    public function setOuterTag($tag)
    {
        $this->outerElement->setTag($tag);

        return $this;
    }

    public function setItemTag($tag)
    {
        $this->itemTag = $tag;

        return $this;
    }

    public function setDividerTag($tag)
    {
        $this->dividerElement->setTag($tag);

        return $this;
    }
}