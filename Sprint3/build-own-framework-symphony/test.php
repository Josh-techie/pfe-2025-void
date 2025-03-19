<?php

// test the simple index.php

use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase{

    public function testHello(): void{
        $_GET['name'] = 'Joe';
        ob_start();
        include('index.php');
        $content = ob_get_clean();
        $this->assertEquals('Hello Joe', $content);
    }
}


?>