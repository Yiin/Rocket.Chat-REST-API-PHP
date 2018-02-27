<?php 

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
    * Just check if the Client class has no syntax error.
    */
    public function testIsThereAnySyntaxError(){
      	$this->assertTrue(
            is_object(
                new Yiin\RocketChat\Client('http://localhost:3000/api/v1')
            )
        );
    }
}