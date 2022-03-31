<?php
namespace App\Cart;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class ShoppingCart extends Command
{
    
    protected function configure(): void
    {
        $this->setName('calculate');               
        $this->addArgument('code', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Available product codes: SR1, CF1, FR1'); 

    }

    public function __construct()
    {
        parent::__construct();
    }

       
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $basket = $input->getArgument('code');
        /*
        //Converting array to string and Capitalizing input string.
        */
        $basket = implode(' ', $basket) ;
        $basket = strtoupper($basket);
       
        $net_price =$this->calculate($basket);
        
        $output->writeln('Basket: '.$basket);
        $output->writeln('Total Price: £'.$net_price);
       
        return 200;

        
    }

    public function calculate($input)
    {         
        $net = 0;
        $cartItems = $this->cartItems($input);
       
        foreach($cartItems as $item => $value)
           {
               $grand_total = $this->applyRules($item, $value);
               $net +=  $grand_total;
           }

          return $net;

   }

    private function applyRules($code, $unit)
    {
        $product_json = file_get_contents('products.json'); 
        $products = json_decode($product_json, true);
        $products = $products['products'];
        $grand_total = 0;

        for($i = 0; $i < count($products); $i++)
        {

           if($products[$i]['code'] == $code)
           {
               $price =  $products[$i]['price'];
                $rule =  $products[$i]['rules'];
                
                if(!empty($rule)){
                   
                    $type =  $rule['type'];
                    $reward =  $rule['reward'];
                    if($rule['minBuy'] <= $unit)
                    {
                        $unit_total = $this->calculatePrice($unit, $price, $type, $reward);
                        $grand_total += $unit_total;
                    }
                    else 
                    {
                        $unit_total = $unit * $price;
                        $grand_total += $unit_total;
                    }

                }

                else
                {
                   

                    $unit_total = $unit * $price;
                    $grand_total += $unit_total;
                    
                }       
           }
           else
           {
              //Error handling or discarted items can be add here.

           }
           
        }
        
       return $grand_total;
        
    }
    private function calculatePrice($unit, $price, $type, $reward)
    {
        switch($type){
            //b1g1 is buy 1 get 1
            //bulkBuy Discount
            // if the reward is increased or decreased, all you need to do is to add in json file.
        
            case "b1g1":
                if($unit % 2 == 0)
                    $unit = ($unit / 2);
                else{
                    $unit = floor($unit / 2)  + 1;
                }

                $total = $unit * $price;
                break;
            case "bulkBuy":                
                $total = ($unit * $price) - (($unit * $price) * $reward/100);
                break;

        }
        return $total;

    }

    //This function counts items

    private function cartItems($input)
    {     
        $list = array();
               
        $arr = explode(',', $input);
        
        for($i = 0; $i < count($arr); $i++)
        {
            
            $code = explode(' ', $arr[$i]);
            
            if(count($code) == 2){
                for($j = 0; $j < $code[1]; $j++)
                {
                    array_push($list, $code[0]);
                }
            }
            elseif(count($code) == 1){
                array_push($list, $code[0]);
            }
            
        }       

        return $items = array_count_values($list);     
        
    }


}