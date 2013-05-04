CaoHtmlTable
============

Zend Framework 2 View Helper to render an HTML Table

The input can be either an array or an instance of CaoHtmlTable\Model\Table.
The code will try to make to most of what its given. 

Installation
------------

### Main Setup

#### By cloning project

1. Install the [CaoHtmlTable](https://github.com/chrisoconnell/CaoHtmlTable) ZF2 module
   by cloning it into `./vendor/`.
2. Clone this project into your `./vendor/` directory.

#### With composer

1. Add this project in your composer.json:

    ```json
    "require": {
        "chrisoconnell/cao-html-table": "dev-master"
    }
    ```

2. Now tell composer to download CaoHtmlTable by running the command:

    ```bash
    $ php composer.phar update
    ```

#### Post installation

1. Enabling it in your `application.config.php` file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'CaoHtmlTable',
        ),
        // ...
    );
    ```

Example &mdash; Table with header row
-------------------------------------
1. Define table rows as an array of associative arrays.

    ```php
    $rows = array(
      array('header col1' => 'col1 row1', 'header col2' => 'col2 row1'),
      array('header col1' => 'col1 row2', 'header col2' => 'col2 row2'),
    );
    ```
    Header row will be set from the keys of the **first** array.

2. Call view helper inside your view script (.phtml file).

    ```php
    echo $this->htmlTable($rows);
    ```

3. Which will output the following:

    ```html
    <table>
     <thead>
      <tr>
        <th>header col1</th><th>header col2</th>
      </tr>
     </thead>
     <tbody>
      <tr>
        <td>col1 row1</td><td>col2 row1</td>
      </tr>
      <tr>
        <td>col1 row2</td><td>col2 row2</td>
      </tr>
     </tbody>
    </table>
    ```
Notice that the keys of the array are mapped to the header row.

Example &mdash; Table without header row
----------------------------------------
1. Define table rows as an array of arrays.

    ```php
    $rows = array(
      array('col1 row1', 'col2 row1'),
      array('col1 row2', 'col2 row2'),
    );
    ```

2. Call view helper inside your view script (.phtml file).

    ```php
    echo $this->htmlTable($rows);
    ```

3. Which will output the following:

    ```html
    <table>
     <tbody>
      <tr>
        <td>col1 row1</td><td>col2 row1</td>
      </tr>
      <tr>
        <td>col1 row2</td><td>col2 row2</td>
      </tr>
     </tbody>
    </table>
    ```
    
Notice that no header row was output.

Example &mdash; Using instance of CaoHtmlTable\Model\Table
----------------------------------------------------------
When you need more flexibility for the table &mdash; ie set caption, css class &mdash; then you need to create an instance of
`CaoHtmlTable\Model\Table` to use as the view helper input.

1. Define the instance and set the data.

    ```php
    $rows = array(
        array('col1 row1', 'col2 row1'),
        array('col1 row2', 'col2 row2', 'col 3 row2'),
    );
    $table = new CaoHtmlTable\Model\Table($rows);
    $table->setAttributes(array('class' => 'selected', 'id' => 'list'))
          ->setCaption('My Table Caption')
          ->setHeaderRow(array('Header 1', 'Header 2', 'Header 3'));
    ```
When setting the header row, the index of the header will be matched to the index of the
row. If a matching row index is not found, then the table cell will be set to `&nbsp;`.

2. Call view helper inside your view script (.phtml file).

    ```php
    echo $this->htmlTable($table);
    ```

3. Which will output the following:

    ```html
    <table class="selected" id="list">
      <caption>My Table Caption</caption>
      <thead>
        <tr>
          <th>Header 1</th><th>Header 2</th><th>Header 3</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>col1 row1</td><td>col2 row1</td><td>&nbsp;</td>
        </tr>
        <tr>
          <td>col1 row2</td><td>col2 row2</td><td>col 3 row2</td>
        </tr>
      </tbody>
    </table>
    ```
