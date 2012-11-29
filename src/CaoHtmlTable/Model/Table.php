<?php

namespace CaoHtmlTable\Model;

use Zend\Stdlib\ArrayUtils;

class Table
{
    protected $data;

    protected $caption;

    protected $headerRow;

    protected $attributes;

    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    public function setCaption($caption)
    {
        $this->caption = (string)$caption;

        return $this;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function hasCaption()
    {
        return isset($this->caption);
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setHeaderRow(array $headerRow)
    {
        if (!ArrayUtils::isList($headerRow)) {
            throw new \InvalidArgumentException('Header Row must be a list of column names');
        }
        $this->headerRow = $headerRow;

        return $this;
    }

    public function getHeaderRow()
    {
        // If no header row is provided, get headers from 1st data row.
        if (!isset($this->headerRow)) {
            return array_keys($this->data[0]);
        }
        return $this->headerRow;
    }

    public function hasHeaderRow()
    {
        // If no header row is provided, see if we can get heads from data itself.
        if (!isset($this->headerRow)) {
            return ArrayUtils::hasStringKeys($this->data[0]);
        }

        return true;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function hasAttributes()
    {
        return isset($this->attributes);
    }
}