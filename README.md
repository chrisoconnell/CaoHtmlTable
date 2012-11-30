CaoHtmlTable
============

Zend Framework 2 View Helper to render an HTML Table

The input can be either an array or an instance of CaoHtmlTable\Model\Table.
The code will try to make to most of what its given. 

Example - Table with header row
----------------------------------
    $data = array(
      0 => array('header col1' => 'col1 row1', 'header col2' => 'col2 row1'),
      1 => array('header col1' => 'col1 row2', 'header col2' => 'col2 row2'),
    );

If the above `$data` was set in your controller, then inside your view script (.phtml file) put:

    echo $this->htmlTable($data);

Which will output the following:
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
    
Example - Table without header row
----------------------------------
If this is your data:

    $data = array(
      0 => array('col1 row1', 'col2 row1'),
      1 => array('col1 row2', 'col2 row2'),
    );
    
Then the output of `echo $this->htmlTable($data);` will be:
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
