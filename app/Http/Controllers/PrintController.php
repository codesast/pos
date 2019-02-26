<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors;
use Mike42\Escpos\Printer;

class PrintController extends Controller
{
    public function printTest(){
        /* Most printers are open on port 9100, so you just need to know the IP
 * address of your receipt printer, and then fsockopen() it on that port.
 */
        try {
            $connector = new NetworkPrintConnector("192.168.1.252", 9100);

            /* Print a "Hello world" receipt" */
            //$connector -> finalize();
            $printer = new Printer($connector);            /*$printer -> text("Hello World!\n");
            $printer -> feed(10);
            $printer -> cut(Printer::CUT_FULL, 2);*/
            /* Line feeds */
            /* Cuts */
            $printer -> text("This Printer is KOT printer with IP 192.168.1.252");
            $printer -> feed(2);
            $printer -> close();
            /* Close printer */
            //$printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }


    }

    public function printTest2(){
        /* Most printers are open on port 9100, so you just need to know the IP
 * address of your receipt printer, and then fsockopen() it on that port.
 */
        try {
            $connector = new NetworkPrintConnector("192.168.1.253", 9100);

            /* Print a "Hello world" receipt" */
            //$connector -> finalize();
            $printer = new Printer($connector);
            /*$printer -> text("Hello World!\n");
            $printer -> feed(10);
            $printer -> cut(Printer::CUT_FULL, 2);*/
            /* Line feeds */
            /* Cuts */
            $printer -> text("This Printer is BOT printer with IP 192.168.1.253");
            $printer -> feed(2);
            $printer -> close();
            /* Close printer */
            //$printer -> close();
        } catch (Exception $e) {
            echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
        }


    }
}
