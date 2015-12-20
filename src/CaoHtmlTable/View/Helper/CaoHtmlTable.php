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
     * @param array|HtmlTable $data
     * @return string The table HTML
     * @throws \InvalidArgumentException if rows is not an array or instance of CaoHtmlTable\Model\Table.
     */
    public function __invoke($data = null, $lineCallable = null)
    {
        if ($data === null) {
            return $this;
        }
        if (!is_array($data) && !($data instanceof HtmlTable)) {
            throw new \InvalidArgumentException('Must pass an array or instance of CaoHtmlTable\Model\Table.');
        }

        /** @var HtmlTable $table */
        $table = is_array($data) ? new HtmlTable($data) : $data;

        if ($table->hasAttributes()) {
            $attribs = $this->htmlAttribs($table->getAttributes());
        } else {
            $attribs = '';
        }

        $html = '<table' . $attribs . '>' . PHP_EOL;
        $escape = null != $table->getEscape() ? $this->getView()->plugin($table->getEscape()) : function ($str) {
            return $str;
        };

        if ($table->hasCaption()) {
            $html .= '<caption>' . $escape($table->getCaption()) . '</caption>' . PHP_EOL;
        }

        if ($table->hasHeaderRow()) {
            $html .= '<thead>' . PHP_EOL . '<tr>' . PHP_EOL;
            foreach ($table->getHeaderRow() as $header) {
                $html .= '<th>' . $escape($header) . '</th>' . PHP_EOL;
            }
            $html .= '</tr>' . PHP_EOL . '</thead>' . PHP_EOL;
        }

        $html .= '<tbody>' . PHP_EOL;
        foreach ($table->getRows() as $key => $row) {
            $lineAttributes = "";
            if ($lineCallable!== null){
                $lineAttributes = call_user_func($lineCallable, $key , $row);
            }
            $html .= "<tr $lineAttributes>" . PHP_EOL;
            foreach ($table->getHeaderRow() as $key => $header) {
                if (isset($row[$key])) {
                    //Add Callable column definitions
                    if (is_callable($row[$key])) {
                        $col = $row[$key]($row);
                    } else {
                        $col = $escape($row[$key]);
                    }
                } else {
                    $col = '&nbsp;';
                }
                $html .= '<td>' . $col . '</td>' . PHP_EOL;
            }
            $html .= '</tr>' . PHP_EOL;
        }
        $html .= '</tbody>' . PHP_EOL . '</table>' . PHP_EOL;

        return $html;
    }



}
