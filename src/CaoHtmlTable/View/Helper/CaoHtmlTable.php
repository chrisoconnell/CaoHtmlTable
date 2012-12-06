<?php

namespace CaoHtmlTable\View\Helper;

use CaoHtmlTable\Model\Table as HtmlTable;
use Zend\View\Helper\AbstractHtmlElement;
use Zend\Stdlib\ArrayUtils;

class CaoHtmlTable extends AbstractHtmlElement
{
    /**
     * Generates a 'Table' element.
     *
     * @param array|CaoHtmlTable\Model\Table $data
     * @return string The table HTML
     * @throws \InvalidArgumentException if rows is not an array or instance of CaoHtmlTable\Model\Table.
     */
    public function __invoke($data = array())
    {
        if (!is_array($data) && !($data instanceof HtmlTable)) {
            throw new \InvalidArgumentException('Must pass an array or instance of CaoHtmlTable\Model\Table.');
        }

        $table = is_array($data) ? new HtmlTable($data) : $data;

        if ($table->hasAttributes()) {
            $attribs = $this->htmlAttribs($table->getAttributes());
        } else {
            $attribs = '';
        }

        $html = '<table' . $attribs . '>' . self::EOL;
        $escape = $this->getView()->plugin('escapehtml');

        if ($table->hasCaption()) {
            $html .= '<caption>' . $escape($table->getCaption()) . '</caption>' . self::EOL;
        }

        if ($table->hasHeaderRow()) {
            $html .= '<thead>' . self::EOL . '<tr>' . self::EOL;
            foreach ($table->getHeaderRow() as $header) {
                $html .= '<th>' . $escape($header) . '</th>' . self::EOL;
            }
            $html .= '</tr>' . self::EOL . '</thead>' . self::EOL;
        }

        $html .= '<tbody>' . self::EOL;
        foreach ($table->getRows() as $row) {
            $html .= '<tr>' . self::EOL;
            foreach ($table->getHeaderRow() as $key => $header) {
                $col = isset($row[$key]) ? $escape($row[$key]) : '&nbsp;';
                $html .= '<td>' . $col . '</td>' . self::EOL;
            }
            $html .= '</tr>' . self::EOL;
        }
        $html .= '</tbody>' . self::EOL . '</table>' . self::EOL;

        return $html;
    }
}