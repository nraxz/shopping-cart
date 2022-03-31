<?php
namespace App\Cart;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;
use App\Cart\ShoppingCart;

class ShoppingCartTest extends TestCase
{
   
     /**
     * @param $input     
     * @param $expectedResult
     *
     * @dataProvider cartDataProvider
     */
    public function testCalculate($input)
    {
       /* $calculate = new CommandTester(new ShoppingCart());       

        $options = [
            'code' => $input,
        ];
       
        $calculate->execute($options);
        $cart = new ShoppingCartTest();
        $result = $cart->convert($input);
        $expectedResult ='Basket: '. $input. '\r\n Total price: '. $result;
        // var_dump($converter->getDisplay());
       
       $this->assertEquals($expectedResult, $converter->getDisplay());

       

    }

    public function cartDataProvider()
    {
        return [
            ['FR1,SR1,FR1,FR1,CF1 \r\n Total price: £22.45'],
                        

        ];
        
    }    
    */

}