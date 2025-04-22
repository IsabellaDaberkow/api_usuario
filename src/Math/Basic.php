<?php 
namespace Projetux\Math;

class Basic 
{
    /** 
     * @return int|float
    */
    public function soma(int|float $numero, int|float $numero2)
    {
        return $numero + $numero2;
    }

    /**
     * @return int|float
     */
    public function subtrai(int|float $numero, int|float $numero2)
    {
        return $numero - $numero2;
    }

    /** 
     * @return int|float
    */
    public function multiplica(int|float $numero, int|float $numero2)
    {
        return $numero * $numero2;
    }

      /** 
     * @return int|float
    */
    public function divide(int|float $numero, int|float $divisor)
    {
        return $numero / $divisor;
    }

      /** 
     * @return int|float
    */
    public function elevaAoQuadrado(int|float $numero)
    {
        return $numero ** 2;
        // return pow ($numero,2);
    }

      /** 
     * @return int|float
    */
    public function Quadradaraiz(int|float $numero)
    {
        return sqrt($numero);
    }
}
