<?php

namespace CaoHtmlTableTest\View\Helper;

use CaoHtmlTable\View\Helper\CaoHtmlTable;
use CaoHtmlTable\Model\Table;
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

    public function testTableFromEmptyInstance()
    {
        $table = $this->helper->__invoke(new Table());

        $contains = array('<table>', '</table>', '<tbody>', '</tbody>');
        $notContains = array('<thead>', '</thead>', '<tr>', '</tr>', '<th>', '</th>', '<td>', '</td>');

        foreach ($contains as $contain) {
            $this->assertContains($contain, $table);
        }
        foreach ($notContains as $notContain) {
            $this->assertNotContains($notContain, $table);
        }
    }

    public function testTableFromInstanceWithData()
    {
        $data = array(
            array('c1r1', 'c2r1'),
            array('c1r2', 'c2r2'),
        );
        $table = $this->helper->__invoke(new Table($data));

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

    public function testTableFromInstanceWithCaption()
    {
        $data = array(
            array('c1r1', 'c2r1'),
            array('c1r2', 'c2r2'),
        );
        $caoTable = new Table($data);
        $caoTable->setCaption('My Caption');
        $table = $this->helper->__invoke($caoTable);

        // Confirm caption tag was generated.
        $this->assertContains('<caption>My Caption</caption>', $table);
    }

    public function testTableFromInstanceWithSetHeaderRow()
    {
        $data = array(
            array('c1r1', 'c2r1'),
            array('c1r2', 'c2r2'),
        );
        $headers = array('h1', 'h2');
        $caoTable = new Table($data);
        $caoTable->setHeaderRow($headers);
        $table = $this->helper->__invoke($caoTable);

        // Confirm th tag was generated for each header.
        foreach($headers as $header) {
            $this->assertContains('<th>' . $header . '</th>', $table);
        }
    }

    public function testTableFromInstanceWithIndexedSetHeaderRow()
    {
        $data = array(
            array('h1' => 'c1r1', 'h2' => 'c2r1'),
            array('h1' => 'c1r2', 'h2' => 'c2r2'),
        );
        $headers = array('h1' => 'Header 1', 'h2' => 'Header 2');
        $caoTable = new Table($data);
        $caoTable->setHeaderRow($headers);
        $table = $this->helper->__invoke($caoTable);

        // Confirm th tag was generated for each header.
        foreach($headers as $index => $header) {
            $this->assertContains('<th>' . $header . '</th>', $table);
            $this->assertNotContains($index, $table);
        }
    }

    public function testTableFromInstanceWithSetAttributes()
    {
        $data = array(
            array('h1' => 'c1r1', 'h2' => 'c2r1'),
            array('h1' => 'c1r2', 'h2' => 'c2r2'),
        );
        $attributes = array('class' => 'selected', 'name' => 'list');
        $caoTable = new Table($data);
        $caoTable->setAttributes($attributes);
        $table = $this->helper->__invoke($caoTable);

        $this->assertContains('class="selected"', $table);
        $this->assertContains('name="list"', $table);
    }
}
