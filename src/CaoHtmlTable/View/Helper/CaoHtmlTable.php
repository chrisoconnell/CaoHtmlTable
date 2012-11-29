<?php

namespace CaoHtmlTable\View\Helper;

use CaoHtmlTable\Model\Table as HtmlTable;
use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\ArrayUtils;

class CaoHtmlTable extends AbstractHelper
{
    /**
     * @var HtmlTable | array
     */
    protected $table;

    public function __invoke($data = array())
    {
        if (!is_array($data) && !($data instanceof HtmlTable)) {
            throw new \InvalidArgumentException('Must pass an array or instance of CaoHtmlTable\Model\Table.');
        }

        $this->table = is_array($data) ? new HtmlTable($data) : $data;

        return $this->render();
    }

    protected function render()
    {
        $html = '<table' . $this->getAttributes() . '>';
        $escape = $this->getView()->plugin('escapehtml');
        $table = $this->table;

        if ($table->hasCaption()) {
            $html .= '<caption>' . $escape($table->getCaption()) . '</caption>';
        }

        if ($table->hasHeaderRow()) {
            $html .= '<thead><tr>';
            foreach ($table->getHeaderRow() as $header) {
                $html .= '<th>' . $escape($header) . '</th>';
            }
            $html .= '</tr></thead>';
        }

        $html .= '<tbody>';
        foreach ($table->getData() as $row) {
            $html .= '<tr>';
            foreach ($table->getHeaderRow() as $header) {
                $col = isset($row[$header]) ? $escape($row[$header]) : '&nbsp;';
                $html .= '<td>' . $col . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        return $html;
    }

    protected function getAttributes()
    {
        $attributes = '';
        $escape = $this->getView()->plugin('escapehtmlattr');

        if ($this->table->hasAttributes()) {
            foreach ($this->table->getAttributes() as $name => $value) {
                $attributes .= ' ' . $name . '="' . $escape($value) . '"';
            }
        }

        return $attributes;
    }
}