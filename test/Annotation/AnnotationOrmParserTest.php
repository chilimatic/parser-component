<?php


use chilimatic\lib\Parser\Annotation\AnnotationOrmParser;

class AnnotationOrmParserTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return string
     */
    public function invalidDocProvider() {
        return "
         /**
          * @var my normal comment
          */
        ";
    }

    /**
     * @return string
     */
    public function validDocProvider() {
        return "
         /**
          * @ORM something=stuff;   
          */
        ";
    }


    /**
     * @test
     */
    public function ormParserImplementsIFlyWeightParserInterface()
    {
        $parser = new AnnotationOrmParser();

        self::assertInstanceOf('\chilimatic\lib\Interfaces\IFlyWeightParser', $parser);
    }

    /**
     * @test
     */
    public function ormParserWithInvalidAnnotationString()
    {
        $parser = new AnnotationOrmParser();
        $returnValue = $parser->parse($this->invalidDocProvider());

        self::assertNull($returnValue);
    }

    /**
     * @test
     */
    public function ormParserWithValidAnnotationString()
    {
        $parser = new AnnotationOrmParser();
        $returnValue = $parser->parse($this->validDocProvider());

        self::assertEquals([['something','stuff']], $returnValue);
    }
}