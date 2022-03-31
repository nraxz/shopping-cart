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
        
       
        $net_price =$this->calculate($input);
        
       
        return 200;

        
    }

    public function calculate($input)
    {       
       

   }

    private function applyRules($code, $unit)
    {

    }

}