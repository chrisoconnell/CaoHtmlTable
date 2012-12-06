<?php

namespace CaoHtmlTableTest\View\Helper;

use CaoHtmlTable\View\Helper\CaoHtmlTable;
use Zend\View\Renderer\PhpRenderer as View;

class CaoHtmlTableTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CaoHtmlTable\View\Helper\CaoHtmlTable
     */
    public $helper;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->view   = new View();
        $this->helper = new CaoHtmlTable();
        $this->helper->setView($this->view);
    }

    public function tearDown()
    {
        unset($this->helper);
    }

    public function testEmptyTable()
    {
        $table = $this->helper->__invoke();

        $contains = array('<table>', '</table>', '<tbody>', '</tbody>');
        $notContains = array('<thead>', '</thead>', '<tr>', '</tr>', '<th>', '</th>', '<td>', '</td>');

        foreach ($contains as $contain) {
            $this->assertContains($contain, $table);
        }
        foreach ($notContains as $notContain) {
            $this->assertNotContains($notContain, $table);
        }
    }

    public function testTableFromArrayWithoutHeaderRow()
    {
        $data = array(
            array('c1r1', 'c2r1'),
            array('c1r2', 'c2r2'),
        );
        $table = $this->helper->__invoke($data);

        $contains = array('<table>', '</table>', '<tbody>', '</tbody>', '<tr>', '</tr>', '<td>', '</td>');
        $notContains = array('<thead>', '</thead>', '<th>', '</th>');

        foreach ($contains as $contain) {
            $this->assertContains($contain, $table);
        }
        foreach ($notContains as $notContain) {
            $this->assertNotContains($notContain, $table);
        }

        // Confirm td tag was generated for each element.
        foreach($data as $row) {
            foreach($row as $element) {
                $this->assertContains('<td>' . $element . '</td>', $table);
            }
        }
    }

    public function testTableFromArrayWithHeaderRow()
    {
        $data = array(
            array('h1' => 'c1r1', 'h2' => 'c2r1'),
            array('h1' => 'c1r2', 'h2' => 'c2r2'),
        );
        $table = $this->helper->__invoke($data);

        $contains = array('<table>', '</table>', '<tbody>', '</tbody>', '<thead>', '</thead>', '<th>', '</th>', '<tr>', '</tr>', '<td>', '</td>');

        foreach ($contains as $contain) {
            $this->assertContains($contain, $table);
        }

        // Confirm td tag was generated for each element.
        foreach($data as $row) {
            foreach($row as $element) {
                $this->assertContains('<td>' . $element . '</td>', $table);
            }
        }

        // Confirm th tag was generated for each header.
        foreach(array('h1', 'h2') as $header) {
            $this->assertContains('<th>' . $header . '</th>', $table);
        }
    }
}
