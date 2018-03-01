<?php 

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
    * Just check if our classes has no syntax errors.
    */
    public function testIsThereAnySyntaxError(){
        $client = new Yiin\RocketChat\Client('http://localhost:3000/api/v1');

      	$this->assertTrue(
            is_object(
                $client
            )
        );

        $this->assertTrue(
            is_object(
                $client->authenticationAPI()
            )
        );

        $this->assertTrue(
            is_object(
                $client->usersAPI()
            )
        );
    }
}